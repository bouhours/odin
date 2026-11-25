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
setAttachment($template, "soutenances", "soutenances.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$planning_courant = -1;
if (isset($_GET['bfmw_num_s'])) {
    $planning_courant = $_GET['bfmw_num_s'];
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$les_planning = Soutenances::getPlanning(CURRENT_DEPT_ID,$annee_courante);
$planning_courant = affectToBlocAndRepeat($template,"un_planning",$les_planning, new Comparateur("PLANNING_ID",$planning_courant));

if ($planning_courant != -1) {
        $soutenances = Soutenances::getSoutenances($planning_courant,$annee_courante);
        affectToBlocAndRepeat($template,"un_stage.un_creneau.un_etudiant",$soutenances,null,
        array(
            "un_stage" => array(-1,"STAGE_DATE_SOUTENANCE"),
            "un_stage.un_creneau" => array(-1,"CRENEAU_ID")
        ));
}
affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante
));

generateCompleteXHTML($template, "soutenances");

