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

class Absences extends Connectable
{
    public static function getAbsencesNewGen(int $annee_courante=-1, int $expire = -1, string $ET_ID="=ET_ID", string $ENS_ID="ENS_ID",string $complement = "",string $groupby="",string $orderby="ORDER BY GROUPE_NOM, GROUPE_ID, ET_ID, ABS_REAL_DATE, CRENEAU_REAL_START, CRENEAU_REAL_END, EDT_DATE_DEBUT, EDT_DATE_FIN, MAT_NOM",string $cols="common_absences_v2.*,ABST_NOM,ET_NOM, ET_NUMERO,ET_ID,GROUPE_ID,GROUPE_NOM, GROUPE_PRO, GROUPE_CODE, MAT_ID,EDT_NOM, ENS_NOM, CRENEAU_NOM, EDT_DATE_DEBUT, EDT_HEURE_DEBUT, EDT_DATE_FIN, EDT_HEURE_FIN",bool $count = false) : array {
        if ($count) {
            $req = "SELECT $cols,ABS_REAL_DATE, MAT_NOM, EDT_HEURE_DEBUT, EDT_HEURE_FIN, EDT_NOM FROM (common_absences_v2,common_enseignant,common_annee) LEFT JOIN common_absences_type ON (ABST_ID=ABS_ABST_ID) LEFT JOIN common_matiere ON (MAT_ID=ABS_MAT_ID) LEFT JOIN common_absences_creneau ON (CRENEAU_ID=ABS_CRENEAU_ID) LEFT JOIN common_backup_ade_enseignant ON (EDT_UID = ABS_EDT_UID AND ENS_ID=EDT_ENS_ID) WHERE $complement ANNEE_ID=ABS_ANNEE_ID AND ENS_ID=ABS_ENS_ID AND ABS_ET_ID $ET_ID ".($annee_courante==-1?"":"AND ABS_ANNEE_ID=$annee_courante")." ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND ABS_ENS_ID=$ENS_ID $groupby $orderby";
        } else {
            $req = "SELECT DISTINCT $cols,ABS_REAL_DATE, MAT_NOM, ET_PROFESSIONNALISATION, EDT_HEURE_DEBUT, EDT_HEURE_FIN, EDT_NOM FROM (common_absences_v2,etudiants_groupes,common_enseignant,common_annee) LEFT JOIN common_absences_type ON (ABST_ID=ABS_ABST_ID) LEFT JOIN common_matiere ON (MAT_ID=ABS_MAT_ID) LEFT JOIN common_absences_creneau ON (CRENEAU_ID=ABS_CRENEAU_ID) LEFT JOIN common_backup_ade_enseignant ON (EDT_UID = ABS_EDT_UID AND ENS_ID=EDT_ENS_ID) WHERE $complement ANNEE_ID=ABS_ANNEE_ID AND ENS_ID=ABS_ENS_ID  AND ET_ID=ABS_ET_ID AND ET_ID $ET_ID AND GROUPE_FEUILLE=1 ".($annee_courante==-1?"":"AND ET_GROUPE_ANNEE_ID=$annee_courante AND ABS_ANNEE_ID=$annee_courante")." ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND ABS_ENS_ID=$ENS_ID $groupby $orderby";
        }
        $res = self::$conn->query($req);
        $retour = array();
        while ($date = $res->fetch_assoc()) {
            $date['REAL_DATE'] = date("d/m/Y",$date['ABS_REAL_DATE']);
            if ($date['MAT_NOM'] == "") {
                $date['CRENEAU_NOM'] = date("H:i", $date['EDT_HEURE_DEBUT']) . " - " . date("H:i", $date['EDT_HEURE_FIN']);
                $date['MAT_NOM'] = $date['EDT_NOM'];
            }
            $retour[] = $date;
        }
        return $retour;
    }

