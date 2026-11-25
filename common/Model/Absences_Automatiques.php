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

class Absences_Automatiques extends Connectable
{

    public static function getSignaturesPourUnEnseignant(int $ens_id, string $groupe_id, string $edt_uid) : array
    {
        $req = "SELECT * FROM common_absences_signatures WHERE SIGNATURE_ENS_ID=$ens_id AND SIGNATURE_GROUPE_ID IN ($groupe_id) AND SIGNATURE_EDT_UID='$edt_uid'
                UNION
                SELECT * FROM common_pro_signatures WHERE SIGNATURE_ENS_ID=$ens_id AND SIGNATURE_GROUPE_ID IN ($groupe_id) AND SIGNATURE_EDT_UID='$edt_uid'
                ";
        return self::getRequete($req);
    }

    public static function insererUneAbsenceAutomatiquement(int $annee_courante,string $edt_uid,int $et_id,int $groupe_id,int $ens_id, int $mat_id=-1) : bool
    {
        $jointure = "";
        if ($mat_id != -1) {
            $ue_id = Formations::getMatiere($mat_id)["MAT_UE_ID"];
            $jointure = "
                LEFT JOIN common_dispense_ue ON 
                    (ET_ID = DISP_ET_ID AND DISP_UE_ID=$ue_id AND DISP_ANNEE_ID=$annee_courante)
                LEFT JOIN common_dispense_matieres ON
                    (ET_ID = common_dispense_matieres.DISP_ET_ID AND DISP_MAT_ID=$mat_id 
                        AND common_dispense_matieres.DISP_ANNEE_ID=$annee_courante) 
            ";
        }

        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";

        $req = "SELECT *
                FROM common_backup_ade_etudiant,etudiants_groupes
                $jointure
                WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=EDT_GROUPE_ID AND EDT_UID='$edt_uid' 
                  AND ET_ID=$et_id 
                  AND ET_ID NOT IN (
                        SELECT SIGNATURE_ET_ID FROM $table
                        WHERE SIGNATURE_GROUPE_ID=$groupe_id AND SIGNATURE_EDT_UID='$edt_uid' AND SIGNATURE_ENS_ID IS NULL)";
        $absences_a_ajouter = self::getRequete($req);
        return self::insererAbsence($absences_a_ajouter, $mat_id, $ens_id, $edt_uid, $annee_courante);
    }

    public static function insererAbsenceAutomatiquement(int $annee_courante,string $edt_uid,int $groupe_id,int $ens_id, int $mat_id=-1)
    {
        $jointure = "";
        if ($mat_id != -1) {
            $ue_id = Formations::getMatiere($mat_id)["MAT_UE_ID"];
            $jointure = "
                LEFT JOIN common_dispense_ue ON 
                    (ET_ID = DISP_ET_ID AND DISP_UE_ID=$ue_id AND DISP_ANNEE_ID=$annee_courante)
                LEFT JOIN common_dispense_matieres ON
                    (ET_ID = common_dispense_matieres.DISP_ET_ID AND DISP_MAT_ID=$mat_id 
                        AND common_dispense_matieres.DISP_ANNEE_ID=$annee_courante) 
            ";
        }
        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";

        $req = "SELECT *
                FROM common_backup_ade_etudiant
                JOIN etudiants_groupes ON (ET_GROUPE_ANNEE_ID = $annee_courante AND GROUPE_ID = EDT_GROUPE_ID)
                JOIN common_formation ON (FORM_ID = GROUPE_FORM_ID)
                $jointure                
                WHERE EDT_UID = '$edt_uid'
                  AND GROUPE_ID = $groupe_id
                  AND (FORM_ABSENCES_AUTO = 1 OR ET_PROFESSIONNALISATION = 1)
                  AND ET_ID NOT IN (SELECT SIGNATURE_ET_ID
                                    FROM $table
                                    WHERE SIGNATURE_GROUPE_ID = $groupe_id
                                      AND SIGNATURE_EDT_UID = '$edt_uid'
                                      AND SIGNATURE_ENS_ID IS NULL)
        ";

        $absences_a_ajouter = self::getRequete($req);
        return self::insererAbsence($absences_a_ajouter, $mat_id, $ens_id, $edt_uid, $annee_courante);
    }

