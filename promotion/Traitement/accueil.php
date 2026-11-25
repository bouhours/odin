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

$annee_courante = $_GET['bfmw_num_a']??Annees::getIdAnneeCourante();
$groupe_a_afficher = $_GET['bfmw_orig_g'] ?? -1;
$les_annees = Annees::getAnneeNonClose();
$annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annees,new Comparateur("ANNEE_ID",$annee_courante));

$les_groupes = Groupes::getGroupesDuDepartement(CURRENT_DEPT_ID);
$groupe_a_afficher = affectToBlocAndRepeat($template, "une_formation.un_groupe", $les_groupes, new Comparateur("GROUPE_ID", $groupe_a_afficher), array(
    "une_formation" => array(-1, "FORM_ID")
));

$les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$groupe_a_afficher);
$nb_elternants = 0;
foreach ($les_etudiants as $un_etudiant) {
    $un_etudiant['ET_AGE'] = getAge($un_etudiant['ET_NAISSANCE']);
    if ($un_etudiant['ET_PROFESSIONNALISATION'] == "1") {
        $nb_elternants++;
    }
    affectToBloc($template, "un_etudiant", $un_etudiant);
}

affectToXHTML($template,array(
    "NB_GROUPES" => count($les_groupes),
    "EFFECTIF" => count($les_etudiants),
    "ALTERNANTS" => $nb_elternants,
    "GROUPE_COURANT" => $groupe_a_afficher,
    "ANNEE_COURANTE" => $annee_courante,
    "AFFICHER_ANNEE" => count($les_annees) > 1
));

generateCompleteXHTML($template, "accueil");