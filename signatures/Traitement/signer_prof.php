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

$send_may_i = "signer_prof";
require_once ('check_tablette.php');
verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}


if (!isset($_POST['bfmw_orig_d']) || !isset($_POST['bfmw_orig_signer_prof'])) {
    $send="p=accueil";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();

setAttachment($template, "signer_prof", "signer_prof.html");

affectToXHTML($template,array(
    "ENSEIGNANT" => isset($_POST['bfmw_orig_signer_prof']),
    "ENS_ID" => isset($_POST['bfmw_orig_signer_prof'])?$_POST['bfmw_orig_p']:"",
    "ENS_NOM" => isset($_POST['bfmw_orig_signer_prof'])?$_POST['bfmw_orig_n']:"",
    "EDT_UID" => $_POST['bfmw_orig_d'],
    "MAT_ID" => $_POST['bfmw_num_mat_id'],
    "HAS_SIGNED" => false
));

$la_formation = Formations::getFormationDeLaMatiere($_POST['bfmw_num_mat_id']);
if ($la_formation != null) {

    if (isset($_POST['bfmw_orig_signer_prof'])) {
        $les_groupes_affiches_id = array(-1);
        $nombre_de_signatures = GrillesDeSignatures::showGrilleEnseignant(Absences::getCreneauxDeCours($annee_courante, $_POST['bfmw_orig_d']), $template, $_POST['bfmw_num_mat_id'], $annee_courante, $la_formation["FORM_ID"], $les_groupes_affiches_id);

        affectToXHTML($template, array(
            "NOM_MATIERE" => $_POST['bfmw_orig_signer_prof'],
            "NOMBRE_SIGNATURE" => $nombre_de_signatures,
            "GROUPE_ID" => count($les_groupes_affiches_id) > 1 ? implode("$", array_unique($les_groupes_affiches_id)) : $_POST['bfmw_num_g']
        ));
    }
}
generateCompleteXHTML($template, "signer_prof");