    public static function getAbsencesToMailNewGen(int $annee_courante) : array {
        $req = "SELECT GROUPE_ID,GROUPE_NOM,ET_NOM,ET_MAIL,ENS_NOM, ABS_REAL_DATE, ABST_NOM,MAT_NOM,CRENEAU_NOM,ABS_ID,EDT_HEURE_DEBUT,EDT_HEURE_FIN, EDT_NOM, GROUPE_ENS_ID FROM (common_absences_v2,common_enseignant,etudiants_groupes) LEFT JOIN common_matiere ON (MAT_ID=ABS_MAT_ID) LEFT JOIN common_absences_type ON (ABST_ID=ABS_ABST_ID) LEFT JOIN common_absences_creneau ON (CRENEAU_ID=ABS_CRENEAU_ID) LEFT JOIN common_backup_ade_enseignant ON (EDT_UID=ABS_EDT_UID AND EDT_ENS_ID=ABS_ENS_ID) WHERE  ABS_MAIL=0 AND ET_ID=ABS_ET_ID AND ENS_ID=ABS_ENS_ID AND ABS_ANNEE_ID=$annee_courante AND GROUPE_ENS_ID IS NOT NULL AND ET_GROUPE_ANNEE_ID=$annee_courante AND ABS_JUSTIFICATION='non' ORDER BY GROUPE_NOM,GROUPE_ID,GROUPE_ENS_ID,ET_NOM,ABS_REAL_DATE,CRENEAU_REAL_START";

        $res = self::$conn->query($req);
        $retour = array();
        while ($date = $res->fetch_assoc()) {
            if ($date['MAT_NOM']== null) {
                $date['CRENEAU_NOM'] = date("H:i", $date['EDT_HEURE_DEBUT']) . " - " . date("H:i", $date['EDT_HEURE_FIN']);
                $date['MAT_NOM'] = $date['EDT_NOM'];
            }
            $retour[$date['GROUPE_ENS_ID']][] = $date;
        }
        return $retour;
    }

    public static function getNombreAbsencesNewGen(string $ET_ID,int $annee_courante=-1, int $expire = -1, string $ENS_ID="ABS_ENS_ID",string $complement = "") : int {
        $req = "SELECT * FROM common_absences_v2 WHERE $complement ABS_ET_ID=$ET_ID AND ".($annee_courante==-1?"":"ABS_ANNEE_ID=$annee_courante")." ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND ABS_ENS_ID=$ENS_ID";
        $res = self::$conn->query($req);
        return $res->num_rows;
    }

    public static function getOldAbsencesSeules(string $ET_ID, string $cols="*",string $complement = "", string $groupby="", string $orderby="")
    {
        $req = "SELECT $cols FROM common_absences, common_absences_creneau WHERE $complement ABS_ET_ID=$ET_ID AND CRENEAU_ID=ABS_CRENEAU_ID $groupby $orderby";
        $res = self::$conn->query($req);
        $retour = array();
        while ($date = $res->fetch_assoc()) {
            $retour[] = $date;
        }
        return $retour;
    }

