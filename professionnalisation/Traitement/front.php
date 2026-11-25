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
 * Suppression d'une signature
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_u']) && isset($_GET['bfmw_orig_g']) && isset($_GET['bfmw_orig_del']) && $_GET['bfmw_orig_p2']=='fiche' && (Formations::isResponsable() || Formations::isSecretaire() || Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID))) {
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
if (isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_g']) && $_GET['bfmw_orig_p2']=='emargement' && (Formations::isResponsable() || Formations::isSecretaire() || Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID))) {
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
        $req = "UPDATE common_backup_ade_etudiant SET EDT_ARCHIVE=".time()." WHERE EDT_GROUPE_ID=".$_POST['bfmw_num_g']." AND EDT_DATE_DEBUT>=".real_date_time($_POST['bfmw_orig_DATE_START'],$_POST['bfmw_orig_HEURE_START'])." AND EDT_DATE_FIN <= ".real_date_time($_POST['bfmw_orig_DATE_END'],$_POST['bfmw_orig_HEURE_END']);
        $conn->query($req);
    }

    $param .= "&g=".$_POST['bfmw_num_g'];
}

/**
 * Restauration des archives
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_g']) && $_GET['bfmw_orig_p2']=='archives' && isset($_POST['bfmw_orig_g']) && isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_archive']) && (Formations::isResponsable() || Formations::isSecretaire() || Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID))) {
    Signatures::restaurerArchives($_POST['bfmw_num_g'],$_POST['bfmw_num_a'],$_POST['bfmw_num_archive']);
    $param .= "&g=".$_POST['bfmw_num_g']."&a=".$_POST['bfmw_num_a'];
}

//Ajout des tablettes
if (isAdmin() && isset($_POST['bfmw_orig_add_tablette'])) {
    createData("common_tablettes",$_POST,1);
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;

require 'refresh.php';

function real_date_time($date,$time) {
    list($jour, $mois, $annee) = explode('/', $date);
    list($heure, $minutes) = explode('h', $time);
    return mktime($heure,$minutes,0,$mois,$jour,$annee);
}