<?php
/**
 * Auteur : Cédric BOUHOURS
 * Ce code est mis à disposition selon les termes de la Licence Creative Commons Attribution
 * Pas d'Utilisation Commerciale - Pas de Modification 4.0 International.
 *
 * Attribution — Vous devez créditer l'Œuvre, intégrer un lien vers la licence. Vous devez indiquer ces informations par tous les moyens raisonnables, sans toutefois suggérer que l'Offrant vous soutient ou soutient la façon dont vous avez utilisé son Oeuvre.
 *
 * Pas d’Utilisation Commerciale — Vous n'êtes pas autorisé à faire un usage commercial de cette Oeuvre, tout ou partie du matériel la composant.
 *
 * Pas de modifications — Dans le cas où vous effectuez un remix, que vous transformez, ou créez à partir du matériel composant l'Oeuvre originale, vous n'êtes pas autorisé à distribuer ou mettre à disposition l'Oeuvre modifiée.
 *
 * Pas de restrictions complémentaires — Vous n'êtes pas autorisé à appliquer des conditions légales ou des mesures techniques qui restreindraient légalement autrui à utiliser l'Oeuvre dans les conditions décrites par la licence.
 *
 *
 */

class Plannings extends Connectable
{
    public static function creerPlanning(array $data) : int {
        return createData("common_planning",$data,4);
    }

    public static function supprimerPlanning(int $planning_id) : bool {
        $req = "DELETE FROM common_planning WHERE PLANNING_ID=$planning_id";
        return self::execRequete($req);
    }

    public static function supprimerCreneau(int $creneau_id) : bool {
        $req = "DELETE FROM common_planning_creneau WHERE CRENEAU_ID=$creneau_id";
        return self::execRequete($req);
    }

    public static function getUnPlanning(int $planning_id) : array {
        $req = "SELECT * FROM common_planning WHERE PLANNING_ID=$planning_id";
        return self::getRequete($req);
    }

    public static function getPlanning(int $DEPT_ID) : array {
        $req = "SELECT *,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START_ENS),'%d/%m/%Y %Hh%i') AS PLANNING_START_ENS_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END_ENS),'%d/%m/%Y %Hh%i') AS PLANNING_END_ENS_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START_ET),'%d/%m/%Y %Hh%i') AS PLANNING_START_ET_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END_ET),'%d/%m/%Y %Hh%i') AS PLANNING_END_ET_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START),'%d/%m/%Y %Hh%i') AS PLANNING_START_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END),'%d/%m/%Y %Hh%i') AS PLANNING_END_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START),'%d/%m/%Y') AS PLANNING_START_AFFICHAGE_DATE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END),'%d/%m/%Y') AS PLANNING_END_AFFICHAGE_DATE
                FROM common_planning
                WHERE PLANNING_DEPT_ID=$DEPT_ID
                ORDER BY PLANNING_START,PLANNING_END, PLANNING_CONTENU";
        return self::getRequeteAvecClef("PLANNING_ID",$req);
    }

    public static function getPlanningAvecCreneaux(int $DEPT_ID,int $annee_id) : array {
        $req = "SELECT *,IF(PLANNING_PUBLIC=1,'checked','') AS PLANNING_PUBLIC_AFFICHAGE,
                FROM_UNIXTIME(PLANNING_START_ENS) AS PLANNING_START_ENS_AFFICHAGE,FROM_UNIXTIME(PLANNING_END_ENS) AS PLANNING_END_ENS_AFFICHAGE,
                FROM_UNIXTIME(PLANNING_START_ET) AS PLANNING_START_ET_AFFICHAGE,FROM_UNIXTIME(PLANNING_END_ET) AS PLANNING_END_ET_AFFICHAGE,
                FROM_UNIXTIME(PLANNING_START) AS PLANNING_START_AFFICHAGE,FROM_UNIXTIME(PLANNING_END) AS PLANNING_END_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                FROM common_planning
                LEFT JOIN common_planning_creneau ON (PLANNING_ID=CRENEAU_PLANNING_ID)
                WHERE common_planning.PLANNING_DEPT_ID=$DEPT_ID AND common_planning.PLANNING_ANNEE_ID=$annee_id
                ORDER BY PLANNING_START,PLANNING_END, PLANNING_CONTENU, PLANNING_ID, CRENEAU_DEBUT, CRENEAU_FIN";
        return self::getRequete($req);
    }

