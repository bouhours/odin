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

if (Formations::isSecretaire() && (!isset($_GET['bfmw_orig_chef']) || (isset($_GET['bfmw_orig_chef']) && $_GET['bfmw_orig_chef']!=='p5fkhz6sd'))) {
    $send="p=aide";
    require('refresh.php');
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "accueil", "accueil.html");

$annee_courante = Annees::getIdAnneeCourante();

$isChef = (Formations::isResponsable() || Formations::isSecretaire() || Formations::isChef()) && isset($_GET['bfmw_orig_chef']);

/**
 * Créneaux horaires
 */
$req = "SELECT * FROM common_absences_creneau WHERE CRENEAU_CLASSIQUE=1 AND CRENEAU_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY CRENEAU_REAL_START,CRENEAU_REAL_END";
$res = $conn->query($req);
while ($creneau = $res->fetch_assoc()) {
    affectToBloc($template, "un_creneau_frequent", $creneau);
}

$req = "SELECT * FROM common_absences_creneau WHERE CRENEAU_CLASSIQUE=0 AND CRENEAU_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY CRENEAU_REAL_START,CRENEAU_REAL_END";
$res = $conn->query($req);
while ($creneau = $res->fetch_assoc()) {
    affectToBloc($template, "un_creneau", $creneau);
}

/**
 * Types d'absences
 */
$req = "SELECT * FROM common_absences_type";
$res = $conn->query($req);
while ($type = $res->fetch_assoc()) {
    affectToBloc($template, "un_type", $type);
}

/**
 * Cours
 */
$la_maquette = Formations::getMaquettePourEnseignant($isChef?-1:CURRENT_ID, CURRENT_DEPT_ID, $annee_courante, "MAT_LOCK_ANNEE_ID<$annee_courante AND ");

MatieresListView::generateListView($la_maquette,$template,$annee_courante,"listview_template_module_open.html","listview_template_module_close.html",
    function(array $uneMatiere){
        $template1 = attachXHTML();
        setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
        affectToXHTML($template1, $uneMatiere);
        return generateCompleteXHTML($template1,"listview_template_matiere",true);
    },function(array $un_element,int $annee_courante) {
        global $isChef;
        return Formations::getMatieresAffectees($un_element['UE_ID'], $isChef?-1:$un_element['MAT_ENS_ID'], $annee_courante);
    },-1,"","&nbsp;&nbsp;&nbsp;&nbsp;",true);

affectToXHTML($template,array(
    "NB" => count($la_maquette),
    "IS_CHEF" => $isChef
));


generateCompleteXHTML($template, "accueil");
