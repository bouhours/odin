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
 * Créer créneaux automatiquement
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="planning" && isset($_POST['bfmw_orig_auto']) && isset($_POST['bfmw_num_DEPARTEMENT_ID'])) {
    if (! Departements::isInDepartement(CURRENT_ID,$_POST['bfmw_num_DEPARTEMENT_ID'])) {
        makeErreur("", "Création d'un planning", "Erreur, piratage détecte !");
    } else {
        $id = Plannings::genererCreneauxAutomatiquement($_POST);
        if ($id > 0) {
            makeErreur("success", "Création des créneaux", "Les créneaux ont été créés avec succès.");
        } else {
            makeErreur("", "Création des créneaux", "Il y a eu une erreur lors de la création des créneaux.");
        }
    }

    $param .= "&amp;a=".$_POST['bfmw_num_PLANNING_ANNEE_ID'];
}

/**
 * Créer planning
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="planning" && isset($_POST['bfmw_orig_creer_planning']) && isset($_POST['bfmw_num_*PLANNING_DEPT_ID'])) {
    if (! Departements::isInDepartement(CURRENT_ID,$_POST['bfmw_num_*PLANNING_DEPT_ID'])) {
        makeErreur("", "Création d'un planning", "Erreur, piratage détecte !");
    } else {
        bfmw_add_secured($_POST,"*PLANNING_UID",uniqid("",true));
        $id = Plannings::creerPlanning($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'un planning", "Le planning a été créé avec succès.");
        } else {
            makeErreur("", "Création d'un planning", "Il y a eu une erreur lors de la création du planning.");
        }
    }

    $param .= "&amp;a=".$_POST['bfmw_num_*PLANNING_ANNEE_ID'];
}


/**
 * Supprimer planning
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="planning" && isset($_GET['bfmw_orig_delplan']) && isset($_GET['bfmw_orig_d'])) {
    if (! Departements::isInDepartement(CURRENT_ID,$_GET['bfmw_num_d'])) {
        makeErreur("", "Suppression d'un planning", "Erreur, piratage détecte !");
    } else {
        if (Plannings::supprimerPlanning($_GET['bfmw_num_delplan'])) {
            makeErreur("success", "Suppression d'un planning", "Le planning a été suppimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un planning", "Il y a eu une erreur lors de la suppression du planning.");
        }
    }
    $param .= "&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer créneau
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="planning" && isset($_GET['bfmw_orig_delcre']) && isset($_GET['bfmw_orig_d'])) {
    if (! Departements::isInDepartement(CURRENT_ID,$_GET['bfmw_num_d'])) {
        makeErreur("", "Suppression d'un créneau", "Erreur, piratage détecte !");
    } else {
        if (Plannings::supprimerCreneau($_GET['bfmw_num_delcre'])) {
            makeErreur("success", "Suppression d'un créneau", "Le créneau a été supprimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un créneau", "Il y a eu une erreur lors de la suppression d'un créneau.");
        }
    }
    $param .= "&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer rdv
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="planning" && isset($_POST['bfmw_orig_to_del']) && isset($_POST['bfmw_num_RDV_ID'])) {
    if (! Departements::isInDepartement(CURRENT_ID,$_POST['bfmw_num_d'])) {
        makeErreur("", "Suppression d'un créneau", "Erreur, piratage détecte !");
    } else {
        mysql_start_transaction();
        if (Plannings::supprimerRDV($_POST['bfmw_num_RDV_ID']) == 1) {
            mysql_commit();
            makeErreur("success", "Suppression d'un créneau", "Le créneau a été supprimé avec succès.");
        } else {
            mysql_rollback();
            makeErreur("", "Suppression d'un créneau", "Il y a eu une erreur lors de la suppression d'un créneau.");
        }
    }
    $param .= "&amp;a=".$_POST['bfmw_num_a'];
}