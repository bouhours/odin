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

setAttachment($template, "accueil", "accueil.html");

$annee_courante = $_GET['bfmw_orig_a'] ?? Annees::getLastIdAnneeCourante();

$annees = Annees::getAnnee();
$annee_courante = affectToBlocAndRepeat($template,"une_annee",$annees,new Comparateur("ANNEE_ID",$annee_courante));

$charge = ChargeEnseignements::computeChargeEqTDEnseignantDetailV2($annee_courante,CURRENT_ID);

affectToBlocAndRepeat($template,"une_formation.un_semestre.une_ue.une_matiere.une_charge",$charge,null,array(
    "une_formation" => array(-1,"FORM_ID"),
    "une_formation.un_semestre" => array(-1,"SEM_ID"),
    "une_formation.un_semestre.une_ue" => array(-1,"UE_ID"),
    "une_formation.un_semestre.une_ue.une_matiere" => array(-1,"MAT_ID")
));

affectToXHTML($template,array(
    "TOTAL_ANNEE" => $charge[array_key_last($charge)]["TOTAL_ANNEE"]??0
));

generateCompleteXHTML($template, "accueil");