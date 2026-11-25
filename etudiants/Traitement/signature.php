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
    $send="p=accueil";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,$annee_courante)) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}


setAttachment($template, "sgnature", "signature.html");

$tablette_only=true;
if (!isset($_SESSION['ACTIVE_SIGNATURES_TABLETTES'])) {
    $tablette_only=false;
    $masque = "0";
    $condition = "";
    if (isset($_SESSION['ACTIVE_ABSENCES_PRO'])) {
        $masque = "EDT_MASQUE";
        $condition = "GROUPE_PRO = 1 AND";
    }

    $les_formations = Formations::getFormationDeLEtudiant(CURRENT_ID, $annee_courante);
    $signature_anticipee = false;
    $nombre_minutes_max = -1;
    foreach ($les_formations as $formation_de_letudiant) {
        $signature_anticipee |= $formation_de_letudiant["FORM_AUTORISE_SIGNATURES_ANTICIPEES"];
        $nombre_minutes_max = $formation_de_letudiant["FORM_MINUTES_SIGNATURES"];
    }
    $les_cours = Absences::getCreneauxDeCoursPourUnEtudiant(CURRENT_ID, $annee_courante, $masque, $signature_anticipee, $condition);
    $uid_en_cours = -1;
    $groupe = array();
    $les_cours_a_afficher = array();
    foreach ($les_cours as $un_cours) {
        if (Absences_Automatiques::isCreneauDejaSigne(CURRENT_ID, $un_cours['GROUPE_ID'], $un_cours['EDT_UID'])) {
            continue;
        }
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
            $les_cours_a_afficher[$uid_en_cours]["GROUPE_ID"] .= "$" . $un_cours["GROUPE_ID"];
            $les_cours_a_afficher[$uid_en_cours]["GROUPE_NOM"] .= " - " . $un_cours["GROUPE_NOM"];
        }
    }
    foreach ($les_cours_a_afficher as $un_cours) {
        $un_cours['DATE_DEBUT'] = date("j/m/Y", $un_cours['EDT_DATE_DEBUT']);
        $un_cours['HEURE_DEBUT'] = date("H:i", $un_cours['EDT_HEURE_DEBUT']);
        $un_cours['HEURE_DEBUT'] = date("H:i", $un_cours['EDT_HEURE_DEBUT']);
        $un_cours['HEURE_FIN'] = date("H:i", $un_cours['EDT_HEURE_FIN']);
        affectToBloc($template, "un_cours", $un_cours);
    }
}
affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante,
    "TALETTE_UNIQUEMENT" => $tablette_only
));

generateCompleteXHTML($template, "sgnature");
