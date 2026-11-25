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

/*****************************************************************
 * GERER ETUDIANT ************************************************
 *****************************************************************/
/**
 * Rechercher login
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gereretudiants" && isset($_POST['bfmw_orig_logins']) && isAdmin()) {
    require_once 'Traitement/ldap.php';
    $req = "SELECT * FROM common_etudiant WHERE ET_LOGIN = '' ORDER BY ET_NOM";
    $res = $conn->query($req);
    while ($un_etudiant = $res->fetch_assoc()) {
        if ($un_etudiant['ET_LOGIN'] != "") {
            $req = "UPDATE common_etudiant SET ET_LOGIN='" . Ldap::ldap_recherche_login_etudiant($un_etudiant['ET_MAIL']) . "' WHERE ET_ID=" . $un_etudiant['ET_ID'];
            $conn->query($req);
        }
    }
}

/**
 * Démission d'un étudiant
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gereretudiants" && isset($_GET['bfmw_orig_dem']) && isset($_GET['bfmw_orig_e'])) {
    $req = "SELECT * FROM common_inscription,common_semestre,common_formation,common_responsable_formation,common_departement WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND DEPT_ID=FORM_DEPT_ID AND FORM_ID=SEM_FORM_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ET_ID=".$_GET['bfmw_num_e']." AND (RESPONSABLE_ENS_ID=".CURRENT_ID." OR DEPT_ENS_ID=".CURRENT_ID.") AND FORM_ID=RESPONSABLE_FORM_ID GROUP BY INSCRIPT_ET_ID";
    if ($conn->query($req)->num_rows == 1 || isAdmin() || Formations::isSecretaire()) {
        mysql_start_transaction();
        $req = "DELETE FROM common_etudiant_groupes WHERE GROUPE_ET_ID=".$_GET['bfmw_num_e'];
        $conn->query($req);
        $req = "UPDATE common_etudiant SET ET_DEM=1 WHERE ET_ID=" . $_GET['bfmw_num_e'];
        $conn->query($req);

        if ($conn->affected_rows > 0) {
            mysql_commit();
            makeErreur("success", "Déclarer un étudiant démissionnaire", "L'étudiant a été déclaré démissionnaire");
        } else {
            mysql_rollback();
            makeErreur("", "Déclarer un étudiant démissionnaire", "Une erreur est survenue lors de la déclaration de l'étudiant. Contactez le responsable de formation.");
        }
    } else {
        makeErreur("", "Déclarer un étudiant démissionnaire", "Piratage détecté");
    }

    $param .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a']."&e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e'];;
}

/**
 * Suppression d'un étudiant
 */
if (isset($_GET['bfmw_orig_deletu']) && isAdmin()) {
    $req = "DELETE FROM common_etudiant WHERE ET_ID=" . $_GET['bfmw_num_deletu'];
    $conn->query($req);
    if ($conn->affected_rows === 1) {
        makeErreur("success", "Suppression d'un étudiant", "L'étudiant a été supprimé avec succès");
    } else {
        makeErreur("", "Suppression d'un étudiant", "Une erreur est survenue lors de la suppression de l'étudiant. Contactez le responsable de formation.");
    }
}

/**
 * Rapatriement des notes de l'année précédente
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gereretudiants" && isset($_GET['bfmw_orig_retrieve']) && isset($_GET['bfmw_orig_e'])) {
/*
    $annee_courante = Annees::getIdAnneeCourante();

    $req = "SELECT * FROM common_dispense_ue WHERE DISP_ET_ID=".$_GET['bfmw_num_e']." AND DISP_UE_ID=".$_GET['bfmw_num_retrieve'];
    $res = $conn->query($req);
    $total = $res->num_rows;
    if ($res->num_rows != 1) {
        makeErreur("","Rapatriement des notes de l'année précédente","Impossible de récupérer les notes car l'étudiant n'est pas dispensé de l'UE.");
    } else {
        mysql_start_transaction();
        $req = "SELECT * FROM common_matiere WHERE MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND MAT_HAS_NOTE=1 AND MAT_UE_ID=".$_GET['bfmw_orig_retrieve'];
        $resMAT = $conn->query($req);
        while ($une_matiere = $resMAT->fetch_assoc()) {
            $req = "INSERT INTO common_controle(CONTROLE_NOM, CONTROLE_MAT_ID, CONTROLE_VALIDE, CONTROLE_MOYENNE, CONTROLE_VISIBLE, CONTROLE_ANNEE_ID, CONTROLE_ENS_ID) VALUES ('Rapatriement de l\'année précédente', ".$une_matiere['MAT_ID'].", 1, '1', 0,$annee_courante, ".CURRENT_ID.")";
            $conn->query($req);
            if ($conn->affected_rows != 1) {
                mysql_rollback();
                makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°25. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                break;
            } else {
                $id_controle = $conn->insert_id;
                $req = "SELECT * FROM common_clotures_moyennes_matiere WHERE MOYMAT_MAT_ID=".$une_matiere['MAT_ID']." AND MOYMAT_ET_ID=".$_GET['bfmw_num_e']." AND MOYMAT_ANNEE_ID=$annee_courante-1";
                $resMOY = $conn->query($req);
                if ($resMOY->num_rows != 1 && $resMOY->num_rows != 0) {
                    mysql_rollback();
                    makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°30. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                    break;
                } else if ($resMOY->num_rows != 0) {
                    $moyenne = $resMOY->fetch_assoc();
                    $req = "INSERT INTO common_notes(NOTES_CONTROLE_ID, NOTES_ET_ID, NOTES_VALEUR) VALUES ($id_controle,".$_GET['bfmw_num_e'].",".$moyenne['MOYMAT_VALEUR'].")";
                    $conn->query($req);
                    if ($conn->affected_rows != 1) {
                        mysql_rollback();
                        makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°101. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                        break;
                    }
                }
            }

        }

        if (!isErreur()) {
            mysql_commit();
            makeErreur("success","Rapatriement des notes de l'année précédente","Toutes les notes ont été rapatriées.");
        }
    }*/


    $param .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a']."&e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e'];
}

