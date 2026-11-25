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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante=$_GET['bfmw_orig_a'];
}

$comparateur = new Comparateur("PLANNING_ID",-1,"ACTIVE_PLANNING","class=\"active\"");

if (isset($_GET['bfmw_orig_planning'])) {
    $comparateur = new Comparateur("PLANNING_ID",$_GET['bfmw_orig_planning'],"ACTIVE_PLANNING","class=\"active\"");
}

$les_plannings = Plannings::getPlanning(CURRENT_DEPT_ID);
affectToBlocAndRepeat($template,"un_planning",$les_plannings,$comparateur);


$_SESSION["ANNEE_COURANTE"] = $annee_courante;


generateCompleteXHTML($template, "menu");
