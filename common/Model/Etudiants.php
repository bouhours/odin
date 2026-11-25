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

class Etudiants extends Connectable
{
    public static function getEtudiantsGroupes(int $annee_courante, string $groupe_id, int $et_id = -1, string $complement = ""): array
    {
        $req = "SELECT gr_plein.*,
                       common_etudiant_groupes.*,
                       common_etudiant.*,
                       gr_feuille.GROUPE_NOM AS GROUPE_FEUILLE_NOM,
                       IF(ET_ID = -1, 'jaune_force', '') AS SELECTED
                FROM common_groupes gr_plein
                         JOIN common_etudiant_groupes ON ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE, '%')
                         JOIN common_etudiant ON ET_ID = GROUPE_ET_ID
                         JOIN common_groupes gr_feuille ON ET_GROUPE_CODE = gr_feuille.GROUPE_CODE
                WHERE $complement gr_plein.GROUPE_ID IN ($groupe_id)
                  AND ET_GROUPE_ANNEE_ID = $annee_courante
                ORDER BY ET_NOM";

        return self::getRequeteAvecClef("ET_ID", $req);
    }

    public static function getEtudiantsGroupesAvecStages(int $annee_courante, int $groupe_id): array
    {
        $req = "SELECT * FROM (etudiants_groupes,common_inscription) LEFT JOIN common_stage ON (ET_ID=STAGE_ET_ID AND STAGE_ANNEE_ID=ET_GROUPE_ANNEE_ID) WHERE GROUPE_ID=$groupe_id AND ET_GROUPE_ANNEE_ID=$annee_courante AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$annee_courante AND INSCRIPT_DISP=0 GROUP BY ET_ID ORDER BY ET_NOM";
        return self::getRequeteAvecClef("ET_ID", $req);
    }

    public static function getEtudiant(int $etudiant, int $annee): ?array
    {
        $req = "SELECT ET_ID, GROUPE_ID,ET_NOM,ET_MAIL,DEPT_NOM,FORM_NOM, ET_NAISSANCE, ET_RED, ET_TIERS, IF(ET_TIERS=1,'oui','non') AS ET_TIERS_AFF, IF(ET_SPORTIF=1,'oui','non') AS ET_SPORTIF_AFF, ET_SPORTIF, ET_DEM, ET_NUMERO, ET_BAC, GROUPE_FORM_ID FROM etudiants_groupes,common_formation,common_departement WHERE DEPT_ID=FORM_DEPT_ID AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FEUILLE=1 AND ET_GROUPE_ANNEE_ID=$annee AND ET_ID=$etudiant";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            return null;
        }
        return $retour;
    }

    public static function getEtudiantSimple(int $etudiant): ?array
    {
        $req = "SELECT ET_ID,ET_NOM,ET_MAIL, ET_QUIZZBOX, ET_LOGIN, ET_NAISSANCE, ET_RED, ET_TIERS, IF(ET_TIERS=1,'oui','non') AS ET_TIERS_AFF, IF(ET_SPORTIF=1,'oui','non') AS ET_SPORTIF_AFF, ET_SPORTIF, ET_DEM, ET_NUMERO, ET_BAC FROM common_etudiant WHERE ET_ID=$etudiant";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            return null;
        }
        return $retour;
    }

    public static function getEtudiantsParGroupesEtSemestres(int $GROUPE_ID, int $SEM_ID, int $ANNEE_ID): array
    {
        //$req = "select ET_ID,ET_NOM,GROUPE_ID,GROUPE_NOM, GROUPE_ENS_ID,ET_NUMERO, GROUPE_FEUILLE, ET_MAIL, ET_BAC,ET_NAISSANCE,ET_TIERS,ET_RED,ANNEE_ID,ANNEE_NOM,FORM_ID,FORM_NOM,FORM_DEPT_ID,FORM_PRO,SEM_ID,SEM_NOM from etudiants_groupes,common_annee,common_formation,common_semestre,semestres_groupes_code where SEM_ID=$SEM_ID AND GROUPE_ID=$GROUPE_ID AND `ANNEE_ID` = `ET_GROUPE_ANNEE_ID` and `ANNEE_COURANTE` = 1 AND SEM_ID=GROUPE_SEM_ID AND FORM_ID=SEM_FORM_ID AND SEM_GROUPE_CODE LIKE CONCAT(ET_GROUPE_CODE,'%') ORDER BY GROUPE_NOM, ET_NOM";
        $req = "SELECT ET_ID,ET_NOM, ET_NOM_DE_FAMILLE, ET_PRENOM ,GROUPE_ID,GROUPE_NOM, GROUPE_ENS_ID,ET_NUMERO, GROUPE_FEUILLE, ET_MAIL, ET_BAC,ET_NAISSANCE,ET_TIERS,ET_RED,ANNEE_ID,ANNEE_NOM,FORM_ID,FORM_NOM,FORM_DEPT_ID,FORM_PRO,SEM_ID,SEM_NOM FROM etudiants_groupes, common_inscription, common_formation, common_semestre, common_annee WHERE ET_GROUPE_ANNEE_ID=ANNEE_ID AND GROUPE_ID=$GROUPE_ID AND ANNEE_ID=INSCRIPT_ANNEE_ID AND FORM_ID=SEM_FORM_ID AND SEM_ID=$SEM_ID AND SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=GROUPE_FORM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID AND INSCRIPT_SEM_ID=$SEM_ID ORDER BY GROUPE_CODE,ET_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsParGroupesEtSemestresParCode(string $GROUPE_CODE, int $SEM_ID, int $ANNEE_ID): array
    {
        $req = "SELECT ET_ID,ET_NOM,GROUPE_ID,GROUPE_NOM, GROUPE_ENS_ID,ET_NUMERO, GROUPE_FEUILLE, ET_MAIL, ET_BAC,ET_NAISSANCE,ET_TIERS,ET_RED,ANNEE_ID,ANNEE_NOM,FORM_ID,FORM_NOM,FORM_DEPT_ID,FORM_PRO,SEM_ID,SEM_NOM FROM etudiants_groupes, common_inscription, common_formation, common_semestre, common_annee WHERE ET_GROUPE_ANNEE_ID=ANNEE_ID AND GROUPE_FEUILLE=1 AND GROUPE_CODE LIKE CONCAT('$GROUPE_CODE','%') AND ANNEE_ID=INSCRIPT_ANNEE_ID AND FORM_ID=SEM_FORM_ID AND SEM_ID=$SEM_ID AND SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=GROUPE_FORM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID AND INSCRIPT_SEM_ID=$SEM_ID ORDER BY GROUPE_CODE,ET_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsParGroupesEtSemestresInscrits(int $SEM_ID, int $ANNEE_ID): array
    {
        $req = "SELECT ET_ID,ET_NOM,ET_TIERS,ET_RED,GROUPE_ID,GROUPE_NOM, FORM_ID, FORM_NOM, SEM_NOM, ANNEE_NOM FROM etudiants_groupes, common_inscription, common_formation, common_semestre, common_annee, common_semestres_groupes WHERE SEM_ID=GROUPE_SEM_ID AND GROUPE_ID=SEM_GROUPE_ID AND ET_GROUPE_ANNEE_ID=ANNEE_ID AND GROUPE_FEUILLE=1 AND ANNEE_ID=INSCRIPT_ANNEE_ID AND FORM_ID=SEM_FORM_ID AND SEM_ID=$SEM_ID AND SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=GROUPE_FORM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID AND INSCRIPT_SEM_ID=$SEM_ID ORDER BY GROUPE_CODE,ET_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsInscrits(int $FORM_ID, int $ANNEE_ID, string $completement = ""): array
    {
        $req = "SELECT *,
                       IF(ET_TIERS = 1, 'checked', '')                AS TIERS,
                       IF(ET_SPORTIF = 1, 'checked', '')              AS SPORTIF,
                       IF(ET_PROFESSIONNALISATION = 1, 'checked', '') AS ET_PRO,
                       IF(MEILLEURE_ET_ID IS NOT NULL, 'checked', '') AS ET_MEILLEURE,
                       ''                                             AS CHECKED
                FROM common_etudiant
                     JOIN common_inscription ON (ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID)
                     JOIN common_semestre ON (SEM_FORM_ID=$FORM_ID AND SEM_ID=INSCRIPT_SEM_ID)
                     LEFT JOIN common_etudiant_meilleure_ue ON (MEILLEURE_ET_ID=ET_ID AND MEILLEURE_ANNEE_ID=INSCRIPT_ANNEE_ID)
                WHERE $completement 1
                GROUP BY ET_ID
                ORDER BY ET_NOM;
        ";
        return self::getRequeteAvecClef("ET_ID", $req);
    }

    public static function getEtudiantsInscritsAuSemestre(int $SEM_ID, int $ANNEE_ID): array
    {
        $req = "SELECT * FROM common_inscription,common_etudiant WHERE ET_ID=INSCRIPT_ET_ID AND INSCRIPT_SEM_ID=$SEM_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID ORDER BY ET_NOM";
        return self::getRequeteAvecClef("ET_ID", $req);
    }

    public static function getEtudiantsDuDepartement(int $DEPT_ID, int $ANNEE_ID, string $order = "ET_NOM", string $formations_autorisees = ""): array
    {
        if ($formations_autorisees != "") {
            $formations_autorisees = "FORM_ID IN (" . $formations_autorisees . ") AND ";
        }
        $req = "SELECT ET_ID,ET_NOM, FORM_ID, FORM_NOM FROM common_etudiant,common_inscription,common_semestre,common_formation, common_departement WHERE $formations_autorisees DEPT_ID=FORM_DEPT_ID AND FORM_ID=SEM_FORM_ID AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID AND DEPT_ID=$DEPT_ID GROUP BY ET_ID ORDER BY $order";
        return self::getRequete($req);
    }

    public static function getInscriptions(int $etudiant_courant, array &$les_inscriptions, array &$les_inscriptions_annees)
    {
        $req = "SELECT * from common_inscription,common_semestre,common_formation WHERE FORM_ID=SEM_FORM_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ET_ID=$etudiant_courant ORDER BY FORM_ID,SEM_ORDRE";
        $resINSCRIPT = self::doRequete($req);
        while ($une_inscription = $resINSCRIPT->fetch_assoc()) {
            $les_inscriptions[$une_inscription['INSCRIPT_SEM_ID']] = $une_inscription;
            $les_inscriptions_annees[$une_inscription['INSCRIPT_SEM_ID'] . "$" . $une_inscription['INSCRIPT_ANNEE_ID']] = $une_inscription;
        }
    }

    public static function getGroupesEtudiant(int $et_id, int $annee_id, string $complement = ""): array
    {
        $les_groupes = array();
        $req = "SELECT * FROM etudiants_groupes WHERE $complement  ET_GROUPE_ANNEE_ID=$annee_id AND GROUPE_FEUILLE=1 AND GROUPE_ET_ID=$et_id";
        return self::getRequeteAvecClef("GROUPE_ID", $req);
    }

    public static function getGroupesEtudiantString(int $et_id, $annee_id): string
    {
        $les_groupes = self::getGroupesEtudiant($et_id, $annee_id);
        return implode(",", array_keys($les_groupes));
    }

    public static function getGroupes(int $etudiant_courant, array &$les_groupes, array &$les_groupes_annees, string $dept_id = "FORM_DEPT_ID")
    {
        $req = "SELECT * from common_groupes,common_etudiant_groupes, common_formation WHERE FORM_DEPT_ID=$dept_id AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FEUILLE=1 AND ET_GROUPE_CODE = GROUPE_CODE AND GROUPE_ET_ID=" . $etudiant_courant . " ORDER BY ET_GROUPE_ANNEE_ID, GROUPE_CODE";
        $resINSCRIPT = self::doRequete($req);
        while ($un_groupe = $resINSCRIPT->fetch_assoc()) {
            $les_groupes[$un_groupe['GROUPE_ID']] = $un_groupe;
            $les_groupes_annees[$un_groupe['GROUPE_ID'] . "$" . $un_groupe['ET_GROUPE_ANNEE_ID']] = $un_groupe;
        }
    }

    public static function getDisepensesUE(int $etudiant_courant, int $annee_courante): array
    {
        $req = "SELECT *, IF(DISP_UE_ID = UE_ID, 'checked', '') AS UE_CHECKED
                FROM common_semestre
                         JOIN common_ue ON (SEM_ID = UE_SEM_ID)
                         JOIN common_inscription
                              ON (INSCRIPT_ET_ID = " . $etudiant_courant . " AND INSCRIPT_ANNEE_ID = " . $annee_courante . " AND
                                  UE_SEM_ID = INSCRIPT_SEM_ID)
                         LEFT JOIN common_dispense_ue ON (DISP_ET_ID = " . $etudiant_courant . " AND UE_ID = DISP_UE_ID AND
                                                          DISP_ANNEE_ID = $annee_courante)
                WHERE SEM_START_ANNEE_ID <= $annee_courante
                  AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL)
                  AND UE_START_ANNEE_ID <= $annee_courante
                  AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL)
                GROUP BY UE_ID
                ORDER BY SEM_ORDRE, SEM_ID, UE_ORDRE";
        return self::getRequete($req);
    }

    public static function getDisepensesMat(int $etudiant_courant, int $annee_courante): array
    {
        $req = "SELECT *, IF(DISP_MAT_ID = MAT_ID, 'checked', '') AS MAT_CHECKED
                FROM common_semestre
                         JOIN common_ue ON (SEM_ID = UE_SEM_ID)
                         JOIN common_matiere ON (UE_ID = MAT_UE_ID AND MAT_HAS_NOTE = 1 AND MAT_COPIE_MAT_ID IS NULL)
                         JOIN common_inscription ON (UE_SEM_ID = INSCRIPT_SEM_ID AND INSCRIPT_ET_ID = " . $etudiant_courant . " AND
                                                     INSCRIPT_ANNEE_ID = " . $annee_courante . ")
                         LEFT JOIN common_dispense_matieres ON (DISP_ET_ID = " . $etudiant_courant . " AND MAT_ID = DISP_MAT_ID AND
                                                                DISP_ANNEE_ID = $annee_courante)
                WHERE SEM_START_ANNEE_ID <= $annee_courante
                  AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL)
                  AND UE_START_ANNEE_ID <= $annee_courante
                  AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL)
                  AND MAT_START_ANNEE_ID <= $annee_courante
                  AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)
                GROUP BY MAT_ID
                ORDER BY SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID, MAT_ORDRE";
        return self::getRequete($req);
    }

    public static function getSemestresInscrits(int $ET_ID, int $DEPT_ID): mysqli_result
    {
        $req = "SELECT ET_NOM, ET_NUMERO, INSCRIPT_ANNEE_ID, SEM_ID, SEM_NOM, ANNEE_NOM
                FROM common_inscription
                     JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID)
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                    JOIN common_annee ON (ANNEE_ID = INSCRIPT_ANNEE_ID)
                    JOIN common_etudiant ON (ET_ID = INSCRIPT_ET_ID)
                WHERE FORM_DEPT_ID = $DEPT_ID
                  AND INSCRIPT_ET_ID = $ET_ID
                GROUP BY INSCRIPT_ET_ID, SEM_ID, INSCRIPT_ANNEE_ID
                ORDER BY ANNEE_NOM, SEM_ORDRE";
        return self::doRequete($req);
    }

    public static function getSemestresInscritsPourUneAnnee(int $ET_ID, int $ANNEE_ID): mysqli_result
    {
        $req = "SELECT * FROM common_semestre,etudiants_groupes,common_inscription WHERE SEM_START_ANNEE_ID <= $ANNEE_ID AND (SEM_END_ANNEE_ID > $ANNEE_ID OR SEM_END_ANNEE_ID IS NULL) AND ET_GROUPE_ANNEE_ID=$ANNEE_ID AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID = INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID AND ET_ID = $ET_ID GROUP BY ET_ID,SEM_ID ORDER BY SEM_ORDRE";
        return self::doRequete($req);
    }

    public static function getSemestresInscritsPourUneAnneeArray(int $ET_ID, int $ANNEE_ID): array
    {
        $req = "SELECT SEM_ID, SEM_NOM
                FROM common_semestre
                         JOIN common_inscription ON INSCRIPT_SEM_ID = SEM_ID AND INSCRIPT_ANNEE_ID=$ANNEE_ID
                         JOIN common_etudiant ON INSCRIPT_ET_ID = ET_ID
                WHERE ET_ID = $ET_ID
                ORDER BY SEM_ORDRE";
        return self::getRequete($req);
    }

    public static function getAnneeInscription(int $ET_ID): array
    {
        $req = "SELECT * FROM common_annee,common_inscription WHERE ANNEE_ID=INSCRIPT_ANNEE_ID AND INSCRIPT_ET_ID=$ET_ID GROUP BY ANNEE_ID ORDER BY ANNEE_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsDuResponsable(string $les_formations_autorisees, int $annee_courante, int $ens_id, int $groupe_id): array
    {
        if ($les_formations_autorisees === "0") {
            $req = "SELECT ET_ID,ET_NOM,ET_BAC,GROUPE_ID,GROUPE_NOM, GROUPE_FEUILLE, GROUPE_CODE, ET_RED FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=$groupe_id AND GROUPE_ENS_ID = $ens_id GROUP BY ET_ID";
        } else {
            $req = "SELECT ET_ID,ET_NOM,ET_BAC,GROUPE_ID,GROUPE_NOM, GROUPE_FEUILLE, GROUPE_CODE, ET_RED FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=$groupe_id AND GROUPE_FORM_ID IN ($les_formations_autorisees) GROUP BY ET_ID";
        }
        return self::getRequeteAvecClef("ET_ID", $req);
    }

    public static function isInscrit(int $ET_ID, int $annee_courante): bool
    {
        $req = "SELECT * FROM common_inscription WHERE INSCRIPT_ANNEE_ID=$annee_courante AND INSCRIPT_ET_ID=$ET_ID";
        return self::doRequete($req)->num_rows > 0;
    }

    public static function getEtudiantsDeLaMatiere(int $mat_id, int $annee_courante, int $dept_id): array
    {
        $req = "SELECT ET_ID,ET_NOM FROM common_matiere,common_ue,common_semestre,common_semestres_groupes,etudiants_groupes WHERE MAT_ID=$mat_id AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND SEM_ID=GROUPE_SEM_ID AND GROUPE_ID=SEM_GROUPE_ID AND GROUPE_FORM_ID=SEM_FORM_ID AND ET_GROUPE_ANNEE_ID=$annee_courante GROUP BY ET_ID ";
        return self::getRequeteAvecClef("ET_ID", $req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "ET_QUIZZBOX":
            case "ET_BAC":
            case "ET_TIERS":
            case "ET_RED":
            case "ET_SPORTIF":
                $req = "UPDATE common_etudiant SET " . $tag . "='" . $valeur . "' WHERE ET_ID=" . $wherenum;
                return self::execRequete($req);
                break;
            case "MEILLEUR_ET_ID":
                $valeurs = explode("$", $where);
                if ($valeurnum == 1) {
                    $req = "INSERT INTO common_etudiant_meilleure_ue(MEILLEURE_ET_ID, MEILLEURE_ANNEE_ID) VALUES(" . get_numeric($valeurs[0]) . "," . get_numeric($valeurs[1]) . ")";
                } else {
                    $req = "DELETE FROM common_etudiant_meilleure_ue WHERE MEILLEURE_ET_ID=" . get_numeric($valeurs[0]) . " AND MEILLEURE_ANNEE_ID=" . get_numeric($valeurs[1]);
                }
                return self::execRequete($req);
            case "ET_DISPENSE":
                $valeurs = explode("$", $where);
                if ($valeurnum == 1) {
                    $req = "INSERT INTO common_dispense_ue(DISP_ET_ID, DISP_UE_ID, DISP_ANNEE_ID) VALUES(" . get_numeric($valeurs[0]) . "," . get_numeric($valeurs[1]) . "," . get_numeric($valeurs[2]) . ")";
                } else {
                    $req = "DELETE FROM common_dispense_ue WHERE DISP_ET_ID=" . get_numeric($valeurs[0]) . " AND DISP_ANNEE_ID=" . get_numeric($valeurs[2]) . " AND DISP_UE_ID=" . get_numeric($valeurs[1]);
                }
                return self::execRequete($req);
                break;
            case "MAT_DISPENSE":
                $valeurs = explode("$", $where);
                if ($valeurnum == 1) {
                    $req = "INSERT INTO common_dispense_matieres(DISP_ET_ID, DISP_MAT_ID, DISP_ANNEE_ID) VALUES(" . get_numeric($valeurs[0]) . "," . get_numeric($valeurs[1]) . "," . get_numeric($valeurs[2]) . ")";
                } else {
                    $req = "DELETE FROM common_dispense_matieres WHERE DISP_ET_ID=" . get_numeric($valeurs[0]) . " AND DISP_ANNEE_ID=" . get_numeric($valeurs[2]) . " AND DISP_MAT_ID=" . get_numeric($valeurs[1]);
                }
                return self::execRequete($req);
                break;
        }
        return false;
    }

    public static function isDispense(int $et_id, int $annee_courante, ?int $mat_id): bool
    {
        if ($mat_id == null) {
            return false;
        }

        $req = "SELECT * FROM common_dispense_ue,common_matiere WHERE DISP_ANNEE_ID=$annee_courante AND DISP_ET_ID=$et_id AND DISP_UE_ID=MAT_UE_ID AND MAT_ID=$mat_id";
        $retour = self::doRequete($req)->num_rows;
        if ($retour > 0) {
            return true;
        }

        $req = "SELECT * FROM common_dispense_matieres WHERE DISP_MAT_ID=$mat_id AND DISP_ET_ID=$et_id AND DISP_ANNEE_ID=$annee_courante";
        return self::doRequete($req)->num_rows > 0;
    }

    public static function updateEtudiants()
    {
        $req = "SELECT * from common_etudiant";
        $res = self::doRequete($req);
        while ($un_etudiant = $res->fetch_assoc()) {
            //updateData("common_etudiant",Ldap::ldap_rechercher_etudiant_avec_numeros($un_etudiant['ET_NUMERO']),"ET_ID=".$un_etudiant["ET_ID"],5,true);
            break;
        }
    }

    public static function getEtudiantPro(int $et_id): array
    {
        $req = "SELECT * FROM common_etudiant LEFT JOIN common_enseignant ON (ENS_ID=ET_TUTEUR_ENS_ID) WHERE ET_ID=$et_id";
        return self::getRequete($req);
    }

    public static function setTuteurEnseignant(int $et_id, ?int $ens_id): bool
    {
        $req = "UPDATE common_etudiant SET ET_TUTEUR_ENS_ID=" . ($ens_id == null ? "NULL" : $ens_id) . " WHERE ET_ID=$et_id";
        return self::execRequete($req);
    }

    public static function getLoginEtudiant(string $et_nom): array
    {
        $req = "SELECT ET_LOGIN AS LOGIN, ET_NOM AS NOM FROM common_etudiant WHERE ET_NOM LIKE '%$et_nom%' ORDER BY ET_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsGroupesAvecStagesEtPlanning(string $annee_courante, string $groupe_id): array
    {
        $req = "SELECT STAGE_JURY_ENS_ID,GROUPE_FORM_ID,ET_ID, PLANNING_ID, ET_NOM,ENS_NOM,STAGE_REF,PLANNING_CONTENU, FROM_UNIXTIME(STAGE_DATE_SOUTENANCE,'%d/%m/%Y') AS DATE_SOUTENANCE, FROM_UNIXTIME(CRENEAU_DEBUT,'%Hh%i') AS CRENEAU_DEBUT, FROM_UNIXTIME(CRENEAU_FIN,'%Hh%i') AS CRENEAU_FIN
                FROM (etudiants_groupes,common_inscription)
                    LEFT JOIN common_stage ON (ET_ID=STAGE_ET_ID AND STAGE_ANNEE_ID=ET_GROUPE_ANNEE_ID)
                    LEFT JOIN common_enseignant ON (ENS_ID=STAGE_ENS_ID)                    
                    LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID=PLANNING_STAGE_ID)
                    LEFT JOIN common_soutenances_planning ON (PLANNING_ID=STAGE_PLANNING_ID)
                    LEFT JOIN common_soutenances_planning_creneau ON (CRENEAU_ID=STAGE_SOUTENANCE_CRENEAU_ID)
                WHERE GROUPE_ID=$groupe_id AND ET_GROUPE_ANNEE_ID=$annee_courante
                  AND INSCRIPT_ANNEE_ID=$annee_courante AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_DISP = 0
                GROUP BY ET_ID,PLANNING_ID
                ORDER BY ET_NOM, ET_ID, PLANNING_ID";

        $retour = self::getRequete($req);
        foreach ($retour as &$un_etudiant) {
            $un_etudiant['NB_CANDIDATURES'] = count(Stages::getCandidatures($un_etudiant['ET_ID'], $annee_courante));
            if ($un_etudiant['STAGE_JURY_ENS_ID'] != "") {
                $un_etudiant['MEMBRE_JURY'] = Enseignants::getEnseigant($un_etudiant['STAGE_JURY_ENS_ID'])[0]['ENS_NOM'];
            } else {
                $un_etudiant['MEMBRE_JURY'] = "";
            }
        }
        return $retour;
    }

    public static function getFormationInscrit(int $et_id, int $annee_id): array
    {
        $req = "SELECT common_formation.*
                FROM common_inscription
                    JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID)
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                WHERE INSCRIPT_ET_ID=$et_id AND INSCRIPT_ANNEE_ID=$annee_id
                GROUP BY FORM_ID";
        return self::getRequete($req);
    }

    public static function getFormationInscritFormation(int $et_id, int $form_id): array
    {
        $req = "SELECT common_formation.*,common_annee.*
                FROM common_inscription
                    JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID)
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                    JOIN common_annee ON (ANNEE_ID = INSCRIPT_ANNEE_ID)
                WHERE INSCRIPT_ET_ID=$et_id AND FORM_ID=$form_id
                GROUP BY ANNEE_ID
                ORDER BY ANNEE_ID DESC";
        return self::getRequete($req);
    }

    public static function isMeilleureUE(int $ET_ID, int $annee_courante)
    {
        $req = "SELECT * FROM common_etudiant_meilleure_ue WHERE MEILLEURE_ANNEE_ID=$annee_courante AND MEILLEURE_ET_ID=$ET_ID";
        return self::doRequete($req)->num_rows > 0;

    }

    public static function getTousLesEtudiants(): array
    {
        $req = "SELECT DISTINCT ET_NUMERO, ET_LOGIN
                FROM common_etudiant
                         JOIN common_inscription ON (INSCRIPT_ET_ID = ET_ID)
                         JOIN common_annee ON (ANNEE_COURANTE = 1 AND
                                               (INSCRIPT_ANNEE_ID = ANNEE_ID OR INSCRIPT_ANNEE_ID = ANNEE_ID - 1 OR
                                                INSCRIPT_ANNEE_ID = ANNEE_ID + 1))
                WHERE ET_NUMERO IS NOT NULL
                   OR ET_NUMERO <> ''";
        return self::getRequete($req);

    }

    public static function getEtudiantsDuDepartementPourAPI(int $dept_id, int $annee_courante)
    {

    }

    public static function getEtudiantsDemissionnaires(int $annee_courante, int $dept_id)
    {
        $req = "select FORM_NOM, ET_ID, ET_NOM, ET_PROFESSIONNALISATION, ET_NUMERO, ET_NAISSANCE, ET_BAC, ET_RED, ET_TIERS
                from common_etudiant
                         join common_inscription on (ET_ID = INSCRIPT_ET_ID)
                         join common_semestre on (SEM_ID = INSCRIPT_SEM_ID)
                         join common_formation on (FORM_ID = SEM_FORM_ID)
                where ET_DEM = 1
                  AND INSCRIPT_ANNEE_ID = $annee_courante
                  AND FORM_DEPT_ID = $dept_id
                GROUP BY ET_ID
                ORDER BY FORM_NOM,ET_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsSansNote(int $annee_id, int $sem_id, int $groupe_id) : array
    {
        $req = "SELECT UE_ID, UE_NOM, MAT_ID, MAT_NOM, MAT_ORDRE, ET_ID, ET_NOM, SUM(IF(NOTES_VALEUR IS NULL, 0, 1)) AS TOTAL
            FROM common_etudiant
                     JOIN common_etudiant_groupes ON (ET_ID = GROUPE_ET_ID)
                     JOIN common_groupes ON (ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE, '%'))
                     JOIN common_inscription ON (INSCRIPT_ANNEE_ID = ET_GROUPE_ANNEE_ID AND INSCRIPT_ET_ID = ET_ID)
                     JOIN common_ue ON (UE_SEM_ID = INSCRIPT_SEM_ID)
                     JOIN common_matiere ON (MAT_UE_ID = UE_ID)
                     LEFT JOIN common_dispense_ue on (ET_ID = common_dispense_ue.DISP_ET_ID AND DISP_UE_ID = UE_ID AND
                                                         DISP_ANNEE_ID = ET_GROUPE_ANNEE_ID)
                     LEFT JOIN common_dispense_matieres on (ET_ID = common_dispense_matieres.DISP_ET_ID AND DISP_MAT_ID = MAT_ID)
                     LEFT JOIN common_controle ON (CONTROLE_ANNEE_ID = ET_GROUPE_ANNEE_ID AND CONTROLE_MAT_ID = MAT_ID)
                     LEFT JOIN common_notes ON (NOTES_ET_ID = ET_ID AND CONTROLE_ID = NOTES_CONTROLE_ID)
            WHERE GROUPE_ID = $groupe_id
              AND INSCRIPT_SEM_ID = $sem_id
              AND CONTROLE_MOYENNE = '1'
              AND CONTROLE_VALIDE = 1
              AND MAT_HAS_NOTE = 1
              AND ET_GROUPE_ANNEE_ID = $annee_id
              AND DISP_UE_ID IS NULL
              AND DISP_MAT_ID IS NULL
              AND ET_DEM = 0
            GROUP BY ET_ID, MAT_ID
            HAVING TOTAL = 0
            ORDER BY UE_ORDRE, UE_ID, MAT_ORDRE, MAT_ID, ET_NOM
        ";

        return self::getRequete($req);
    }

}