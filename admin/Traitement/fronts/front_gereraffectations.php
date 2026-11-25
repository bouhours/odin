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
/*****************************************************************
 * AFFECTION ENSEIGNANT MATIERE **********************************
 *****************************************************************/
/**
 * Affectation d'un enseignant à une matière
 */
if (isset($_POST['bfmw_orig_affecter_enseignant']) && isset($_POST['bfmw_num_*ENS_MAT_ANNEE_ID']) && isset($_POST['bfmw_num_*MAT_ENS_ID']) && isset($_POST['bfmw_num_*ENS_MAT_ID']) && isset($_GET['bfmw_num_s'])) {
    $id = createData("common_enseignants_matieres", $_POST, 3);
    if ($id != -1) {
        makeErreur("success", "Affection d'un enseignant à une matière", "L'enseignant a été affecté avec succès.");
    } else {
        makeErreur("", "Affection d'un enseignant à une matière", "Il y a eu une erreur lors de l'affectation de l'enseignant. Contactez le responsable de formation.");
    }
    $param = "&a=".$_POST['bfmw_num_*ENS_MAT_ANNEE_ID']."&e=".$_POST['bfmw_num_*MAT_ENS_ID']."&m=".$_POST['bfmw_num_*ENS_MAT_ID']."&s=".$_GET['bfmw_num_s'];
}
/**
 * Désaffectation d'un enseignant à une matière
 */
if (isset($_GET['bfmw_orig_delm']) && isset($_GET['bfmw_orig_dele']) && isset($_GET['bfmw_orig_dela']) && isset($_GET['bfmw_orig_dela'])) {
    if (Formations::supprimerAffectationEnseignantMatiere($_GET['bfmw_num_delm'],$_GET['bfmw_num_dela'],$_GET['bfmw_num_dele']) === 1) {
        makeErreur("success", "Retrait d'un enseignant d'une matière", "L'affectation de l'enseignant a été supprimée avec succès.");
    } else {
        makeErreur("", "Retrait d'un enseignant d'une matière", "L'affectation de l'enseignant n'a pas été supprimée. Contactez le responsable de formation");
    }

    $param = "&a=".$_GET['bfmw_num_dela']."&e=".$_GET['bfmw_num_dele']."&m=".$_GET['bfmw_num_delm']."&s=".$_GET['bfmw_num_s'];
}

/**
 * Recopie des affectations d'un enseignant à une matière
 */
if (isset($_GET['bfmw_orig_a1']) && isset($_GET['bfmw_orig_copie']) && isAdmin() && $_GET['bfmw_orig_p2'] == "gererenseignant") {
    mysql_start_transaction();
    if (Formations::recopierVersAnneeSuivante($_GET['bfmw_num_a1'])) {
        makeErreur("success", "Recopie des affectations", "La recopie a été effectuée avec succès.");
    } else {
        makeErreur("", "Recopie des affectations", "La recopie n'a pas été effectuée.");
    }

    $param = "&a=".$_GET['bfmw_num_a1']."&s=".$_GET['bfmw_num_s'];;
}