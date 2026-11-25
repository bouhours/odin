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
 * GESTION GROUPES ***********************************************
 *****************************************************************/
/**
 * Création d'un groupe
 */
if (isset($_POST['bfmw_orig_create_groupe']) && isset($_POST['bfmw_orig_*GROUPE_NOM'])) {
    if (trim($_POST['bfmw_orig_*GROUPE_NOM']) != "") {
        if (isset($_POST['bfmw_orig_PARENT'])) {
            $tab = explode("$",$_POST['bfmw_orig_PARENT']);
            $_POST['bfmw_orig_*GROUPE_FORM_ID'] = $tab[0];
            $_POST['bfmw_num_*GROUPE_FORM_ID'] = get_numeric($_POST['bfmw_orig_*GROUPE_FORM_ID']);
            $_POST['bfmw_orig_*GROUPE_PARENT'] = $tab[1];
            $_POST['bfmw_num_*GROUPE_PARENT'] = get_numeric($_POST['bfmw_orig_*GROUPE_PARENT']);
        }

        $req = "SELECT * FROM common_groupes WHERE GROUPE_NOM='".$_POST['bfmw_orig_*GROUPE_NOM']."' AND GROUPE_FORM_ID=".$_POST['bfmw_num_*GROUPE_FORM_ID']." AND GROUPE_PARENT".($_POST['bfmw_orig_*GROUPE_PARENT']=="NULL"?" IS NULL":"=".$_POST['bfmw_num_*GROUPE_PARENT']);

        if ($conn->query($req)->num_rows == 0) {
            computeCode($_POST);

            $id = createData("common_groupes", $_POST, 5);
            if ($conn->insert_id > 0) {
                makeErreur("success", "Création d'un groupe", "Le groupe a été créé");
            } else {
                makeErreur("", "Création d'un groupe", "Il y a eu une erreur à la création du groupe");
            }
        } else {
            makeErreur("warning", "Création d'un groupe", "Le nom du groupe choisi existe déjà");
        }
    } else {
        makeErreur("", "Création d'un groupe", "Impossible de créer un groupe sans nom");
    }
}

/**
 * Suppression d'un groupe
 */
if (isset($_GET['bfmw_orig_delgroupe']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="creergroupe" && (Formations::isResponsable() || Formations::isSecretaire() || Formations::isChef() || isAdmin())) {
    $req = "SELECT DISTINCT GROUPE_ID FROM common_groupes,common_formation, common_departement, common_responsable_formation WHERE FORM_ID=RESPONSABLE_FORM_ID AND DEPT_ID=FORM_DEPT_ID AND FORM_ID=GROUPE_FORM_ID AND DEPT_ID=".CURRENT_DEPT_ID." AND (DEPT_ENS_ID=".CURRENT_ID." OR RESPONSABLE_ENS_ID=".CURRENT_ID.") AND GROUPE_ID=".$_GET['bfmw_num_delgroupe'];
    if ($conn->query($req)->num_rows == 1 || isAdmin() || Formations::isSecretaire()) {
        mysql_start_transaction();
        if (Groupes::supprimerUnGroupe($_GET['bfmw_num_delgroupe'],Annees::getIdAnneeCourante())) {
            makeErreur("success", "Suppression d'un groupe", "Le groupe a été supprimé");
            mysql_commit();
        } else {
            makeErreur("", "Suppression d'un groupe", "Erreur lors de la suppression du groupe");
            mysql_rollback();
        }
    } else {
        makeErreur("", "Suppression d'un groupe", "Piratage détecté");
    }
}

/**
 * Mise à jour d'un groupe
 */
if (isset($_GET['bfmw_orig_g']) && isset($_POST['bfmw_orig_groupe_code']) && isset($_POST['bfmw_orig_update_groupe']) && isset($_POST['bfmw_orig_a'])) {
    mysql_start_transaction();

    $lesEtudiants = explode("\r\n", $_POST['bfmw_orig_lesEtudiants']);

    $req = "DELETE FROM common_etudiant_groupes WHERE ET_GROUPE_CODE = '" . $_POST['bfmw_orig_groupe_code'] . "' AND ET_GROUPE_ANNEE_ID=".$_POST['bfmw_orig_a'];
    $conn->query($req);

    foreach ($lesEtudiants as $numeroEtudiant) {
        if ($numeroEtudiant!="") {
            $req = "INSERT INTO common_etudiant_groupes(ET_GROUPE_CODE,GROUPE_ET_ID,ET_GROUPE_ANNEE_ID) SELECT '" . $_POST['bfmw_orig_groupe_code'] . "',ET_ID,".$_POST['bfmw_num_a']." FROM common_etudiant WHERE ET_NUMERO = '$numeroEtudiant'";
            $conn->query($req);
            if ($conn->affected_rows == 0) {
                mysql_rollback();
                makeErreur("", "Mise à jour d'un groupe", "Il y a eu une erreur lors de la mise à jour du groupe");
                break;
            }
        }
    }


    if (!isErreur()) {
        mysql_commit();
        makeErreur("success", "Affectation des groupes", "Les groupes ont été correctement affectés");
    }

    $param .= "&a=".$_POST['bfmw_orig_a']."&g=".$_POST['bfmw_orig_g'];
}


function computeCode(array &$data){
    global $conn;

    $retour = "";
    if ($data['bfmw_num_*GROUPE_FEUILLE'] == 0 && $data['bfmw_orig_*GROUPE_PARENT'] == "NULL") {
        $retour = $data['bfmw_num_*GROUPE_FORM_ID'].str_replace("%","",$data['bfmw_orig_*GROUPE_NOM']);
    } else if ($data['bfmw_orig_*GROUPE_PARENT'] != "NULL") {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_ID=".$data['bfmw_num_*GROUPE_PARENT'];
        $groupe = $conn->query($req)->fetch_assoc()['GROUPE_CODE'];
        $retour = $groupe.str_replace("%","",$data['bfmw_orig_*GROUPE_NOM']);
    }
    if ($data['bfmw_num_*GROUPE_FEUILLE'] == 1) {
        $retour .= "*";
    }
    $data['bfmw_orig_*GROUPE_CODE'] = $retour;
    $data['bfmw_num_*GROUPE_CODE'] = null;
}