    public static function getNombreDeDemiJourneesNonJustifiees(int $ET_ID,int $expire = 0, string $ENS_ID="ABS_ENS_ID",int $annee_courante=-1, string $complement = "", bool $justifiees = false) : int
    {
        $req = "SELECT COUNT(*),`CRENEAU_DEMI` FROM common_absences_v2,common_absences_creneau WHERE $complement ".($annee_courante==-1?"":"ABS_ANNEE_ID=$annee_courante AND")." ABS_ENS_ID=$ENS_ID AND CRENEAU_ID=ABS_CRENEAU_ID  ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND ABS_ET_ID=$ET_ID AND ABS_JUSTIFICATION".($justifiees?"<>":"=")."'non' GROUP BY ABS_DATE";
        $retour = self::$conn->query($req)->num_rows;

        /*$req = "SELECT * FROM common_absences_v2,common_backup_ade_enseignant WHERE ".($annee_courante==-1?"":"ABS_ANNEE_ID=$annee_courante AND")." ABS_ENS_ID=$ENS_ID AND ABS_MAT_ID IS NULL AND ABS_ENS_ID=EDT_ENS_ID AND EDT_UID=ABS_EDT_UID ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND ABS_ET_ID=$ET_ID ORDER BY EDT_DATE_DEBUT,EDT_HEURE_DEBUT";
        $res = self::$conn->query($req);
        $les_demi_journees = array();
        $date_en_cours = -1;
        $horaire_en_cours = -1;
        $matin = false;
        $aprem = false;
        $demi = 0;
        while ($date = $res->fetch_assoc()) {
            if ($date_en_cours != date("j/m/Y", $date['EDT_DATE_DEBUT'])) {
                $date_en_cours = date("j/m/Y", $date['EDT_DATE_DEBUT']);
                $matin = false;
                $aprem = false;
                $les_demi_journees[$date_en_cours] = 0;
            }

            if ($horaire_en_cours != $date['EDT_HEURE_DEBUT']) {
                $horaire_en_cours = $date['EDT_HEURE_DEBUT'];
                if (date("H", $date['EDT_HEURE_DEBUT']) < 12 && !$matin) {
                    if ($date['ABS_JUSTIFICATION']=='non') {
                        $matin = true;
                        $les_demi_journees[$date_en_cours]++;
                    }
                }
                if (date("H", $date['EDT_HEURE_DEBUT']) > 12 && !$aprem) {
                    if ($date['ABS_JUSTIFICATION']=='non') {
                        $aprem = true;
                        $les_demi_journees[$date_en_cours]++;
                    }
                }
            }
        }
        //Calcul du nombre de demi journées.
        foreach ($les_demi_journees as $aajouter) {
            $demi += $aajouter;
        }*/
        $demi=0;

        return $retour + $demi;

    }

//    public static function getDemisJourneesNonJustifieesToutEtudiant() : array
//    {
//        $req = "SELECT DISTINCT ABS_ET_ID,ABS_ANNEE_ID FROM common_absences_v2,common_inscription,common_semestre,common_formation WHERE INSCRIPT_ANNEE_ID=ABS_ANNEE_ID AND INSCRIPT_ET_ID=ABS_ET_ID AND SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=SEM_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND ABS_ANNEE_ID IS NOT NULL";
//        $res = self::$conn->query($req);
//        $retour = array();
//        while ($un_etudiant = $res->fetch_assoc()) {
//            $un_etudiant['TOTAL'] = self::getNombreDeDemiJourneesNonJustifiees($un_etudiant['ABS_ET_ID'],-1,"ABS_ENS_ID",$un_etudiant['ABS_ANNEE_ID']);
//            $retour[] = $un_etudiant;
//        }
//
//        return $retour;
//    }

//    public static function getOldDemisJourneesNonJustifieesToutEtudiant() : array
//    {
//        $req = "SELECT ABS_ET_ID,COUNT(*) AS TOTAL  FROM common_absences,common_absences_creneau WHERE CRENEAU_ID=ABS_CRENEAU_ID AND ABS_JUSTIFICATION='non' GROUP BY ABS_ET_ID,`CRENEAU_DEMI`,ABS_REAL_DATE";
//        $res = self::$conn->query($req);
//        $retour = array();
//        while ($date = $res->fetch_assoc()) {
//            $retour[] = $date;
//        }
//        return $retour;
//    }

    public static function getNombreAbsencesNonJustifiees(int $ET_ID,int $expire = 0, string $ENS_ID="ABS_ENS_ID",int $annee_courante=-1,$complement = "") : int
    {
        $req = "SELECT common_absences_v2.ABS_ID FROM common_absences_v2,common_absences_creneau WHERE $complement ".($annee_courante==-1?"":"ABS_ANNEE_ID=$annee_courante AND")." ABS_ENS_ID=$ENS_ID AND CRENEAU_ID=ABS_CRENEAU_ID AND ABS_ET_ID=$ET_ID ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND ABS_JUSTIFICATION='non'";
        return self::$conn->query($req)->num_rows;
    }

    public static function getNombreAbsencesExcusees(int $ET_ID,int $expire = 0, string $ENS_ID="ABS_ENS_ID",int $annee_courante=-1) : int
    {
        $req = "SELECT ABS_ID FROM common_absences_v2 WHERE ".($annee_courante==-1?"":"ABS_ANNEE_ID=$annee_courante AND")." ABS_ENS_ID=$ENS_ID AND ABS_ET_ID=$ET_ID ".($expire===-1?"":"AND ABS_EXPIRE='$expire'")." AND (ABS_EXCUSE<>'' OR ABS_EXCUSE IS NOT NULL)";
        return self::$conn->query($req)->num_rows;
    }

    public static function getNombreJustificationsAValider(int $ET_ID) : int
    {
        $req = "SELECT * FROM common_absences_justifications WHERE JUSTIF_ET_ID=$ET_ID AND JUSTIF_ATTENTE=1";
        return self::$conn->query($req)->num_rows;
    }

