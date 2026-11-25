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

if (!isRegistered() && !isAdmin()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "renseignement", "renseignement.html");

$annee_courante = Annees::getIdAnneeCourante();

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$les_formations = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);
$formation_courante = affectToBlocAndRepeat($template,"une_formation",$les_formations,new Comparateur("FORM_ID",$formation_courante));
$les_champs = Fiches_Renseignements::getChampsDeLaFormation($formation_courante);
affectToBlocAndRepeat($template,"un_champ",$les_champs);

affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante,
    "FORMATION_COURANTE" => $formation_courante,
    "HAS_CHAMPS" => count($les_champs)
));

generateCompleteXHTML($template, "renseignement");


