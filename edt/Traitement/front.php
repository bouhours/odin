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
 * Ajout d'une contrainte
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']==="fiche" && isset($_GET['bfmw_orig_pe']) && isset($_GET['bfmw_orig_newm']) && isset($_GET['bfmw_orig_init'])) {
    /*$req = "SELECT * FROM edt_periode WHERE PERIODE_ID = " . $_GET['bfmw_num_pe'];
    $res = $conn->query($req);
    $une_periode = $res->fetch_assoc();
    $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
    if (time() > $date_maxi->getTimestamp()) {
        makeErreur("", "Création d'une matière", "Il y a eu une erreur : piratage détecté");
    } else {
        $req = "INSERT INTO common_edt_contraintes(CONTRAINTE_FICHE_ID, CONTRAINTE_ENS_ID, CONTRAINTE_SEMAINES) VALUES(" . $_GET['bfmw_num_newm'] . "," . CURRENT_ID . ",".$_GET['bfmw_num_init'].")";
        if (!$conn->query($req)) {
            makeErreur("", "Création d'une matière", "Erreur grave : Contactez le responsable de la formation");
        }
    }

    if ($_GET['bfmw_num_pe'] !== "") {
        $param = "&pe=" . $_GET['bfmw_num_pe'];
    } else {
        $_GET['bfmw_orig_p2'] = "voeux";
    }*/
}

/**
 * Ajout d'un exam
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']==="fiche" && isset($_GET['bfmw_orig_pe']) && isset($_GET['bfmw_orig_newe'])) {
    $req = "SELECT * FROM edt_periode WHERE PERIODE_ID = " . $_GET['bfmw_num_pe'];
    $res = $conn->query($req);
    $une_periode = $res->fetch_assoc();
    $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
    $current = CURRENT_ID;
    $force = false;
    if (isAdmin() && isset($_GET['bfmw_num_ens'])) {
        $current = $_GET['bfmw_num_ens'];
        $force = true;
    }
    if (time() > $date_maxi->getTimestamp() && !$force) {
        makeErreur("", "Création d'un exam", "Il y a eu une erreur : piratage détecté");
    } else {
        $req = "INSERT INTO common_edt_exams(EXAM_FICHE_ID, EXAM_ENS_ID) VALUES(" . $_GET['bfmw_num_newe'] . "," . $current . ")";
        if (!$conn->query($req)) {
            makeErreur("", "Création d'un exam", "Erreur grave : Contactez le responsable de la formation");
        }
    }

    if ($_GET['bfmw_num_pe'] !== "") {
        if (isset($_GET['bfmw_num_ens'])) {
            $param = "&ens=".$_GET['bfmw_num_ens']."&fi=".$_GET['bfmw_num_newe'];
        }
        $param .= "&pe=" . $_GET['bfmw_num_pe']."#id_add_exam";
    } else {
        $_GET['bfmw_orig_p2'] = "voeux";
    }
}

/**
 * Suppression d'une contrainte
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']==="fiche" && isset($_GET['bfmw_orig_pe']) && isset($_GET['bfmw_orig_delm']) && isset($_GET['bfmw_orig_delf'])) {
    /*$req = "SELECT * FROM edt_periode WHERE PERIODE_ID = " . $_GET['bfmw_num_pe'];
    $res = $conn->query($req);
    $une_periode = $res->fetch_assoc();
    $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
    if (time() > $date_maxi->getTimestamp()) {
        makeErreur("", "Suppression d'une matière", "Il y a eu une erreur : piratage détecté");
    } else {

        $req = "DELETE FROM common_edt_contraintes WHERE CONTRAINTE_FICHE_ID = " . $_GET['bfmw_num_delf'] . " AND CONTRAINTE_ENS_ID = " . CURRENT_ID . " AND CONTRAINTE_ID = " . $_GET['bfmw_num_delm'];
        $conn->query($req);
        if ($conn->affected_rows !== 1) {
            makeErreur("", "Suppression d'une matière", "Il y a eu une erreur. Piratage détecté.");
        }
    }

    if ($_GET['bfmw_num_pe'] !== "") {
        $param = "&pe=" . $_GET['bfmw_num_pe'];
    } else {
        $_GET['bfmw_orig_p2'] = "voeux";
    }*/
}

