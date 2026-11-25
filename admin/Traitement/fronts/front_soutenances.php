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
 * Créer session
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_session'])) {
    if (! array_key_exists($_POST['bfmw_num_*SESSION_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_*SESSION_ANNEE_ID']))) {
        makeErreur("", "Création d'une session", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerSession($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'une session", "La session a été créée avec succès.");
        } else {
            makeErreur("", "Création d'une session", "Il y a eu une erreur lors de la création d'une session.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_*SESSION_FORM_ID']."&amp;a=".$_POST['bfmw_num_*SESSION_ANNEE_ID'];
}

/**
 * Créer créneaux automatiquement
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_auto'])) {
    if (! array_key_exists($_POST['bfmw_num_FORMATION_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_PLANNING_ANNEE_ID']))) {
        makeErreur("", "Création d'un planning", "Erreur, piratage détecte !");
    } else {
        $id = Soutenances::genererCreneauxAutomatiquement($_POST);
        if ($id > 0) {
            makeErreur("success", "Création des créneaux", "Les créneaux ont été créés avec succès.");
        } else {
            makeErreur("", "Création des créneaux", "Il y a eu une erreur lors de la création des créneaux.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_FORMATION_ID']."&amp;a=".$_POST['bfmw_num_PLANNING_ANNEE_ID'];
}

/**
 * Créer planning
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_planning'])) {
    if (! array_key_exists($_POST['bfmw_num_FORMATION_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_*PLANNING_ANNEE_ID']))) {
        makeErreur("", "Création d'un planning", "Erreur, piratage détecte !");
    } else {
        $id = Soutenances::creerPlanning($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'un planning", "Le planning a été créé avec succès.");
        } else {
            makeErreur("", "Création d'un planning", "Il y a eu une erreur lors de la création du planning.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_FORMATION_ID']."&amp;a=".$_POST['bfmw_num_*PLANNING_ANNEE_ID'];
}

/**
 * Recopier session
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_copier_session']) && isset($_POST['bfmw_orig_SESSION_SOURCE']) && isset($_POST['bfmw_orig_SESSION_DEST']) && isset($_POST['bfmw_orig_SESSION_FORM_ID'])) {
    if (! array_key_exists($_POST['bfmw_num_SESSION_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_SESSION_ANNEE_ID']))) {
        makeErreur("", "Copie d'une session", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::copierSession($_POST['bfmw_num_SESSION_SOURCE'],$_POST['bfmw_num_SESSION_DEST'],$_POST['bfmw_num_SESSION_FORM_ID']);
        if ($id > 0) {
            makeErreur("success", "Copie d'une session", "La session a été copiée avec succès.");
        } else {
            makeErreur("", "Copie d'une session", "Il y a eu une erreur lors de la copie d'une session.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_SESSION_FORM_ID']."&amp;a=".$_POST['bfmw_num_SESSION_ANNEE_ID'];
}

/**
 * Créer destination
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_destination'])) {
    if (! array_key_exists($_POST['bfmw_num_*DEST_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("", "Création d'une destination", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerDestination($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'une destination", "La destination a été créée avec succès.");
        } else {
            makeErreur("", "Création d'une destination", "Il y a eu une erreur lors de la création d'une destination.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_*DEST_FORM_ID']."&amp;a=".$_POST['bfmw_num_ANNEE_ID'];
}

/**
 * Créer section
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_section'])) {
    if (! array_key_exists($_POST['bfmw_num_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("", "Création d'une section", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerSection($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'une section", "La section a été créée avec succès.");
        } else {
            makeErreur("", "Création d'une section", "Il y a eu une erreur lors de la création d'une section.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_FORM_ID']."&amp;a=".$_POST['bfmw_num_ANNEE_ID'];
}

/**
 * Créer niveau
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_niveau'])) {
    if (! array_key_exists($_POST['bfmw_num_*NIVEAU_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("", "Création d'un niveau", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerNiveau($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'un niveau", "Le niveau a été créé avec succès.");
        } else {
            makeErreur("", "Création d'un niveau", "Il y a eu une erreur lors de la création d'un niveau.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_*NIVEAU_FORM_ID']."&amp;a=".$_POST['bfmw_num_ANNEE_ID'];
}

/**
 * Créer critère
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_critere'])) {
    if (! array_key_exists($_POST['bfmw_num_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("", "Création d'un critère", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerCritere($_POST);
        if ($id > 0) {
            makeErreur("success", "Création d'un critère", "Le critère a été créé avec succès.");
        } else {
            makeErreur("", "Création d'un critère", "Il y a eu une erreur lors de la création d'un critère.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_FORM_ID']."&amp;a=".$_POST['bfmw_num_ANNEE_ID'];
}

/**
 * Créer explications
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_creer_explication'])) {
    if (! array_key_exists($_POST['bfmw_num_FORM_ID'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_ANNEE_ID']))) {
        makeErreur("", "Création d'une explication", "Erreur, piratage détecte !");
    } else {
        $id = Notation_Soutenances::creerExplication($_POST);

        if ($id > 0) {
            makeErreur("success", "Création d'une explication", "L'explication a été créée avec succès.");
        } else {
            makeErreur("", "Création d'une explication", "Il y a eu une erreur lors de la création d'une explication.");
        }
    }

    $param .= "&amp;f=".$_POST['bfmw_num_FORM_ID']."&amp;a=".$_POST['bfmw_num_ANNEE_ID'];
}

/**
 * Supprimer sessions
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_delses']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'une session", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::supprimerSession($_GET['bfmw_num_delses'])) {
            makeErreur("success", "Suppression d'une session", "La session a été suppimée avec succès.");
        } else {
            makeErreur("", "Suppression d'une session", "Il y a eu une erreur lors de la suppression d'une session.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer planning
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_delplan']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'un planning", "Erreur, piratage détecte !");
    } else {
        if (Soutenances::supprimerPlanning($_GET['bfmw_num_delplan'])) {
            makeErreur("success", "Suppression d'un planning", "Le planning a été suppimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un planning", "Il y a eu une erreur lors de la suppression du planning.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer créneau
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_delcre']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'un créneau", "Erreur, piratage détecte !");
    } else {
        if (Soutenances::supprimerCreneau($_GET['bfmw_num_delcre'])) {
            makeErreur("success", "Suppression d'un créneau", "Le créneau a été supprimé avec succès.");
        } else {
            makeErreur("", "Suppression d'un créneau", "Il y a eu une erreur lors de la suppression d'un créneau.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer destination
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_deld']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'une destination", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::supprimerDestination($_GET['bfmw_num_deld'])) {
            makeErreur("success", "Suppression d'une destination", "La destination a été suppimée avec succès.");
        } else {
            makeErreur("", "Suppression d'une destination", "Il y a eu une erreur lors de la suppression d'une destination.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer section
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_dels']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'une section", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::supprimerSection($_GET['bfmw_num_dels'])) {
            makeErreur("success", "Suppression d'une section", "La section a été suppimée avec succès.");
        } else {
            makeErreur("", "Suppression d'une section", "Il y a eu une erreur lors de la suppression d'une section.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer niveau
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_deln']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'un niveau", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::supprimerNiveau($_GET['bfmw_num_deln'])) {
            makeErreur("success", "Suppression d'un niveau", "Le niveau a été suppimée avec succès.");
        } else {
            makeErreur("", "Suppression d'un niveau", "Il y a eu une erreur lors de la suppression d'un niveau.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer critère
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_delc']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'un critère", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::supprimerCritere($_GET['bfmw_num_delc'])) {
            makeErreur("success", "Suppression d'un critère", "Le critère a été suppimée avec succès.");
        } else {
            makeErreur("", "Suppression d'un critère", "Il y a eu une erreur lors de la suppression d'un critère.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Supprimer explication
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_GET['bfmw_orig_dele1']) && isset($_GET['bfmw_orig_dele2']) && isset($_GET['bfmw_orig_f'])) {
    if (! array_key_exists($_GET['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_GET['bfmw_num_a']))) {
        makeErreur("", "Suppression d'une section", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::supprimerExplication($_GET['bfmw_num_dele1'],$_GET['bfmw_num_dele2'])) {
            makeErreur("success", "Suppression d'une explication", "L'explication' a été suppimée avec succès.");
        } else {
            makeErreur("", "Suppression d'une explication", "Il y a eu une erreur lors de la suppression d'une explication.");
        }
    }
    $param .= "&amp;f=".$_GET['bfmw_num_f']."&amp;a=".$_GET['bfmw_num_a'];
}

/**
 * Publier les notes
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="soutenances" && isset($_POST['bfmw_orig_MAT_ID']) && isset($_POST['bfmw_orig_session']) && isset($_POST['bfmw_orig_f']) && isset($_POST['bfmw_orig_a'])) {
    if (! array_key_exists($_POST['bfmw_num_f'],Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$_POST['bfmw_num_a']))) {
        makeErreur("", "Publication d'une note", "Erreur, piratage détecte !");
    } else {
        if (Notation_Soutenances::publierNotes($_POST['bfmw_num_MAT_ID'],$_POST['bfmw_num_session'],$_POST['bfmw_num_f'],$_POST['bfmw_num_a'],isset($_POST['bfmw_orig_detail']))) {
            makeErreur("success", "Publication d'une note", "Les notes ont été publiées avec succès.");
        } else {
            makeErreur("", "Publication d'une note", "Il y a eu une erreur lors de la publication des notes.");
        }
    }
    $param .= "&amp;f=".$_POST['bfmw_num_f']."&amp;a=".$_POST['bfmw_num_a'];
}