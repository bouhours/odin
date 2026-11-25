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

setAttachment($template, "equipe", "equipe.html");

$annee_courante = $_GET['bfmw_orig_a'] ?? Annees::getLastIdAnneeCourante();
$formation_courante = $_GET['bfmw_orig_f'] ?? -1;


$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee("DESC"),new Comparateur("ANNEE_ID",$annee_courante));
$formation_courante = affectToBlocAndRepeat($template,"une_formation",Formations::getFormationDuDepartement(CURRENT_DEPT_ID,$annee_courante),new Comparateur("FORM_ID",$formation_courante));


affectToBlocAndRepeat($template,"un_semestre.une_ue.une_matiere",ChargeEnseignements::getMatieresAffectees($annee_courante,CURRENT_ID,$formation_courante),null,
    array(
        "un_semestre" => array(-1,"SEM_ID"),
        "un_semestre.une_ue" => array(-1,"UE_ID")
    ))
;

affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante,
    "FORM_COURANTE" => $formation_courante,
    "ANNEE_CLOSE" => Annees::getAnneeWithId($annee_courante)[0]["ANNEE_CLOSE"]
));

generateCompleteXHTML($template, "equipe");