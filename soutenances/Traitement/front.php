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
if (isset($_GET["bfmw_num_a"])) {
    $annee_courante = $_GET["bfmw_num_a"];
}

if (isset($_GET["bfmw_orig_p2"]) && $_GET["bfmw_orig_p2"]==="creergroupe" && isset($_POST["bfmw_orig_creer_groupe"])) {
    if (! array_key_exists($_POST['bfmw_num_*GROUPE_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante))) {
        makeErreur("", "Création d'un groupe", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerGroupe($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'un groupe", "Le groupe a été créé avec succès.");
        } else {
            makeErreur("", "Création d'un groupe", "Il y a eu une erreur lors de la création du groupe.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_*GROUPE_FORM_ID']."&s=".$_POST['bfmw_num_*GROUPE_SESSION_ID']."&a=".$annee_courante;
}

if (isset($_GET["bfmw_orig_p2"]) && $_GET["bfmw_orig_p2"]==="creergroupe" && isset($_GET["bfmw_orig_dele"])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante))) {
        makeErreur("", "Suppression d'un étudiant d'un groupe", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::supprimerEtudiantDunGroupe($_GET["bfmw_num_dele"],$_GET["bfmw_num_g"]);
        if ($id > 0) {
            makeErreur("success", "Suppression d'un étudiant d'un groupe", "L'étudiant a été supprimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un étudiant d'un groupe", "Il y a eu une erreur lors de la suppression de l'étudiant.");
        }
    }

    $param .= "&amp;f=".$_GET['bfmw_num_f']."&s=".$_GET['bfmw_num_s']."&a=".$annee_courante."&g=".$_GET['bfmw_num_g'];
}

if (isset($_GET["bfmw_orig_p2"]) && $_GET["bfmw_orig_p2"]==="creergroupe" && isset($_GET["bfmw_orig_delg"])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante))) {
        makeErreur("", "Suppression d'un groupe", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::supprimerGroupes($_GET["bfmw_orig_delg"]);
        if ($id > 0) {
            makeErreur("success", "Suppression d'un groupe", "Le groupe a été supprimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un groupe", "Il y a eu une erreur lors de la suppression du groupe.");
        }
    }

    $param .= "&amp;f=".$_GET['bfmw_num_f']."&s=".$_GET['bfmw_num_s']."&a=".$annee_courante;
}

if (isset($_GET["bfmw_orig_p2"]) && $_GET["bfmw_orig_p2"]==="individuel" && isset($_GET["bfmw_orig_deleens"]) && isset($_GET["bfmw_orig_s"])) {
    $id = Notation_Soutenances::supprimerNotesDunEnseignant($_GET["bfmw_num_deleens"],CURRENT_ID,$annee_courante,$_GET["bfmw_num_s"]);
    if ($id > 0) {
        makeErreur("success", "Suppression des notes", "Les notes ont été supprimées avec succès.");
    } else {
        makeErreur("", "Suppression des notes", "Il y a eu une erreur lors de la suppression des notes.");
    }

    $param .= "&amp;e=".$_GET['bfmw_num_deleens']."&s=".$_GET['bfmw_num_s']."&a=".$annee_courante;
}

if (isset($_GET["bfmw_orig_p2"]) && $_GET["bfmw_orig_p2"]==="groupe" && isset($_GET["bfmw_orig_delgpens"]) && isset($_GET["bfmw_orig_s"])) {
    $id = Notation_Soutenances::supprimerNotesDunEnseignantSurUnGroupe($_GET["bfmw_num_delgpens"],CURRENT_ID,$annee_courante,$_GET['bfmw_num_s']);
    if ($id > 0) {
        makeErreur("success", "Suppression des notes", "Les notes ont été supprimées avec succès.");
    } else {
        makeErreur("", "Suppression des notes", "Il y a eu une erreur lors de la suppression des notes.");
    }

    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;gp=".$_GET['bfmw_num_delgpens']."&s=".$_GET['bfmw_num_s']."&a=".$annee_courante;
}


$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;
require 'refresh.php';