    public static function formatDemiJournees($demi) : string
    {
        return $demi.($demi<2?" journée":" journées");
    }

    public static function formatNonJustifiee($justif) : string
    {
        return "non ".($justif<2?"justifiée":"justifiées");
    }

    public static function formatAbsences($nbtotal) : string
    {
        return $nbtotal.($nbtotal<2?" absence":" absences");
    }

    public static function afficheurAbsences($ET_ID,Template &$template, string $expire, string $nommage, string $total, int $annee_courante=-1, string $prefixe="show.",string $complement=""): void
    {
        //Récupération des absences
        $abs = self::getAbsencesNewGen($annee_courante,$expire,"=".$ET_ID,"ENS_ID",$complement,"GROUP BY MAT_ID,EDT_NOM","","COUNT(*) AS TOTAL, SUM(CASE WHEN ABS_JUSTIFICATION='non' THEN 1 ELSE 0 END) AS NON_JUSTIF, ENS_NOM, EDT_HEURE_DEBUT, EDT_HEURE_FIN, EDT_NOM",true);
        //$abs = self::getAbsences($_GET['bfmw_num_e'],$expire,"*,COUNT(*) AS TOTAL, SUM(CASE WHEN ABS_JUSTIFICATION='non' THEN 1 ELSE 0 END) AS NON_JUSTIF","","GROUP BY ABS_MAT_ID","");
        //$nbtotal = count(self::getAbsences($_GET['bfmw_num_e'],$expire));
        $nbtotal = 0;
        foreach($abs as $une_absence) {
            $une_absence['JUST'] = $une_absence['NON_JUSTIF']." ".self::formatNonJustifiee($une_absence['NON_JUSTIF']);
            $nbtotal += $une_absence['TOTAL'];
            affectToBloc($template, "$prefixe$nommage", $une_absence);
        }

        affectToXHTML($template,self::constructeurNombreAbsences($expire,$total,$nbtotal,$ET_ID,-1,"ABS_ENS_ID",$complement));
    }

    public static function constructeurNombreAbsences(string $expire,string $total,int $nbtotal,int $ET_ID,int $annee_courante=-1, string $ENS_ID="ABS_ENS_ID", string $complement="") : array
    {
        //Calcul du nombre de demi journées.
        $demi = self::getNombreDeDemiJourneesNonJustifiees($ET_ID,$expire,$ENS_ID,$annee_courante,$complement);
        $justif = self::getNombreAbsencesNonJustifiees($ET_ID,$expire,$ENS_ID,$annee_courante,$complement);

        $table = array(
            $total => self::formatAbsences($nbtotal) . " dont $justif " . self::formatNonJustifiee($justif) . ($demi == 0 ? "" : " sur " . self::formatDemiJournees($demi))
        );

        return $table;
    }

    public static function autojustification(int $ET_ID) {

        if ($ET_ID == "") {
            return;
        }

        $req = "SELECT * FROM common_absences_v2,common_absences_creneau WHERE CRENEAU_ID=ABS_CRENEAU_ID AND ABS_EXPIRE=0 AND ABS_JUSTIFICATION='non' AND ABS_ET_ID=$ET_ID FOR UPDATE";
        $res = self::$conn->query($req);
        while ($une_absence = $res->fetch_assoc()) {
            $req = "SELECT * FROM common_absences_justifications WHERE JUSTIF_ET_ID=$ET_ID AND ((JUSTIF_DATE_START<".$une_absence['ABS_REAL_DATE']." AND JUSTIF_DATE_END>".$une_absence['ABS_REAL_DATE'].") OR (JUSTIF_DATE_START=".$une_absence['ABS_REAL_DATE']." AND JUSTIF_DATE_END>".$une_absence['ABS_REAL_DATE']." AND JUSTIF_HEURE_START<=".$une_absence['CRENEAU_REAL_START'].") OR (JUSTIF_DATE_START<".$une_absence['ABS_REAL_DATE']." AND JUSTIF_DATE_END>=".$une_absence['ABS_REAL_DATE']." AND JUSTIF_HEURE_END>=".$une_absence['CRENEAU_REAL_END'].") OR (JUSTIF_DATE_START=".$une_absence['ABS_REAL_DATE']." AND JUSTIF_DATE_END=".$une_absence['ABS_REAL_DATE']." AND JUSTIF_HEURE_START<=".$une_absence['CRENEAU_REAL_START']." AND JUSTIF_HEURE_END>=".$une_absence['CRENEAU_REAL_END']."))";
            $res2 = self::$conn->query($req);
            while ($une_justification = $res2->fetch_assoc()) {
                if ($une_justification['JUSTIF_ENS_ID'] == "") {
                    $une_justification['JUSTIF_ENS_ID'] = "NULL";
                }
                $req = "UPDATE common_absences_v2 SET ABS_JUSTIF_ENS_ID=".$une_justification['JUSTIF_ENS_ID'].", ABS_JUSTIFICATION='".$une_justification['JUSTIF_JUSTIFICATION']."',ABS_EXCUSE='".addslashes($une_justification['JUSTIF_EXCUSE'])."' WHERE ABS_ID=".$une_absence['ABS_ID'];
                self::$conn->query($req);
            }
        }
        self::autojustification_uid($ET_ID);
    }

