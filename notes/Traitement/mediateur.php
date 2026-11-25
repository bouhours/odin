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
setAttachment($template, "mediateur", "mediateur.html");

$annee_courante = Annees::getIdAnneeCourante();

if (isset($_GET['bfmw_orig_selon'])) {
    $selon = $_GET['bfmw_orig_selon'];
} else {
    $selon = "AN" . $annee_courante;
}

$semestre_courant = -1;
if (isset($_GET['bfmw_num_s'])) {
    $semestre_courant = $_GET['bfmw_num_s'];
}
$groupe_courant = -1;
if (isset($_GET['bfmw_num_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

/**
 * Affichage des semestres
 */
$les_formations_autorisees = implode(",",array_keys(Formations::getFormationDuDepartement(CURRENT_DEPT_ID,$annee_courante)));
//$les_formations_autorisees = Formations::getFormationsDeLEnseignantConnecteString(CURRENT_ID,$annee_courante,CURRENT_DEPT_ID);
$semestre_courant = affectToBlocAndRepeat($template,"une_formation.un_semestre",Formations::getSemestres($les_formations_autorisees,$annee_courante),
    new Comparateur("SEM_ID",$semestre_courant),
    array(
        "une_formation" => array(-1,"FORM_ID")
    ));
$formation_du_semestre = Formations::getFormationDuSemestre($semestre_courant);
$formation_valide = -1;
if ($formation_du_semestre != null) {
    $formation_valide = $formation_du_semestre["FORM_ID"];
}


affectToXHTML($template, array(
    "SEM_ID" => $semestre_courant,
    "SELON" => $selon
));

/**
 * Affichage des groupes
 */
$groupe_courant = affectToBlocAndRepeat($template,"un_groupe",Groupes::getGroupesPourUnSemestre($semestre_courant,$annee_courante,"GROUPE_FEUILLE=1 AND"),new Comparateur("GROUPE_ID",$groupe_courant));

affectToXHTML($template, array(
    "GROUPE_ID" => $groupe_courant,
    "ANNEE_ID" => $annee_courante
));

/**
 * Detail
 */
PV::generatePV($annee_courante,"",$template,$groupe_courant,$selon,$formation_valide,$semestre_courant);

generateCompleteXHTML($template, "mediateur");

