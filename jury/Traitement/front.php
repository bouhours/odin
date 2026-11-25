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

$data = "";

/**
 * Création d'un jury
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "preparation" && isset($_POST['bfmw_orig_create_jury'])) {
    if (!array_key_exists($_POST['bfmw_num_*JURY_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_*JURY_ANNEE_ID']))) {
        makeErreur("","Création d'un jury","Impossible de créer le jury.");
    } else {
        if (Jury::creerJury($_POST) > 0) {
            makeErreur("success","Création d'un jury","Le jury a été créé.");
        } else {
            makeErreur("","Création d'un jury","Impossible de créer le jury.");
        }
    }

    $data .= "&f=".$_POST['bfmw_num_*JURY_FORM_ID']."&a=".$_POST['bfmw_num_*JURY_ANNEE_ID'];
}

/**
 * Création d'un regroupement
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "preparation" && isset($_POST['bfmw_orig_create_groupe'])) {
    if (!array_key_exists($_POST['bfmw_num_*GROUPE_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("","Création d'un regroupement","Impossible de créer le regroupement.");
    } else {
        if (Jury::creerGroupe($_POST) > 0) {
            makeErreur("success","Création d'un regroupement","Le regroupement a été créé.");
        } else {
            makeErreur("","Création d'un regroupement","Impossible de créer le regroupement.");
        }
    }

    $data .= "&f=".$_POST['bfmw_num_*GROUPE_FORM_ID']."&a=".$_POST['bfmw_num_ANNEE_ID']."&j=".$_POST['bfmw_num_*GROUPE_JURY_ID'];
}

/**
 * Suppression d'un jury
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "preparation" && isset($_GET['bfmw_orig_delj'])) {
    if (!array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("","Suppression d'un jury","Impossible de supprimer le jury.");
    } else {
        if (Jury::supprimerJury($_GET['bfmw_num_f'],$_GET['bfmw_num_delj'],$_GET['bfmw_num_a']) == 1) {
            makeErreur("success","Suppression d'un jury","Le jury a été supprimé.");
        } else {
            makeErreur("","Suppression d'un jury","Impossible de supprimer le jury.");
        }
    }

    $data .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression d'un regroupement
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "preparation" && isset($_GET['bfmw_orig_delg'])) {
    if (!array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("","Suppression d'un regroupement","Impossible de supprimer le regroupement.");
    } else {
        if (Jury::supprimerGroupe($_GET['bfmw_num_delg'],$_GET['bfmw_num_f']) == 1) {
            makeErreur("success","Suppression d'un regroupement","Le regroupement a été supprimé.");
        } else {
            makeErreur("","Suppression d'un regroupement","Impossible de supprimer le regroupement.");
        }
    }

    $data .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a']."&j=".$_GET['bfmw_num_j'];
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $data . $message_erreur;
require 'refresh.php';
