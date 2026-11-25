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

setAttachment($template, "gererformation", "gererformation.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee", Annees::getAnneeDuDepartement(CURRENT_DEPT_ID),new Comparateur("ANNEE_ID",$annee_courante));

$departement_courant = Departements::getDepartement(CURRENT_DEPT_ID)[0];
$is_chef = $departement_courant['DEPT_ENS_ID'] == CURRENT_ID;
affectToXHTML($template,$departement_courant);

$les_enseignants_du_departement = Enseignants::getEnseignantsPermanents(CURRENT_DEPT_ID,false);
affectToBlocAndRepeat($template,"un_enseignant",$les_enseignants_du_departement,new Comparateur("ENS_ID",$departement_courant['DEPT_ENS_ID']));

$les_formations_du_connecte = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);
$formation_courante = affectToBlocAndRepeat($template,"une_formation_filtre",$les_formations_du_connecte,new Comparateur("FORM_ID",$formation_courante));
if ($formation_courante != -1) {
    $la_formation_courante = $les_formations_du_connecte[$formation_courante];

    $la_formation_courante['FORM_PRO'] = $la_formation_courante['FORM_PRO'] == 1 ? "checked" : "";
    $la_formation_courante['FORM_EVALUABLE'] = $la_formation_courante['FORM_EVALUABLE'] == 1 ? "checked" : "";
    $la_formation_courante['FORM_ABSENCES_AUTO'] = $la_formation_courante['FORM_ABSENCES_AUTO'] == 1 ? "checked" : "";
    $la_formation_courante['FORM_AUTORISE_SIGNATURES_ANTICIPEES'] = $la_formation_courante['FORM_AUTORISE_SIGNATURES_ANTICIPEES'] == 1 ? "checked" : "";
    $la_formation_courante['FORM_SIGNATURE_SUR_TABLETTES'] = $la_formation_courante['FORM_SIGNATURE_SUR_TABLETTES'] == 1 ? "checked" : "";
    affectToBloc($template, "une_formation", $la_formation_courante);

    $les_responsables = array();
    foreach (Enseignants::getResponsableFormation($formation_courante) as $un_responsable) {
        $les_responsables[] = $un_responsable['ENS_ID'];
    }
    affectEnseignantsMultiples($les_enseignants_du_departement, $les_responsables, "une_formation.un_enseignant_responsable", $template);

    $les_responsables = array();
    foreach (Enseignants::getSecretaireFormation($formation_courante) as $un_responsable) {
        $les_responsables[] = $un_responsable['ENS_ID'];
    }
    affectEnseignantsMultiples($les_enseignants_du_departement, $les_responsables, "une_formation.un_enseignant_secretaire", $template);


    $la_maquette = Formations::getMaquetteSansMatiere(CURRENT_DEPT_ID, $annee_courante, "FORM_ID=$formation_courante AND ");
    $previous_sem = -1;
    $previous_ue = -1;
    foreach ($la_maquette as &$un_element) {
        $un_element['SEM_VIDE'] = true;
        $un_element['UE_VIDE'] = true;
        if ($un_element['SEM_ID'] != "") {
            $un_element['SEM_VIDE'] = count(Formations::getUEAvecControleDuSemestre($un_element['SEM_ID'], $annee_courante)) == 0;
        }
        if ($un_element['UE_ID'] != "") {
            $un_element['UE_VIDE'] = count(Formations::getMatieresAvecControleDeUE($un_element['UE_ID'], $annee_courante)) == 0;
        }
    }

    $les_periodes = Edt::getPeriode($formation_courante, $formation_courante);
    $lesAssoc = array();
    $lesPeriodesMatieres = Edt::getPeriodeMatieres(Formations::getFormationsDuConnecteString());
    foreach ($lesPeriodesMatieres as $une_assoc) {
        $lesAssoc[$une_assoc['MAT_PERIODE_ID'] . "$" . $une_assoc['PERIODE_MAT_ID']] = true;
    }

    MatieresListView::generateListView($la_maquette, $template, $annee_courante, "gererformation_template_module_open.html", "gererformation_template_module_close.html",
        function (array $uneMatiere, $annee_id, $__) {
            global $les_periodes;
            global $lesAssoc;
            global $is_chef;
            global $formation_courante;
            global $annee_courante;

            $template1 = attachXHTML();
            setAttachment($template1, "gererformation_template_matiere", "gererformation_template_matiere.html");
            $uneMatiere['NB_PERIODE'] = count($les_periodes);
            $uneMatiere['NOM_COPIE'] = $uneMatiere["MAT_COPIE_MAT_ID"] != "" ? Formations::getMatiere($uneMatiere["MAT_COPIE_MAT_ID"])["MAT_NOM"] : "aucune";
            affectToXHTML($template1, $uneMatiere);
            affectToXHTML($template1, array(
                "ENS_ID" => CURRENT_ID,
                "IS_ADMIN" => isAdmin(),
                "IS_CHEF" => $is_chef || isAdmin(),
                "FORM_ID" => $formation_courante,
                "ANNEE_COURANTE" => $annee_id
            ));
            generatePeriode($les_periodes, $uneMatiere, $lesAssoc, $template1);

            if ($uneMatiere['NEW_MAT'] == 1) {
                $la_maquette_2 = Formations::getMaquetteSansMatiere(CURRENT_DEPT_ID, $annee_courante, "FORM_ID=$formation_courante AND SEM_ID=" . $uneMatiere["SEM_ID"] . " AND ");
                MatieresListView::generateListView($la_maquette_2, $template1, $annee_courante, "listview_template_module_open.html", "listview_template_module_close.html",
                    function (array $uneMatiere) {
                        $template3 = attachXHTML();
                        setAttachment($template3, "listview_template_matiere", "listview_template_matiere.html");
                        affectToXHTML($template3, $uneMatiere);
                        return generateCompleteXHTML($template3, "listview_template_matiere", true);
                    }, function (array $un_element, int $annee_courante) {
                        return Formations::getMatieresAvecRacine($un_element['UE_ID'], $annee_courante, "MAT_COPIE_MAT_ID IS NULL AND ");
                    }, $uneMatiere["MAT_COPIE_MAT_ID"] ?? -1, "", "&nbsp;&nbsp;&nbsp;&nbsp;", true);
            }


            return generateCompleteXHTML($template1, "gererformation_template_matiere", true);
        }, function (array $un_element, int $annee_id) {
            if ($un_element['UE_ID'] != "") {
                return Formations::getMatieresAvecRacineEtSemestre($un_element['UE_ID'], $annee_id);
            }
            return array();
        }, -1, "arbre_");

    affectToBlocAndRepeat($template, "un_semestre.une_ue.une_matiere", Formations::getMaquette(CURRENT_DEPT_ID, $annee_courante, "FORM_ID=$formation_courante AND"), null,
        array(
            "un_semestre" => array(-1, "SEM_ID"),
            "un_semestre.une_ue" => array(-1, "UE_ID")
        ));
}
affectToXHTML($template, array(
    "ENS_ID" => CURRENT_ID,
    "IS_ADMIN" => isAdmin(),
    "IS_CHEF" => $is_chef || isAdmin(),
    "FORM_ID" => $formation_courante,
    "ANNEE_COURANTE" =>$annee_courante,
    "NOM_DU_CHEF" => Enseignants::getEnseigant($departement_courant['DEPT_ENS_ID'])[0]["ENS_NOM"]
));

