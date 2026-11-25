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

setAttachment($template, "lire", "lire.html");

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Affichage des absences
 */
$les_absences = array();
$filter_active = false;
$les_etudiants_concernes = "=ET_ID";
$enseignant_a_afficher = CURRENT_ID;
if (isset($_GET['bfmw_orig_all'])) {
    $les_absences = Absences::getAbsencesNewGen($annee_courante,0,"=ET_ID",CURRENT_ID,"","GROUP BY ET_ID","");
    $les_etudiants = array();
    foreach($les_absences as $etudiant) {
        $les_etudiants[] = $etudiant['ET_ID'];
    }
    if (count($les_etudiants) > 0) {
        $les_etudiants_concernes = "IN (".implode(",",$les_etudiants).")";
        $enseignant_a_afficher = "ENS_ID";
        //$les_absences = Absences::getAbsencesNewGen($annee_courante,0,"IN (".implode(",",$les_etudiants).")");
    }
}
if (isset($_GET['bfmw_orig_show'])) {
    $filter_active = true;
    if ($_GET['bfmw_orig_show'] != "") {
        $les_absences = Absences::getAbsencesNewGen($annee_courante,0,$les_etudiants_concernes,$enseignant_a_afficher,"MAT_ID=".$_GET['bfmw_num_show']." AND ","GROUP BY ABS_ID","ORDER BY ET_NOM, ET_ID, ABS_REAL_DATE, CRENEAU_REAL_START, CRENEAU_REAL_END, EDT_DATE_DEBUT, EDT_DATE_FIN, MAT_NOM");
    } else {
        $req = "SELECT * FROM common_backup_ade_enseignant WHERE EDT_UID='".$_GET['bfmw_orig_showp']."' AND EDT_ENS_ID=".CURRENT_ID;
        $res = $conn->query($req);
        if ($un_cours = $res->fetch_assoc()) {
            $les_absences = Absences::getAbsencesNewGen($annee_courante,0,$les_etudiants_concernes,$enseignant_a_afficher,"EDT_NOM='".$un_cours['EDT_NOM']."' AND ","GROUP BY ABS_ID","ORDER BY ET_NOM, ET_ID, ABS_REAL_DATE, CRENEAU_REAL_START, CRENEAU_REAL_END, EDT_DATE_DEBUT, EDT_DATE_FIN, MAT_NOM");
        } else {
            $les_absences = null;
        }
    }
} else {
    $les_absences = Absences::getAbsencesNewGen($annee_courante,0,$les_etudiants_concernes,$enseignant_a_afficher,"","GROUP BY ABS_ID","ORDER BY ET_NOM, ET_ID, ABS_REAL_DATE, CRENEAU_REAL_START, CRENEAU_REAL_END, EDT_DATE_DEBUT, EDT_DATE_FIN, MAT_NOM");
}


foreach($les_absences as &$un_groupe_etudiant) {
    $formation = Groupes::getFormation($un_groupe_etudiant['GROUPE_ID']);
    $un_groupe_etudiant['FORM_ID'] = $formation[0]["FORM_ID"];
    $un_groupe_etudiant['FORM_NOM'] = $formation[0]["FORM_NOM"];
}

$etudiant_precedent = -1;
$matiere_en_cours = array();
$les_matieres = array();
$nom_groupe = "";
foreach($les_absences as $etudiant) {
    if (isset($_GET["bfmw_num_showG"]) && $etudiant['GROUPE_ID'] != $_GET["bfmw_num_showG"]) {
        continue;
    }

    $etudiant["OK_DEL"] = ($etudiant["ET_PROFESSIONNALISATION"]!=1);

    if ($etudiant["ABS_ENS_ID"] != CURRENT_ID) {
        $etudiant["OK_DEL"] = false;
    }

    if (isset($_GET["bfmw_num_showG"])) {
        $nom_groupe = $etudiant['GROUPE_NOM'];
    }

    if (!isset($matiere_en_cours[$etudiant['MAT_NOM']])) {
       $matiere_en_cours[$etudiant['MAT_NOM']] = "1";
       $les_matieres[] = $etudiant;
    }

    if ($etudiant_precedent != $etudiant['ET_ID']) {
        $etudiant_precedent = $etudiant['ET_ID'];
        $phrase = array();
        if (isset($_GET['bfmw_orig_all'])) {
            $phrase = Absences::constructeurNombreAbsences("0", "NOMBRE_ABSENCES", Absences::getNombreAbsencesNewGen($etudiant['ET_ID'], $annee_courante, 0), $etudiant['ET_ID'],$annee_courante);
        } else {
            $phrase = Absences::constructeurNombreAbsences("0", "NOMBRE_ABSENCES", Absences::getNombreAbsencesNewGen($etudiant['ET_ID'], $annee_courante, 0, CURRENT_ID), $etudiant['ET_ID'], $annee_courante, CURRENT_ID);
        }
        $etudiant["NOMBRE_ABSENCES"] = $phrase['NOMBRE_ABSENCES'];
        affectToBloc($template, "un_etudiant", $etudiant);
    }

    affectToBloc($template, "un_etudiant.une_absence",$etudiant);

}

foreach ($les_matieres as $un_cours) {
    if ($un_cours['ABS_ENS_ID'] == CURRENT_ID) {
        affectToBloc($template, "un_cours", $un_cours);
    }
}

usort($les_absences,'trierAbsences');

affectToBlocAndRepeat($template,"une_formation_filtre.un_groupe",$les_absences,null,
    array(
        "une_formation_filtre" => array(-1,"FORM_ID")
    ),null,"GROUPE_ID");

affectToXHTML($template, array(
    "CURRENT_ID" => CURRENT_ID,
    "FILTER_ACTIVE" => $filter_active,
    "FILTER" => (! isset($_GET["bfmw_num_showG"]))?"":("&amp;showG=".$_GET['bfmw_num_showG']),
    "ALL_ACTIVE" => isset($_GET["bfmw_orig_all"]),
    "GROUPE_NOM" => $nom_groupe
));

generateCompleteXHTML($template, "lire");

function trierAbsences($elem1,$elem2) : int {
    if ($elem1["FORM_ID"] == $elem2["FORM_ID"] && $elem1["GROUPE_CODE"] == $elem2["GROUPE_CODE"]) {
        return 0;
    }

    if ($elem1["FORM_ID"] == $elem2["FORM_ID"] && $elem1["GROUPE_CODE"] < $elem2["GROUPE_CODE"]) {
        return -1;
    }

    if ($elem1["FORM_ID"] == $elem2["FORM_ID"] && $elem1["GROUPE_CODE"] >= $elem2["GROUPE_CODE"]) {
        return 1;
    }

    return ($elem1["FORM_ID"] < $elem2["FORM_ID"]) ? -1 : 1;
}