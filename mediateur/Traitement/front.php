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

if (!isRegistered() && !isset($_GET['bfmw_orig_p2'])) {
    echo "Non autorisé";
    exit;
}

$param = "";



/**
 * Autojustification
 */
if (isset($_POST['bfmw_orig_autojustif'])) {
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_DATE_START']) === false) {
        makeErreur("", "Erreur !", "Impossible de créer la justification.");
    }
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_DATE_END']) === false) {
        makeErreur("", "Erreur !", "Impossible de créer la justification.");
    }
    if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/",$_POST['bfmw_orig_HEURE_START']) === false) {
        makeErreur("", "Erreur !", "Impossible de créer la justification.");
    }
    if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/",$_POST['bfmw_orig_HEURE_END']) === false) {
        makeErreur("", "Erreur !", "Impossible de créer la justification.");
    }

    if (!isErreur()) {

        $_POST['bfmw_orig_*JUSTIF_DATE_START'] = transformDate($_POST['bfmw_orig_DATE_START']);
        $_POST['bfmw_num_*JUSTIF_DATE_START'] = get_numeric($_POST['bfmw_orig_*JUSTIF_DATE_START']);
        $_POST['bfmw_orig_*JUSTIF_DATE_END'] = transformDate($_POST['bfmw_orig_DATE_END']);
        $_POST['bfmw_num_*JUSTIF_DATE_END'] = get_numeric($_POST['bfmw_orig_*JUSTIF_DATE_END']);
        $_POST['bfmw_orig_*JUSTIF_HEURE_START'] = transformHeure($_POST['bfmw_orig_HEURE_START']);
        $_POST['bfmw_num_*JUSTIF_HEURE_START'] = get_numeric($_POST['bfmw_orig_*JUSTIF_HEURE_START']);
        $_POST['bfmw_orig_*JUSTIF_HEURE_END'] = transformHeure($_POST['bfmw_orig_HEURE_END']);
        $_POST['bfmw_num_*JUSTIF_HEURE_END'] = get_numeric($_POST['bfmw_orig_*JUSTIF_HEURE_END']);
        $_POST['bfmw_orig_*JUSTIF_ENS_ID'] = CURRENT_ID;
        $_POST['bfmw_num_*JUSTIF_ENS_ID'] = CURRENT_ID;
        if (createData("common_absences_justifications", $_POST, 8) > 0) {
            makeErreur("success", "Création d'une justification", "La justification a été correctement enregistrée.");
            Absences::autojustification($_POST['bfmw_num_*JUSTIF_ET_ID']);
        } else {
            makeErreur("", "Erreur !", "Impossible de créer la justification.");
        }
    }
    $param .= "&g=".$_POST['bfmw_num_g']."&e=".$_POST['bfmw_num_*JUSTIF_ET_ID']."#".$_POST['bfmw_num_*JUSTIF_ET_ID'];
}

/**
 * Suppression d'une autojustification
 */
if (isset($_GET['bfmw_orig_delj']) && isset($_GET['bfmw_num_e']) && $_GET['bfmw_orig_p2'] == "absences") {
    $req = "SELECT * FROM common_absences_justifications WHERE JUSTIF_ID=".$_GET['bfmw_num_delj'];
    $res = $conn->query($req);
    if ($justif = $res->fetch_assoc()) {
        if ($justif['JUSTIF_CHEMIN'] != "") {
            @unlink("../etudiants/".$justif['JUSTIF_CHEMIN']);
        }
    }

    $req = "DELETE FROM common_absences_justifications WHERE JUSTIF_ID=".$_GET['bfmw_num_delj'];
    if ($conn->query($req) === false) {
        makeErreur("", "Erreur grave", "Contactez le responsable de formation");
    } else {
        if ($conn->affected_rows === 0) {
            makeErreur("", "Suppression", "Impossible de supprimer cette justification.");
        } else {
            makeErreur("success", "Suppression", "La justification a correctement été supprimée.");
        }
    }
    $param .= "&g=".$_GET['bfmw_num_g']."&e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e'];
}

