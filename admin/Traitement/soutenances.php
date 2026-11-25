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

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}
$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

setAttachment($template, "soutenances", "soutenances.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$formation_courante = affectToBlocAndRepeat($template,"une_formation",Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante),new Comparateur("FORM_ID",$formation_courante));

/**
 * Planning
 */
$les_plannings = Soutenances::getPlanningAvecCreneaux(CURRENT_DEPT_ID,$annee_courante);
affectToBlocAndRepeat($template,"un_planning.un_creneau", $les_plannings, null,
array(
   "un_planning" => array(-1,"PLANNING_ID")
));

/**
 * Sessions
 */
$les_sessions = Notation_Soutenances::getSession($annee_courante,$formation_courante);
$session_courante = -1;
foreach ($les_sessions as &$une_session) {
    if ($session_courante != $une_session['SESSION_ID']) {
        $session_courante = $une_session['SESSION_ID'];
        $une_session['NB_NOTES'] = count(Notation_Soutenances::getEtudiantsAyantUneNote($annee_courante, $une_session['SESSION_ID'], $formation_courante));
        $une_session['HAS_NOTES'] = $une_session['NB_NOTES'] > 0;
        affectToBloc($template, "une_session", $une_session);
        if ($une_session['HAS_NOTES'] > 0) {
            $maquette = Formations::getMaquetteSansMatiere(CURRENT_DEPT_ID, $annee_courante, "FORM_ID = $formation_courante AND (SELECT COUNT(*) FROM common_matiere WHERE MAT_HAS_NOTE AND MAT_UE_ID=UE_ID AND MAT_LOCK_ANNEE_ID<$annee_courante AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)) > 0 AND ");
            MatieresListView::generateListView($maquette, $template, $annee_courante, "listview_template_module_open.html", "listview_template_module_close.html",
                function (array $uneMatiere) {
                    $template1 = attachXHTML();
                    setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
                    affectToXHTML($template1, $uneMatiere);
                    return generateCompleteXHTML($template1, "listview_template_matiere", true);
                }, function (array $un_element, int $annee_courante) {
                    return Formations::getMatieresAvecRacine($un_element['UE_ID'], $annee_courante, "MAT_LOCK_ANNEE_ID < $annee_courante AND MAT_COPIE_MAT_ID IS NULL AND ");
                }, -1, "une_session.", "&nbsp;&nbsp;",true);
        }
    }
}

/**
 * Recopie
 */
$les_sessions_pas_vide = Notation_Soutenances::getSessionPasVideDuDepartement(CURRENT_DEPT_ID,$annee_courante);
affectToBlocAndRepeat($template,"une_formation_session.une_session_source",$les_sessions_pas_vide,null,
    array(
        "une_formation_session" => array(-1,"FORM_ID")
    ));

$les_sessions_vide = Notation_Soutenances::getSessionVide($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"une_session_vide",$les_sessions_vide);

/**
 * Destinations
 */
$les_destinations = Notation_Soutenances::getDestination($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"une_session_dest.une_destination",$les_destinations,null,
    array(
        "une_session_dest" => array(-1,"SESSION_ID")
    ));

/**
 * Sections
 */
$les_sections = Notation_Soutenances::getSection($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"une_session_sect.une_dest.une_section",$les_sections,null,
    array(
        "une_session_sect" => array(-1,"SESSION_ID"),
        "une_session_sect.une_dest" => array(-1,"DEST_ID")
    ));

/**
 * Niveaux
 */
$les_niveaux = Notation_Soutenances::getNiveau($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"une_session_niveau.une_dest_filtre.un_niveau",$les_niveaux,null,
    array(
        "une_session_niveau" => array(-1,"SESSION_ID"),
        "une_session_niveau.une_dest_filtre" => array(-1,"DEST_ID")
    ));

/**
 * Critères
 */
$les_criteres = Notation_Soutenances::getCriteres($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"une_session_critere.une_dest_critere.une_section.un_critere",$les_criteres,null,
    array(
        "une_session_critere" => array(-1,"SESSION_ID"),
        "une_session_critere.une_dest_critere" => array(-1,"DEST_ID"),
        "une_session_critere.une_dest_critere.une_section" => array(-1,"SECTION_ID")
    ));

/**
 * Explications
 */
$les_explications = Notation_Soutenances::getExplications($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"une_session_explication.une_dest_explication.un_critere.un_niveau.une_explication",$les_explications,null,
    array(
        "une_session_explication" => array(-1,"SESSION_ID"),
        "une_session_explication.une_dest_explication" => array(-1,"DEST_ID"),
        "une_session_explication.une_dest_explication.un_critere" => array(-1,"CRITERE_ID"),
        "une_session_explication.une_dest_explication.un_critere.un_niveau" => array(-1,"NIVEAU_ID")
    ));

/**
 * Notes
 */


affectToXHTML($template,array(
    "HAS_PLANNING" => count($les_plannings)>0,
    "HAS_SESSION" => count($les_sessions)>0,
    "HAS_SESSION_PAS_VIDE" => count($les_sessions_vide)>0 && count($les_sessions_pas_vide)>1,
    "HAS_DESTINATION" => count($les_destinations)>0,
    "HAS_SECTION" => count($les_sections)>0,
    "HAS_NIVEAU" => count($les_niveaux)>0,
    "HAS_CRITERE" => count($les_criteres)>0,
    "HAS_EXPLICATION" => count($les_explications)>0,
    "FORMATION_COURANTE" => $formation_courante,
    "DEPARTEMENT_COURANT" => CURRENT_DEPT_ID,
    "ANNEE_COURANTE" => $annee_courante
));

generateCompleteXHTML($template, "soutenances");
