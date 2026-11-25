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

if (!isRegistered() & !isAdmin()) {
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

$groupe_courant = "";
if (isset($_GET['bfmw_num_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

setAttachment($template, "groupe", "groupe.html");

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

$les_groupes = Groupes::getGroupesVides(Formations::getFormationsDuConnecteString(),"GROUPE_FEUILLE=1 AND ");
$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes,new Comparateur("GROUPE_ID",$groupe_courant),
    array(
        "une_formation" => array(-1,"FORM_ID")
    ));

if (count($les_groupes) > 0) {

    $etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$groupe_courant);
    $les_groupes[$groupe_courant]['NB'] = count($etudiants);
    foreach ($etudiants as $unEtudiant) {
        $unEtudiant['RETURN'] = "\n";
        affectToBloc($template, "un_etudiant", $unEtudiant);
    }

    affectToXHTML($template, $les_groupes[$groupe_courant]);
}

affectToXHTML($template, array(
   "ANNEE_ID" =>  $annee_courante,
    "NB_GROUPES" => count($les_groupes)
));

generateCompleteXHTML($template, "groupe");
