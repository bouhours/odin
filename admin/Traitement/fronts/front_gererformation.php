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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
/*****************************************************************
 * GERER FORMATION ***********************************************
 *****************************************************************/
/**
 * Création des éléments d'une formation
 */

if (isset($_GET['bfmw_orig_t'])) {
    $id = 0;
    $message = $_GET['bfmw_orig_t'];
    switch ($_GET['bfmw_orig_t']) {
        case "departement" :
            if (isAdmin()) {
                if (Departements::creerDepartement($_POST)) {
                    $id = 1;
                } else {
                    $id = 0;
                }
                $message = "département";
            }
            break;
        case "formation" :
            if (Formations::isSecretaire() || Formations::isChef() || isAdmin()) {
                bfmw_add_secured($_POST,"*FORM_START_ANNEE_ID",$annee_courante);
                $id = createData("common_formation", $_POST, 3);
                $req = "INSERT INTO common_responsable_formation(RESPONSABLE_FORM_ID, RESPONSABLE_ENS_ID) VALUES ($id,".CURRENT_ID.")";
                $conn->query($req);
            }
            break;
        case "semestre" :
            if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f'])  || isAdmin()) {
                $ordre_max = Formations::getOrdreMaxSemestre($_GET['bfmw_num_f'],$annee_courante);
                bfmw_add_secured($_POST,"*SEM_ORDRE",$ordre_max+1);
                $id = createData("common_semestre", $_POST, 5);
            }
            break;
        case "ue" :
            if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f'])  || isAdmin()) {
                $ordre_max = Formations::getOrdreMaxUe($_POST['bfmw_num_*UE_SEM_ID'],$annee_courante);
                bfmw_add_secured($_POST,"*UE_ORDRE",$ordre_max+1);
                $id = createData("common_ue", $_POST, 5);
            }

            break;
        case "matiere" :
            if (isset($_POST['bfmw_orig_UE_MAT'])) {
                $extract = explode("$", $_POST['bfmw_orig_UE_MAT']);
                bfmw_add_secured($_POST,"*MAT_UE_ID",$extract[0]);
                bfmw_add_secured($_POST,"*MAT_SURMAT_ID",$extract[1]);
                bfmw_add_secured($_POST,"*MAT_LOCK_ANNEE_ID",$annee_courante-1);
                $ordre_max = Formations::getOrdreMaxMatSurMat($extract[1],$annee_courante);
            } else {
                if (isset($_POST['bfmw_num_*MAT_UE_ID'])) {
                    $ordre_max = Formations::getOrdreMaxMat($_POST['bfmw_num_*MAT_UE_ID'], $annee_courante);
                } else {
                    break;
                }

            }

            if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
                bfmw_add_secured($_POST,"*MAT_ORDRE",$ordre_max+1);
                $id = createData("common_matiere", $_POST, 8);
                $message = "module";
                if ($id <= 0) {
                    $id = createData("common_matiere", $_POST, 9);
                    $message = "matière";
                }
            }

            break;
    }

    $param .= (isset($_GET['bfmw_num_f'])?("&f=" . $_GET['bfmw_num_f']):"")."&a=".$_GET['bfmw_num_a'];

    if ($id > 0) {
        makeErreur("success", "Création de : " . $_GET['bfmw_orig_t'], "Création effectuée");
    } else {
        makeErreur("", "Création de : " . $_GET['bfmw_orig_t'], "Echec création");
    }
}

/**
 * Upload d'une maquette complète
 */