/**
 * Justification d'une absence par le médiateur
 */
if (isset($_GET['bfmw_orig_justif']) && isset($_GET['bfmw_orig_justification']) && $_GET['bfmw_orig_p2'] == "absences") {
    $req = "UPDATE common_absences_v2 SET ABS_JUSTIF_ENS_ID=".CURRENT_ID.",  ABS_JUSTIFICATION = '".$_GET['bfmw_orig_justification']."' WHERE ABS_ID=" . $_GET['bfmw_num_justif'] . " AND " . CURRENT_ID . " IN (SELECT GROUPE_ENS_ID FROM etudiants_groupes WHERE ET_ID=ABS_ET_ID)";
    if (Formations::isResponsable() || Formations::isSecretaire()) {
        $req = "UPDATE common_absences_v2 SET ABS_JUSTIF_ENS_ID=".CURRENT_ID." ,  ABS_JUSTIFICATION = '".$_GET['bfmw_orig_justification']."' WHERE ABS_ID=" . $_GET['bfmw_num_justif'];
    }
    if ($conn->query($req) === false) {
        makeErreur("", "Erreur grave", "Contactez le responsable de formation");
    } else {
        if ($conn->affected_rows === 0) {
            makeErreur("", "Justification", "Impossible de justifier cette absence.");
        } else {
            makeErreur("success", "Justification", "L'absence a correctement été marquée justifiée.");
        }
    }

    $param .= "&g=".$_GET['bfmw_orig_g'];
    if (isset($_GET['bfmw_orig_e'])) {
        $param .= "&e=".$_GET['bfmw_orig_e']."#".$_GET['bfmw_orig_e'];
    }
    if (isset($_GET['bfmw_orig_r'])) {
        $param .= "&r=".$_GET['bfmw_orig_r']."#r".$_GET['bfmw_orig_r'];
    }
}

/**
 * Suppression d'une justification par le médiateur
 */
if (isset($_GET['bfmw_orig_del_justif']) && $_GET['bfmw_orig_p2'] == "absences") {
    $req = "UPDATE common_absences_v2 SET ABS_JUSTIFICATION = 'non' WHERE ABS_ID=" . $_GET['bfmw_num_del_justif'] . " AND " . CURRENT_ID . " IN (SELECT GROUPE_ENS_ID FROM etudiants_groupes WHERE ET_ID=ABS_ET_ID)";
    if (Formations::isResponsable() || Formations::isSecretaire()) {
        $req = "UPDATE common_absences_v2 SET ABS_JUSTIFICATION = 'non' WHERE ABS_ID=" . $_GET['bfmw_num_del_justif'];
    }
    if ($conn->query($req) === false) {
        makeErreur("", "Erreur grave", "Contactez le responsable de formation");
    } else {
        if ($conn->affected_rows === 0) {
            makeErreur("", "Suppression d'une justification", "Impossible de supprimer cette justification.");
        } else {
            makeErreur("success", "Suppression d'une justification", "La justification a a correctement été supprimée.");
        }
    }

    $param .= "&g=".$_GET['bfmw_orig_g'];
    if (isset($_GET['bfmw_orig_e'])) {
        $param .= "&e=".$_GET['bfmw_orig_e']."#".$_GET['bfmw_orig_e'];
    }
    if (isset($_GET['bfmw_orig_r'])) {
        $param .= "&r=".$_GET['bfmw_orig_r']."#r".$_GET['bfmw_orig_r'];
    }
}

/**
 * Ajout d'un suivi d'étudiant
 */
