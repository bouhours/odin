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

$annee_courante = $_GET['bfmw_num_a']??Annees::getIdAnneeCourante();
$groupe_courant = $_GET['bfmw_num_g']??-1;
$semestre_courant = $_GET['bfmw_num_s']??-1;

setAttachment($template, "suivi", "suivi.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$les_groupes = Groupes::getGroupesDuResponsable($formations_autorisees,$annee_courante,CURRENT_ID);

$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes, new Comparateur("GROUPE_ID",$groupe_courant), array("une_formation"=>array(-1,"FORM_ID")));

$les_semestres = Formations::getSemestresPourUnGroupe($les_groupes[$groupe_courant]['GROUPE_CODE']);

$semestre_courant = affectToBlocAndRepeat($template,"un_semestre",$les_semestres, new Comparateur("SEM_ID",$semestre_courant));

$les_sans_notes = Etudiants::getEtudiantsSansNote($annee_courante,$semestre_courant, $groupe_courant);

affectToBlocAndRepeat($template,"une_ue.une_matiere.un_etudiant",$les_sans_notes, null, array(
    "une_ue" => array (-1,"UE_ID"),
    "une_ue.une_matiere" => array (-1,"MAT_ID")
));

affectToXHTML($template, array(
    "ANNEE_COURANTE" => $annee_courante,
    "GROUPE_COURANT" => $groupe_courant,
    "HAS_SANS_NOTE" => count($les_sans_notes) > 0
));

generateCompleteXHTML($template, "suivi");
