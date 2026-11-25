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
$annee_courante = $force_annee_courante;

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,$annee_courante)) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

if (! Stages::isStagesDisponibles(CURRENT_ID,$annee_courante)) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

setAttachment($template, "stages", "stages.html");

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$les_candidatures = Stages::getCandidatures(CURRENT_ID,$annee_courante);
$les_formations = Formations::getFormationDeLEtudiant(CURRENT_ID,$annee_courante);

$formation_courante = affectToBlocAndRepeat($template,"une_formation",$les_formations,new Comparateur("FORM_ID",$formation_courante));

$formation_courante = Formations::getFormation($formation_courante)[$formation_courante];

affectToBlocAndRepeat($template,"une_candidature",$les_candidatures);
$les_stages = Stages::getStages($formation_courante['FORM_ID'],$annee_courante,CURRENT_ID);
$stage_affecte = Stages::getIdStageDUnEtudiant(CURRENT_ID,$annee_courante);

$creneaux = array();
$planning_contenu = "";
$session_selection_ouverte = false;
$soutenance_placee = "";
if ($stage_affecte != -1) {
    $les_plannings = Stages::getPlannings($stage_affecte,$annee_courante);
    if (count($les_plannings) > 0) {
        foreach ($les_plannings as $un_planning) {
            $session_selection_ouverte = $un_planning['PLANNING_START_ET'] <= time() && $un_planning['PLANNING_END_ET'] >= time();
            $session_selection_ouverte &= $un_planning["STAGE_DATE_SOUTENANCE"] === null && $un_planning["STAGE_SOUTENANCE_CRENEAU_ID"] === null;
            if ($un_planning["STAGE_DATE_SOUTENANCE"] === null) {
                $creneaux = Generation_Planning_Soutenances::getCreneauxDeSoutenancesPossibles(CURRENT_ID, $stage_affecte, $un_planning["STAGE_PLANNING_ID"], $annee_courante, CURRENT_DEPT_ID);
            }
            $un_planning["SELECTION_SOUTENANCE"] = count($creneaux)>0 && $session_selection_ouverte;
            $un_planning["SELECTION_OUVERTE"] = $session_selection_ouverte;
            $un_planning["JURY"] = $un_planning['STAGE_JURY_ENS_ID']!=null?Enseignants::getEnseigant($un_planning['STAGE_JURY_ENS_ID'])[0]['ENS_NOM']:"";
            affectToBloc($template,"un_planning",$un_planning);
            affectToBlocAndRepeat( $template,"un_planning.un_creneau",$creneaux);
            if (count($creneaux) == 0 && $un_planning["STAGE_DATE_SOUTENANCE"] == "" && $session_selection_ouverte) {
                sendMail(Enseignants::getEnseigant($les_stages[$stage_affecte]['STAGE_ENS_ID'])[0]['ENS_MAIL'], "ALERTE - Planification de soutenance",
                    "Bonjour,\n\nAucun créneau de soutenance n'est possible pour " . $_SESSION['etudiants_nom'] . ".\n\nMerci d'en ajouter des nouveaux.\n\nCordialement",
                    "cedric.bouhours@uca.fr");
            }
            /*$planning = Soutenances::getUnPlanning($un_planning["STAGE_PLANNING_ID"])[0];
            $planning_contenu = $planning["PLANNING_CONTENU"];
            $session_selection_ouverte = $planning['PLANNING_START_ET'] <= time() && $planning['PLANNING_END_ET'] >= time();
            $session_selection_ouverte &= $un_planning["STAGE_DATE_SOUTENANCE"] === null && $un_planning["STAGE_SOUTENANCE_CRENEAU_ID"] === null;
            $creneaux = Generation_Planning_Soutenances::getCreneauxDeSoutenancesPossibles(CURRENT_ID, $stage_affecte, $un_planning["STAGE_PLANNING_ID"], $annee_courante, CURRENT_DEPT_ID);
            if (count($creneaux) == 0 && $un_planning["STAGE_DATE_SOUTENANCE"] == "" && $session_selection_ouverte) {
                sendMail(Enseignants::getEnseigant($les_stages[$stage_affecte]['STAGE_ENS_ID'])[0]['ENS_MAIL'], "ALERTE - Planification de soutenance",
                    "Bonjour,\n\nAucun créneau de soutenance n'est possible pour " . $_SESSION['etudiants_nom'] . ".\n\nMerci d'en ajouter des nouveaux.\n\nCordialement",
                    "cedric.bouhours@uca.fr");
            }
            affectToBlocAndRepeat( $template,"un_creneau",$creneaux);*/
        }
    }

    affectToXHTML($template,$les_stages[$stage_affecte]??array());
}

$nb_stages=0;

foreach ($les_stages as $un_stage) {
    if ($un_stage['STAGE_REF'] == "CSP") {
        continue;
    } else {
        $nb_stages++;
    }
    $un_stage['STAGE_SUJET'] = nl2br($un_stage['STAGE_SUJET']);
    $un_stage['CANDIDATURES'] = $un_stage['NB_CANDIDATS']>1?"candidatures":"candidature";
    affectToBloc($template,"un_stage",$un_stage);
}

affectToXHTML($template,array(
    "NB_CANDIDATURES_ETUDIANT" => count($les_candidatures),
    "NB_CANDIDATURES_ETUDIANT_NON_ELIMINE" => count(Stages::getCandidaturesNonElimine(CURRENT_ID,$annee_courante)),
    "FORM_CANDIDATURES_STAGE_MAX" => $formation_courante["FORM_CANDIDATURES_STAGE_MAX"],
    "FORM_CANDIDATURES_STAGE_ET_MAX" => $formation_courante["FORM_CANDIDATURES_STAGE_ET_MAX"],
    "ETUDIANT_ID" => CURRENT_ID,
    "STAGE_AFFECTE" => $stage_affecte,
    "NOMBRE_STAGES" => $nb_stages,
    "ANNEE_COURANTE" => $annee_courante,
    "TUTEUR" => $stage_affecte!=-1?($les_stages[$stage_affecte]['STAGE_ENS_ID']!=null?Enseignants::getEnseigant($les_stages[$stage_affecte]['STAGE_ENS_ID'])[0]['ENS_NOM']:""):""
));

generateCompleteXHTML($template, "stages");