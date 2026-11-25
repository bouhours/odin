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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$groupe_valide = -1;
if (isset($_GET['bfmw_num_g'])) {
    $groupe_valide = $_GET['bfmw_num_g'];
}

$etudiant_valide = -1;
if (isset($_GET['bfmw_num_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}

$les_annees_non_closes = Annees::getAnneeNonClose();
$annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annees_non_closes,new Comparateur("ANNEE_ID",$annee_courante));


affectToXHTML($template, array(
    "ANNEE_ID" => $annee_courante,
    "OPEN_ANNEE" => count($les_annees_non_closes) > 1
));

/**
 * Affichage des groupes
 */
$les_groupes = Groupes::getGroupeDeJury(CURRENT_DEPT_ID,$annee_courante,CURRENT_ID);
$groupe_valide = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes,new Comparateur("GROUPE_ID",$groupe_valide),
    array(
        "une_formation" => array(-1,"FORM_ID")
    ));

if ($groupe_valide != -1) {
    BilanEtudiant::generateMaster($template,$annee_courante,$groupe_valide,CURRENT_ID,$etudiant_valide);
    BilanEtudiant::generateBilan($template,$annee_courante,$etudiant_valide);

}

generateCompleteXHTML($template, "accueil");