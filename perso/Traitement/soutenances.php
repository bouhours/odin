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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

setAttachment($template, "soutenances", "soutenances.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$les_soutenances = Enseignants::getSoutenances(CURRENT_ID,$annee_courante,CURRENT_DEPT_ID);
affectToBlocAndRepeat($template,"un_planning.une_formation.une_soutenance.un_creneau.un_etudiant",$les_soutenances,null,
    array(
        "un_planning" => array(-1,"PLANNING_ID"),
        "un_planning.une_formation" => array(-1,"FORM_ID"),
        "un_planning.une_formation.une_soutenance" => array(-1,"STAGE_DATE_SOUTENANCE"),
        "un_planning.une_formation.une_soutenance.un_creneau" => array(-1,"CRENEAU_ID")
    )
);

affectToXHTML($template,array(
    "HAS_SOUTENANCES" => count($les_soutenances) > 0
));

generateCompleteXHTML($template, "soutenances");