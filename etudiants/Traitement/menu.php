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

setAttachment($template,"menu", "menu.html");

$les_non_closes = Annees::getAnneeNonClose();

if (count($les_non_closes) > 1 && !isset($_GET["bfmw_num_nonclose"]) && $_GET["bfmw_orig_p"] != "choixAnnee") {
    $send = "p=choixAnnee";
    require "refresh.php";
    exit;
}

$force_annee_courante = Annees::getIdAnneeCourante();

if (count($les_non_closes) > 1 && isset($_GET["bfmw_num_nonclose"])) {
    foreach ($les_non_closes as $une_annee) {
        if ($une_annee["ANNEE_ID"] == $_GET["bfmw_num_nonclose"]) {
            $force_annee_courante = $_GET["bfmw_num_nonclose"];
            break;
        }
    }
}

$active = "ACTIVE_RENSEIGNEMENT";

$annee_courante = $force_annee_courante;

$les_formations = Formations::getFormationDeLEtudiant(CURRENT_ID,$annee_courante,"FORM_ABSENCES_AUTO=1 AND ");
unset($_SESSION['ACTIVE_ABSENCES_AUTO']);
foreach ($les_formations as $formation_avec_absences_auto) {
    if ($formation_avec_absences_auto != null) {
        $_SESSION['ACTIVE_ABSENCES_AUTO'] = 1;
        break;
    }
}

$les_formations = Formations::getFormationDeLEtudiant(CURRENT_ID,$annee_courante,"FORM_PRO=1 AND ");
unset($_SESSION['ACTIVE_ABSENCES_PRO']);
foreach ($les_formations as $formation_pro) {
    if ($formation_pro != null) {
        $_SESSION['ACTIVE_ABSENCES_PRO'] = 1;
        break;
    }
}

$les_formations = Formations::getFormationDeLEtudiant(CURRENT_ID,$annee_courante,"FORM_SIGNATURE_SUR_TABLETTES=1 AND ");
unset($_SESSION['ACTIVE_SIGNATURES_TABLETTES']);
foreach ($les_formations as $formation_pro) {
    if ($formation_pro != null) {
        $_SESSION['ACTIVE_SIGNATURES_TABLETTES'] = 1;
        break;
    }
}


if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "accueil" : $active = "ACTIVE_RENSEIGNEMENT";break;
        case "notes" : $active = "ACTIVE_NOTES";break;
        case "bilan" : $active = "ACTIVE_BILAN";break;
        case "absences" : $active = "ACTIVE_ABSENCES";break;
        case "emprunts" : $active = "ACTIVE_EMPRUNTS";break;
        case "edt" : $active = "ACTIVE_EDT";break;
        case "retour" : $active = "ACTIVE_RETOUR";break;
        case "stages" : $active = "ACTIVE_STAGES";break;
        case "choixAnnee" : $active = "";break;
        case "poursuites" : $active = "ACTIVE_POURSUITE";break;
        case "signature" :
        case "signer" :
            $active = "ACTIVE_ABSENCES_AUTO";break;
    }
}


$table = array(
      $active => "class=\"active\"",
    "CODE" => CURRENT_DEPT,
    "IS_POURSUITE" => Formations::isSelectionPoursuite(CURRENT_ID,CURRENT_DEPT_ID,time()),
    "IS_RETOUR" => Formations::isRetourActif(CURRENT_ID,time(),$annee_courante),
    "IS_INSCRIT_COURANT" => Etudiants::isInscrit(CURRENT_ID,$annee_courante),
    "IS_STAGES" => Stages::isStagesDisponibles(CURRENT_ID,$annee_courante),
    "RENSEIGNEMENTS_OK" => !Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,$annee_courante),
    "ABSENCES_AUTO" => isset($_SESSION['ACTIVE_ABSENCES_AUTO']),
    "ABSENCES_PRO" => isset($_SESSION['ACTIVE_ABSENCES_PRO']),
    "PARAM" => count($les_non_closes) > 1?"&amp;nonclose=$force_annee_courante":"",
    "FORCE_ANNEE" => $force_annee_courante != Annees::getIdAnneeCourante()
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");