    public static function isCreneauDejaSigne(int $et_id, int $groupe_id, string $edt_uid) : bool
    {
        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";
        $req = "SELECT * FROM $table WHERE SIGNATURE_GROUPE_ID=$groupe_id AND (SIGNATURE_ET_ID=$et_id OR SIGNATURE_ENS_ID IS NOT NULL) AND SIGNATURE_EDT_UID='$edt_uid'";
        return self::doRequete($req)->num_rows > 0;
    }

    public static function isCreneauDejaSigneParEnseignant(int $groupe_id, string $edt_uid) : ?string
    {
        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";
        $req = "SELECT SIGNATURE_ENS_ID FROM $table WHERE SIGNATURE_GROUPE_ID=$groupe_id AND SIGNATURE_ENS_ID IS NOT NULL AND SIGNATURE_EDT_UID='$edt_uid'";
        $retour = self::getRequete($req);
        if (isset($retour[0])) {
            return $retour[0]["SIGNATURE_ENS_ID"];
        } else {
            return null;
        }
    }

    public static function getSignaturesPourUnEtudiant(int $et_id, string $groupe_id, string $edt_uid)
    {
        $req = "SELECT * FROM common_absences_signatures WHERE SIGNATURE_ET_ID=$et_id AND SIGNATURE_GROUPE_ID IN ($groupe_id) AND SIGNATURE_EDT_UID='$edt_uid'
                UNION
                SELECT * FROM common_pro_signatures WHERE SIGNATURE_ET_ID=$et_id AND SIGNATURE_GROUPE_ID IN ($groupe_id) AND SIGNATURE_EDT_UID='$edt_uid'";
        return self::getRequete($req);
    }

    public static function getSignaturesPourUnGroupe(int $groupe_id, string $edt_uid, int $annee_courante, int $mat_id=-1, string $complement = "") : array
    {
        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";
        $req = "SELECT ET_NOM, ET_ID, SIGNATURE, SIGNATURE_MAT_ID, ET_NUMERO, GROUPE_NOM, SIGNATURE_ID, GROUPE_ID, ABS_ID,ABS_JUSTIFICATION,'$edt_uid' AS SIGNATURE_EDT_UID, $groupe_id AS SIGNATURE_GROUPE_ID, ABS_EXCUSE
                FROM common_groupes
                         JOIN common_etudiant_groupes ON (`ET_GROUPE_CODE` like concat(GROUPE_CODE, '%') AND ET_GROUPE_ANNEE_ID = $annee_courante)
                         JOIN common_etudiant ON (ET_ID = GROUPE_ET_ID)
                         LEFT JOIN $table ON (ET_ID = SIGNATURE_ET_ID AND SIGNATURE_GROUPE_ID = GROUPE_ID AND
                                                             SIGNATURE_EDT_UID = '$edt_uid')
                         LEFT JOIN common_absences_v2 on (ABS_EDT_UID = '$edt_uid' AND ET_ID = ABS_ET_ID)
                WHERE $complement GROUPE_ID = $groupe_id
                ORDER BY ET_NOM";
        $etudiants = self::getRequeteAvecClef("ET_ID",$req);
        $retour = array();
        if ($mat_id == -1) {
            $mat_id = null;
            foreach ($etudiants as $et_id => $un_etudiant) {
                if ($un_etudiant['SIGNATURE_MAT_ID'] != "" && $mat_id == -1) {
                    $mat_id = $un_etudiant['SIGNATURE_MAT_ID'];
                }
            }
        }
        foreach ($etudiants as $et_id=>$un_etudiant) {
            if (! Etudiants::isDispense($et_id,$annee_courante,$mat_id)) {
                $retour[] = $un_etudiant;
            }
        }

        return $retour;
    }

    public static function supprimerSignature(int $signature_id, int $groupe_id, string $edt_uid) : int {
        $table = Groupes::isPro($groupe_id)?"common_pro_signatures":"common_absences_signatures";
        $req = "DELETE FROM $table WHERE SIGNATURE_ID=$signature_id AND SIGNATURE_GROUPE_ID = $groupe_id AND SIGNATURE_EDT_UID='$edt_uid'";
        return self::execRequeteAvecAffected($req);
    }

