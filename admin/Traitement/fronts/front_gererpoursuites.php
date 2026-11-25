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
if (!defined('FRONT_ACCESS')) {
    die ('Piratage détecté');
}
/*****************************************************************
 * POURSUITES ****************************************************
 *****************************************************************/
/**
 * Affectation d'une matière à une matière de poursuite
 */
if (isset($_POST['bfmw_orig_affecter_poursuite'])) {
    $id = createData("common_poursuite_matiere_composition", $_POST, 2);
    if ($id === 0) {
        makeErreur("success", "Affectation d'une matière à une matière de poursuites d'études", "La matière a été affectée avec succès.");
    } else {
        makeErreur("", "Affectation d'une matière à une matière de poursuites d'études", "Il y a eu une erreur lors de l'affectation de la matière. Contactez le responsable de formation.");
    }
}

/**
 * Suppression d'une mat
 */
if (isset($_GET['bfmw_orig_delmat']) && isset($_GET['bfmw_orig_delmatp'])) {
    $req = "DELETE FROM common_poursuite_matiere_composition WHERE PMAT_MAT_ID=".$_GET['bfmw_num_delmat']." AND MAT_PMAT_ID=" . $_GET['bfmw_num_delmatp'];
    $conn->query($req);
}

/**
 * Création d'un pmat
 */
if (isset($_POST['bfmw_orig_creer_pmat'])) {
    $_POST['bfmw_orig_*PMAT_DEPT_ID'] = CURRENT_DEPT_ID;
    $_POST['bfmw_num_*PMAT_DEPT_ID'] = CURRENT_DEPT_ID;
    $id = createData("common_poursuite_matiere", $_POST, 2);
    if ($id > 0) {
        makeErreur("success", "Création d'une matière de poursuite d'études", "La matière a été correctement créé");
    } else {
        makeErreur("", "Création d'une matière de poursuite d'études", "Il y a eu une erreur lors de la création de la matière");
    }
}

/**
 * Suppression d'une pmat
 */
if (isset($_GET['bfmw_orig_delmatp']) && !isset($_GET['bfmw_orig_delmat'])) {
    $req = "DELETE FROM common_poursuite_matiere WHERE PMAT_DEPT_ID=".CURRENT_DEPT_ID." AND PMAT_ID=" . $_GET['bfmw_num_delmatp'];
    $conn->query($req);
}

/**
 * Clôtures
 */
function copyTables($champs, $from, $where, $to, $nbfields) : bool
{
    global $conn;

    $req = "SELECT $champs FROM $from WHERE $where";
    $res = $conn->query($req);
    try {
        $total = $res->num_rows;
    } catch (Exception $e) {
        die ($req);
    }

    while ($une_ligne = $res->fetch_assoc()) {
        $ligne = array($une_ligne);
        manual_bfmw_secure($ligne);
        createData($to, $ligne[0], $nbfields);
    }
    /*$req = "SELECT $champs FROM $to WHERE $where";
    $res = $conn->query($req);

    return ($total == $res->num_rows);*/
    return true;
}

