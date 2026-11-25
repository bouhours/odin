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

setAttachment($template, "menu", "menu.html");

$active = "ACTIVE_ACCUEIL";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "reel" : $active = "ACTIVE_REEL";break;
        case "equipe" : $active = "ACTIVE_EQUIPE";break;
        case "disponibilites" : $active = "ACTIVE_DISPO";break;
        case "stagiaires" : $active = "ACTIVE_STAGIAIRES";break;
        case "soutenances" : $active = "ACTIVE_SOUTENANCES";break;
    }
}

$annee_courante = $_GET['bfmw_orig_a'] ?? Annees::getLastIdAnneeCourante();

$_SESSION['ANNEE_COURANTE'] = $annee_courante;

$les_planning = Soutenances::getPlanning(CURRENT_DEPT_ID, $annee_courante,"PLANNING_START_ENS<=".time()." AND PLANNING_END_ENS>=".time()." AND ");

if (count($les_planning)>0) {
    $_SESSION['perso_session_ouverte'] = "OK";
} else {
    unset($_SESSION['perso_session_ouverte']);
}

$table = array(
    $active => "class=\"active\"",
    "ANNEE" => $annee_courante,
    "HAS_SESSION" => isset($_SESSION['perso_session_ouverte'])
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");
