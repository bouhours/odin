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
if (!defined('FRONT_ACCESS')) {
    die ('Piratage détecté');
}

/**
 * Créer champ
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="renseignement" && isset($_POST['bfmw_orig_creer_champ'])) {
    if (! array_key_exists($_POST['bfmw_num_*CHAMPS_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("", "Création d'un champ", "Erreur, piratage détecte !");
    } else {
        $id = Fiches_Renseignements::creerChamp($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'un champ", "Le champ a été créée avec succès.");
        } else {
            makeErreur("", "Création d'un champ", "Il y a eu une erreur lors de la création d'un champ.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_*CHAMPS_FORM_ID']."&amp;a=".$_POST['bfmw_num_ANNEE_ID'];
}
/**
 * Supprimer champ
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="renseignement" && isset($_GET['bfmw_orig_delchp']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'un champ", "Erreur, piratage détecte !");
    } else {
        if (Fiches_Renseignements::supprimerChamp($_GET['bfmw_orig_delchp'])) {
            makeErreur("success", "Suppression d'un champ", "Le champ a été suppimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un champ", "Il y a eu une erreur lors de la suppression d'un champ.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