    public static function creerCreneau(array $data) : int {
        return createData("common_planning_creneau",$data,3);
    }

       public static function genererCreneauxAutomatiquement(array $data) : bool
    {
        $from = transformHeure($data["bfmw_orig_CRENEAU_DEBUT"]);
        $to = transformHeure($data["bfmw_orig_CRENEAU_FIN"]);
        $pas = $data["bfmw_orig_CRENEAU_PAS"]*60;
        $duree = $data["bfmw_orig_CRENEAU_DUREE"]*60;
            $retour = true;
        for ($i=$from;$i<=$to-$duree;$i+=$pas) {
            $to_save = array();
            bfmw_add_secured($to_save, "*CRENEAU_PLANNING_ID", $data['bfmw_num_PLANNING_ID']);
            bfmw_add_secured($to_save, "*CRENEAU_DEBUT", $i);
            bfmw_add_secured($to_save, "*CRENEAU_FIN", $i+$duree);
            $retour &= (self::creerCreneau($to_save) > 0);
        }

        return $retour;

    }

      public static function getEnseignantValorisesPourPlanning(int $planning_id, int $dept_id) : array
    {
        $les_enseignants = array_keys(Enseignants::getEnseignantsPermanents($dept_id));
        $req = "SELECT *,SUM(IF(RDV_ID IS NULL,0,1)) AS NB_RENDEZVOUS,SUM(IF(DISPO_PLANNING_ID IS NULL,0,1)) AS NB_DISPO,IF(PLANNING_SPE=1,'checked','') AS SPE_AFFICHAGE
                FROM common_enseignant
                LEFT JOIN common_planning_dispo_enseignant ON (ENS_ID=CRENEAU_ENS_ID AND DISPO_PLANNING_ID = $planning_id)
                LEFT JOIN common_planning_enseignant ON (ENS_ID=PLANNING_ENS_ID AND ENS_PLANNING_ID = $planning_id)
                LEFT JOIN common_planning_rendezvous ON (ENS_ID=RDV_ENS_ID AND DISPO_ID=RDV_DISPO_ID AND ENS_PLANNING_ID = RDV_PLANNING_ID)
                WHERE ENS_ID IN (".implode(",",$les_enseignants).")
                GROUP BY ENS_ID
                ORDER BY ENS_NOM
                ";
       return self::getRequete($req);
    }

    public static function getCreneauxAvecRendezVous(int $planning_id, int $ens_id, int $date_courante) : array
    {
        $req = "SELECT *, IF(DISPO_ENS_PRESENTIEL = 1 OR DISPO_ENS_PRESENTIEL IS NULL,'checked','') AS PRESENTIEL, IF(DISPO_ENS_TELEPHONIQUE = 1 OR DISPO_ENS_TELEPHONIQUE IS NULL,'checked','') AS TELEPHONIQUE, IF(DISPO_ENS_VISIO = 1 OR DISPO_ENS_VISIO IS NULL,'checked','') AS VISIO, IF (DISPO_ID IS NULL,'','checked') AS DISPO_CHECKED,  $ens_id AS ENS_ID_INJECTED,DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                FROM common_planning_creneau
                LEFT JOIN common_planning_dispo_enseignant ON (CRENEAU_ID = DISPO_CRENEAU_ID AND CRENEAU_ENS_ID=$ens_id AND DISPO_DATE=$date_courante)
                LEFT JOIN common_planning_rendezvous ON (RDV_DISPO_ID = DISPO_ID AND RDV_ENS_ID = $ens_id AND RDV_PLANNING_ID=$planning_id)                
                WHERE CRENEAU_PLANNING_ID=$planning_id
                ORDER BY CRENEAU_DEBUT";
        return self::getRequete($req);
    }

