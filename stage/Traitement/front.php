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

if (!isRegistered() && !isset($_GET['bfmw_orig_p2'])) {
    echo "Non autorisé";
    exit;
}

$param = "";

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Création du stage
 */
if ($_GET['bfmw_orig_p2'] == "accueil" && isset($_POST['bfmw_orig_depose_stage']) && isset($_GET['bfmw_orig_f']) && isset($_GET['bfmw_orig_a'])){
    if (!isset($_POST['bfmw_num_FORM_ID'])) {
        makeErreur("","Création d'un stage","Au moins une formation est obligatoire");
    }
    if (!isErreur() && preg_match("/^([a-zA-Z0-9_\-\.]+)@((([a-zA-Z0-9\-]+\.)+))([a-zA-Z]+|[0-9]+)(\]?)(,([a-zA-Z0-9_\-\.]+)@((([a-zA-Z0-9\-]+\.)+))([a-zA-Z]+|[0-9]+)(\]?))*$/",$_POST['bfmw_orig_*STAGE_MAIL']) !== 1) {
        makeErreur("","Création d'un stage","Attention, le format utilisé pour l'adresse mail est invalide.");
    }
    if (!isErreur()) {
        $_POST['bfmw_orig_*STAGE_DATE'] = time();
        $_POST['bfmw_num_*STAGE_DATE'] = time();
        mysql_start_transaction();
        $insert_id = createData("common_stage", $_POST, 6);
        if ($insert_id > 0) {
            foreach ($_POST['bfmw_num_FORM_ID'] as $une_formation) {
                if (Formations::insertStageFormations($une_formation, $insert_id) === false) {
                    makeErreur("", "Création d'un stage", "Il y a eu une erreur lors de l'affectation du stage aux formations. Contactez Cédric BOUHOURS (cedric.bouhours@uca.fr)");
                    mysql_rollback();
                    break;
                }
            }
            makeErreur("success", "Création d'un stage", "La création du stage a été effectuée avec succès");
            mysql_commit();
        } else {
            makeErreur("", "Création d'un stage", "Il y a eu une erreur lors de la création du stage. Contactez Cédric BOUHOURS (cedric.bouhours@uca.fr)");
            mysql_rollback();
        }
    }


    $param .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression du stage
 */
if ($_GET['bfmw_orig_p2'] == "accueil" && isset($_GET['bfmw_orig_dels']) && isset($_GET['bfmw_orig_f']) && isset($_GET['bfmw_orig_a'])){
    if (Stages::supprimerStage($_GET['bfmw_num_dels'],$_GET['bfmw_orig_a'])) {
        makeErreur("success","Suppression d'un stage","Le stage a été supprimé.");
    } else {
        makeErreur("","Suppression d'un stage","Impossible de supprimer ce stage.");
    }
    $param .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression de la candidature à un stage
 */
if (($_GET['bfmw_orig_p2'] == "accueil" || $_GET['bfmw_orig_p2'] == "etudiants") && isset($_GET['bfmw_orig_delaff']) && (isset($_GET['bfmw_orig_f']) || isset($_GET['bfmw_orig_g'])) && isset($_GET['bfmw_orig_s']) && isset($_GET['bfmw_orig_a'])){
    if (Stages::supprimerCandidateStage($_GET['bfmw_num_s'],$_GET['bfmw_orig_delaff'],$_GET['bfmw_orig_a'])) {
        makeErreur("success","Suppression d'une candidature à un stage","La candidature a été supprimée.");
    } else {
        makeErreur("success","Suppression d'une candidature à un stage","Impossible de supprimer cette candidature.");
    }
    if (isset($_GET['bfmw_orig_f'])) {
        $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=" . $_GET['bfmw_num_a'] . "&e=" . $_GET['bfmw_num_delaff'];
    } else {
        $param .= "&g=" . $_GET['bfmw_num_g'] . "&a=" . $_GET['bfmw_num_a'] . "&e=" . $_GET['bfmw_num_delaff'];
    }
}

/**
 * Dispenser une étudiant de stage
 */
if ($_GET['bfmw_orig_p2'] == "etudiants" && isset($_GET['bfmw_orig_disp']) && isset($_GET['bfmw_orig_e']) && isset($_GET['bfmw_orig_g']) && isset($_GET['bfmw_orig_a']) && isset($_GET['bfmw_orig_f']) && isset($_GET['bfmw_orig_g'])){
    if (Stages::dispenserEtudiant($_GET['bfmw_num_e'],$_GET['bfmw_num_a'])) {
        makeErreur("success","Dispense de stage","La dispense a été enregistrée.");
    } else {
        makeErreur("success","Dispense de stage","Impossible de dispenser cet étudiant.");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=" . $_GET['bfmw_num_a'] . "&g=" . $_GET['bfmw_num_g'];
}

/**
 * Réserver un créneau de soutenance
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "etudiants" && isset($_POST['bfmw_orig_selection_creneau']) && isset($_POST['bfmw_orig_selection_creneau'])) {
    $tab = explode("$",$_POST['bfmw_orig_selection_creneau']);
    if (isset($tab[0]) && isset($tab[1]) && isset($tab[2]) && isset($tab[3]) && isset($tab[4]) && isset($_GET['bfmw_num_e'])) {
        $le_stage = Stages::getStage($tab[4],$annee_courante);
        $le_planning = Stages::getPlanning($tab[3],$tab[4],$annee_courante);
        if ($le_stage != null && $le_planning != null) {
            if (Generation_Planning_Soutenances::affecterCreneauDeSoutenance($_GET['bfmw_num_e'], $tab[4], $tab[3], $_GET['bfmw_num_a'], CURRENT_DEPT_ID,$tab[1],$tab[0],$tab[2],$le_stage[0]['STAGE_ENS_ID'])) {
                makeErreur("success", "Réservation de créneau de soutenance", "Le créneau a été réservé.");
            } else {
                makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau, réessayez.");
            }
        } else {
            makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau, vous n'avez pas de stage.");
        }
        $param .= "&a=" . $_GET['bfmw_num_a'] ."&f=" . $_GET['bfmw_num_f'] ."&g=" . $_GET['bfmw_num_g'] . "&e=" . $_GET['bfmw_num_e'] . "#". $_GET['bfmw_num_e'];
    } else {
        makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau.");
    }
}

/**
 * Suppression d'une soutenance
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "etudiants" && isset($_POST['bfmw_orig_del_soutenance']) && isset($_POST['bfmw_orig_p']) && isset($_POST['bfmw_orig_del_sout'])) {
    if (Generation_Planning_Soutenances::supprimerSoutenance($_POST['bfmw_num_del_soutenance'],$_POST['bfmw_num_p'])) {
        makeErreur("success", "Suppression d'une soutenance", "La soutenance a été supprimée.");
    } else {
        makeErreur("", "Suppression d'une soutenance", "Il y a eu une erreur lors de la suppression de la soutenance.");
    }

    $param .= "&a=" . $_GET['bfmw_num_a'] ."&f=" . $_GET['bfmw_num_f'] ."&g=" . $_GET['bfmw_num_g'] . "&e=" . $_GET['bfmw_num_e'] . "#". $_GET['bfmw_num_e'];
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;
require 'refresh.php';