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

verifSession();

$les_formations_autorisees = Formations::getFormationsDuConnecteString();

$annee_courante = Annees::getIdAnneeCourante();

if (isset($_POST['bfmw_orig_s'])) {

    affectToXHTML($template,array(
        "IS_CHEF" => (Formations::isResponsable() || Formations::isSecretaire()) && isset($_GET['bfmw_orig_chef'])
    ));

    if (Formations::isResponsable() || Formations::isSecretaire()) {
        $req = "SELECT * FROM affectations_enseignants, common_enseignant WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ENS_ID=DEPT_ENS_ID AND MAT_ID=".$_POST['bfmw_num_s']." AND ENS_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY ENS_NOM";
    } else {
        $req = "SELECT * FROM affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=".$_POST['bfmw_num_s']." AND DEPT_ENS_ID=".CURRENT_ID." AND ENS_DEPT_ID=".CURRENT_DEPT_ID;    }

    $res = $conn->query($req);
    if (!is_bool($res) && $res->num_rows >= 1) {
        setAttachment($template, "selecteur_etudiants", "selecteur_etudiants.html");
        $id_sem = -1;
        $mat_ue_id = -1;

        /**
         * Enseignants
         */
        while ($un_enseignant = $res->fetch_assoc()) {
            $id_sem = $un_enseignant["SEM_ID"];
            $mat_ue_id = $un_enseignant["MAT_UE_ID"];
            if (Formations::isResponsable() || Formations::isSecretaire()) {
                affectToBloc($template, "un_enseignant", $un_enseignant);
            }
        }

        /**
         * Groupes
         */
        $req = "SELECT * FROM etudiants_groupes,semestres_groupes_code,common_inscription, common_semestre, common_formation WHERE GROUPE_DELETED=0 AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND FORM_ID=SEM_FORM_ID AND SEM_ID=INSCRIPT_SEM_ID AND SEM_ID=GROUPE_SEM_ID AND GROUPE_SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$annee_courante AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_SEM_ID = " . $id_sem . "  AND SEM_GROUPE_CODE LIKE concat(`GROUPE_CODE`,'%') GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
        $res = $conn->query($req);
        $les_groupes = array();
        affectToXHTML($template, array(
            "NB" => $res->num_rows
        ));
        $formation_en_cours = -1;
        while ($groupes = $res->fetch_assoc()) {
            if ($groupes['GROUPE_PRO'] == 1 || !Groupes::hasGroupeNonPro($groupes)) {
                continue;
            }

            $les_groupes[] = $groupes['GROUPE_ID'];

            if ($formation_en_cours != $groupes['FORM_ID']) {
                $formation_en_cours = $groupes['FORM_ID'];
                affectToBloc($template, "une_formation", $groupes);
            }

            affectToBloc($template, "une_formation.un_groupe", $groupes);
        }

        /**
         * Etudiants
         */
        if (count($les_groupes) > 0) {
            $req = "SELECT ET_ID, ET_NOM, GROUPE_ID, GROUPE_NOM, DISP_UE_ID, DISP_MAT_ID
                        FROM common_etudiant
                                 JOIN common_etudiant_groupes on (GROUPE_ET_ID = ET_ID AND ET_GROUPE_ANNEE_ID = $annee_courante)
                                 JOIN common_groupes ON (ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE, '%') AND GROUPE_DELETED = 0)
                                 JOIN common_inscription ON (INSCRIPT_ET_ID = ET_ID AND INSCRIPT_ANNEE_ID = $annee_courante AND INSCRIPT_SEM_ID = ".$id_sem.")
                                 LEFT JOIN common_dispense_ue on (ET_ID = DISP_ET_ID AND DISP_UE_ID = ".$mat_ue_id." AND DISP_ANNEE_ID = $annee_courante)
                                 LEFT JOIN common_dispense_matieres on (ET_ID = common_dispense_matieres.DISP_ET_ID AND DISP_MAT_ID = ".$_POST['bfmw_num_s']." AND
                                                                        common_dispense_matieres.DISP_ANNEE_ID = $annee_courante)
                        WHERE GROUPE_ID IN (" . implode(", ", $les_groupes) . ")
                        GROUP BY GROUPE_ID, ET_NUMERO
                        ORDER BY ET_NOM";
            $res = $conn->query($req);
            while ($etu = $res->fetch_assoc()) {
                if (count(Etudiants::getGroupesEtudiant($etu["ET_ID"],$annee_courante,"GROUPE_PRO=0 AND")) > 0) {
                    affectToBloc($template, "un_etudiant", $etu);
                }
            }
        }

        generateCompleteXHTML($template, "selecteur_etudiants");
    }

}
exit;
