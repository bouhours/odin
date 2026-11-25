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

class Soutenances extends Connectable
{
    public static function creerPlanning(array $data) : int {
        return createData("common_soutenances_planning",$data,3);
    }

    public static function supprimerPlanning(int $planning_id) : bool {
        $req = "DELETE FROM common_soutenances_planning WHERE PLANNING_ID=$planning_id";
        return self::execRequete($req);
    }

    public static function supprimerCreneau(int $creneau_id) : bool {
        $req = "DELETE FROM common_soutenances_planning_creneau WHERE CRENEAU_ID=$creneau_id";
        return self::execRequete($req);
    }

    public static function getUnPlanning(int $planning_id) : array {
        $req = "SELECT * FROM common_soutenances_planning WHERE PLANNING_ID=$planning_id";
        return self::getRequete($req);
    }

    public static function getPlanning(int $DEPT_ID,int $annee_id, string $complement="") : array {
        $req = "SELECT *,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START_ENS),'%d/%m/%Y %Hh%i') AS PLANNING_START_ENS_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END_ENS),'%d/%m/%Y %Hh%i') AS PLANNING_END_ENS_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START_ET),'%d/%m/%Y %Hh%i') AS PLANNING_START_ET_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END_ET),'%d/%m/%Y %Hh%i') AS PLANNING_END_ET_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_SOUTENANCES_START),'%d/%m/%Y %Hh%i') AS PLANNING_SOUTENANCES_START_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_SOUTENANCES_END),'%d/%m/%Y %Hh%i') AS PLANNING_SOUTENANCES_END_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_SOUTENANCES_START),'%d/%m/%Y') AS PLANNING_SOUTENANCES_START_AFFICHAGE_DATE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_SOUTENANCES_END),'%d/%m/%Y') AS PLANNING_SOUTENANCES_END_AFFICHAGE_DATE
                FROM common_soutenances_planning
                WHERE $complement PLANNING_DEPT_ID=$DEPT_ID AND PLANNING_ANNEE_ID=$annee_id
                ORDER BY PLANNING_SOUTENANCES_START,PLANNING_SOUTENANCES_END, PLANNING_CONTENU";
        return self::getRequeteAvecClef("PLANNING_ID",$req);
    }

    public static function getPlanningAvecCreneaux(int $DEPT_ID,int $annee_id) : array {
        $req = "SELECT *,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START_ENS),'%d/%m/%Y %Hh%i') AS PLANNING_START_ENS_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END_ENS),'%d/%m/%Y %Hh%i') AS PLANNING_END_ENS_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_START_ET),'%d/%m/%Y %Hh%i') AS PLANNING_START_ET_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_END_ET),'%d/%m/%Y %Hh%i') AS PLANNING_END_ET_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(PLANNING_SOUTENANCES_START),'%d/%m/%Y %Hh%i') AS PLANNING_SOUTENANCES_START_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(PLANNING_SOUTENANCES_END),'%d/%m/%Y %Hh%i') AS PLANNING_SOUTENANCES_END_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                FROM common_soutenances_planning LEFT JOIN common_soutenances_planning_creneau ON (PLANNING_ID=CRENEAU_PLANNING_ID)
                WHERE PLANNING_DEPT_ID=$DEPT_ID AND PLANNING_ANNEE_ID=$annee_id
                ORDER BY PLANNING_SOUTENANCES_START,PLANNING_SOUTENANCES_END, PLANNING_CONTENU, PLANNING_ID, CRENEAU_DEBUT, CRENEAU_FIN";
        return self::getRequete($req);
    }

    public static function creerCreneau(array $data) : int {
        return createData("common_soutenances_planning_creneau",$data,3);
    }

    public static function creerDisponibilite(array $data) : int {
        return createData("common_soutenances_planning_dispo_enseignant", $data, 4);
    }

    public static function suppressionDisponibilite(int $ens_id, int $dispo_id, int $planning_id) : ?bool {
        $req = "SELECT * FROM common_soutenances_planning_creneau_enseignant WHERE CRENEAU_DISPO_ID=$dispo_id AND DISPO_CRENEAU_STAGE_ID IS NOT NULL";
        if (self::doRequete($req)->num_rows > 0) {
            return null;
        }

        $req = "DELETE FROM common_soutenances_planning_dispo_enseignant WHERE DISPO_ID=$dispo_id AND DISPO_PLANNING_ID=$planning_id AND DISPO_ENS_ID=$ens_id";
        return self::execRequete($req);
    }

    public static function isDateAutoriseeDansLePlanning(int $date, int $planning_courant) : bool {
        $req = "SELECT * FROM common_soutenances_planning WHERE PLANNING_SOUTENANCES_START <= $date AND PLANNING_SOUTENANCES_END >= $date AND PLANNING_ID=$planning_courant";
        return self::doRequete($req)->num_rows == 1;
    }

