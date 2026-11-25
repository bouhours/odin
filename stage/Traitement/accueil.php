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

setAttachment($template, "accueil", "accueil.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$formation_courante = -1;
if (isset($_GET['bfmw_orig_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$les_formations = array();
if (Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    $les_formations = Formations::getFormationsDuGestionnaireDeStage(CURRENT_ID, CURRENT_DEPT_ID, $annee_courante);
} else {
    $les_formations = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);
}

if (count($les_formations) == 0) {
    echo "Accès refusé";
    exit;
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
$formation_courante = affectToBlocAndRepeat($template,"une_formation",$les_formations,new Comparateur("FORM_ID",$formation_courante));
$les_stages = Stages::getStages($formation_courante,$annee_courante);
$nb_stages = 0;
foreach ($les_stages as $STAGE_ID=>$un_stage) {
    if ($un_stage['STAGE_REF'] == "CSP") {
        continue;
    } else {
        $nb_stages++;
    }

    $un_stage['STAGE_SUJET_NL'] = $un_stage['STAGE_SUJET'];
    $un_stage['STAGE_SUJET'] = nl2br($un_stage['STAGE_SUJET']);
    $un_stage['STAGE_CONTACT_NL'] = $un_stage['STAGE_CONTACT'];
    $un_stage['STAGE_CONTACT'] = nl2br($un_stage['STAGE_CONTACT']);
    affectToBloc($template,"un_stage",$un_stage);

    $formations_du_stage = $les_formations;
    foreach ($formations_du_stage as &$une_formation) {
        $une_formation['CHECKED'] = "";
        if (isset($un_stage['FORMATIONS'])) {
            if ($un_stage['FORMATIONS']) {
                if (isset($un_stage['FORMATIONS'][$une_formation['FORM_ID']])) {
                    $une_formation['CHECKED'] = "checked";
                }
            }
        }
    }

    affectToBlocAndRepeat($template,"un_stage.une_formation",$formations_du_stage);
    if (isset($un_stage['CANDIDATS'])) {
        foreach ($un_stage['CANDIDATS'] as $un_etudiant) {
            affectToBloc($template,"un_stage.un_etudiant",$un_etudiant);
        }
    }
}

affectToXHTML($template, array(
    "ANNEE_COURANTE" => $annee_courante,
    "FORMATION_COURANTE" => $formation_courante,
    "NOMBRE_STAGES" => $nb_stages,
    "FORM_CANDIDATURES_STAGE_MAX" => $les_formations[$formation_courante]["FORM_CANDIDATURES_STAGE_MAX"],
    "FORM_CANDIDATURES_STAGE_ET_MAX" => $les_formations[$formation_courante]["FORM_CANDIDATURES_STAGE_ET_MAX"],
));

generateCompleteXHTML($template, "accueil");