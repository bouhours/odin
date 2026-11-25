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
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$jury_courant = -1;
if (isset($_GET['bfmw_num_j'])) {
    $jury_courant = $_GET['bfmw_num_j'];
}

setAttachment($template, "preparation", "preparation.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$formation_courante = affectToBlocAndRepeat($template,"une_formation",Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante),new Comparateur("FORM_ID",$formation_courante));

$les_jurys = Jury::getJury($formation_courante,$annee_courante);
$jury_courant = affectToBlocAndRepeat($template,"un_jury",$les_jurys,new Comparateur("JURY_ID",$jury_courant));

$les_groupes = Jury::getGroupe($jury_courant,$formation_courante);

foreach ($les_groupes as $un_groupe) {
    affectToBloc($template,"un_groupe",$un_groupe);
    affectToBlocAndRepeat($template,"un_groupe.un_etudiant",Jury::getEtudiantsGroupe($jury_courant,$un_groupe['GROUPE_ID'],$formation_courante,$annee_courante));
}



affectToXHTML($template,array(
    "FORMATION_COURANTE" => $formation_courante,
    "ANNEE_COURANTE" => $annee_courante,
    "JURY_COURANT" => $jury_courant,
    "HAS_JURY" => count($les_jurys)>0,
    "HAS_GROUPE" => count($les_groupes)>0
));

generateCompleteXHTML($template, "preparation");