    public static function autojustification_uid(int $ET_ID) {
        $req = "SELECT * FROM common_absences_v2,common_backup_ade_enseignant WHERE ABS_ENS_ID=EDT_ENS_ID AND ABS_EDT_UID=EDT_UID AND ABS_EXPIRE=0 AND ABS_JUSTIFICATION='non' AND ABS_ET_ID=$ET_ID FOR UPDATE";
        $res = self::$conn->query($req);
        while ($une_absence = $res->fetch_assoc()) {
            //il est nécessaire d'extraire que les H/M pour les comparer aux créneaux
            $heure_debut = mktime(date('H',$une_absence['EDT_HEURE_DEBUT']) ,date('i',$une_absence['EDT_HEURE_DEBUT']),null,null,null,null) ;
            $heure_fin = mktime(date('H',$une_absence['EDT_HEURE_FIN']) ,date('i',$une_absence['EDT_HEURE_FIN']),null,null,null,null) ;;
            $date_debut_fin = mktime(0,null,null,date('m',$une_absence['ABS_REAL_DATE']),date('j',$une_absence['ABS_REAL_DATE']),date('Y',$une_absence['ABS_REAL_DATE']));

            $req = "SELECT * FROM common_absences_justifications WHERE JUSTIF_ET_ID=$ET_ID AND ((JUSTIF_DATE_START<$date_debut_fin AND JUSTIF_DATE_END>$date_debut_fin) OR (JUSTIF_DATE_START=$date_debut_fin AND JUSTIF_DATE_END>$date_debut_fin AND JUSTIF_HEURE_START<=$heure_debut) OR (JUSTIF_DATE_START<$date_debut_fin AND JUSTIF_DATE_END>=$date_debut_fin AND JUSTIF_HEURE_END>=$heure_fin) OR (JUSTIF_DATE_START=$date_debut_fin AND JUSTIF_DATE_END=$date_debut_fin AND JUSTIF_HEURE_START<=$heure_debut AND JUSTIF_HEURE_END>=$heure_fin))";
            $res2 = self::$conn->query($req);
            while ($une_justification = $res2->fetch_assoc()) {
                if ($une_justification['JUSTIF_ENS_ID'] == "") {
                    $une_justification['JUSTIF_ENS_ID'] = "NULL";
                }
                $req = "UPDATE common_absences_v2 SET ABS_JUSTIF_ENS_ID=".$une_justification['JUSTIF_ENS_ID'].", ABS_JUSTIFICATION='".$une_justification['JUSTIF_JUSTIFICATION']."',ABS_EXCUSE='".addslashes($une_justification['JUSTIF_EXCUSE'])."' WHERE ABS_ID=".$une_absence['ABS_ID'];
                self::$conn->query($req);
            }
        }
    }

    public static function getJustifications(int $ET_ID,string $orderby="") : array {
        $req = "SELECT *,FROM_UNIXTIME(JUSTIF_DATE_DEPOT,'%d/%m/%Y') AS DATE_DEPOT,FROM_UNIXTIME(JUSTIF_DATE_DEPOT,'%Hh%i') AS HEURE_DEPOT,FROM_UNIXTIME(JUSTIF_DATE_START,'%d/%m/%Y') AS DATE_START,FROM_UNIXTIME(JUSTIF_DATE_END,'%d/%m/%Y') AS DATE_END,FROM_UNIXTIME(JUSTIF_HEURE_START,'%Hh%i') AS HEURE_START,FROM_UNIXTIME(JUSTIF_HEURE_END,'%Hh%i') AS HEURE_END FROM common_absences_justifications WHERE JUSTIF_ET_ID=$ET_ID $orderby";
        return self::getRequete($req);
    }