/**
 * Rapatriement des notes de l'année précédente par matière
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gereretudiants" && isset($_GET['bfmw_orig_retrieveMAT']) && isset($_GET['bfmw_orig_e'])) {

    $req = "SELECT * FROM common_dispense_matieres WHERE DISP_ET_ID=".$_GET['bfmw_num_e']." AND DISP_MAT_ID=".$_GET['bfmw_num_retrieveMAT'];
    $res = $conn->query($req);
    $total = $res->num_rows;
    if ($res->num_rows != 1) {
        makeErreur("","Rapatriement des notes de l'année précédente","Impossible de récupérer les notes car l'étudiant n'est pas dispensé de la matière.");
    } else {
        mysql_start_transaction();
            $req = "INSERT INTO common_controle(CONTROLE_NOM, CONTROLE_MAT_ID, CONTROLE_VALIDE, CONTROLE_MOYENNE, CONTROLE_VISIBLE, CONTROLE_ANNEE_ID, CONTROLE_ENS_ID) VALUES ('Rapatriement de l\'année précédente', ".$_GET['bfmw_orig_retrieveMAT'].", 1, '1', 0,$annee_courante, ".CURRENT_ID.")";
            $conn->query($req);
                $id_controle = $conn->insert_id;
                $req = "SELECT * FROM common_clotures_moyennes_matiere WHERE MOYMAT_MAT_ID=".$_GET['bfmw_orig_retrieveMAT']." AND MOYMAT_ET_ID=".$_GET['bfmw_num_e']." AND MOYMAT_ANNEE_ID=$annee_courante-1";
                $resMOY = $conn->query($req);
                if ($resMOY->num_rows != 1 && $resMOY->num_rows != 0) {
                    mysql_rollback();
                    makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°230. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                } else if ($resMOY->num_rows != 0) {
                    $moyenne = $resMOY->fetch_assoc();
                    $req = "INSERT INTO common_notes(NOTES_CONTROLE_ID, NOTES_ET_ID, NOTES_VALEUR) VALUES ($id_controle,".$_GET['bfmw_num_e'].",".$moyenne['MOYMAT_VALEUR'].")";
                    $conn->query($req);
                    if ($conn->affected_rows != 1) {
                        mysql_rollback();
                        makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°2101. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                    }
                } else {
                    mysql_rollback();
                    makeErreur("warning","Rapatriement des notes de l'année précédente","Aucune note à recopier !");
                }

        if (!isErreur()) {
            mysql_commit();
            makeErreur("success","Rapatriement des notes de l'année précédente","Toutes les notes ont été rapatriées.");
        }
    }


    $param .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a']."&e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e'];
}

/**
 * Rapatriement des notes de l'année précédente par semestre
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gereretudiants" && isset($_GET['bfmw_orig_retrieveSEM']) && isset($_GET['bfmw_orig_e'])) {

    $annee_courante = $_GET['bfmw_num_a']+1;

        mysql_start_transaction();
        $req = "SELECT * FROM common_matiere,common_semestre,common_ue WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND MAT_HAS_NOTE=1 AND SEM_ID=".$_GET['bfmw_num_retrieveSEM'];
        $resMAT = $conn->query($req);
        while ($une_matiere = $resMAT->fetch_assoc()) {
            $req = "INSERT INTO common_controle(CONTROLE_NOM, CONTROLE_MAT_ID, CONTROLE_VALIDE, CONTROLE_MOYENNE, CONTROLE_VISIBLE, CONTROLE_ANNEE_ID, CONTROLE_ENS_ID) VALUES ('Rapatriement de l\'année précédente', ".$une_matiere['MAT_ID'].", 1, '1', 0,$annee_courante, ".CURRENT_ID.")";
            $conn->query($req);
            if ($conn->affected_rows != 1) {
                mysql_rollback();
                makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°325. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                break;
            } else {
                $id_controle = $conn->insert_id;
                $req = "SELECT * FROM common_clotures_moyennes_matiere WHERE MOYMAT_MAT_ID=".$une_matiere['MAT_ID']." AND MOYMAT_ET_ID=".$_GET['bfmw_num_e']." AND MOYMAT_ANNEE_ID=$annee_courante-1";
                $resMOY = $conn->query($req);
                if ($resMOY->num_rows != 1 && $resMOY->num_rows != 0) {
                    mysql_rollback();
                    makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°330. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                    break;
                } else if ($resMOY->num_rows != 0) {
                    $moyenne = $resMOY->fetch_assoc();
                    $req = "INSERT INTO common_notes(NOTES_CONTROLE_ID, NOTES_ET_ID, NOTES_VALEUR) VALUES ($id_controle,".$_GET['bfmw_num_e'].",".$moyenne['MOYMAT_VALEUR'].")";
                    $conn->query($req);
                    if ($conn->affected_rows != 1) {
                        mysql_rollback();
                        makeErreur("","Rapatriement des notes de l'année précédente","Erreur n°3101. Contactez Cédric BOUHOURS : cedric.bouhours@uca.fr");
                        break;
                    }
                }
            }

        }

        if (!isErreur()) {
            mysql_commit();
            makeErreur("success","Rapatriement des notes de l'année précédente","Toutes les notes ont été rapatriées.");
        }

    $param .= "&f=".$_GET['bfmw_num_f']."&a=".$_GET['bfmw_num_a']."&e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e'];
}