    public static function getDisponibilites(int $ens_id,int $annee_courante,int $planning_courant) : array{
        $req = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS DISPO_DATE_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE,
                IF(DISPO_ID=CRENEAU_DISPO_ID AND CRENEAU_ID=DISPO_CRENEAU_ID,'checked','') AS DISPO_CHECKED
                FROM (common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau)
                LEFT JOIN common_soutenances_planning_creneau_enseignant ON (DISPO_ID=CRENEAU_DISPO_ID AND CRENEAU_ID=DISPO_CRENEAU_ID)
                WHERE CRENEAU_PLANNING_ID=DISPO_PLANNING_ID AND DISPO_ENS_ID=$ens_id AND DISPO_ANNEE_ID=$annee_courante
                AND DISPO_PLANNING_ID=$planning_courant
                ORDER BY DISPO_DATE,DISPO_ID,CRENEAU_DEBUT,CRENEAU_FIN,CRENEAU_ID";
        return self::getRequete($req);
    }

    public static function getNombreSoutenancesPourUnEnseignant(int $ens_id, int $annee_id) : int {
        $retour = 0;

        $req = "SELECT * FROM common_soutenances_planning_enseignant WHERE PLANNING_ENS_ID=$ens_id AND PLANNING_ANNEE_ID=$annee_id";
        if ($un_enseignant = self::doRequete($req)->fetch_assoc()) {
            $retour = Generation_Planning_Soutenances::getNombreSoutenancesDejaPlacees($annee_id,$ens_id);
            $deja_placees = 0;
            if (count($retour) == 1) {
                $deja_placees = $retour[$ens_id]['TOTAL'];
            }
            return max(0,($un_enseignant['PLANNING_SOUT_MAX']-$un_enseignant['PLANNING_SOUT_FAITES']-$deja_placees));
        }

        return $retour;
    }

