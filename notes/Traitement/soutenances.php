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

setAttachment($template, "soutenances", "soutenances.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

if (! Notation_Soutenances::isEnseignantAMisUneNote(CURRENT_ID,CURRENT_DEPT_ID)) {
    $send="p=accueil";
    require 'refresh.php';
    exit;
}


$formation_valide = -1;
if (isset($_GET['bfmw_orig_f'])) {
    $formation_valide = $_GET['bfmw_num_f'];
}
$session_valide = -1;
if (isset($_GET['bfmw_orig_s'])) {
    $session_valide = $_GET['bfmw_num_s'];
}
$etudiant_valide = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
$out = false;
$les_etudiants = array();

if (! Notation_Soutenances::isEnseignantAMisUneNote(CURRENT_ID,CURRENT_DEPT_ID,$annee_courante)) {
    $out = true;
} else {

    $les_formations = Formations::getFormationsAyantDesExplications(CURRENT_DEPT_ID,$annee_courante);
    if (count($les_formations) === 0) {
        exit;
    }
    $formation_valide = affectToBlocAndRepeat($template, "une_formation", $les_formations, new Comparateur("FORM_ID", $formation_valide));

    $les_sessions = Notation_Soutenances::getSession($annee_courante, $formation_valide);

    $session_valide = affectToBlocAndRepeat($template, "une_session", $les_sessions, new Comparateur("SESSION_ID", $session_valide));

    $les_etudiants = Notation_Soutenances::getEtudiantsAyantEuUneNote($annee_courante, $session_valide, $formation_valide, CURRENT_ID);
    affectToBlocAndRepeat($template, "un_etudiant", $les_etudiants, new Comparateur("ET_ID", $etudiant_valide, "SELECTED", "jaune_force"));
}

affectToXHTML($template, array(
    "FORMATION_COURANTE" => $formation_valide,
    "ANNEE_COURANTE" => $annee_courante,
    "SESSION_COURANTE" => $session_valide,
    "ETUDIANT_ID" => $etudiant_valide,
    "HAS_ETUDIANT" => count($les_etudiants) > 0,
    "OUT" => $out,
    "ET_NUMERO" => $etudiant_valide == -1 ? "" : ($les_etudiants[$etudiant_valide]['ET_NUMERO']??"")
));

/**
 * Detail
 */
if ($etudiant_valide != -1) {

    $template2 = new Template(BFWM_TEMPLATE_ROOT);
    setAttachment($template2, "template_grille", "template_grille.html");
    $formation_courante = Formations::getFormation($formation_valide)[$formation_valide];


    $mat_id = Notation_Soutenances::getMatierePourUnEtudiantEtUneSession($etudiant_valide,$session_valide,$annee_courante);
    if ($mat_id != null) {
        affectToBlocAndRepeat($template2,"un_controle",Controles::getControlesDansMatierePourUnEtudiant($etudiant_valide,$mat_id,$annee_courante));
    }

    $les_grilles = Notation_Soutenances::getGrilles($formation_courante['FORM_ID'],CURRENT_ID,$annee_courante,$session_valide,$etudiant_valide,1);
    affectToBlocAndRepeat($template2,"une_destination.une_section.un_critere.un_niveau.une_explication",$les_grilles,null,
        array(
            "une_destination" => array(-1,"DEST_ID"),
            "une_destination.une_section" => array(-1,"SECTION_ID"),
            "une_destination.une_section.un_critere" => array(-1,"CRITERE_ID"),
            "une_destination.une_section.un_critere.un_niveau" => array(-1,"NIVEAU_ID"),
        ));

    $moyenne = array();
    if ($mat_id != null) {
        $moyenne = Moyennes::getMoyenneUnEtudiantUneMatiere(CURRENT_DEPT, $etudiant_valide, $mat_id, $annee_courante);
    }
    if (count($moyenne) > 0) {
        $moyenne = round($moyenne[0]['MOYMAT_VALEUR'],2);
    } else {
        $moyenne = "?";
    }

    affectToXHTML($template2,array(
        "MOYENNE" => $moyenne,
        "TEXTE" => Etudiants::getEtudiant($etudiant_valide,$annee_courante)[0]["ET_NOM"],
        "IDENTIFIANT" => $etudiant_valide,
        "PAGE" => "individuel",
        "IDDEL" => "deleens",
        "VALDEL" => $etudiant_valide,
        "FORMATION_COURANTE" => -1,
        "SESSION_COURANTE" => $session_valide
    ));

    affectToXHTML($template,array(
        "GRILLE" => generateCompleteXHTML($template2,"template_grille",true)
    ));
}


generateCompleteXHTML($template, "soutenances");