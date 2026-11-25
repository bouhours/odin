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
$les_annees = Annees::getAnneeNonClose();
if ((Formations::isResponsable() || Formations::isSecretaire())) {
    $les_annees = Annees::getAnnee();
    if (isset($_GET['bfmw_orig_a'])) {
        $annee_courante = $_GET['bfmw_num_a'];
    }
}
$groupe_valide = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_valide = $_GET['bfmw_num_g'];
}
$etudiant_valide = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annees,new Comparateur("ANNEE_ID",$annee_courante));

$les_formations_autorisees = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);

/**
 * Affichage des groupes
 */
$groupe_valide = affectToBlocAndRepeat($template,"une_formation.un_groupe",Groupes::getGroupesDuResponsable(implode(",",array_keys($les_formations_autorisees)),$annee_courante,CURRENT_ID),
    new Comparateur("GROUPE_ID",$groupe_valide),
    array("une_formation" => array(-1,"FORM_ID")));

affectToXHTML($template,array(
    "ANNEE_ID" => $annee_courante,
    "GROUPE_ID" => $groupe_valide,
    "IS_RESPONSABLE" => Formations::isResponsable() || Formations::isSecretaire()
));

if ($groupe_valide !== "-1") {

    BilanEtudiant::generateMaster($template,$annee_courante,$groupe_valide,CURRENT_ID, $etudiant_valide);
    if ($etudiant_valide !== -1) {
        $les_formations = Groupes::getFormation($groupe_valide);
        foreach ($les_formations as $une_formation) {
            BilanEtudiant::generateBilan($template, $annee_courante, $etudiant_valide, $une_formation['FORM_ID']);
            break;
        }
    } else {
        openBloc($template,"global");
        BilanCompetences::afficheurBilanToutEtudiant($annee_courante,$groupe_valide,$template,"global");
    }

}

generateCompleteXHTML($template, "accueil");