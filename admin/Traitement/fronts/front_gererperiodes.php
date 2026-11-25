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
 * PERIODES ******************************************************
 *****************************************************************/
/**
 * Création d'une période
 */

if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "periodes" && isset($_POST['bfmw_orig_create_periode'])) {
    $id = createData("common_edt_periode", $_POST, 4);
    if ($id > 0) {
        makeErreur("success", "Création d'une période", "La période a été créée avec succès.");
    } else {
        makeErreur("", "Création d'une période", "Il y a eu une erreur lors de la création de la période. Contactez Cédric BOUHOURS (cedric.bouhours@uca.fr)");
    }
}

/**
 * Suppression d'une période
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "periodes" && isset($_GET['bfmw_orig_delperiode'])) {
    $req = "SELECT * FROM common_periodes_matieres WHERE MAT_PERIODE_ID=".$_GET['bfmw_orig_delperiode'];
    if ($conn->query($req)->num_rows>0) {
        makeErreur("", "Suppression d'une période", "Impossible de supprimer la période.");
    } else {
        $req = "DELETE FROM common_edt_periode WHERE PERIODE_ID=".$_GET['bfmw_orig_delperiode'];
        $conn->query($req);
        if ($conn->affected_rows == 1) {
            makeErreur("success", "Suppression d'une période", "La période a été supprimée avec succès.");
        } else {
            makeErreur("", "Suppression d'une période", "Il y a eu une erreur lors de la suppression de la période. Contactez Cédric BOUHOURS (cedric.bouhours@uca.fr)");
        }

    }
}