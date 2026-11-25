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

$send_may_i = "signature";
require_once ('check_tablette.php');

verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$groupe_courant = -1;
if (isset($_GET['bfmw_num_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$le_groupe = Groupes::getGroupe($groupe_courant);

if ($le_groupe == null) {
    die;
}

$le_groupe = $le_groupe[0];

$annee_courante = Annees::getIdAnneeCourante();

setAttachment($template, "sgnature", "signature.html");

$masque = "0";
$condition = "";
if ($le_groupe['GROUPE_PRO'] == 1) {
    $masque = "EDT_MASQUE";
    $condition = "GROUPE_PRO = 1 AND";
}

$les_formations = Formations::getFormation($formation_courante);
$signature_anticipee = false;
$nombre_minutes_max = -1;
foreach ($les_formations as $formation_de_letudiant) {
    $signature_anticipee |= $formation_de_letudiant["FORM_AUTORISE_SIGNATURES_ANTICIPEES"];
    $nombre_minutes_max = $formation_de_letudiant["FORM_MINUTES_SIGNATURES"];
}
$les_cours = Absences::getCreneauxDeCoursPourUnGroupe($groupe_courant, $annee_courante, $masque, $signature_anticipee, $condition);
$uid_en_cours = -1;
$groupe = array();
$les_cours_a_afficher = array();
foreach ($les_cours as $un_cours) {
    if ($nombre_minutes_max != -1) {
        $maintenant = new DateTime();
        $maintenantplusuneheure = $maintenant->sub(new DateInterval("PT".$nombre_minutes_max."M"));
        if ($un_cours['EDT_DATE_FIN'] < $maintenantplusuneheure->getTimestamp()) {
            continue;
        }
    }
    if ($uid_en_cours != $un_cours['EDT_UID']) {
        $uid_en_cours = $un_cours['EDT_UID'];
        $les_cours_a_afficher[$uid_en_cours] = $un_cours;
    } else {
        $les_cours_a_afficher[$uid_en_cours]["GROUPE_ID"] = $groupe_courant;
        $les_cours_a_afficher[$uid_en_cours]["GROUPE_NOM"] = $le_groupe["GROUPE_NOM"];
    }
}

$vide=false;
if (count($les_cours_a_afficher) == 0) {
   $vide = true;
}

foreach ($les_cours_a_afficher as $un_cours) {
    $un_cours['DATE_DEBUT'] = date("j/m/Y", $un_cours['EDT_DATE_DEBUT']);
    $un_cours['HEURE_DEBUT'] = date("H:i", $un_cours['EDT_HEURE_DEBUT']);
    $un_cours['HEURE_DEBUT'] = date("H:i", $un_cours['EDT_HEURE_DEBUT']);
    $un_cours['HEURE_FIN'] = date("H:i", $un_cours['EDT_HEURE_FIN']);
    affectToBloc($template, "un_cours", $un_cours);
}

affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante,
    "VIDE" => $vide
));

generateCompleteXHTML($template, "sgnature");
