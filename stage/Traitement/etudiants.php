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
setAttachment($template, "etudiants", "etudiants.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$groupe_courant = -1;
if (isset($_GET['bfmw_num_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$etudiant_courant = -1;
if (isset($_GET['bfmw_num_e'])) {
    $etudiant_courant = $_GET['bfmw_num_e'];
}


$les_formations = array();
if (Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    $les_formations = Formations::getFormationsDuGestionnaireDeStage(CURRENT_ID, CURRENT_DEPT_ID,$annee_courante);
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


$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));
$les_groupes = Groupes::getGroupesOLD(implode(",",$les_formations_avec_stages),$annee_courante);
$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes,new Comparateur("GROUPE_ID",$groupe_courant),array("une_formation" => array(-1,"FORM_ID")));
if ($groupe_courant > 0) {
    affectToBlocAndRepeat($template, "un_etudiant", Etudiants::getEtudiantsGroupesAvecStages($annee_courante, $groupe_courant), new Comparateur("ET_ID",$etudiant_courant,"SELECTED","jaune_force"));

    $table = array(
        "ANNEE_ID" => $annee_courante,
        "GROUPE_ID" => $groupe_courant,
        "SHOW_DETAIL" => isset($_GET['bfmw_orig_e']),
        "HIDE" => false
    );

    affectToXHTML($template, $table);
} else {
    $table = array(
        "ANNEE_ID" => -1,
        "GROUPE_ID" => -1,
        "SHOW_DETAIL" => false,
        "HIDE" => true
    );

    affectToXHTML($template, $table);
}

affectToXHTML($template,array(
    "HAS_TUTEUR" => false,
    "HAS_SESSION" => false,
    "AUCUNE_CANDIDATURE" => true,
    "STAGE_ID" => -1,
    "ETUDIANT_ID" => $etudiant_courant,
    "FORMATION_COURANTE" => $formation_courante,
    "DEPT_ID" => CURRENT_DEPT_ID
));

/**
 * Detail
 */
if ($etudiant_courant != -1 && $formation_courante != -1) {
    $les_stages = Stages::getStagesDUnGroupe($groupe_courant,$annee_courante);
    $stage_affecte = Stages::getStageDUnEtudiant($etudiant_courant,$annee_courante);
    $les_plannings = Soutenances::getPlanning(CURRENT_DEPT_ID,$annee_courante);
    $id_stage_affecte = -1;
    if ($stage_affecte != null) {
        $id_stage_affecte = $stage_affecte["STAGE_ID"];
    }
    affectToBlocAndRepeat($template,"un_stage",$les_stages, new Comparateur("STAGE_ID",$id_stage_affecte));
    $has_creneaux = false;
    $has_soutenance = false;
    $has_tuteur = false;
    if ($id_stage_affecte != -1) {
        $les_enseignants_permanents = Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID);
        array_unshift($les_enseignants_permanents,array(
            "ENS_NOM" => "Aucun",
            "ENS_ID" => "NULL"
        ));
        $enseignant_tuteur = affectToBlocAndRepeat($template,"un_enseignant",$les_enseignants_permanents,new Comparateur("ENS_ID",$stage_affecte['STAGE_ENS_ID']));
        $les_plannings_choisis = Soutenances::getPlanningChoisis($id_stage_affecte, $annee_courante);
        if ($enseignant_tuteur > 0) {
            $has_tuteur = true;
            affectToBlocAndRepeat($template, "un_enseignant_suggere", $les_enseignants_permanents, new Comparateur("ENS_ID", $stage_affecte['STAGE_SUGGESTION_ENS_ID']));
            foreach ($les_plannings as $planning_id => $planning) {
                if (isset($les_plannings_choisis[$planning_id])) {
                    $les_plannings[$planning_id]["CHECKED"] = "checked";
                } else {
                    $les_plannings[$planning_id]["CHECKED"] = "";
                }
            }
            affectToBlocAndRepeat($template, "un_planning", $les_plannings);
        }

        foreach ($les_plannings_choisis as $planning_id=>$__) {
            $les_soutenances = Soutenances::getSoutenancesEtudiant($etudiant_courant,$planning_id,$annee_courante);
            if (count($les_soutenances) > 0) {
                if (isset($les_soutenances[$stage_affecte["STAGE_ID"]])) {
                    $une_soutenance = $les_soutenances[$stage_affecte["STAGE_ID"]];
                    $une_soutenance["PLANNING_CONTENU"] = $les_plannings[$planning_id]["PLANNING_CONTENU"];
                    $une_soutenance["PLANNING_ID"] = $les_plannings[$planning_id]["PLANNING_ID"];
                    $une_soutenance["HAS_CRENEAU"] = false;
                    $une_soutenance["HAS_SOUTENANCE"] = false;
                    $enseignants = array();
                    $creneaux = array();
                    if ($une_soutenance["STAGE_DATE_SOUTENANCE"] == null) {
                        //$creneaux = Generation_Planning_Soutenances::getCreneauxDeSoutenancesPossibles($etudiant_courant, $id_stage_affecte, $planning_id, $annee_courante, CURRENT_DEPT_ID);
                        $creneaux = $une_soutenance["LES_CRENEAUX"];
                        $une_soutenance["HAS_CRENEAU"] = count($creneaux) > 0;
                    } else {
                        $une_soutenance["HAS_SOUTENANCE"] = true;
                        $enseignants = Generation_Planning_Soutenances::getEnseignantsPossiblesSurUnCreneau($etudiant_courant, $id_stage_affecte, $planning_id, $annee_courante, CURRENT_DEPT_ID, $une_soutenance["STAGE_SOUTENANCE_CRENEAU_ID"], $une_soutenance["STAGE_DATE_SOUTENANCE"]);
                    }
                    affectToBloc($template,"un_planning_soutenances",$une_soutenance);
                    if ($une_soutenance["STAGE_DATE_SOUTENANCE"] == null) {
                        affectToBlocAndRepeat($template, "un_planning_soutenances.un_creneau", $creneaux);
                    } else {
                        if (count($enseignants) > 0) {
                            affectToBlocAndRepeat($template, "un_planning_soutenances.un_enseignant_remplacant", $enseignants);
                        }
                    }
                }
            }
        }
    }

    $les_candidatures = Stages::getCandidatures($etudiant_courant,$annee_courante);
    affectToXHTML($template,array(
        "AUCUNE_CANDIDATURE" => count($les_candidatures) === 0,
        "STAGE_ID" =>$id_stage_affecte,
        "ETUDIANT_ID" => $etudiant_courant,
        "FORMATION_COURANTE" => $formation_courante,
        "HAS_SESSION" => count($les_plannings) > 0 && $id_stage_affecte != -1,
        "DEPT_ID" => CURRENT_DEPT_ID,
        "HAS_TUTEUR" => $has_tuteur,
        "HIDE" => false
    ));
    affectToBlocAndRepeat($template,"une_candidature", $les_candidatures);
}

generateCompleteXHTML($template, "etudiants");

