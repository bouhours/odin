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

setAttachment($template, "gererenseignant", "gererenseignant.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$matiere_courante = -1;
if (isset($_GET['bfmw_num_m'])) {
    $matiere_courante = $_GET['bfmw_num_m'];
}
$enseignant_courant = -1;
if (isset($_GET['bfmw_num_e'])) {
    $enseignant_courant = $_GET['bfmw_num_e'];
}
$semestre_courant = -1;
if (isset($_GET['bfmw_num_s'])) {
    $semestre_courant = $_GET['bfmw_num_s'];
}

$annee_close = Annees::getAnneeWithId($annee_courante)[0]['ANNEE_CLOSE'];
$enseignant_courant = affectToBlocAndRepeat($template,"un_enseignant",Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID),new Comparateur("ENS_ID",$enseignant_courant));
$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
$formations_autorisees = Formations::getFormationsDuConnecteV2String(CURRENT_DEPT_ID,$annee_courante);
$semestre_courant = affectToBlocAndRepeat($template,"un_departement_filtre.une_formation_filtre.un_semestre_filtre",Formations::getSemestres($formations_autorisees,$annee_courante),
    new Comparateur("SEM_ID",$semestre_courant),array(
        "un_departement_filtre" => array(-1,"DEPT_ID"),
        "un_departement_filtre.une_formation_filtre" => array(-1,"FORM_ID")
    )
);

$nb_matieres = 0;
if ($semestre_courant !== -1) {
    $la_maquette = Formations::getMaquetteSansMatiere(CURRENT_DEPT_ID,$annee_courante,"SEM_ID=$semestre_courant AND FORM_ID IN ($formations_autorisees) AND ");
    $nb_matieres = count($la_maquette);
    $matiere_courante = MatieresListView::generateListView($la_maquette,$template,$annee_courante,"listview_template_module_open.html","listview_template_module_close.html",
        function(array $uneMatiere){
            $template1 = attachXHTML();
            setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
            affectToXHTML($template1, $uneMatiere);
            return generateCompleteXHTML($template1,"listview_template_matiere",true);
        },function(array $un_element,int $annee_courante) {
            return Formations::getMatieresAvecRacine($un_element['UE_ID'],$annee_courante, "MAT_COPIE_MAT_ID IS NULL AND ");
        },$matiere_courante,"","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",true);

    MatieresListView::generateListView($la_maquette,$template,$annee_courante,"gererenseignant_template_module_open.html","gererenseignant_template_module_close.html",
        function(array $uneMatiere,int $annee_courante, int $semestre_courant){
            global $annee_close;
            $template1 = attachXHTML();
            setAttachment($template1, "gererenseignant_template_matiere", "gererenseignant_template_matiere.html");
            $uneMatiere['ANNEE_COURANTE'] = $annee_courante;
            $uneMatiere['SEMESTRE_COURANT'] = $semestre_courant;
            $uneMatiere['ANNEE_CLOSE'] = $annee_close;
            affectToXHTML($template1, $uneMatiere);
            $la_charge = ChargeEnseignements::getAffectationEnseignants($uneMatiere['MAT_ID'], $annee_courante);
            foreach ($la_charge as $un_enseignant) {
                if ($un_enseignant['ENS_MAT_NOTEUR'] == 1) {
                    $un_enseignant['NOTEUR'] = "checked";
                } else {
                    $un_enseignant['NOTEUR'] = "";
                }
                affectToBloc($template1, "un_enseignant", $un_enseignant);
            }
            return generateCompleteXHTML($template1,"gererenseignant_template_matiere",true);
        },function(array $un_element,int $annee_courante) {
            return Formations::getMatieresAvecRacine($un_element['UE_ID'],$annee_courante, "MAT_COPIE_MAT_ID IS NULL AND ");
        },-1,"arbre_");

    if (isAdmin()) {
        openBloc($template, "isAdmin");
    }
}
$tab = array(
    "ANNEE_COURANTE" => $annee_courante,
    "SEMESTRE_COURANT" => $semestre_courant,
    "OK_AFFECTATION" => $nb_matieres > 0
);
affectToXHTML($template, $tab);

generateCompleteXHTML($template, "gererenseignant");