    public static function archiverFiches(int $time,int $groupe_id, int $debut, int $fin) : bool {
        $req = "UPDATE common_backup_ade_etudiant SET EDT_ARCHIVE=$time WHERE EDT_GROUPE_ID=$groupe_id AND EDT_DATE_DEBUT>=$debut AND EDT_DATE_FIN <= $fin";
        return self::execRequete($req);
    }


    private static function insererAbsence(array &$absences_a_ajouter, int $mat_id, int $ens_id, string $edt_uid, int $annee_courante): bool
    {
        $fail = false;
        foreach ($absences_a_ajouter as $une_absence) {
            if ($une_absence['ET_ID'] == "") {
                continue;
            }

            if ($mat_id != -1) {
                $toinsert['*ABS_MAT_ID'] = $mat_id;
                if ($une_absence['DISP_UE_ID'] != null || $une_absence['DISP_MAT_ID'] != null) {
                    continue;
                }
            }

            $les_creneaux = Absences::getCreneauxHoraire(extractTime($une_absence['EDT_HEURE_DEBUT']), extractTime($une_absence['EDT_HEURE_FIN']), CURRENT_DEPT_ID);
            if (count($les_creneaux) == 0) {
                $creneau_id = Absences::creerCreneauHoraire(extractTime($une_absence['EDT_HEURE_DEBUT']), extractTime($une_absence['EDT_HEURE_FIN']), CURRENT_DEPT_ID);
            } else {
                $creneau_id = array_keys($les_creneaux)[0];
            }

            $toinsert['*ABS_CRENEAU_ID'] = $creneau_id;
            $toinsert['*ABS_ENS_ID'] = $ens_id;
            $toinsert['*ABS_ET_ID'] = $une_absence['ET_ID'];
            $toinsert['*ABS_EDT_UID'] = $edt_uid;
            $toinsert['*ABS_DATE'] = date('d/m/Y', $une_absence['EDT_DATE_DEBUT']);
            $toinsert['*ABS_JUSTIFICATION '] = 'non';
            $toinsert['*ABS_MAIL'] = 0;
            $toinsert['*ABS_REAL_DATE'] = extractDate($une_absence['EDT_DATE_DEBUT']);
            $toinsert['*ABS_EXPIRE'] = 0;
            $toinsert['*ABS_ANNEE_ID'] = $annee_courante;

            $data = array($toinsert);
            manual_bfmw_secure($data);
            if ($mat_id != -1) {
                $id = createData("common_absences_v2", $data[0], 11);
            } else {
                $id = createData("common_absences_v2", $data[0], 10);
            }
            if ($id <= 0) {
                $fail = true;
            }
            Absences::autojustification_uid($une_absence['ET_ID']);
        }
        return $fail;
    }

    public static function getMatiere(string $edt_uid) : array
    {
        $req = "SELECT DISTINCT ABS_MAT_ID AS MAT_ID
                FROM common_absences_v2
                WHERE ABS_EDT_UID='$edt_uid' AND ABS_MAT_ID IS NOT NULL";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            $req = "SELECT SIGNATURE_MAT_ID AS MAT_ID
                    FROM common_pro_signatures WHERE SIGNATURE_EDT_UID='$edt_uid' AND SIGNATURE_MAT_ID IS NOT NULL
                        UNION
                    SELECT SIGNATURE_MAT_ID AS MAT_ID
                    FROM common_absences_signatures WHERE SIGNATURE_EDT_UID='$edt_uid'  AND SIGNATURE_MAT_ID IS NOT NULL
            ";
            $retour = self::getRequete($req);
        }
        return $retour;
    }

    public static function masquerCreneauxNonSigneesParEnseignantInferieurA(int $date) : int
    {
        $req = "UPDATE common_backup_ade_etudiant SET EDT_MASQUE=1 WHERE EDT_ID IN (
                    SELECT EDT_ID FROM common_backup_ade_etudiant
                        WHERE EDT_DATE_DEBUT<$date AND EDT_MASQUE=0 AND
                              EDT_UID NOT IN (SELECT SIGNATURE_EDT_UID FROM common_absences_signatures
                                                WHERE SIGNATURE_ENS_ID IS NOT NULL))";
        return self::execRequeteAvecAffected($req);
    }
}