if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "clotures" && isset($_POST['bfmw_orig_clot_annee']) && isAdmin()) {
    $req = "SELECT * FROM common_annee WHERE ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " AND ANNEE_CLOSE=0";
    if ($conn->query($req)->num_rows === 0) {
        makeErreur("", "Clôture d'une année", "Impossible de clôturer une année déjà close.");
    } else {
        set_time_limit(600);
        mysql_start_transaction();
        $req = "SELECT DEPT_CODE FROM common_departement";
        $res = $conn->query($req);
        while ($un_departement = $res->fetch_assoc()) {
            if (!isErreur() && !copyTables("IFNULL(MOYAN_VALEUR,'NULL') AS `*MOYAN_VALEUR`, MOYAN_ET_ID AS `*MOYAN_ET_ID`, MOYAN_FORM_ID AS `*MOYAN_FORM_ID`, MOYAN_ANNEE_ID AS `*MOYAN_ANNEE_ID`, IFNULL(MOYAN_SPECIAL,'NULL') AS `*MOYAN_SPECIAL`",
                $un_departement['DEPT_CODE']."_notes_moyennes_annee",
                "MOYAN_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                "common_clotures_moyennes_annee",
                5
            )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer les moyennes de l'année.");
            }

            if (!isErreur() && !copyTables("MOYMAT_COEF AS `*MOYMAT_COEF`,MOYMAT_MAT_ID AS `*MOYMAT_MAT_ID`,MOYMAT_ET_ID AS `*MOYMAT_ET_ID`,MOYMAT_ANNEE_ID AS `*MOYMAT_ANNEE_ID`,MOYMAT_UE_ID AS `*MOYMAT_UE_ID`,MOYMAT_UE_COEF AS `*MOYMAT_UE_COEF`,MOYMAT_SEM_COEF AS `*MOYMAT_SEM_COEF`,MOYMAT_SEM_ID AS `*MOYMAT_SEM_ID`,MOYMAT_FORM_ID AS `*MOYMAT_FORM_ID`,IFNULL(MOYMAT_SURMAT_ID,'NULL') AS `*MOYMAT_SURMAT_ID`,IFNULL(MOYMAT_VALEUR,'NULL') AS `*MOYMAT_VALEUR`,IFNULL(MOYMAT_SPECIAL,'NULL') AS `*MOYMAT_SPECIAL`,IFNULL(MOYMAT_BONUS_SPECIAL,'NULL') AS `*MOYMAT_BONUS_SPECIAL`,IFNULL(MOYMAT_DISPENSE,'NULL') AS `*MOYMAT_DISPENSE`",
                    $un_departement['DEPT_CODE']."_notes_moyennes_matiere",
                    "MOYMAT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                    "common_clotures_moyennes_matiere",
                    14
                )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer des matières.");
            }

            if (!isErreur() && !copyTables("IFNULL(MOYMAT_VALEUR,'NULL') AS `*MOYMAT_VALEUR`,MOYMAT_COEF AS `*MOYMAT_COEF`,MOYMAT_MAT_ID AS `*MOYMAT_MAT_ID`,MOYMAT_ET_ID AS `*MOYMAT_ET_ID`,MOYMAT_ANNEE_ID AS `*MOYMAT_ANNEE_ID`,MOYMAT_UE_ID AS `*MOYMAT_UE_ID`,MOYMAT_UE_COEF AS `*MOYMAT_UE_COEF`,MOYMAT_SEM_COEF AS `*MOYMAT_SEM_COEF`,MOYMAT_SEM_ID AS `*MOYMAT_SEM_ID`,MOYMAT_FORM_ID AS `*MOYMAT_FORM_ID`,IFNULL(MOYMAT_SURMAT_ID,'NULL') AS `*MOYMAT_SURMAT_ID`,IFNULL(MOYMAT_SPECIAL,'NULL') AS `*MOYMAT_SPECIAL`",
                    $un_departement['DEPT_CODE']."_notes_moyennes_matiere_sans_bonus",
                    "MOYMAT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                    "common_clotures_moyennes_matiere_sans_bonus",
                    12
                )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer les moyennes des matières sans bonus.");
            }

            if (!isErreur() && !copyTables("IFNULL(MOYMAT_BONUS_VALEUR,'NULL') AS `*MOYMAT_BONUS_VALEUR`,MOYMAT_MAT_ID AS `*MOYMAT_MAT_ID`,MOYMAT_ET_ID AS `*MOYMAT_ET_ID`,MOYMAT_ANNEE_ID AS `*MOYMAT_ANNEE_ID`,MOYMAT_UE_ID AS `*MOYMAT_UE_ID`,MOYMAT_UE_COEF AS `*MOYMAT_UE_COEF`,MOYMAT_SEM_COEF AS `*MOYMAT_SEM_COEF`,MOYMAT_SEM_ID AS `*MOYMAT_SEM_ID`,MOYMAT_FORM_ID AS `*MOYMAT_FORM_ID`,IFNULL(MOYMAT_SURMAT_ID,'NULL') AS `*MOYMAT_SURMAT_ID`,IFNULL(MOYMAT_BONUS_SPECIAL,'NULL') AS `*MOYMAT_BONUS_SPECIAL`",
                    $un_departement['DEPT_CODE']."_notes_moyennes_matiere_somme_bonus",
                    "MOYMAT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                    "common_clotures_moyennes_matiere_somme_bonus",
                    11
                )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer les moyennes des bonus.");
            }

            if (!isErreur() && !copyTables("IFNULL(MOYSEM_VALEUR,'NULL') AS `*MOYSEM_VALEUR`,MOYSEM_ET_ID AS `*MOYSEM_ET_ID`,MOYSEM_FORM_ID AS `*MOYSEM_FORM_ID`,MOYSEM_ANNEE_ID AS `*MOYSEM_ANNEE_ID`,MOYSEM_COEF AS `*MOYSEM_COEF`,MOYSEM_ID AS `*MOYSEM_ID`,IFNULL(MOYSEM_SPECIAL,'NULL') AS `*MOYSEM_SPECIAL`",
                    $un_departement['DEPT_CODE']."_notes_moyennes_semestre",
                    "MOYSEM_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                    "common_clotures_moyennes_semestre",
                    7
                )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer les moyennes du semestre.");
            }
//Manque dispense
            if (!isErreur() && !copyTables("IFNULL(MOYMAT_VALEUR,'NULL') as `*MOYMAT_VALEUR`, MOYMAT_MAT_ID as `*MOYMAT_MAT_ID`,MOYMAT_COEF as `*MOYMAT_COEF`,MOYMAT_ET_ID as `*MOYMAT_ET_ID`,MOYMAT_ANNEE_ID as `*MOYMAT_ANNEE_ID`,MOYMAT_UE_ID as `*MOYMAT_UE_ID`,MOYMAT_UE_COEF as `*MOYMAT_UE_COEF`,MOYMAT_SEM_COEF as `*MOYMAT_SEM_COEF`,MOYMAT_SEM_ID as `*MOYMAT_SEM_ID`,MOYMAT_FORM_ID as `*MOYMAT_FORM_ID`,IFNULL(MOYMAT_SPECIAL,'NULL') as `*MOYMAT_SPECIAL`",
                    $un_departement['DEPT_CODE']."_notes_moyennes_surmatieres",
                    "MOYMAT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                    "common_clotures_moyennes_surmatieres",
                    11
                )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer les moyennes des surmatières.");
            }

            if (!isErreur() && !copyTables("IFNULL(MOYUE_VALEUR,'NULL') AS `*MOYUE_VALEUR`,IFNULL(MOYUE_BARREE,'NULL') AS `*MOYUE_BARREE`,MOYUE_ET_ID AS `*MOYUE_ET_ID`,MOYUE_ANNEE_ID AS `*MOYUE_ANNEE_ID`,MOYUE_UE_ID AS `*MOYUE_UE_ID`,MOYUE_COEF AS `*MOYUE_COEF`,MOYUE_SEM_COEF AS `*MOYUE_SEM_COEF`,MOYUE_SEM_ID AS `*MOYUE_SEM_ID`,MOYUE_FORM_ID AS `*MOYUE_FORM_ID`,MOYUE_COEF_CALC AS `*MOYUE_COEF_CALC`,IFNULL(MOYUE_SPECIAL,'NULL') AS `*MOYUE_SPECIAL`",
                    $un_departement['DEPT_CODE']."_notes_moyennes_ue_meilleures",
                    "MOYUE_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'],
                    "common_clotures_moyennes_ue",
                    11
                )) {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer les moyennes de l'ue.");
            }
        }

        if (!isErreur()) {
            $req = "INSERT INTO common_clotures_notes select common_notes.* from common_notes,common_controle where CONTROLE_ID=NOTES_CONTROLE_ID AND CONTROLE_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'];
            $conn->query($req);
            $insertions = $conn->affected_rows;
            $req = "DELETE FROM common_notes WHERE NOTES_ID IN (select NOTES_ID from common_notes,common_controle where CONTROLE_ID=NOTES_CONTROLE_ID AND CONTROLE_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . ")";
            $conn->query($req);
            $suppressions = $conn->affected_rows;
            if ($suppressions != $insertions) {
                makeErreur("", "Clôture d'une année", "ERREUR : $insertions notes insérées pour $suppressions supprimées");
            }
        }

        if (!isErreur()) {
            $req = "INSERT INTO common_pro_signatures_backup select common_pro_signatures.* from common_pro_signatures,common_backup_ade_etudiant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID";
            $conn->query($req);
            $insertions = $conn->affected_rows;
            $req = "DELETE FROM common_pro_signatures WHERE SIGNATURE_ID IN (SELECT SIGNATURE_ID FROM common_pro_signatures,common_backup_ade_etudiant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID)";
            $conn->query($req);
            $suppressions = $conn->affected_rows;
            if ($suppressions != $insertions) {
                makeErreur("", "Clôture d'une année", "ERREUR : $insertions signatures pro étudiants insérées pour $suppressions supprimées");
            }
        }

        if (!isErreur()) {
            $req = "INSERT INTO common_pro_signatures_backup select common_pro_signatures.* from common_pro_signatures,common_backup_ade_enseignant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID";
            $conn->query($req);
            $insertions = $conn->affected_rows;
            $req = "DELETE FROM common_pro_signatures WHERE SIGNATURE_ID IN (SELECT SIGNATURE_ID FROM common_pro_signatures,common_backup_ade_enseignant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID)";
            $conn->query($req);
            $suppressions = $conn->affected_rows;
            if ($suppressions != $insertions) {
                makeErreur("", "Clôture d'une année", "ERREUR : $insertions signatures pro enseignants insérées pour $suppressions supprimées");
            }
        }

        if (!isErreur()) {
            $req = "INSERT INTO common_absences_signatures_backup select common_absences_signatures.* from common_absences_signatures,common_backup_ade_etudiant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID";
            $conn->query($req);
            $insertions = $conn->affected_rows;
            $req = "DELETE FROM common_absences_signatures WHERE SIGNATURE_ID IN (SELECT SIGNATURE_ID FROM common_absences_signatures,common_backup_ade_etudiant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID)";
            $conn->query($req);
            $suppressions = $conn->affected_rows;
            if ($suppressions != $insertions) {
                makeErreur("", "Clôture d'une année", "ERREUR : $insertions signatures étudiants insérées pour $suppressions supprimées");
            }
        }

        if (!isErreur()) {
            $req = "INSERT INTO common_absences_signatures_backup select common_absences_signatures.* from common_absences_signatures,common_backup_ade_enseignant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID";
            $conn->query($req);
            $insertions = $conn->affected_rows;
            $req = "DELETE FROM common_absences_signatures WHERE SIGNATURE_ID IN (SELECT SIGNATURE_ID FROM common_absences_signatures,common_backup_ade_enseignant where EDT_UID=SIGNATURE_EDT_UID AND EDT_ANNEE_ID=" . $_POST['bfmw_num_clot_annee'] . " GROUP BY SIGNATURE_ID)";
            $conn->query($req);
            $suppressions = $conn->affected_rows;
            if ($suppressions != $insertions) {
                makeErreur("", "Clôture d'une année", "ERREUR : $insertions signatures enseignants insérées pour $suppressions supprimées");
            }
        }


        if (!isErreur()) {
            $req = "UPDATE common_annee SET ANNEE_CLOSE=1 WHERE ANNEE_ID=".$_POST['bfmw_num_clot_annee'];
            $conn->query($req);
            if ($conn->affected_rows === 1) {
                mysql_commit();
                makeErreur("success", "Clôture d'une année", "L'année a été clôturée correctement.");
            } else {
                makeErreur("", "Clôture d'une année", "Impossible de clôturer le flag de l'année.");
                mysql_rollback();
            }
        } else {
            mysql_rollback();
        }
    }
}