/**
 * Suppression d'un exam
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']==="fiche" && isset($_GET['bfmw_orig_pe']) && isset($_GET['bfmw_orig_dele']) && isset($_GET['bfmw_orig_delf'])) {
    $req = "SELECT * FROM edt_periode WHERE PERIODE_ID = " . $_GET['bfmw_num_pe'];
    $res = $conn->query($req);
    $une_periode = $res->fetch_assoc();
    $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
    $current = CURRENT_ID;
    $force = false;
    if (isAdmin() && isset($_GET['bfmw_num_ens'])) {
        $current = $_GET['bfmw_num_ens'];
        $force = true;
    }
    if (time() > $date_maxi->getTimestamp() && !$force) {
        makeErreur("", "Suppression d'un exam", "Il y a eu une erreur : piratage détecté");
    } else {

        $req = "DELETE FROM common_edt_exams WHERE EXAM_FICHE_ID = " . $_GET['bfmw_num_delf'] . " AND EXAM_ENS_ID = " . $current . " AND EXAM_ID = " . $_GET['bfmw_num_dele'];
        $conn->query($req);
        if ($conn->affected_rows !== 1) {
            makeErreur("", "Suppression d'un exam", "Il y a eu une erreur.");
        }
    }

    if ($_GET['bfmw_num_pe'] !== "") {
        if (isset($_GET['bfmw_num_ens'])) {
            $param = "&ens=".$_GET['bfmw_num_ens']."&fi=".$_GET['bfmw_orig_delf'];
        }
        $param .= "&pe=" . $_GET['bfmw_num_pe']."#id_add_exam";
    } else {
        $_GET['bfmw_orig_p2'] = "voeux";
    }
}

/**
 * Ajout d'une demande
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_commentaire']) && $_GET['bfmw_orig_p2']==="demande" && (isset($_POST['bfmw_orig_submit_modif']) || isset($_POST['bfmw_orig_submit_cancel'])  || isset($_POST['bfmw_orig_submit_nouveau']))) {

    $type="CHANGEMENT";
    if (isset($_POST['bfmw_orig_submit_cancel'])){
        $type="ANNULATION";
    }
    if (isset($_POST['bfmw_orig_submit_nouveau'])){
        $type="CREATION";
    }

    mysql_start_transaction();
    $mail= false;
    if ($type==="CREATION") {
        $a_ajouter['bfmw_orig_*DEMANDE_ENS_ID'] = CURRENT_ID;
        $a_ajouter['bfmw_num_*DEMANDE_ENS_ID'] = CURRENT_ID;
        $a_ajouter['bfmw_orig_*DEMANDE_TYPE'] = $type;
        $a_ajouter['bfmw_num_*DEMANDE_TYPE'] = null;
        $a_ajouter['bfmw_orig_*DEMANDE_COMMENTAIRE'] = $_POST['bfmw_orig_commentaire'];
        $a_ajouter['bfmw_num_*DEMANDE_COMMENTAIRE'] = null;


        if (createData("common_edt_changement", $a_ajouter, 3) > 0) {
            makeErreur("success", "Demande de changement d'emploi du temps", "Votre demande a bien été enregistrée, et sera prise en compte dès que possible.");
            $mail=true;
        } else {
            makeErreur("", "Demande de changement d'emploi du temps", "Il y a eu une erreur lors de l'enregistrement de votre demande. Contactez le responsable de la formation.");
        }
    } else {
        foreach ($_POST['bfmw_orig_commentaire'] as $un_id) {
            $a_ajouter['bfmw_orig_*DEMANDE_ENS_ID'] = CURRENT_ID;
            $a_ajouter['bfmw_num_*DEMANDE_ENS_ID'] = CURRENT_ID;
            $a_ajouter['bfmw_orig_*DEMANDE_TYPE'] = $type;
            $a_ajouter['bfmw_num_*DEMANDE_TYPE'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_ADE'] = $un_id;
            $a_ajouter['bfmw_num_*DEMANDE_ADE'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_COMMENTAIRE'] = $_POST['bfmw_orig_commentaire_' . $un_id];
            $a_ajouter['bfmw_num_*DEMANDE_COMMENTAIRE'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_DATE'] = $_POST['bfmw_orig_date_' . $un_id];
            $a_ajouter['bfmw_num_*DEMANDE_DATE'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_DEBUT'] = $_POST['bfmw_orig_heure_deb_' . $un_id];
            $a_ajouter['bfmw_num_*DEMANDE_DEBUT'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_FIN'] = $_POST['bfmw_orig_heure_fin_' . $un_id];
            $a_ajouter['bfmw_num_*DEMANDE_FIN'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_NOM'] = $_POST['bfmw_orig_nom_' . $un_id];
            $a_ajouter['bfmw_num_*DEMANDE_NOM'] = null;
            $a_ajouter['bfmw_orig_*DEMANDE_SALLE'] = $_POST['bfmw_orig_salle_' . $un_id];
            $a_ajouter['bfmw_num_*DEMANDE_SALLE'] = null;

            if (createData("common_edt_changement", $a_ajouter, 9) > 0) {
                makeErreur("success", "Demande de changement d'emploi du temps", "Votre demande a bien été enregistrée, et sera prise en compte dès que possible.");
                $mail=true;
            } else {
                makeErreur("", "Demande de changement d'emploi du temps", "Il y a eu une erreur lors de l'enregistrement de votre demande. Contactez le responsable de la formation.");
            }
        }
    }
    if ($mail) {
        $req = "SELECT * FROM edt_access_enseignants WHERE ENS_GESTIONNAIRE_ADE=1 AND ACCESS_DEPT_ID=".CURRENT_DEPT_ID;
        $res = $conn->query($req);
        $destinataires = "";
        while ($un_gestionnaire = $res->fetch_assoc()) {
            if ($destinataires !== "") {
                $destinataires .= ",";
            }
            $destinataires .= $un_gestionnaire['ENS_MAIL'];
        }
        sendMail("noreply+odin@uca.fr", "Demande de changement", "Bonjour\n\nUne demande de changement d'emploi du temps a été déposée sur Odin.\n\nCordialement",$destinataires);
    }
    mysql_commit();

}

/**
 * Gestion des demandes
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']==="gestion_demande" && isGestionnaire() && isset($_POST['bfmw_orig_DEMANDE_ID']) && (isset($_POST['bfmw_orig_submit_executor']) || isset($_POST['bfmw_orig_submit_done']) || isset($_POST['bfmw_orig_submit_refuse']))) {
    if ($fp = SynchronizeAccess()) {
        mysql_start_transaction();
        if (isset($_POST['bfmw_orig_submit_executor'])) {
            $req = "UPDATE common_edt_changement SET DEMANDE_EXECUTOR_ENS_ID=" . CURRENT_ID . " WHERE DEMANDE_EXECUTOR_ENS_ID IS NULL AND DEMANDE_ID=" . $_POST['bfmw_orig_DEMANDE_ID'];
        }
        if (isset($_POST['bfmw_orig_submit_done'])) {
            $req = "SELECT * FROM edt_access_enseignants,common_edt_changement WHERE ENS_ID = DEMANDE_ENS_ID AND DEMANDE_ID=" . $_POST['bfmw_orig_DEMANDE_ID'];
            $un_enseignant = $conn->query($req)->fetch_assoc();
            sendMail($un_enseignant['ENS_MAIL'],"Demande de changement d'emploi du temps","Bonjour,\n\nVotre demande de changement d'emploi du temps a été effectuée par ".$_SESSION['edt_nom'].". Elle sera visible sur votre emploi du temps dans moins d'une heure.\n\nCordialement");

            $req = "UPDATE common_edt_changement SET DEMANDE_DONE=1 WHERE DEMANDE_ID=" . $_POST['bfmw_orig_DEMANDE_ID'];
        }
        if (isset($_POST['bfmw_orig_submit_refuse'])) {
            $req = "SELECT * FROM edt_access_enseignants,common_edt_changement WHERE ENS_ID = DEMANDE_ENS_ID AND DEMANDE_ID=" . $_POST['bfmw_orig_DEMANDE_ID'];
            $un_enseignant = $conn->query($req)->fetch_assoc();
            sendMail($un_enseignant['ENS_MAIL'],"Demande de changement d'emploi du temps","Bonjour,\n\nVotre demande de changement d'emploi du temps n'a pas été prise en compte. Contactez ".$_SESSION['edt_nom']." pour plus de détail.\n\nCordialement");

            $req = "UPDATE common_edt_changement SET DEMANDE_DONE=1 WHERE DEMANDE_ID=" . $_POST['bfmw_orig_DEMANDE_ID'];
        }
        $conn->query($req);
        if ($conn->affected_rows != 1) {
            mysql_rollback();
            makeErreur("","Gestion des demandes de modification", "La demande de modification a déjà été affectée.");
        } else {
            mysql_commit();
        }
        DesynchronizeAccess($fp);
    } else {
        makeErreur("","Gestion des demandes de modification", "La demande de modification a déjà été affectée.");
    }
}


$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;

require 'refresh.php';