    public static function getSoutenances(int $planning_id, int $annee_id) : array {
        $req = "SELECT common_stage.*,common_soutenances_planning_stage.*,ET_ID,ET_NOM,IFNULL(STAGE_DATE_SOUTENANCE,9999999999) AS SORT,CRENEAU_ID,ENS_NOM AS TUTEUR,
                DATE_FORMAT(FROM_UNIXTIME(STAGE_DATE_SOUTENANCE),'%d/%m/%Y') AS DISPO_DATE_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                FROM (common_stage,common_etudiant,common_enseignant)   
                LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID=PLANNING_STAGE_ID AND STAGE_PLANNING_ANNEE_ID = $annee_id)
                LEFT JOIN common_soutenances_planning_creneau ON (CRENEAU_ID=STAGE_SOUTENANCE_CRENEAU_ID) 
                WHERE STAGE_PLANNING_ID=$planning_id AND STAGE_ANNEE_ID=$annee_id
                AND ET_ID=STAGE_ET_ID AND ENS_ID=STAGE_ENS_ID
                ORDER BY SORT,CRENEAU_DEBUT,CRENEAU_FIN,CRENEAU_ID,ET_NOM,ET_ID
                ";
        $soutenances = self::getRequeteAvecClef("STAGE_ID",$req);
        foreach ($soutenances as &$une_soutenance) {
            if ($une_soutenance['STAGE_JURY_ENS_ID'] !== null) {
                $une_soutenance['JURY'] = Enseignants::getEnseigant($une_soutenance['STAGE_JURY_ENS_ID'])[0]["ENS_NOM"];
            } else {
                $une_soutenance['JURY'] = "?";
            }
            if ($une_soutenance["STAGE_DATE_SOUTENANCE"] == "") {
                $une_soutenance['LES_CRENEAUX'] = Generation_Planning_Soutenances::getCreneauxDeSoutenancesPossibles($une_soutenance["ET_ID"], $une_soutenance["STAGE_ID"], $planning_id, $annee_id, CURRENT_DEPT_ID);
                $une_soutenance['NB_CRENEAUX_POSSIBLES'] = count($une_soutenance['LES_CRENEAUX']);
            } else {
                $une_soutenance['LES_CRENEAUX'] = array();
                $une_soutenance['NB_CRENEAUX_POSSIBLES'] = "";
            }
        }
        return $soutenances;
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "DISPO_ENS" :
                $tab = explode("$",$where);
                if ($valeurnum == 1) {
                    mysql_start_transaction();
                    $req = "INSERT INTO common_soutenances_planning_creneau_enseignant(CRENEAU_DISPO_ID, DISPO_CRENEAU_ID) VALUES ($tab[0],$tab[1])";
                    if (self::execRequete($req)) {
                        if (Generation_Planning_Soutenances::checkCreneauxAFermer($tab[0],$tab[1])) {
                            mysql_commit();
                            return true;
                        }
                    }
                    mysql_rollback();
                    return false;
                } else {
                    $req = "SELECT * FROM common_soutenances_planning_creneau_enseignant WHERE CRENEAU_DISPO_ID=$tab[0] AND DISPO_CRENEAU_ID=$tab[1] AND DISPO_CRENEAU_STAGE_ID IS NOT NULL";
                    if (self::doRequete($req)->num_rows > 0) {
                        return false;
                    }

                    $req = "DELETE FROM common_soutenances_planning_creneau_enseignant WHERE CRENEAU_DISPO_ID=$tab[0] AND DISPO_CRENEAU_ID=$tab[1]";
                }
                return self::execRequete($req);
                break;
            case "PLANNING_START_ENS" :
            case "PLANNING_END_ENS" :
            case "PLANNING_START_ET" :
            case "PLANNING_END_ET" :
            case "PLANNING_SOUTENANCES_START" :
            case "PLANNING_SOUTENANCES_END" :
                try {
                    $date_convertie = transformDateHeure($valeur);
                } catch (Exception $e) {
                    return false;
                }
                $req = "UPDATE common_soutenances_planning SET $tag=$date_convertie WHERE PLANNING_ID=$wherenum";
                return self::execRequete($req);
                break;
            case "PLANNING_SOUTENANCES_NB_SALLES" :
                $req = "UPDATE common_soutenances_planning SET $tag=$valeurnum WHERE PLANNING_ID=$wherenum";
                return self::execRequete($req);
                break;
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
                $req = "UPDATE common_soutenances_planning_creneau SET $tag=$valeurnum WHERE CRENEAU_ID=$wherenum";
                return self::execRequete($req);
                break;
        }
        return false;
    }

    public static function getPlanningChoisis(int $stage_affecte, string $annee_courante) : array
    {
        $req = "SELECT * FROM common_soutenances_planning_stage WHERE PLANNING_STAGE_ID=$stage_affecte AND STAGE_PLANNING_ANNEE_ID=$annee_courante";
        return self::getRequeteAvecClef("STAGE_PLANNING_ID",$req);
    }

    public static function getSoutenancesEtudiant(int $et_id, int $planning_id, int $annee_id) : array
    {
        $req = "SELECT common_stage.*,common_soutenances_planning_stage.*,ET_ID,ET_NOM,IFNULL(STAGE_DATE_SOUTENANCE,9999999999) AS SORT,CRENEAU_ID,ENS_NOM AS TUTEUR,
                DATE_FORMAT(FROM_UNIXTIME(STAGE_DATE_SOUTENANCE),'%d/%m/%Y') AS DISPO_DATE_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                FROM (common_stage,common_etudiant,common_enseignant)   
                LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID=PLANNING_STAGE_ID AND STAGE_PLANNING_ANNEE_ID = $annee_id)
                LEFT JOIN common_soutenances_planning_creneau ON (CRENEAU_ID=STAGE_SOUTENANCE_CRENEAU_ID) 
                WHERE STAGE_PLANNING_ID=$planning_id AND STAGE_ANNEE_ID=$annee_id
                AND ET_ID=STAGE_ET_ID AND ENS_ID=STAGE_ENS_ID AND ET_ID=$et_id
                ORDER BY SORT,CRENEAU_DEBUT,CRENEAU_FIN,CRENEAU_ID,ET_NOM,ET_ID
                ";
        $soutenances = self::getRequeteAvecClef("STAGE_ID", $req);
        foreach ($soutenances as &$une_soutenance) {
            if ($une_soutenance['STAGE_JURY_ENS_ID'] !== null) {
                $une_soutenance['JURY'] = Enseignants::getEnseigant($une_soutenance['STAGE_JURY_ENS_ID'])[0]["ENS_NOM"];
            } else {
                $une_soutenance['JURY'] = "?";
            }
            if ($une_soutenance["STAGE_DATE_SOUTENANCE"] == "") {
                $une_soutenance['LES_CRENEAUX'] = Generation_Planning_Soutenances::getCreneauxDeSoutenancesPossibles($une_soutenance["ET_ID"], $une_soutenance["STAGE_ID"], $planning_id, $annee_id, CURRENT_DEPT_ID);
                $une_soutenance['NB_CRENEAUX_POSSIBLES'] = count($une_soutenance['LES_CRENEAUX']);
            } else {
                $une_soutenance['LES_CRENEAUX'] = array();
                $une_soutenance['NB_CRENEAUX_POSSIBLES'] = "";
            }
        }
        return $soutenances;
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

    public static function creerDisponibiliteAutomatiquement(int $ens_id,int $annee_courante, array $les_planning)
    {
        foreach ($les_planning as $un_planning) {
            for ($i=$un_planning['PLANNING_SOUTENANCES_START'];$i<$un_planning['PLANNING_SOUTENANCES_END'];$i += 86400) {

                $to_save = array();
                bfmw_add_secured($to_save,"*DISPO_ENS_ID",$ens_id);
                bfmw_add_secured($to_save,"*DISPO_ANNEE_ID",$annee_courante);
                bfmw_add_secured($to_save,"*DISPO_PLANNING_ID ",$un_planning['PLANNING_ID']);
                bfmw_add_secured($to_save,"*DISPO_DATE ",$i);
                self::creerDisponibilite($to_save);
            }
        }
    }
}