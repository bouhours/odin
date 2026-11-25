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

if (!isRegistered()) {
    echo "Non autorisé";
    exit;
}

if (!Formations::isSecretaire() && !Formations::isMediateur() && !Formations::isResponsable()) {
    echo "Non autorisé.";
    exit;
}

$formations_autorisees = Formations::getFormationsDuConnecteString();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = -1;
if (!isset($_GET['bfmw_num_a'])) {
    $annee_courante = Annees::getIdAnneeCourante();
} else {
    $annee_courante = $_GET['bfmw_num_a'];
}

$groupe_courant = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

setAttachment($template, "competences", "competences.html");

if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isChef()) {
    $annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));
} else {
    $annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
}

$les_groupes = Groupes::getGroupesDuResponsable($formations_autorisees,$annee_courante,CURRENT_ID);

$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes, new Comparateur("GROUPE_ID",$groupe_courant), array("une_formation"=>array(-1,"FORM_ID")));

affectToXHTML($template, array(
    "ANNEE_COURANTE" => $annee_courante,
    "GROUPE_COURANT" => $groupe_courant,
    "HAS_COMPETENCES" => Resultats::hasResultats($groupe_courant,CURRENT_DEPT_ID)
));

generateCompleteXHTML($template, "competences");
