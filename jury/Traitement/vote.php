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

if (!isset($_SESSION['session_vote_formation']) || $_SESSION['session_vote_formation']!=$formation_courante) {
    $send="?p=accueil";
    require "refresh.php";
    exit;
}

setAttachment($template, "vote", "vote.html");

$les_regroupements = Jury::getGroupeAvecEtudiants($jury_courant,CURRENT_DEPT);
$groupe_courant = -1;
$etudiant_courant = -1;
$total = 0;
$complet = 0;
$calcul = array();
foreach ($les_regroupements as &$un_groupement) {
    if ($groupe_courant != $un_groupement["GROUPE_ID"]) {
        $groupe_courant = $un_groupement["GROUPE_ID"];
        unset($total);
        $total = 0;
        $un_groupement["GROUPE_NOMBRE"] = &$total;
        $un_groupement["COMPLET"] = &$complet;
    }
    if ($etudiant_courant != $un_groupement["ET_ID"]) {
        $etudiant_courant = $un_groupement["ET_ID"];
        $total++;
        $complet++;
        $les_groupes = Groupes::getGroupeEtudiant($un_groupement["ET_ID"],$annee_courante);
        $noms_des_groupes = array();
        foreach ($les_groupes as $un_groupe) {
            $noms_des_groupes[] = $un_groupe["GROUPE_NOM"];
        }
        $un_groupement["ET_GROUPE_COURANT"] = implode(" - ",$noms_des_groupes);
    }
}

foreach ($les_regroupements as &$un_element) {
    if (isset($un_element["GROUPE_NOMBRE"])) {
        $un_element["POURCENTAGE"] = round($un_element["GROUPE_NOMBRE"] * 100 / $un_element["COMPLET"]);
    }
}

affectToBlocAndRepeat($template,"un_groupe.un_etudiant.une_annee.un_semestre.une_ue",$les_regroupements,null,
    array(
        "un_groupe" => array(-1,"GROUPE_ID"),
        "un_groupe.un_etudiant" => array(-1,"ET_ID"),
        "un_groupe.un_etudiant.une_annee" => array(-1,"ANNEE_ID"),
        "un_groupe.un_etudiant.une_annee.un_semestre" => array(-1,"SEM_ID")
    ));

affectToXHTML($template,array(
    "IS_RESPONSABLE" => Formations::isResponsableFormation($formation_courante),
    'ANNEE_COURANTE' => Jury::getAnneeDuJury($jury_courant),
    "FORMATION_COURANTE" => $formation_courante,
    "JURY_COURANT" => $jury_courant
));

generateCompleteXHTML($template, "vote");