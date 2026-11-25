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

$send_may_i = "signer";
require_once ('check_tablette.php');

verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

if (!isset($_POST['bfmw_orig_d']) || !isset($_POST['bfmw_orig_groupe_nom'])  || !isset($_POST['bfmw_orig_groupe_pro'])) {
    $send="p=accueil";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();
$groupe_courant = $_POST['bfmw_num_g']??-1;
$groupe_pro = $_POST['bfmw_num_groupe_pro']??-1;
$groupe_nom = $_POST['bfmw_orig_groupe_nom']??-1;
$uid_courante = $_POST['bfmw_orig_d']??-1;
$enseignant = $_POST['bfmw_orig_n']??"";
$cours = $_POST['bfmw_orig_cours']??"";
$enseignant_courant = $_POST['bfmw_orig_p']??-1;

setAttachment($template, "signer", "signer.html");
$les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$groupe_courant,-1,Formations::isAbsenceAutomatique($groupe_courant)?"":"ET_PROFESSIONNALISATION=1 AND");
GrillesDeSignatures::showGrilleEtudiant($les_etudiants,$template,$uid_courante);

affectToXHTML($template,array(
    "GROUPE_NOM" => $groupe_nom,
    "GROUPE_ID" => $groupe_courant,
    "ENSEIGNANT" => $enseignant,
    "NOM_COURS" => $cours,
    "EDT_UID" => $uid_courante,
    "EDT_ENS_ID" => $enseignant_courant
));

generateCompleteXHTML($template, "signer");

