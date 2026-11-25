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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

setAttachment($template, "planning", "planning.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

/**
 * Planning
 */
$les_plannings = Plannings::getPlanningAvecCreneaux(CURRENT_DEPT_ID,$annee_courante);
$anti_boucle = -1;
affectToBlocAndRepeat($template,"un_planning.un_creneau", $les_plannings, null,
array(
   "un_planning" => array(-1,"PLANNING_ID")
),function ($une_ligne) {
    global $template;
    global $anti_boucle;
    affectToBloc($template,"un_planning.un_creneau",$une_ligne);

    if ($anti_boucle != $une_ligne["PLANNING_ID"]) {
        $anti_boucle = $une_ligne["PLANNING_ID"];
        affectToBlocAndRepeat($template,"un_planning.un_enseignant",Plannings::getEnseignantValorisesPourPlanning($une_ligne["PLANNING_ID"],$une_ligne["PLANNING_DEPT_ID"]));
        $les_rdv = Plannings::getTousLesRendezVousDeLEnseignant($une_ligne["PLANNING_ID"]);
        affectToXHTML($template,array(
            "NB_RDV" => count($les_rdv)
        ));

        affectToBlocAndRepeat($template,"un_planning.une_date.un_rdv",$les_rdv,null,array(
            "un_planning.une_date" => array(-1,"DISPO_DATE")
        ));
    }
});

affectToXHTML($template,array(
    "HAS_PLANNING" => count($les_plannings)>0,
    "DEPARTEMENT_COURANT" => CURRENT_DEPT_ID,
    "ANNEE_COURANTE" => $annee_courante
));

generateCompleteXHTML($template, "planning");