if (isset($_GET['bfmw_orig_generateur']) && isset($_FILES["FICHIER_MODELE"]) && $_FILES['FICHIER_MODELE']["name"]!="") {
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        $contenu_du_fichier = file_get_contents($_FILES['FICHIER_MODELE']["tmp_name"]);
        $tableau_de_lignes = explode("\n", $contenu_du_fichier);
        try {
            if (Formations::importMaquette($tableau_de_lignes, $_GET['bfmw_num_f'], $_GET['bfmw_num_a'])) {
                makeErreur("success", "Import de la maquette", "Import effectué");
            } else {
                throw new Exception("Return false");
            }
        } catch (Exception $e) {
            makeErreur("", "Import de la maquette", "Erreur lors de l'import");
        }
    } else {
        makeErreur("", "Import de la maquette", "Vous n'êtes pas autorisé à faire cet import");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression d'une matière
 */
if (isset($_GET['bfmw_orig_delmatiere'])) {
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        $req = "DELETE FROM common_matiere WHERE MAT_ID=" . $_GET['bfmw_num_delmatiere'];
        $conn->query($req);
        if ($conn->affected_rows === 1) {
            makeErreur("success", "Suppression d'une matière", "Suppression effectuée");
        } else {
            makeErreur("", "Suppression d'une matière", "Erreur lors de la suppression d'une matière");
        }
    } else {
        makeErreur("", "Suppression d'une matière", "Erreur lors de la suppression d'une matière");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression d'un semestre
 */
if (isset($_GET['bfmw_orig_delsemestre'])) {
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        $req = "DELETE FROM common_semestre WHERE SEM_ID=" . $_GET['bfmw_num_delsemestre'];
        $conn->query($req);
        if ($conn->affected_rows > 0) {
            makeErreur("success", "Suppression d'un semestre", "Suppression effectuée");
        } else {
            makeErreur("", "Suppression d'un semestre", "Erreur lors de la suppression d'un semestre");
        }
    } else {
        makeErreur("", "Suppression d'un semestre", "Erreur lors de la suppression d'un semestre");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Suppression d'une ue
 */
if (isset($_GET['bfmw_orig_delue'])) {
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        $req = "DELETE FROM common_ue WHERE UE_ID=" . $_GET['bfmw_num_delue'];
        $conn->query($req);
        if ($conn->affected_rows > 0) {
            makeErreur("success", "Suppression d'une ue", "Suppression effectuée");
        } else {
            makeErreur("", "Suppression d'une ue", "Erreur lors de la suppression d'une ue");
        }
    } else {
        makeErreur("", "Suppression d'une ue", "Erreur lors de la suppression d'une ue");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];

}

/**
 * Suppression d'une formation
 */
if (isset($_GET['bfmw_orig_delformation'])) {
    if (Formations::isSecretaire() || Formations::isChef() || isAdmin()) {
        $req = "DELETE FROM common_formation WHERE FORM_ID=" . $_GET['bfmw_num_delformation'];
        $conn->query($req);
        if ($conn->affected_rows > 0) {
            makeErreur("success", "Suppression d'une formation", "Suppression effectuée");
        } else {
            makeErreur("", "Suppression d'une formation", "Erreur lors de la suppression d'une formation");
        }
    } else {
        makeErreur("", "Suppression d'une formation", "Erreur lors de la suppression d'une formation");
    }
    if (isset($_GET['bfmw_num_f'])) {
        $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
    }
}

/**
 * Suppression d'un département
 */
if (isset($_GET['bfmw_orig_deldepartement']) && isAdmin()) {
    if (Departements::supprimerDepartement($_GET['bfmw_orig_deldepartement'],CURRENT_DEPT)) {
        makeErreur("success", "Suppression d'un département", "Suppression effectuée");
    } else {
        makeErreur("", "Suppression d'un département", "Erreur lors de la suppression d'un département");
    }
    if (isset($_GET['bfmw_num_f'])) {
        $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
    }
}


/**
 * Masquage d'une matière
 */
if (isset($_GET['bfmw_orig_hidematiere']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        if (Formations::HideMatieres($_GET['bfmw_num_hidematiere'], $_GET['bfmw_num_a'])) {
            makeErreur("success", "Retrait d'une matière de la maquette", "Suppression effectuée");
            mysql_commit();
        } else {
            makeErreur("", "Retrait d'une matière de la maquette", "Erreur lors de la suppression d'une matière");
            mysql_rollback();
        }
    } else {
        makeErreur("", "Retrait d'une matière de la maquette", "Erreur lors de la suppression d'une matière");
        mysql_rollback();
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Switch d'une matière
 */
if (isset($_GET['bfmw_orig_switchmatiere']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        if (Formations::SwitchMatieres($_GET['bfmw_num_switchmatiere'], $_GET['bfmw_num_a'])) {
            makeErreur("success", "Réactivation d'une matière", "Réactivation effectuée");
            mysql_commit();
        } else {
            makeErreur("", "Réactivation d'une matière", "Erreur lors de la réactivation d'une matière");
            mysql_rollback();
        }
    } else {
        makeErreur("", "Réactivation d'une matière", "Erreur lors de la réactivation d'une matière");
        mysql_rollback();
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Masquage d'une formation
 */
if (isset($_GET['bfmw_orig_hideformation']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_hideformation']) || Formations::isResponsableFormation($_GET['bfmw_num_hideformation']) || Formations::isChefFormation($_GET['bfmw_num_hideformation']) || isAdmin()) {
        if (Formations::HideFormations($_GET['bfmw_num_hideformation'],$_GET['bfmw_num_a'])) {
            makeErreur("success", "Retrait d'une formation de la maquette", "Suppression effectuée");
            mysql_commit();
        } else {
            mysql_rollback();
            makeErreur("", "Retrait d'une formation de la maquette", "Erreur lors de la suppression d'une formation");
        }
    } else {
        mysql_rollback();
        makeErreur("", "Retrait d'une formation de la maquette", "Erreur lors de la suppression d'une formation");
    }

    $param .= "&f=" . $_GET['bfmw_orig_hideformation'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Masquage d'un semestre
 */
if (isset($_GET['bfmw_orig_hidesemestre']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        if (Formations::HideSemestres($_GET['bfmw_num_hidesemestre'],$_GET['bfmw_orig_a'])) {
            makeErreur("success", "Retrait d'un semestre de la maquette", "Suppression effectuée");
            mysql_commit();
        } else {
            mysql_rollback();
            makeErreur("", "Retrait d'un semestre de la maquette", "Erreur lors de la suppression d'un semestre");
        }
    } else {
        mysql_rollback();
        makeErreur("", "Retrait d'un semestre de la maquette", "Erreur lors de la suppression d'un semestre");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Switch d'un semestre
 */
if (isset($_GET['bfmw_orig_switchsemestre']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        if (Formations::SwitchSemestres($_GET['bfmw_num_switchsemestre'],$_GET['bfmw_orig_a'])) {
            makeErreur("success", "Réactivation d'un semestre", "Réactivation effectuée");
            mysql_commit();
        } else {
            mysql_rollback();
            makeErreur("", "Réactivation d'un semestre", "Erreur lors de la réactivation d'un semestre");
        }
    } else {
        mysql_rollback();
        makeErreur("", "Réactivation d'un semestre", "Erreur lors de la réactivation d'un semestre");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Masquage d'une ue
 */
if (isset($_GET['bfmw_orig_hideue']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        if (Formations::HideUEs( $_GET['bfmw_num_hideue'],$_GET['bfmw_num_a'])) {
            makeErreur("success", "Retrait d'une ue de la maquette", "Suppression effectuée");
            mysql_commit();
        } else {
            makeErreur("", "Retrait d'une ue de la maquette", "Erreur lors de la suppression d'une ue");
            mysql_rollback();
        }
    } else {
        makeErreur("", "Retrait d'une ue de la maquette", "Erreur lors de la suppression d'une ue");
        mysql_rollback();
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Switch d'une ue
 */
if (isset($_GET['bfmw_orig_switchue']) && isset($_GET['bfmw_orig_a'])) {
    mysql_start_transaction();
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        if (Formations::SwitchUEs( $_GET['bfmw_num_switchue'],$_GET['bfmw_num_a'])) {
            makeErreur("success", "Réactivation d'une UE", "Réactivation effectuée");
            mysql_commit();
        } else {
            makeErreur("", "Réactivation d'une UE", "Erreur lors de la réactivation d'une ue");
            mysql_rollback();
        }
    } else {
        makeErreur("", "Réactivation d'une UE", "Erreur lors de la réactivation d'une ue");
        mysql_rollback();
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}

/**
 * Deplacement d'un élément
 */
if (isset($_GET['bfmw_orig_po']) && isset($_GET['bfmw_orig_down']) && isset($_GET['bfmw_orig_move']) && isset($_GET['bfmw_orig_tu'])) {
    if (Formations::isSecretaireFormation($_GET['bfmw_num_f']) || Formations::isResponsableFormation($_GET['bfmw_num_f']) || Formations::isChefFormation($_GET['bfmw_num_f']) || isAdmin()) {
        $table = "";
        $prefixe = "";
        $identifier = "";
        switch ($_GET['bfmw_orig_tu']) {
            case "sem" :
                $table = "common_semestre";
                $prefixe = "SEM";
                $identifier = "SEM_FORM_ID";
                break;
            case "ue" :
                $table = "common_ue";
                $prefixe = "UE";
                $identifier = "UE_SEM_ID";
                break;
            case "matue" :
                $table = "common_matiere";
                $prefixe = "MAT";
                $identifier = "MAT_UE_ID";
                break;
            case "matmod" :
                $table = "common_matiere";
                $prefixe = "MAT";
                $identifier = "MAT_SURMAT_ID";
                break;
        }


        if (Formations::deplacerElement($table,$prefixe,$identifier, $_GET['bfmw_num_u'],$_GET['bfmw_num_move'],$_GET['bfmw_num_down'],$_GET['bfmw_num_po'],$annee_courante)) {
            makeErreur("success", "Déplacement", "Déplacement effectué");
        } else {
            makeErreur("", "Déplacement", "Erreur lors du déplacement");
        }
    } else {
        makeErreur("", "Déplacement", "Erreur lors du déplacement");
    }

    $param .= "&f=" . $_GET['bfmw_num_f'] . "&a=".$_GET['bfmw_num_a'];
}