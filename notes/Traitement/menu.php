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

setAttachment($template,"menu", "menu.html");

$active = "ACTIVE_SAISIR";

$annee_courante = Annees::getIdAnneeCourante();

$req = "SELECT * FROM affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ENS_MAT_NOTEUR = 1 AND MAT_ENS_ID=".CURRENT_ID." AND ENS_MAT_ANNEE_ID=".Annees::getIdAnneeCourante();
if ($conn->query($req)->num_rows > 0) {
    openBloc($template, "isNoteur");
}

if (isset($_GET['bfmw_orig_p'])) {
    if ($_GET['bfmw_orig_p'] == "valider" || $_GET['bfmw_orig_p'] == "validerControle") {
        $active = "ACTIVE_VALIDER";
    }
    if ($_GET['bfmw_orig_p'] == "consulter") {
        $active = "ACTIVE_CONSULTER";
    }
    if ($_GET['bfmw_orig_p'] == "mediateur") {
        $active = "ACTIVE_MEDIATEUR";
    }
    if ($_GET['bfmw_orig_p'] == "soutenances") {
        $active = "ACTIVE_SOUTENANCES";
    }
    if ($_GET['bfmw_orig_p'] == "aide") {
        $active = "ACTIVE_AIDE";
    }
    if ($_GET['bfmw_orig_p'] == "bilan") {
        $active = "ACTIVE_BILAN";
    }
    if ($_GET['bfmw_orig_p'] == "competences") {
        $active = "ACTIVE_COMPETENCE";
    }
    if ($_GET['bfmw_orig_p'] == "suivi") {
        $active = "ACTIVE_SUIVI";
    }
    if ($_GET['bfmw_orig_p'] == "export") {
        $active = "ACTIVE_EXPORT";
    }
    if ($_GET['bfmw_orig_p'] == "export" && isset($_GET['bfmw_orig_f'])) {
        $active = "ACTIVE_EXPORT_FORMATION";
    }
    if ($_GET['bfmw_orig_p'] == "accueil" && ((isset($_GET['bfmw_orig_chef']) || isset($_SESSION['notes_chef'])) && !isset($_GET['bfmw_orig_itt']))) {
        $active = "ACTIVE_APOGEE";
    }
}

$table = array(
    "PARAM" => (isset($_GET['bfmw_orig_m'])?"&amp;m=".$_GET['bfmw_orig_m']:""),
    "HAS_SOUTENANCES" => Notation_Soutenances::isEnseignantAMisUneNote(CURRENT_ID,CURRENT_DEPT_ID),
    "IS_MEDIATEUR" => Formations::isMediateur(),
    "IS_SECRETAIRE" => Formations::isSecretaire() || isAdmin(),
    "IS_CHEF" => Formations::isChef() || Formations::isResponsable() || isAdmin(),
    $active => "class=\"active\""
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");