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

if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = $_GET["bfmw_num_a"] ?? Annees::getIdAnneeCourante();

setAttachment($template, "factures", "factures.html");

$annee_courante = affectToBlocAndRepeat($template, "une_annee", Annees::getAnneeNonClose(), new Comparateur("ANNEE_ID", $annee_courante));
$les_formations = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante,"AND (FORM_END_ANNEE_ID<$annee_courante OR FORM_END_ANNEE_ID IS NULL) AND FORM_PRO=1");

affectToBlocAndRepeat($template,"une_formation",$les_formations);

generateCompleteXHTML($template, "factures");
