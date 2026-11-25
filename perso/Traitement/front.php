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
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

/**
 * Création d'une disponibilité
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_s']) && isset($_POST['bfmw_orig_date']) && isset($_POST['bfmw_orig_creer_dispo'])) {
    try {
        $date_2359 = transformDate2359($_POST['bfmw_orig_date']);
        $date_0000 = transformDate($_POST['bfmw_orig_date']);
        if (Soutenances::isDateAutoriseeDansLePlanning($date_2359,$_GET['bfmw_num_s']) || Soutenances::isDateAutoriseeDansLePlanning($date_0000,$_GET['bfmw_num_s'])) {
            bfmw_add_secured($_POST, "*DISPO_ENS_ID", CURRENT_ID);
            bfmw_add_secured($_POST, "*DISPO_ANNEE_ID", $annee_courante);
            bfmw_add_secured($_POST, "*DISPO_PLANNING_ID", $_GET['bfmw_num_s']);
            bfmw_add_secured($_POST, "*DISPO_DATE", $date_0000);

            $id = Soutenances::creerDisponibilite($_POST);
            if ($id > 0) {
                makeErreur("success", "Création d'une disponibilité", "Votre disponibilité a été correctement enregistrée");
            } else {
                makeErreur("", "Création d'une disponibilité", "Il y a eu une erreur lors de l'enregistrement de votre disponibilité");
            }
        } else {
            makeErreur("", "Création d'une disponibilité", "La date choisie est en dehors de la date du planning");
        }
    } catch (Exception $e) {
        makeErreur("","Création d'une disponibilité", "Il y a eu une erreur lors de l'enregistrement de votre disponibilité");
    }
    $param .= "&s=".$_GET['bfmw_num_s']."&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression d'une disponibilité
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_deldispo']) && isset($_GET['bfmw_orig_s'])) {
    $retour = Soutenances::suppressionDisponibilite(CURRENT_ID,$_GET['bfmw_num_deldispo'],$_GET['bfmw_num_s']);
    if ($retour == null) {
        makeErreur("", "Suppression d'une disponibilité", "Impossible de supprimer cette disponibilité, une soutenance y est affectée");
    } else if ($retour === true) {
        makeErreur("success", "Suppression d'une disponibilité", "Votre disponibilité a été correctement supprimée");
    } else {
        makeErreur("", "Suppression d'une disponibilité", "Il y a eu une erreur lors de la suppression de votre disponibilité");
    }
    $param .= "&a=".$_GET['bfmw_num_a'];
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;
require 'refresh.php';