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

setAttachment($template, "recapitulatif", "recapitulatif.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$formation_courante = -1;
if (isset($_GET['bfmw_orig_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}
$groupe_courant = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

$les_formations = array();
if (Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    $les_formations = Formations::getFormationsDuGestionnaireDeStage(CURRENT_ID, CURRENT_DEPT_ID, $annee_courante);
} else {
    $les_formations = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);
}
$les_formations_autorisees = array_keys($les_formations);
$les_formations_avec_stages[] = 0;
foreach ($les_formations_autorisees as $une_formation) {
    if (count(Stages::getStages($une_formation,$annee_courante)) > 0) {
        $les_formations_avec_stages[] = $une_formation;
    }
}

if (count($les_formations) == 0) {
    echo "Accès refusé";
    exit;
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
$les_groupes = Groupes::getGroupesOLD(implode(",",$les_formations_avec_stages),$annee_courante);
$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes,new Comparateur("GROUPE_ID",$groupe_courant),array("une_formation" => array(-1,"FORM_ID")));

if ($groupe_courant > 0) {
    affectToBlocAndRepeat($template, "un_etudiant.un_planning", Etudiants::getEtudiantsGroupesAvecStagesEtPlanning($annee_courante, $groupe_courant),null,
        array(
            "un_etudiant" => array(-1, "ET_ID")
        )
    );
}

affectToXHTML($template,array(
    "ANNEE_ID" => $annee_courante,
    "GROUPE_ID" => $groupe_courant
));

generateCompleteXHTML($template, "recapitulatif");