if (isset($_POST['bfmw_orig_save_suivi']) && $_GET['bfmw_orig_p2'] == "suivi") {
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_date_suivi']) === false) {
        makeErreur("", "Erreur !", "Impossible d'enregistrer le suivi.");
    }

    $req = "SELECT * FROM etudiants_groupes WHERE ET_ID=".$_POST['bfmw_num_*SUIVI_ET_ID']." AND GROUPE_ENS_ID=".CURRENT_ID;
    if (Formations::isResponsable() || Formations::isSecretaire()) {
        $les_formations_autorisees = Formations::getFormationsDuConnecteString();
        $req = "SELECT * FROM etudiants_groupes,common_formation WHERE FORM_ID=GROUPE_FORM_ID AND GROUPE_FORM_ID IN (".$les_formations_autorisees.") AND FORM_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
    }
    if ($conn->query($req)->num_rows == 0) {
        makeErreur("", "Erreur !", "Piratage détecté");
    }

    if (!isErreur()) {

        $_POST['bfmw_orig_*SUIVI_DATE'] = transformDate($_POST['bfmw_orig_date_suivi']);
        $_POST['bfmw_num_*SUIVI_DATE'] = get_numeric($_POST['bfmw_orig_*SUIVI_DATE']);
        $_POST['bfmw_orig_*SUIVI_ENS_ID'] = CURRENT_ID;
        $_POST['bfmw_num_*SUIVI_ENS_ID'] = CURRENT_ID;
        if (createData("common_suivi",$_POST,4) > 0) {
            makeErreur("success", "Enregistrement", "Le suivi a bien été enregistré.");
        }
    }

    $param .= "&g=".$_POST['bfmw_orig_GROUPE_ID']."&a=".$_POST['bfmw_num_ANNEE_ID']."&e=".$_POST['bfmw_orig_*SUIVI_ET_ID']."#".$_POST['bfmw_orig_*SUIVI_ET_ID'];
}

/**
 * Suppression d'un suivi d'étudiant
 */
if (isset($_GET['bfmw_orig_del_suivi']) && $_GET['bfmw_orig_p2'] == "suivi" && isset($_GET['bfmw_orig_e'])) {

    $req = "DELETE FROM common_suivi WHERE SUIVI_ID=".$_GET['bfmw_num_del_suivi']." AND SUIVI_ENS_ID=".CURRENT_ID;

    $conn->query($req);
    if ($conn->affected_rows == 0) {
        makeErreur("", "Erreur !", "Impossible de supprimer le suivi.");
    } else {
        makeErreur("success", "Suppression", "La suivi a bien été supprimé.");
    }

    $param .= "&g=".$_GET['bfmw_orig_g']."&e=".$_GET['bfmw_orig_e']."#".$_GET['bfmw_orig_e'];
}

/**
 * Suppression d'une note
 */
if ($_GET['bfmw_orig_p2'] == "notes" && isset($_GET['bfmw_orig_e']) && isset($_GET['bfmw_orig_g']) && isset($_GET['bfmw_orig_deln']) && isAdmin()) {
    $req = "DELETE FROM common_notes WHERE NOTES_ID=".$_GET['bfmw_num_deln'];
    $conn->query($req);
    if ($conn->affected_rows == 0) {
        makeErreur("", "Erreur !", "Impossible de supprimer la note.");
    } else {
        makeErreur("success", "Suppression", "La note a été supprimée.");
    }

    $param .= "&g=".$_GET['bfmw_orig_g']."&e=".$_GET['bfmw_orig_e']."#".$_GET['bfmw_orig_e'];
}

/**
 * Acceptation ou non de la justification d'un étudiant
 */
