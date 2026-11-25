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

$data = "";

/**
 * Emprunt
 */
if (isset($_POST['bfmw_orig_emprunter']) && $_GET['bfmw_orig_p2'] === "accueil") {

    $_POST['bfmw_orig_*EMPRUNT_DATE_OUT'] = date("Y-m-d");
    $_POST['bfmw_num_*EMPRUNT_DATE_OUT'] = "";
    if ($_POST['bfmw_orig_*EMPRUNT_ENS_ID'] == "") {
        $_POST['bfmw_orig_*EMPRUNT_ENS_ID'] = CURRENT_ID;
        $_POST['bfmw_num_*EMPRUNT_ENS_ID'] = CURRENT_ID;
    }
    if ($_POST['bfmw_orig_*EMPRUNT_DATE_RETOUR'] == "") {
        $_POST['bfmw_orig_*EMPRUNT_DATE_RETOUR'] = "NULL";
        $_POST['bfmw_num_*EMPRUNT_DATE_RETOUR'] = "";
    }
    if ($_POST['bfmw_orig_*EMPRUNT_EXTERNE'] == "") {
        $_POST['bfmw_orig_*EMPRUNT_EXTERNE'] = "NULL";
        $_POST['bfmw_num_*EMPRUNT_EXTERNE'] = "";
    }
    
    $req = "SELECT IFNULL(OBJ_STOCK-sum(EMPRUNT_NOMBRE)-".$_POST['bfmw_num_*EMPRUNT_NOMBRE'].",OBJ_STOCK) AS OBJ_RESTE FROM common_objet LEFT JOIN emprunt ON (OBJ_ID=EMPRUNT_OBJ_ID) WHERE `EMPRUNT_OBJ_ID` = ".$_POST['bfmw_num_*EMPRUNT_OBJ_ID'];
    $res = $conn->query($req);
    $fail = true;
    if ($obj = $res->fetch_assoc()) {
        $fail = ($obj['OBJ_RESTE']<0);
    }
    if (!$fail) {
        createData("common_emprunt", $_POST, 6);
        if ($conn->affected_rows <= 0) {
            $req = "UPDATE common_emprunt SET EMPRUNT_NOMBRE = EMPRUNT_NOMBRE+".$_POST['bfmw_num_*EMPRUNT_NOMBRE']." WHERE EMPRUNT_OBJ_ID=".$_POST['bfmw_num_*EMPRUNT_OBJ_ID']." AND EMPRUNT_ENS_ID=".$_POST['bfmw_num_*EMPRUNT_ENS_ID'];

            $conn->query($req);
            if ($conn->affected_rows != 1) {
                makeErreur("", "Erreur !", "Enregistrement impossible. Erreur grave, contactez le responsable de formation");
            } else {
                makeErreur("success", "Emprunt", "L'emprunt a été correctement enregistré");
            }
        } else {
            makeErreur("success", "Emprunt", "L'emprunt a été correctement enregistré");
        }
    } else {
        makeErreur("", "Erreur !", "Enregistrement impossible. Piratage détecté");
    }
}

/**
 * Rendre
 */
if (isset($_POST['bfmw_orig_rendre'])) {
    $req = "UPDATE common_emprunt_etudiant SET EMPRUNT_NOMBRE = EMPRUNT_NOMBRE-1 WHERE EMPRUNT_OBJ_ID=".$_POST['bfmw_num_*EMPRUNT_OBJ_ID']." AND EMPRUNT_ENS_ID=".CURRENT_ID." AND EMPRUNT_ET_ID=".$_POST['bfmw_num_*EMPRUNT_ET_ID'];
    if ($_POST['bfmw_orig_*EMPRUNT_ET_ID'] == "") {
        $req = "UPDATE common_emprunt SET EMPRUNT_NOMBRE = EMPRUNT_NOMBRE-1 WHERE EMPRUNT_OBJ_ID=".$_POST['bfmw_num_*EMPRUNT_OBJ_ID']." AND EMPRUNT_ENS_ID=".CURRENT_ID;
    }
    $conn->query($req);
    if ($conn->affected_rows != 1) {
        makeErreur("", "Erreur !", "Enregistrement impossible.");
    } else {
        if ($_POST['bfmw_orig_*EMPRUNT_ET_ID'] == "") {
            $conn->query("DELETE FROM common_emprunt WHERE EMPRUNT_NOMBRE = 0");
        } else {
            $conn->query("DELETE FROM common_emprunt_etudiant WHERE EMPRUNT_NOMBRE = 0");
        }
        $datapost = array(array("*LOG" => "Emprunt - Le ".date("Y-m-d").", le matériel ".$_POST['bfmw_orig_*EMPRUNT_OBJ_ID']." a été restitué par ".$_SESSION['emprunts_nom']."."));
        manual_bfmw_secure($datapost);
        createData("common_log", $datapost[0], 1);
        makeErreur("success", "Rendu", "L'objet a été correctement rendu");
    }
}

/**
 * Ajout
 */
if (isset($_POST['bfmw_orig_ajouter']) && $_GET['bfmw_orig_p2']=="ajouter") {
    if (createData("common_objet", $_POST, 3) > 0){
        makeErreur("success", "Ajout", "Le nouveau matériel a été ajouté");
    } else {
        makeErreur("", "Erreur !", "Enregistrement impossible. Erreur grave, contactez le responsable de formation");
    }
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $data . $message_erreur;
require 'refresh.php';