/**
 * Ajout d'un avis de PE
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "poursuite" && isset($_POST['bfmw_orig_creer_avis']) && isset($_POST['bfmw_orig_*MODELE_AVIS']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    bfmw_add_secured($_POST,"*MODELE_DEPT_ID",CURRENT_DEPT_ID);
    createData("common_poursuite_avis_modele",$_POST,2);
}

/**
 * Suppression d'un avis de PE
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "poursuite" && isset($_GET['bfmw_orig_delavis']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    Poursuites::supprimerAvis($_GET['bfmw_num_delavis'], CURRENT_DEPT_ID);
}

/**
 * Ajout d'une catégorie de PE
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "poursuite" && isset($_POST['bfmw_orig_creer_categorie']) && isset($_POST['bfmw_orig_*CATEGORIE_NOM']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    bfmw_add_secured($_POST,"*CATEGORIE_DEPT_ID",CURRENT_DEPT_ID);
    createData("common_poursuite_avis_categorie",$_POST,2);
}

/**
 * Suppression d'une catégorie d'avis de PE
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "poursuite" && isset($_GET['bfmw_orig_delcateg']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    Poursuites::supprimerCategorie($_GET['bfmw_orig_delcateg'], CURRENT_DEPT_ID);
}


/**
 * Préparation du jury de poursuites
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "poursuite" && isset($_GET['bfmw_orig_prepa']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    mysql_start_transaction();

    $annee_courante = Annees::getIdAnneeCourante();

    $formationsConcernees = Formations::getFormationsDuConnecteString();

    $req = "SELECT GROUPE_SEM_ID FROM common_groupes,common_semestres_groupes WHERE GROUPE_ID=SEM_GROUPE_ID AND GROUPE_POURSUITE=1 AND GROUPE_FORM_ID IN ($formationsConcernees) GROUP BY GROUPE_SEM_ID";
    $res = $conn->query($req);
    $semestresConcernees= array("0");
    while ($un_semestre = $res->fetch_assoc()) {
        $semestresConcernees[] = $un_semestre['GROUPE_SEM_ID'];
    }


    $req = "SELECT GROUPE_SEM_ID FROM common_groupes,common_semestres_groupes WHERE GROUPE_ID=SEM_GROUPE_ID AND GROUPE_FORM_ID IN ($formationsConcernees) GROUP BY GROUPE_SEM_ID";
    $res = $conn->query($req);
    while ($un_semestre = $res->fetch_assoc()) {
        $req = "DELETE FROM common_cloture_ue WHERE CLOT_SEM_ID IN (".$un_semestre['GROUPE_SEM_ID'].")";
        $req = "DELETE FROM common_cloture_sem WHERE CLOT_SEM_ID IN (".$un_semestre['GROUPE_SEM_ID'].")";
    }

    //Ues annee courante
    $req = "SELECT * FROM ".CURRENT_DEPT."_notes_moyennes_ue_meilleures WHERE MOYUE_SEM_ID IN (" . implode(",",$semestresConcernees) . ") AND MOYUE_ANNEE_ID=$annee_courante ORDER BY MOYUE_UE_ID,MOYUE_VALEUR DESC";
    $res = $conn->query($req);
    $rang = array();
    while ($une_moyenne = $res->fetch_assoc()) {
        if (isset($rang[$une_moyenne['MOYUE_UE_ID']])) {
            $rang[$une_moyenne['MOYUE_UE_ID']]++;
        } else {
            $rang[$une_moyenne['MOYUE_UE_ID']] = 1;
        }

        $req = "INSERT INTO common_cloture_ue(CLOT_ET_ID,CLOT_UE_ID,CLOT_SEM_ID,CLOT_ANNEE_ID,CLOT_NOTE,CLOT_RANG,CLOT_CLASSEMENT) VALUES('" . $une_moyenne['MOYUE_ET_ID'] . "','" . $une_moyenne['MOYUE_UE_ID'] . "','" . $une_moyenne['MOYUE_SEM_ID'] . "','" . $une_moyenne['MOYUE_ANNEE_ID'] . "','" . round($une_moyenne['MOYUE_VALEUR'], 2) . "'," . $rang[$une_moyenne['MOYUE_UE_ID']] . ",0) ON DUPLICATE KEY UPDATE CLOT_NOTE='" . round($une_moyenne['MOYUE_VALEUR'], 2) . "',CLOT_RANG=" . $rang[$une_moyenne['MOYUE_UE_ID']] . ",CLOT_CLASSEMENT=0";
        $conn->query($req);
    }

    foreach ($rang as $UE_ID => $total) {
        $req = "UPDATE common_cloture_ue SET CLOT_CLASSEMENT=" . $total . " WHERE CLOT_UE_ID=" . $UE_ID . " AND CLOT_ANNEE_ID=" . $annee_courante;
        $conn->query($req);
    }

    //Ues annee passee
    $req = "SELECT * FROM common_clotures_moyennes_ue WHERE MOYUE_FORM_ID IN ($formationsConcernees) AND MOYUE_ANNEE_ID=$annee_courante-1 ORDER BY MOYUE_UE_ID,MOYUE_VALEUR DESC";
    $res = $conn->query($req);
    $rang = array();
    while ($une_moyenne = $res->fetch_assoc()) {
        if (isset($rang[$une_moyenne['MOYUE_UE_ID']])) {
            $rang[$une_moyenne['MOYUE_UE_ID']]++;
        } else {
            $rang[$une_moyenne['MOYUE_UE_ID']] = 1;
        }

        $req = "INSERT INTO common_cloture_ue(CLOT_ET_ID,CLOT_UE_ID,CLOT_SEM_ID,CLOT_ANNEE_ID,CLOT_NOTE,CLOT_RANG,CLOT_CLASSEMENT) VALUES('" . $une_moyenne['MOYUE_ET_ID'] . "','" . $une_moyenne['MOYUE_UE_ID'] . "','" . $une_moyenne['MOYUE_SEM_ID'] . "','" . $une_moyenne['MOYUE_ANNEE_ID'] . "','" . round($une_moyenne['MOYUE_VALEUR'], 2) . "'," . $rang[$une_moyenne['MOYUE_UE_ID']] . ",0) ON DUPLICATE KEY UPDATE CLOT_NOTE='" . round($une_moyenne['MOYUE_VALEUR'], 2) . "',CLOT_RANG=" . $rang[$une_moyenne['MOYUE_UE_ID']] . ",CLOT_CLASSEMENT=0";
        $conn->query($req);
    }

    foreach ($rang as $UE_ID => $total) {
        $req = "UPDATE common_cloture_ue SET CLOT_CLASSEMENT=" . $total . " WHERE CLOT_UE_ID=" . $UE_ID . " AND CLOT_ANNEE_ID=" . ($annee_courante-1);
        $conn->query($req);
    }


    //Semestres annee courante
    $req = "SELECT * FROM ".CURRENT_DEPT."_notes_moyennes_semestre WHERE MOYSEM_ID IN (" . implode(",",$semestresConcernees) . ") AND MOYSEM_ANNEE_ID=$annee_courante ORDER BY MOYSEM_ID,MOYSEM_VALEUR DESC";
    $res = $conn->query($req);
    $nombre = $res->num_rows;
    $rang = 1;
    while ($une_moyenne = $res->fetch_assoc()) {

        $req = "INSERT INTO common_cloture_sem(CLOT_ET_ID,CLOT_SEM_ID,CLOT_ANNEE_ID,CLOT_NOTE,CLOT_RANG,CLOT_CLASSEMENT) VALUES(" . $une_moyenne['MOYSEM_ET_ID'] . "," . $une_moyenne['MOYSEM_ID'] . "," . $annee_courante . ",'" . round($une_moyenne['MOYSEM_VALEUR'], 2) . "'," . $rang . ",$nombre) ON DUPLICATE KEY UPDATE CLOT_NOTE='" . round($une_moyenne['MOYSEM_VALEUR'], 2) . "',CLOT_RANG=" . $rang++ . ",CLOT_CLASSEMENT=$nombre";
        $conn->query($req);
    }

    //Semestres annee passee
    $req = "SELECT * FROM common_clotures_moyennes_semestre WHERE MOYSEM_FORM_ID IN ($formationsConcernees) AND MOYSEM_ANNEE_ID=$annee_courante-1 ORDER BY MOYSEM_ID,MOYSEM_VALEUR DESC";
    $res = $conn->query($req);
    $rang = array();
    while ($une_moyenne = $res->fetch_assoc()) {

        if (isset($rang[$une_moyenne['MOYSEM_ID']])) {
            $rang[$une_moyenne['MOYSEM_ID']]++;
        } else {
            $rang[$une_moyenne['MOYSEM_ID']] = 1;
        }

        $req = "INSERT INTO common_cloture_sem(CLOT_ET_ID,CLOT_SEM_ID,CLOT_ANNEE_ID,CLOT_NOTE,CLOT_RANG,CLOT_CLASSEMENT) VALUES(" . $une_moyenne['MOYSEM_ET_ID'] . "," . $une_moyenne['MOYSEM_ID'] . "," . ($annee_courante-1) . ",'" . round($une_moyenne['MOYSEM_VALEUR'], 2) . "'," . $rang[$une_moyenne['MOYSEM_ID']] . ",0) ON DUPLICATE KEY UPDATE CLOT_NOTE='" . round($une_moyenne['MOYSEM_VALEUR'], 2) . "',CLOT_RANG=" . $rang[$une_moyenne['MOYSEM_ID']] . ",CLOT_CLASSEMENT=0";
        $conn->query($req);
    }

    foreach ($rang as $SEM_ID => $total) {
        $req = "UPDATE common_cloture_sem SET CLOT_CLASSEMENT=" . $total . " WHERE CLOT_SEM_ID=" . $SEM_ID . " AND CLOT_ANNEE_ID=" . ($annee_courante - 1);
        $conn->query($req);
    }


    mysql_commit();
    makeErreur("success","Préparation du jury", "La préparation du jury a été effectuée avec succès");
}
