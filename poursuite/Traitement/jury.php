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

/**
 * Libération de la saisie en cours
 */
$req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=NULL WHERE PMAT_ENS_ID=".CURRENT_ID;
$conn->query($req);



if (!isset($_GET['bfmw_num_categ'])) {
    exit;
}

$categorie = $_GET['bfmw_num_categ'];
$groupe_courant = $_GET['bfmw_num_g']??-1;

setAttachment($template, "jury", "jury.html");

$annee_courante = Annees::getIdAnneeCourante();
$groupes_de_poursuite = Groupes::getGroupesDePoursuite(CURRENT_DEPT_ID);
$groupe_courant = affectToBlocAndRepeat($template,"un_groupe",$groupes_de_poursuite,new Comparateur("GROUPE_ID",$groupe_courant));

foreach ($groupes_de_poursuite AS $un_groupe) {
    if ($groupe_courant != $un_groupe['GROUPE_ID']) {
        continue;
    }
    $les_etudiants = Poursuites::getEtudiantsDuGroupe($annee_courante, $un_groupe["GROUPE_CODE"],$categorie);
    $les_moyennes = Moyennes::getMoyennesDesSemestresTouteAnnee(implode(",", array_keys($les_etudiants)),CURRENT_DEPT);
    foreach ($les_etudiants AS &$un_etudiant) {
        $un_etudiant["MOYAN_VALEUR"] = $les_moyennes[$un_etudiant["ET_ID"]]["MOYAN_VALEUR"]??"0";
    }
    $selon = "MOYAN_VALEUR";
    uasort($les_etudiants, "trierSelon");
    foreach ($les_etudiants AS &$un_etudiant) {
        $un_etudiant["MOYAN_CLASSEMENT"] = array_search($un_etudiant["ET_ID"],array_keys($les_etudiants))+1;
    }


    affectToBlocAndRepeat($template,"un_etudiant",$les_etudiants);
}

affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante,
    "GROUPE_ID" => $groupe_courant,
    "GROUPE_CODE" => Groupes::getGroupe($groupe_courant)[0]["GROUPE_CODE"],
    "IS_ADMIN" => isAdmin() || Formations::isChef() || Formations::isResponsable(),
    "CATEGORIE" => $categorie,
    "CATEGORIE_NOM" => Poursuites::getCategorieById($categorie,CURRENT_DEPT_ID)[0]["CATEGORIE_NOM"],
    "VOTE_CODE" => "jurype_".$annee_courante,
    "IS_GENERATEUR" => isAdmin() || Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire()
));

generateCompleteXHTML($template, "jury");

function trierSelon($elem1,$elem2) {
    global $selon;

    if (floatval($elem1[$selon]) == floatval($elem2[$selon])) {
        return 0;
    }

    return (floatval($elem1[$selon]) > floatval($elem2[$selon])) ? -1 : 1;
}