    public static function getCreneauxDeCoursPourUnEtudiant(int $et_id, int $annee_courante, string $masque="0", int $anticipe=0, string $condition = "") : array {
        $contrainte_horaire = "";
        if ($anticipe == 0) {
            $contrainte_horaire = "common_backup_ade_etudiant.EDT_DATE_DEBUT<=".time()." AND";
        }
        $req = "SELECT common_backup_ade_enseignant.EDT_DATE_DEBUT, common_backup_ade_enseignant.EDT_HEURE_DEBUT,
                       common_backup_ade_enseignant.EDT_HEURE_FIN, common_backup_ade_enseignant.EDT_DATE_FIN, common_backup_ade_enseignant.EDT_NOM, GROUPE_NOM,
                       common_backup_ade_enseignant.EDT_SALLE, ENS_NOM, common_backup_ade_enseignant.EDT_UID,
                       common_backup_ade_enseignant.EDT_ENS_ID, GROUPE_ID, GROUPE_PRO
                FROM (common_backup_ade_etudiant, common_backup_ade_enseignant, common_enseignant, etudiants_groupes)
                LEFT JOIN common_backup_ade_enseignant_nonfacture ON (common_backup_ade_enseignant.EDT_UID=NONFACTURE_EDT_UID)
                WHERE $contrainte_horaire $condition ENS_ID=common_backup_ade_enseignant.EDT_ENS_ID
                  AND NONFACTURE_EDT_UID IS NULL AND EDT_ARCHIVE IS NULL AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=EDT_GROUPE_ID
                  AND GROUPE_FEUILLE=1 AND common_backup_ade_etudiant.EDT_UID=common_backup_ade_enseignant.EDT_UID
                  AND ENS_ID=EDT_ENS_ID AND ET_ID=$et_id AND common_backup_ade_enseignant.EDT_ANNEE_ID=$annee_courante
                  AND EDT_MASQUE=$masque
                  
                  ORDER BY common_backup_ade_etudiant.EDT_HEURE_DEBUT,EDT_UID";
        return self::getRequete($req);
    }

    public static function getCreneauxDeCoursPourUnGroupe(int $groupe_id, int $annee_courante, string $masque="0", int $anticipe=0, string $condition = "") : array {

        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";
        $contrainte_horaire = "";
        if ($anticipe == 0) {
            $contrainte_horaire = "common_backup_ade_etudiant.EDT_DATE_DEBUT<=".time()." AND";
        }
        $req = "SELECT common_backup_ade_enseignant.EDT_DATE_DEBUT,
                       common_backup_ade_enseignant.EDT_HEURE_DEBUT,
                       common_backup_ade_enseignant.EDT_HEURE_FIN,
                       common_backup_ade_enseignant.EDT_DATE_FIN,
                       common_backup_ade_enseignant.EDT_NOM,
                       GROUPE_NOM,
                       common_backup_ade_enseignant.EDT_SALLE,
                       GROUP_CONCAT(ENS_NOM ORDER BY ENS_NOM SEPARATOR ', ' ) AS ENS_NOM,
                       common_backup_ade_enseignant.EDT_UID,
                       GROUP_CONCAT(ENS_ID ORDER BY ENS_NOM SEPARATOR '$' ) AS EDT_ENS_ID,
                       GROUPE_ID,
                       GROUPE_PRO
                FROM common_backup_ade_etudiant
                         JOIN common_backup_ade_enseignant
                              ON (common_backup_ade_etudiant.EDT_UID = common_backup_ade_enseignant.EDT_UID)
                         JOIN common_enseignant ON (ENS_ID = common_backup_ade_enseignant.EDT_ENS_ID)
                         JOIN common_groupes ON (GROUPE_ID = EDT_GROUPE_ID)
                         LEFT JOIN common_backup_ade_enseignant_nonfacture
                                   ON (common_backup_ade_enseignant.EDT_UID = NONFACTURE_EDT_UID)
                         LEFT JOIN $table
                                   ON (SIGNATURE_EDT_UID = common_backup_ade_enseignant.EDT_UID AND SIGNATURE_ET_ID IS NULL AND SIGNATURE_GROUPE_ID = $groupe_id)
                WHERE $contrainte_horaire $condition NONFACTURE_EDT_UID IS NULL
                  AND EDT_ARCHIVE IS NULL
                  AND GROUPE_ID = $groupe_id
                  AND common_backup_ade_enseignant.EDT_ANNEE_ID = $annee_courante
                  AND EDT_MASQUE = $masque
                  AND SIGNATURE_ENS_ID IS NULL
                GROUP BY common_backup_ade_enseignant.EDT_UID
                ORDER BY common_backup_ade_etudiant.EDT_HEURE_DEBUT, EDT_UID";
        return self::getRequete($req);
    }

