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

if (!isRegistered() && !isAdmin()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "poursuite", "poursuite.html");

$annee_courante = Annees::getIdAnneeCourante();
$formations_autorisees = Formations::getFormationsDuConnecteString();

affectToBlocAndRepeat($template,"les_avis",Poursuites::getAvisModele(CURRENT_DEPT_ID));
affectToBlocAndRepeat($template,"les_categories",Poursuites::getCategorie(CURRENT_DEPT_ID));

affectToBlocAndRepeat($template,"un_groupe",Groupes::getGroupesOLD($formations_autorisees,$annee_courante,"GROUPE_PARENT IS NULL AND"),
    new Comparateur("GROUPE_POURSUITE",1,"SELECTED","checked"));

affectToXHTML($template,Departements::getDepartement(CURRENT_DEPT_ID)[0]);
/*
$la_maquette = Formations::getMaquetteSansMatiere(CURRENT_DEPT_ID,$annee_courante,"FORM_ID IN ($formations_autorisees) AND ");
MatieresListView::generateListView($la_maquette,$template,$annee_courante,"listview_template_module_open.html","listview_template_module_close.html",
    function(array $uneMatiere){
        $template1 = attachXHTML();
        setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
        affectToXHTML($template1, $uneMatiere);
        return generateCompleteXHTML($template1,"listview_template_matiere",true);
    },function(array $un_element,int $annee_courante) {
        return Formations::getMatieresAvecRacine($un_element['UE_ID'],$annee_courante,"MAT_COPIE_MAT_ID IS NULL AND ");
    },-1,"","&nbsp;&nbsp;&nbsp;&nbsp;",true);

affectToBlocAndRepeat($template,"une_matiere_de_poursuite.une_matiere.un_enseignant",Poursuites::getMatieresDePoursuite(CURRENT_DEPT_ID,$annee_courante),
    new Comparateur("ENS_MAT_POURSUITE","1","CHECKED","checked"),
    array(
        "une_matiere_de_poursuite" => array(-1,"PMAT_ID"),
        "une_matiere_de_poursuite.une_matiere" => array(-1,"MAT_ID")
    ));
*/
generateCompleteXHTML($template, "poursuite");
