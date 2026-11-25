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

setAttachment($template, "vacataire", "vacataire.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));

$les_charges = ChargeEnseignements::computeChargeEqTDDetail($annee_courante, CURRENT_DEPT_ID,(isset($_GET['bfmw_orig_perm'])?0:1));

affectToBlocAndRepeat($template,"un_enseignant.une_formation.un_semestre.une_ue.une_matiere.une_charge",$les_charges,null,
array (
    "un_enseignant" => array(-1,"ENS_ID"),
    "un_enseignant.une_formation" => array(-1,"FORM_ID"),
    "un_enseignant.une_formation.un_semestre" => array(-1,"SEM_ID"),
    "un_enseignant.une_formation.un_semestre.une_ue" => array(-1,"UE_ID"),
    "un_enseignant.une_formation.un_semestre.une_ue.une_matiere" => array(-1,"MAT_ID")
));

affectToXHTML($template,array(
    "COMPLEMENT" => (isset($_GET['bfmw_orig_perm'])?0:1),
    "MAXI" => ini_get('post_max_size'),
    "ANNEE_COURANTE" => $annee_courante,
    "SUJET_MAIL" => isset($_GET['bfmw_orig_sujet_mail'])?$_GET['bfmw_orig_sujet_mail']:"",
    "MESSAGE" => isset($_GET['bfmw_orig_message'])?$_GET['bfmw_orig_message']:""
));

generateCompleteXHTML($template, "vacataire");
