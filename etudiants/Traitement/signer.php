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

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

if (!isset($_SESSION['ACTIVE_ABSENCES_AUTO']) && !isset($_SESSION['ACTIVE_ABSENCES_PRO'])) {
    $send="?p=accueil";
    require 'refresh.php';
    exit;
}

if (!isset($_POST['bfmw_orig_d'])) {
    $send="p=signature";
    require 'refresh.php';
    exit;
}

if (!isset($_POST['bfmw_orig_g'])) {
    $send="p=signature";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();

if (! Groupes::isEtudiantDansGroupe($_POST['bfmw_orig_g'],CURRENT_ID,$annee_courante)) {
    $send = "p=signature";
    require 'refresh.php';
    exit;
}

setAttachment($template, "signer", "signer.html");

$les_groupes_concernes = explode("$",$_POST['bfmw_orig_g']);
if (isset($_POST['bfmw_orig_signer_eleves'])) {
    foreach ($les_groupes_concernes as $un_groupe) {
        if (Absences_Automatiques::isCreneauDejaSigne(CURRENT_ID, $un_groupe, $_POST['bfmw_orig_d'])) {
            $send = "p=signature";
            require 'refresh.php';
            exit;
        }
    }
}

$etudiant_courant = Etudiants::getEtudiant(CURRENT_ID,$annee_courante);
GrillesDeSignatures::showGrilleEtudiant($etudiant_courant,$template,$_POST['bfmw_orig_d']);

affectToXHTML($template,array(
    "GROUPE_NOM" => "",
    "GROUPE_ID" => $_POST['bfmw_orig_g']
));

/*
$groupe_de_l_etudiant = Groupes::getGroupeEtudiant(CURRENT_ID,$annee_courante);
foreach ($groupe_de_l_etudiant as $un_groupe) {
    if (! in_array($un_groupe["GROUPE_ID"],$les_groupes_concernes)) {
        continue;
    }
    //$les_etudiants_du_groupe = Etudiants::getEtudiantsGroupes($annee_courante,$un_groupe['GROUPE_ID']);
    $les_etudiants_du_groupe = Etudiants::getEtudiant(CURRENT_ID,$annee_courante);
    GrillesDeSignatures::showGrilleEtudiant($les_etudiants_du_groupe,$template,$_POST['bfmw_orig_d']);

    affectToXHTML($template,array(
        "GROUPE_NOM" => $un_groupe['GROUPE_NOM'],
        "GROUPE_ID" => $un_groupe['GROUPE_ID']
    ));
}*/
generateCompleteXHTML($template, "signer");