generateCompleteXHTML($template, "gererformation");

function generatePeriode(array $les_periodes,array $value,array $lesAssoc,Template &$template) : int
{
    $nb_periodes = 0;

    foreach ($les_periodes as $une_periode) {
        $nb_periodes++;
        if (array_key_exists($une_periode['PERIODE_ID'] . "$" . $value['MAT_ID'], $lesAssoc)) {
            $une_periode["SELECTED"] = 'selected="selected"';
            $une_periode["CHECKED"] = 'checked="checked"';
        } else {
            $une_periode["SELECTED"] = '';
            $une_periode["CHECKED"] = '';
        }
        affectToBloc($template, "une_periode", $une_periode);
    };
    return $nb_periodes;
}

function affectEnseignantsMultiples(array $lesEnseignants,array $selections,string $chemin,Template &$template)
{
    foreach ($lesEnseignants as &$un_enseignant) {
        if (in_array($un_enseignant['ENS_ID'],$selections)) {
            $un_enseignant['CHECKED'] = "checked";
            affectToBloc($template, $chemin, $un_enseignant);
        } else {
            $un_enseignant['CHECKED'] = "";
        }
    }
    foreach ($lesEnseignants as $un_enseignant_non_selection) {
        if (! in_array($un_enseignant_non_selection['ENS_ID'],$selections)) {
            affectToBloc($template, $chemin, $un_enseignant_non_selection);
        }
    }
}