    public static function supprimerAbsence(?int $abs_id, ?string $abs_uid=null, ?string $et_id=null) : int
    {
        if ($abs_id == null && $abs_uid != null) {
            $req = "DELETE FROM common_absences_v2 WHERE ABS_EDT_UID='$abs_uid' AND ABS_ET_ID IN ($et_id)";
        } else {
            $req = "DELETE FROM common_absences_v2 WHERE ABS_ID=$abs_id";
        }
        return self::execRequeteAvecAffected($req);
    }

    public static function getCreneauxHoraire(int $debut, int $fin, int $dept_id) : array
    {
        $req = "SELECT * FROM common_absences_creneau WHERE CRENEAU_REAL_START=$debut AND CRENEAU_REAL_END=$fin AND CRENEAU_DEPT_ID=$dept_id";
        return self::getRequeteAvecClef("CRENEAU_ID",$req);
    }

    public static function creerCreneauHoraire(int $debut, int $fin, int $dept_id) : int
    {
        $req = "INSERT INTO common_absences_creneau(CRENEAU_NOM, CRENEAU_DEMI, CRENEAU_REAL_START, CRENEAU_REAL_END, CRENEAU_DEPT_ID) VALUES
                ('".(date("H\hi",$debut)." - ".date("H\hi",$fin))."',
                 '".(date("H",$debut)>=12?"après-midi":"matin")."',
                 $debut,
                 $fin,
                 $dept_id
                )";

        return self::execRequeteAvecInsertId($req);
    }

    public static function getCreneauxDeCours(int $annee_courante,string $edt_uid) : array
    {
        $req = "SELECT ET_ID, ET_NOM, GROUPE_PRO, GROUPE_ID, GROUPE_NOM, ET_NUMERO
                FROM common_backup_ade_etudiant
                    JOIN etudiants_groupes ON (ET_GROUPE_ANNEE_ID = $annee_courante AND GROUPE_ID = EDT_GROUPE_ID AND GROUPE_FEUILLE = 1)
                    JOIN common_formation ON (GROUPE_FORM_ID = FORM_ID)
                WHERE EDT_UID = '$edt_uid'
                    AND (FORM_ABSENCES_AUTO = 1 OR ET_PROFESSIONNALISATION = 1)
                GROUP BY ET_ID, GROUPE_ID
                ORDER BY ET_NOM
        ";
        return self::getRequete($req);
    }

    public static function expirerAbsences(int $form_id, int $date) : int
    {
        $req = "UPDATE common_absences_v2 SET ABS_EXPIRE=1 WHERE ABS_REAL_DATE < $date AND ABS_EXPIRE <> 1 AND (ABS_ET_ID,ABS_ANNEE_ID) IN (
                    SELECT DISTINCT INSCRIPT_ET_ID, INSCRIPT_ANNEE_ID
                    FROM common_inscription
                    JOIN common_semestre ON (SEM_ID=INSCRIPT_SEM_ID) 
                    WHERE SEM_FORM_ID = $form_id
                )";
        return self::execRequeteAvecAffected($req);

    }

    public static function getGroupeDeCreneauxDeCours(int $annee_id, string $edt_uid) : array
    {
        $req = "SELECT *
                FROM common_backup_ade_etudiant
                WHERE EDT_UID = '$edt_uid'
                  AND EDT_ANNEE_ID = $annee_id";
        return self::getRequete($req);
    }
}