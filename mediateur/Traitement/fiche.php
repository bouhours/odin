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

if (!isset($_SESSION['ACTIVE_ABSENCES_AUTO'])) {
    $send="?p=accueil";
    require 'refresh.php';
    exit;
}

if (!isset($_GET['bfmw_orig_u']) || !isset($_GET['bfmw_orig_g'])) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}


$les_formations_autorisees = Formations::getFormationsDuConnecteString();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = Annees::getIdAnneeCourante();
$groupe_courant = $_GET['bfmw_orig_g'];
$edt_courant = $_GET['bfmw_orig_u'];
$le_groupe = Groupes::getGroupe($groupe_courant)[0];


setAttachment($template, "fiche", "fiche.html");

$matiere_courante = -1;
$les_matieres = Absences_Automatiques::getMatiere($edt_courant);
foreach ($les_matieres as $une_matiere) {
    $matiere_courante = $une_matiere['MAT_ID'];
    break;
}

$les_signatures = Absences_Automatiques::getSignaturesPourUnGroupe($groupe_courant,$edt_courant,$annee_courante,$matiere_courante);
$groupe_nom = "";
foreach ($les_signatures as $une_signature) {
    try {
        $une_signature['SIGNATURE'] = gzuncompress(base64_decode($une_signature['SIGNATURE']));
    } catch (ErrorException $e) {
        $une_signature['SIGNATURE'] = base64_decode($une_signature['SIGNATURE']);
    }
    $groupe_nom = $une_signature['GROUPE_NOM'];
    if ($matiere_courante != "") {
        $une_signature['SIGNATURE_MAT_ID'] = $matiere_courante;
    }
    affectToBloc($template, "un_etudiant", $une_signature);
}

$creneau = Signatures::getCreneauEnseignant($groupe_courant,$edt_courant);
foreach ($creneau as &$un_creneau) {
    try {
        $un_creneau['SIGNATURE'] = gzuncompress(base64_decode($un_creneau['SIGNATURE']));
    } catch (ErrorException $e) {
        $un_creneau['SIGNATURE'] = base64_decode($un_creneau['SIGNATURE']);
    }
    $un_creneau['GROUPE_NOM'] = $groupe_nom;
}
affectToBlocAndRepeat($template, "un_creneau.un_enseignant", $creneau, null, array(
    "un_creneau" => array(-1,"EDT_UID")
));

generateCompleteXHTML($template, "fiche");
