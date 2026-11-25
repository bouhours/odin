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

if (!isset($_SESSION['ACTIVE_ABSENCES_AUTO']) && !isset($_SESSION['ACTIVE_ABSENCES_PRO'])) {
    $send="p=accueil";
    require 'refresh.php';
    exit;
}


if (!isset($_POST['bfmw_orig_d']) || !isset($_POST['bfmw_orig_MAT_ID'])) {
    $send="p=signature";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();

setAttachment($template, "signer", "signer.html");

affectToXHTML($template,array(
    "ENSEIGNANT" => isset($_POST['bfmw_orig_signer_prof']),
    "ENS_ID" => isset($_POST['bfmw_orig_signer_prof'])?$_POST['bfmw_orig_p']:"",
    "ENS_NOM" => isset($_POST['bfmw_orig_signer_prof'])?$_POST['bfmw_orig_n']:"",
    "EDT_UID" => $_POST['bfmw_orig_d'],
    "MAT_ID" => $_POST['bfmw_num_MAT_ID'],
    "HAS_SIGNED" => false
));

$la_formation = Formations::getFormationDeLaMatiere($_POST['bfmw_num_MAT_ID']);
if ($la_formation != null) {

    if (isset($_POST['bfmw_orig_signer_prof'])) {
        $groupe = "";
        $les_groupes_affiches_id = array(-1);
        GrillesDeSignatures::showGrilleEnseignant(Absences::getCreneauxDeCours($annee_courante, $_POST['bfmw_orig_d']), $template, $_POST['bfmw_num_MAT_ID'], $annee_courante, $la_formation["FORM_ID"], $les_groupes_affiches_id);

        affectToXHTML($template, array(
            "GROUPE_NOM" => $groupe,
            "GROUPE_ID" => count($les_groupes_affiches_id) > 1 ? implode("$", array_unique($les_groupes_affiches_id)) : $_POST['bfmw_num_g']
        ));
    }
}
generateCompleteXHTML($template, "signer");