if ($_GET['bfmw_orig_p2'] == "absences" && isset($_GET['bfmw_orig_e']) && isset($_GET['bfmw_orig_justif']) && isset($_GET['bfmw_orig_acceptation'])) {
    $les_formations_autorisees = Formations::getFormationsDuConnecteString();

    $annee_courante = Annees::getIdAnneeCourante();

    $req = "SELECT * FROM etudiants_groupes,common_absences_justifications WHERE ET_ID=JUSTIF_ET_ID AND JUSTIF_ID=".$_GET['bfmw_num_justif']." AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ENS_ID='" . CURRENT_ID . "'";
    if (Formations::isSecretaire() || Formations::isResponsable()) {
        $req = "SELECT * FROM etudiants_groupes,common_formation,common_absences_justifications WHERE ET_ID=JUSTIF_ET_ID AND JUSTIF_ID=".$_GET['bfmw_num_justif']." AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FORM_ID IN (".$les_formations_autorisees.") AND FORM_DEPT_ID=".CURRENT_DEPT_ID;
    }

    if ($conn->query($req)->num_rows > 0) {
        $req = "UPDATE common_absences_justifications SET JUSTIF_ATTENTE=0, JUSTIF_ENS_ID=".CURRENT_ID.", JUSTIF_JUSTIFICATION='".$_GET['bfmw_orig_yes']."' WHERE JUSTIF_ID=".$_GET['bfmw_num_justif'];
        $conn->query($req);
        if ($conn->affected_rows == 0) {
            makeErreur("", "Erreur !", "Impossible de valider la justifcation.");
        } else {
            makeErreur("success", "Justification", "La justification a été validée.");
            Absences::autojustification($_GET['bfmw_num_e']);
        }
    }

    $param .= "&g=".$_GET['bfmw_orig_g']."&e=".$_GET['bfmw_orig_e']."#".$_GET['bfmw_orig_e'];
}

/**
 * Suppression d'une signature
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_u']) && isset($_GET['bfmw_orig_g']) && isset($_GET['bfmw_orig_del']) && $_GET['bfmw_orig_p2']=='fiche') {
    $annee_courante = Annees::getIdAnneeCourante();
    mysql_start_transaction();
    if (Absences_Automatiques::supprimerSignature($_GET['bfmw_num_del'],$_GET['bfmw_num_g'],$_GET['bfmw_orig_u']) > 0) {
        makeErreur("success","Suppression d'une signature", "La signature a été supprimée.");
    } else {
        makeErreur("","Suppression d'une signature", "Impossible de supprimer la signature.");
        mysql_rollback();
    }
    if (isset($_GET['bfmw_orig_ens'])) {
        Absences::supprimerAbsence(null,$_GET['bfmw_orig_u'],implode(",",array_keys(Etudiants::getEtudiantsGroupes($annee_courante,$_GET['bfmw_num_g']))));
    } else {
        $enseignant_signataire = Absences_Automatiques::isCreneauDejaSigneParEnseignant($_GET['bfmw_num_g'],$_GET['bfmw_orig_u']);
        if ($enseignant_signataire != null) {
            Absences_Automatiques::insererUneAbsenceAutomatiquement($annee_courante, $_GET['bfmw_orig_u'], $_GET['bfmw_num_e'], $_GET['bfmw_num_g'], $enseignant_signataire, $_GET['bfmw_num_m']);
        }
    }
    mysql_commit();
    $param .= "&u=".$_GET['bfmw_orig_u']."&g=".$_GET['bfmw_orig_g'];

}

/**
 * Archivages des fiches de signature
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_g']) && $_GET['bfmw_orig_p2']=='emargement') {
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_DATE_START']) === false) {
        makeErreur("", "Erreur !", "Impossible d'archiver.");
    }
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_DATE_END']) === false) {
        makeErreur("", "Erreur !", "Impossible d'archiver.");
    }
    if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/",$_POST['bfmw_orig_HEURE_START']) === false) {
        makeErreur("", "Erreur !", "Impossible d'archiver.");
    }
    if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/",$_POST['bfmw_orig_HEURE_END']) === false) {
        makeErreur("", "Erreur !", "Impossible d'archiver.");
    }

    if (!isErreur()) {
        Absences_Automatiques::archiverFiches(time(),$_POST['bfmw_num_g'],transformDateHeureSepares($_POST['bfmw_orig_DATE_START'],$_POST['bfmw_orig_HEURE_START']),transformDateHeureSepares($_POST['bfmw_orig_DATE_END'],$_POST['bfmw_orig_HEURE_END']));
    }

    $param .= "&g=".$_POST['bfmw_num_g'];
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;
require 'refresh.php';
