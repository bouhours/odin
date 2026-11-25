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

$annee_courante = Annees::getIdAnneeCourante();

$groupes_courants = array();
if (isset($_POST['bfmw_orig_g'])) {
    $groupes_courants = explode("$",$_POST['bfmw_orig_g']);
}

foreach ($groupes_courants as $groupe_courant) {

    if ($groupe_courant == "") {
        continue;
    }

    if (! defined("CURRENT_DEPT_ID")) {
        foreach (Groupes::getFormation($groupe_courant) as $une_formation) {
            define('CURRENT_DEPT_ID', $une_formation["FORM_DEPT_ID"]);
        }
    }

    $le_groupe = Groupes::getGroupe($groupe_courant);
    if ($le_groupe != null) {
        $le_groupe = $le_groupe[0];

        if (isset($_POST['bfmw_orig_getDoSign'])) {
            if (Signatures::executeSignature($_POST['bfmw_num_getDoSign'], $_POST['bfmw_num_u'], $_POST['bfmw_orig_g'], $_POST['bfmw_orig_b'])) {
                setAttachment($template, "do_sign", "do_sign.html");
                affectToXHTML($template, array(
                    "NOM" => $_POST['bfmw_orig_n']
                ));
                generateCompleteXHTML($template, "do_sign");
            }
            exit;
        }

        if (isset($_POST['bfmw_orig_sign'])) {
            Signatures::enregistrerSignature($_POST['bfmw_num_sign'], $_POST['bfmw_num_u'], $_POST['bfmw_orig_c'], $_POST['bfmw_orig_g'], $_POST['bfmw_orig_b'], $_POST['bfmw_num_m']);
            exit;
        }
    }
}

/**
 * Suppression d'une signature
 */
if (isset($_GET['bfmw_orig_do_del']) && isset($_POST['bfmw_orig_u']) && isset($_POST['bfmw_orig_g']) && isset($_POST['bfmw_orig_del'])) {
    $annee_courante = Annees::getIdAnneeCourante();
    $formation = Groupes::getFormation($_POST['bfmw_num_g']);
    foreach ($formation as $une_formation) {
        if (Absences_Automatiques::supprimerSignature($_POST['bfmw_num_del'], $_POST['bfmw_num_g'], $_POST['bfmw_orig_u']) > 0) {
            echo "OK";
            exit;
        }
    }
    echo "KO";
    exit;
}

