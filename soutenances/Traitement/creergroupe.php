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

$annee_courante = $_GET['bfmw_num_a']??Annees::getIdAnneeCourante();
$formation_courante = $_GET['bfmw_num_f']??-1;
$session_courante = $_GET['bfmw_num_s']??-1;
$groupe_courant = $_GET['bfmw_num_g']??-1;

setAttachment($template, "creergroupe", "creergroupe.html");

$formationsAyantDesExplications = Formations::getFormationsAyantDesExplications(CURRENT_DEPT_ID, $annee_courante, null, Formations::getFormationsDuConnecteString());
$formation_courante = affectToBlocAndRepeat($template,"une_formation", $formationsAyantDesExplications,new Comparateur("FORM_ID",$formation_courante));
$session_courante = affectToBlocAndRepeat($template,"une_session",Notation_Soutenances::getSession($annee_courante,$formation_courante),new Comparateur("SESSION_ID",$session_courante));

$les_groupes = Notation_Soutenances::getGroupes($annee_courante,$session_courante);
$groupe_courant = affectToBlocAndRepeat($template,"un_groupe.un_etudiant",$les_groupes,new Comparateur("GROUPE_ID",$groupe_courant),
    array(
        "un_groupe" => array(-1,"GROUPE_ID")
    ));

affectToBlocAndRepeat($template,"un_etudiant_formation",Notation_Soutenances::getEtudiantsDeLaFormationAvecInformationGroupeSoutenance($annee_courante,$groupe_courant,$formation_courante,$session_courante));

affectToXHTML($template,array(
    "HAS_GROUPES" => count($les_groupes) > 0,
    "FORMATION_COURANTE" => $formation_courante,
    "ANNEE_COURANTE" => $annee_courante,
    "SESSION_COURANTE" => $session_courante,
    "GROUPE_COURANT" => $groupe_courant,
    "HAS_FORMATIONS" => count($formationsAyantDesExplications)>0
));

generateCompleteXHTML($template, "creergroupe");