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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

if (!Formations::isSecretaire() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    echo "Accès non autorisé";
    exit;
}

setAttachment($template, "enseignants", "enseignants.html");
$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$les_enseignants = implode(",",array_keys(Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID)));
$les_places = Generation_Planning_Soutenances::getNombreSoutenancesDejaPlacees($annee_courante,$les_enseignants);
$infos_soutenances = Enseignants::getEnseignantsDuDepartementAvecInfosSoutenances(CURRENT_DEPT_ID,$annee_courante);

foreach ($infos_soutenances as &$une_ligne) {
    if (isset($les_places[$une_ligne['ENS_ID']])) {
        $une_ligne['TOTAL_PLACE'] = $les_places[$une_ligne['ENS_ID']]["TOTAL"]+$une_ligne['PLANNING_SOUT_FAITES'];
    } else {
        $une_ligne['TOTAL_PLACE'] = 0;
    }
}

affectToBlocAndRepeat($template,"une_categorie.un_enseignant.un_planning.un_etudiant",$infos_soutenances,null,
    array(
        "une_categorie" => array(-1,"ENS_DEPT_VACATAIRE"),
        "une_categorie.un_enseignant" => array(-1,"ENS_ID"),
        "une_categorie.un_enseignant.un_planning" => array(-1,"PLANNING_ID")
    ));

generateCompleteXHTML($template, "enseignants");