    public static function getQuotaEnseignants(int $ens_id, int $planning_id) : array
    {
        $req = "SELECT * FROM common_planning_enseignant WHERE PLANNING_ENS_ID=$ens_id AND ENS_PLANNING_ID=$planning_id";
        return self::getRequete($req);
    }

    public static function getNombreCreneauxReels(int $ens_id, int $planning_id) : int
    {
        $req = "SELECT * FROM common_planning_dispo_enseignant,common_planning_creneau WHERE CRENEAU_ENS_ID=$ens_id AND CRENEAU_ID=DISPO_CRENEAU_ID AND CRENEAU_PLANNING_ID=$planning_id";
        return count(self::getRequete($req));
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "PLANNING_SOUT_MAX":
            case "PLANNING_SOUT_FAITES":
            case "PLANNING_SPE" :
                $tab = explode("$",$where);
                $req = "INSERT INTO common_planning_enseignant(ENS_PLANNING_ID,PLANNING_ENS_ID,$tag) VALUES (".$tab[0].",".$tab[1].",$valeurnum) ON DUPLICATE KEY UPDATE $tag=$valeurnum";
                return self::execRequete($req);
            case "DISPO_ENS_PRESENTIEL" :
            case "DISPO_ENS_TELEPHONIQUE" :
            case "DISPO_ENS_VISIO" :
                $tab = explode("$",$where);
                mysql_start_transaction();
                $req = "UPDATE common_planning_dispo_enseignant SET $tag = $valeurnum WHERE CRENEAU_ENS_ID=$tab[0] AND DISPO_CRENEAU_ID=$tab[1] AND DISPO_DATE=$tab[2]";
                if (self::execRequete($req)) {
                    mysql_commit();
                    return true;
                }
                mysql_rollback();
                return false;
            case "DISPO_ENS" :
                $tab = explode("$",$where);
                if ($valeurnum == 1) {
                    mysql_start_transaction();
                    $req = "INSERT INTO common_planning_dispo_enseignant(CRENEAU_ENS_ID, DISPO_CRENEAU_ID, DISPO_DATE, DISPO_PLANNING_ID) VALUES ($tab[0],$tab[1],$tab[2],$tab[3])";
                    if (self::execRequete($req)) {
                        mysql_commit();
                        return true;
                    }
                    mysql_rollback();
                    return false;
                } else {
                    /*$req = "SELECT * FROM common_planning_dispo_enseignant WHERE CRENEAU_ENS_ID=$tab[0] AND DISPO_CRENEAU_ID=$tab[1] AND DISPO_DATE=$tab[2]";
                    if (self::doRequete($req)->num_rows > 0) {
                        return false;
                    }*/
                    $req = "DELETE FROM common_planning_dispo_enseignant WHERE CRENEAU_ENS_ID=$tab[0] AND DISPO_CRENEAU_ID=$tab[1] AND DISPO_DATE=$tab[2] AND DISPO_PLANNING_ID=$tab[3]";

                }
                return self::execRequete($req);
                break;
            case "PLANNING_START_ENS" :
            case "PLANNING_END_ENS" :
            case "PLANNING_START_ET" :
            case "PLANNING_END_ET" :
            case "PLANNING_START" :
            case "PLANNING_END" :
                try {
                    $date_convertie = transformDateHeure($valeur);
                } catch (Exception $e) {
                    return false;
                }
                $req = "UPDATE common_planning SET $tag=$date_convertie WHERE PLANNING_ID=$wherenum";
                return self::execRequete($req);
            case "PLANNING_NB_PARALLELE" :
            case "PLANNING_PUBLIC" :
            case "PLANNING_NB_MEMBRES" :
                $req = "UPDATE common_planning SET $tag=$valeurnum WHERE PLANNING_ID=$wherenum";
                return self::execRequete($req);
            case "PLANNING_CONTENU" :
                $req = "UPDATE common_planning SET $tag='$valeur' WHERE PLANNING_ID=$wherenum";
                return self::execRequete($req);
            case "CRENEAU_DEBUT" :
            case "CRENEAU_FIN" :
                try {
                    $valeurnum = transformHeure($valeur);
                    if (date('w',$valeurnum) == "6" || date('w',$valeurnum) == "0") {
                        return false;
                    }
                } catch (Exception $e) {
                    return false;
                }
                $req = "UPDATE common_planning_creneau SET $tag=$valeurnum WHERE CRENEAU_ID=$wherenum";
                return self::execRequete($req);
                break;
        }
        return false;
    }

    public static function getMixDisponibilites(int $planning_courant, int $jour) : array
    {
        $req = "SELECT *,
                    FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                    FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE,
                    SUM(IF(RDV_ID IS NULL,DISPO_ENS_VISIO,0)) AS DISPO_VISIO,
                    SUM(IF(RDV_ID IS NULL,DISPO_ENS_TELEPHONIQUE,0)) AS DISPO_TELEPHONIQUE,
                    SUM(IF(RDV_ID IS NULL,DISPO_ENS_PRESENTIEL,0)) AS DISPO_PRESENTIEL,
                    SUM(IF(RDV_ID IS NULL,1,0)) AS DISPO_RDV,
                    IF (SUM(IF(RDV_ID IS NULL,DISPO_ENS_PRESENTIEL,0))=0 AND SUM(IF(RDV_ID IS NULL,DISPO_ENS_TELEPHONIQUE,0))=0 AND SUM(IF(RDV_ID IS NULL,DISPO_ENS_VISIO,0))=0,1,0) AS DISPO_FORCE
                    FROM (common_planning_dispo_enseignant,common_planning_creneau)
                    LEFT JOIN common_planning_rendezvous ON (DISPO_ID = RDV_DISPO_ID)
                    WHERE CRENEAU_ID=DISPO_CRENEAU_ID AND DISPO_PLANNING_ID=$planning_courant AND DISPO_DATE=$jour
                    GROUP BY DISPO_DATE,CRENEAU_ID HAVING DISPO_RDV > 0
                    ";
        return self::getRequete($req);
    }

    public static function getPlanningAvecUid(string $planning_uid, int $now) : array
    {
        $req = "SELECT * FROM common_planning
                WHERE PLANNING_UID='$planning_uid' AND
                      PLANNING_PUBLIC = 1 AND
                      PLANNING_START_ET <= $now AND
                      PLANNING_END_ET >= $now";
        return self::getRequeteAvecClef("PLANNING_ID",$req);
    }

    public static function checkStep2RDV(string $planning_uid,int $now, array $post) : bool
    {
        $planning = self::getPlanningAvecUid($planning_uid,$now);
        if (count($planning) != 1) {
            return false;
        }
        foreach ($planning as $un_planning) {
            $req = "SELECT *,
                    SUM(IF(RDV_ID IS NULL,DISPO_ENS_VISIO,0)) AS DISPO_VISIO,
                    SUM(IF(RDV_ID IS NULL,DISPO_ENS_TELEPHONIQUE,0)) AS DISPO_TELEPHONIQUE,
                    SUM(IF(RDV_ID IS NULL,DISPO_ENS_PRESENTIEL,0)) AS DISPO_PRESENTIEL,
                    SUM(IF(RDV_ID IS NULL,1,0)) AS DISPO_RDV,
                    IF (SUM(IF(RDV_ID IS NULL,DISPO_ENS_PRESENTIEL,0))=0 AND SUM(IF(RDV_ID IS NULL,DISPO_ENS_TELEPHONIQUE,0))=0 AND SUM(IF(RDV_ID IS NULL,DISPO_ENS_VISIO,0))=0,1,0) AS DISPO_FORCE
                    FROM (common_planning_dispo_enseignant,common_planning_creneau)
                    LEFT JOIN common_planning_rendezvous ON (DISPO_ID = RDV_DISPO_ID)
                    WHERE CRENEAU_ID=DISPO_CRENEAU_ID AND DISPO_PLANNING_ID=".$un_planning['PLANNING_ID']."
                    AND DISPO_DATE=".$post["bfmw_num_DISPO"]." AND CRENEAU_ID=".$post["bfmw_num_CRENEAU"]."
                    GROUP BY DISPO_DATE,CRENEAU_ID HAVING DISPO_RDV > 0
                    ";
            $creneau = self::getRequete($req);
            if (count($creneau) != 1) {
                return false;
            }
            foreach ($creneau as $un_creneau) {
                if (isset($post['bfmw_orig_PRES']) && $un_creneau["DISPO_PRESENTIEL"] == 0) {
                    return false;
                }
                if (isset($post['bfmw_orig_VIS']) && $un_creneau["DISPO_VISIO"] == 0) {
                    return false;
                }
                if (isset($post['bfmw_orig_TEL']) && $un_creneau["DISPO_TELEPHONIQUE"] == 0) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function checkStep3RDV(string $planning_uid,int $now) : bool
    {
        $planning = self::getPlanningAvecUid($planning_uid,$now);
        if (count($planning) != 1) {
            return false;
        }
        return true;
    }

    public static function creerRDVtemporaire(string $planning_uid,int $now, array $post) : int
    {
        $planning = self::getPlanningAvecUid($planning_uid,$now);
        if (count($planning) != 1) {
            return -1;
        }
        foreach ($planning as $un_planning) {
            $req = "SELECT *,
                    IF (DISPO_ENS_PRESENTIEL=0 AND DISPO_ENS_TELEPHONIQUE=0 AND DISPO_ENS_VISIO=0,1,0) AS DISPO_FORCE,
                    SUM(IF(RDV_ENS_ID IS NULL,0,1)) AS POIDS
                    FROM (common_planning_dispo_enseignant,common_planning_creneau)
                    LEFT JOIN common_planning_rendezvous ON (RDV_ENS_ID=CRENEAU_ENS_ID)
                    WHERE CRENEAU_ID=DISPO_CRENEAU_ID AND DISPO_PLANNING_ID=".$un_planning['PLANNING_ID']."
                    AND DISPO_DATE=".$post["bfmw_num_DISPO"]." AND CRENEAU_ID=".$post["bfmw_num_CRENEAU"]."
                    GROUP BY CRENEAU_ENS_ID
                    ORDER BY POIDS ASC";
            $creneau = self::getRequete($req);
            foreach ($creneau as $un_creneau) {
                if (! Plannings::isUnique($un_creneau["DISPO_ID"],$un_creneau["CRENEAU_ENS_ID"])) {
                    continue;
                }
                if (isset($post['bfmw_orig_PRES']) && $un_creneau["DISPO_ENS_PRESENTIEL"] == 0 && $un_creneau["DISPO_FORCE"] == 0) {
                    continue;
                }
                if (isset($post['bfmw_orig_VIS']) && $un_creneau["DISPO_ENS_VISIO"] == 0 && $un_creneau["DISPO_FORCE"] == 0) {
                    continue;
                }
                if (isset($post['bfmw_orig_TEL']) && $un_creneau["DISPO_ENS_TELEPHONIQUE"] == 0 && $un_creneau["DISPO_FORCE"] == 0) {
                    continue;
                }
                $to_save = array();
                bfmw_add_secured($to_save,"*RDV_PLANNING_ID",$un_planning['PLANNING_ID']);
                bfmw_add_secured($to_save,"*RDV_ENS_ID",$un_creneau['CRENEAU_ENS_ID']);
                bfmw_add_secured($to_save,"*RDV_DISPO_ID",$un_creneau['DISPO_ID']);
                bfmw_add_secured($to_save,"*RDV_SESSION",session_id());
                bfmw_add_secured($to_save,"*RDV_TYPE",isset($post['bfmw_orig_PRES'])?1:(isset($post['bfmw_orig_VIS'])?2:3));
                $to_delete = new DateTime();
                $to_delete = $to_delete->add(new DateInterval("PT10M"));
                bfmw_add_secured($to_save,"*RDV_DATE_DEL",$to_delete->getTimestamp());
                return createData("common_planning_rendezvous",$to_save,6);
            }
        }
        return -1;
    }

    public static function getRendezVousTemporaire(int $rdv_courant,string $session) : array
    {
        $req = "SELECT *,
                DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS DISPO_DATE_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE,
                CASE RDV_TYPE WHEN 1 THEN 'en&nbsp;</span><span class=\"vert\">présentiel' WHEN 3 THEN 'au&nbsp;</span><span class=\"vert\">téléphone' WHEN 2 THEN 'en&nbsp;</span><span class=\"vert\">visio' END  AS TYPE_AFFICHAGE
                FROM common_planning_rendezvous,common_planning_dispo_enseignant,common_planning_creneau
                WHERE CRENEAU_ID=DISPO_CRENEAU_ID AND DISPO_ID=common_planning_rendezvous.RDV_DISPO_ID
                  AND RDV_ID=$rdv_courant AND RDV_SESSION='$session'";
        return self::getRequete($req);
    }

    public static function getRendezVous(int $rdv_courant) : array
    {
        $req = "SELECT *,
                DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS DISPO_DATE_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE,
                CASE RDV_TYPE WHEN 1 THEN 'en présentiel' WHEN 3 THEN 'au téléphone' WHEN 2 THEN 'en visio' END  AS TYPE_AFFICHAGE
                FROM common_planning_rendezvous,common_planning_dispo_enseignant,common_planning_creneau,common_planning_reservation,common_enseignant,common_planning
                WHERE CRENEAU_ID=DISPO_CRENEAU_ID AND DISPO_ID=common_planning_rendezvous.RDV_DISPO_ID AND common_planning_rendezvous.RDV_ID=common_planning_reservation.RDV_ID
                  AND common_planning_rendezvous.RDV_ID=$rdv_courant AND ENS_ID=RDV_ENS_ID AND PLANNING_ID=RDV_PLANNING_ID";
        return self::getRequete($req);
    }

    public static function creerRDVdefinitif(string $planning_uid,int $now, array $post) : int
    {
        $les_rdv = self::getRendezVousTemporaire($post["bfmw_num_r"],session_id());
        if (count($les_rdv) != 1) {
            return -1;
        }
        foreach ($les_rdv as $rdv) {
            $req = "UPDATE common_planning_rendezvous SET RDV_DATE_DEL = null WHERE RDV_ID=" . $rdv["RDV_ID"];
            if (self::execRequeteAvecAffected($req) != 1) {
                return -1;
            }

            bfmw_add_secured($post, "*RDV_ID", $rdv["RDV_ID"]);
            return createData("common_planning_reservation", $post, 7);
        }
        return -1;
    }

    public static function confirmerRDV(array $lesrendezvous)
    {
        foreach ($lesrendezvous as  $un_rdv) {
            $les_planning = self::getUnPlanning($un_rdv["RDV_PLANNING_ID"]);
            foreach ($les_planning as $un_planning) {
                sendMail($un_rdv["RDV_MAIL"],
                    html_entity_decode("Université Clermont Auvergne - IUT - département informatique", ENT_QUOTES),
                    html_entity_decode("Bonjour,\n\nVotre rendez-vous pour ".$un_planning["PLANNING_CONTENU"].
                        " du département informatique de l'IUT de Clermont Auvergne est confirmé.\n\nIl aura lieu le ".
                        $un_rdv["DISPO_DATE_AFFICHAGE"]." de ".$un_rdv["CRENEAU_DEBUT_AFFICHAGE"]." à ".$un_rdv["CRENEAU_FIN_AFFICHAGE"]. " " .$un_rdv["TYPE_AFFICHAGE"].
                        ".\nToutes les informations nécessaires au bon déroulement de votre entretien vous seront communiquées quelques temps avant par l'enseignant qui est en charge de votre rendez-vous.".
                        "\n\nBien cordialement\n\nL'équipe de recrutement du département informatique de l'IUT de Clermont Auvergne.", ENT_QUOTES),
                    "", "", "Plateforme de prise de rendez-vous <noreply+odin@uca.fr>");

                sendMail($un_rdv["ENS_MAIL"],
                    html_entity_decode("Prise de rendez-vous pour ".$un_planning["PLANNING_CONTENU"], ENT_QUOTES),
                    html_entity_decode("Bonjour,\n\nun rendez-vous a été pris pour ".$un_planning["PLANNING_CONTENU"].
                        "\n\nVoici les informations :\n".
                        $un_rdv["DISPO_DATE_AFFICHAGE"]." de ".$un_rdv["CRENEAU_DEBUT_AFFICHAGE"]." à ".$un_rdv["CRENEAU_FIN_AFFICHAGE"]. " " .$un_rdv["TYPE_AFFICHAGE"].
                        "\n\tNom de l'étudiant : ".$un_rdv["RDV_NOM"]."\n".
                        "\tPrénom de l'étudiant : ".$un_rdv["RDV_PRENOM"]."\n".
                        "\tNuméro de dossier parcoursup : ".$un_rdv["RDV_NUMERO"]."\n".
                        "\tNuméro de téléphone de l'étudiant : ".$un_rdv["RDV_TEL"]."\n".
                        "\tMail de l'étudiant : ".$un_rdv["RDV_MAIL"]."\n".
                        "\tCommentaire : ".$un_rdv["RDV_COMMENTAIRE"]."\n".
                        "\n\nPensez à contacter, le cas échéant, l'étudiant pour lui préciser le lieu de rendez-vous, les modalités téléphoniques (c'est vous qui appelez, c'est lui...) ou le lien de visio.".
                        "\n\nCordialement", ENT_QUOTES),"cedric.bouhours@uca.fr");
            }
        }
    }

    public static function cleanRendezVousTemporaires()
    {
        $req = "DELETE FROM common_planning_rendezvous WHERE RDV_DATE_DEL<".time();
        self::execRequete($req);
    }

    public static function cleanDisponibilitesNonAffecteesEtPassees()
    {
        $req = "DELETE FROM common_planning_dispo_enseignant WHERE DISPO_ID IN (
                    SELECT DISPO_ID
                    FROM common_planning_dispo_enseignant
                    LEFT JOIN common_planning_rendezvous ON (DISPO_ID = RDV_DISPO_ID AND RDV_ENS_ID = CRENEAU_ENS_ID AND RDV_PLANNING_ID=DISPO_PLANNING_ID) 
                    WHERE DISPO_DATE<".time()." AND RDV_ID IS NULL)";
        self::execRequete($req);
    }

    public static function getRendezVousDeLEnseignant(int $planning_id, int $ens_id) : array
    {
        $req = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS DATE_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE,
                CASE RDV_TYPE WHEN 1 THEN 'en&nbsp;</span><span class=\"vert\">présentiel' WHEN 3 THEN 'au&nbsp;</span><span class=\"vert\">téléphone' WHEN 2 THEN 'en&nbsp;</span><span class=\"vert\">visio' END  AS TYPE_AFFICHAGE,
                CONCAT (RDV_NOM,' ',RDV_PRENOM,' - ',RDV_NUMERO) AS RDV_NOM_AFFICHAGE
                FROM common_planning_rendezvous,common_planning_creneau,common_planning_dispo_enseignant,common_planning_reservation
                WHERE RDV_PLANNING_ID=$planning_id AND RDV_ENS_ID=$ens_id 
                AND CRENEAU_ENS_ID=RDV_ENS_ID AND DISPO_ID=RDV_DISPO_ID AND CRENEAU_ID=DISPO_CRENEAU_ID
                AND common_planning_rendezvous.RDV_ID=common_planning_reservation.RDV_ID
                ORDER BY DISPO_DATE,CRENEAU_DEBUT";
        return self::getRequete($req);
    }

    public static function getTousLesRendezVousDeLEnseignant(int $planning_id) : array
    {
        $req = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS DATE_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE,
                CASE RDV_TYPE WHEN 1 THEN 'en&nbsp;</span><span class=\"vert\">présentiel' WHEN 3 THEN 'au&nbsp;</span><span class=\"vert\">téléphone' WHEN 2 THEN 'en&nbsp;</span><span class=\"vert\">visio' END  AS TYPE_AFFICHAGE,
                CONCAT (RDV_NOM,' ',RDV_PRENOM,' - ',RDV_NUMERO) AS RDV_NOM_AFFICHAGE
                FROM common_planning_rendezvous,common_planning_creneau,common_planning_dispo_enseignant,common_planning_reservation,common_enseignant
                WHERE RDV_PLANNING_ID=$planning_id AND RDV_ENS_ID=ENS_ID 
                AND CRENEAU_ENS_ID=RDV_ENS_ID AND DISPO_ID=RDV_DISPO_ID AND CRENEAU_ID=DISPO_CRENEAU_ID
                AND common_planning_rendezvous.RDV_ID=common_planning_reservation.RDV_ID
                ORDER BY DISPO_DATE,CRENEAU_DEBUT";
        return self::getRequete($req);
    }

    public static function supprimerRDV(int $rdv_id) : int
    {
        $les_rdv = self::getRendezVous($rdv_id);
        foreach ($les_rdv as $un_rdv) {
            sendMail($un_rdv["RDV_MAIL"],
                html_entity_decode("Université Clermont Auvergne - IUT - département informatique", ENT_QUOTES),
                html_entity_decode("Bonjour,\n\nVotre rendez-vous du ".$un_rdv["DISPO_DATE_AFFICHAGE"]." de ".
                    $un_rdv["CRENEAU_DEBUT_AFFICHAGE"]." à ".$un_rdv["CRENEAU_FIN_AFFICHAGE"]. " " .$un_rdv["TYPE_AFFICHAGE"]." pour ".$un_rdv["PLANNING_CONTENU"].
                    " du département informatique de l'IUT de Clermont Auvergne vient d'être annulé. Si vous le souhaitez, nous vous invitons à reprendre un rendez-vous rapidement.".
                    "\n\nBien cordialement\n\nL'équipe de recrutement du département informatique de l'IUT de Clermont Auvergne.", ENT_QUOTES),
                "", "", "Plateforme de prise de rendez-vous <noreply+odin@uca.fr>");

            sendMail($un_rdv["ENS_MAIL"],
                html_entity_decode("ANNULATION de rendez-vous pour ".$un_rdv["PLANNING_CONTENU"], ENT_QUOTES),
                html_entity_decode("Bonjour,\n\nun rendez-vous pris pour ".$un_rdv["PLANNING_CONTENU"].
                    " est annulé :\n".
                    $un_rdv["DISPO_DATE_AFFICHAGE"]." de ".$un_rdv["CRENEAU_DEBUT_AFFICHAGE"]." à ".$un_rdv["CRENEAU_FIN_AFFICHAGE"]. " " .$un_rdv["TYPE_AFFICHAGE"].
                    "\n\tNom de l'étudiant : ".$un_rdv["RDV_NOM"]."\n".
                    "\tPrénom de l'étudiant : ".$un_rdv["RDV_PRENOM"]."\n".
                    "\tNuméro de dossier parcoursup : ".$un_rdv["RDV_NUMERO"]."\n".
                    "\tNuméro de téléphone de l'étudiant : ".$un_rdv["RDV_TEL"]."\n".
                    "\tMail de l'étudiant : ".$un_rdv["RDV_MAIL"]."\n".
                    "\tCommentaire : ".$un_rdv["RDV_COMMENTAIRE"]."\n".
                    "\n\nCordialement", ENT_QUOTES),"cedric.bouhours@uca.fr");
        }
        $req = "DELETE FROM common_planning_rendezvous WHERE RDV_ID=$rdv_id";
        return self::execRequeteAvecAffected($req);
    }

    private static function isUnique(int $DISPO_ID, int $DISPO_ENS_ID) : bool
    {
        $req = "SELECT * FROM common_planning_rendezvous WHERE RDV_DISPO_ID=$DISPO_ID AND RDV_ENS_ID=$DISPO_ENS_ID";
        return count(self::getRequete($req)) == 0;
    }
}