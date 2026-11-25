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
 * Autojustification d'une absence
 */
if (isset($_POST['bfmw_orig_autojustif'])) {
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_DATE_START']) === false) {
        makeErreur("", "Erreur !", "La date de début n'est pas valide.");
    }
    if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/",$_POST['bfmw_orig_DATE_END']) === false) {
        makeErreur("", "Erreur !", "La date de fin n'est pas valide.");
    }
    if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/",$_POST['bfmw_orig_HEURE_START']) === false) {
        makeErreur("", "Erreur !", "L'heure de début n'est pas valide.");
    }
    if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/",$_POST['bfmw_orig_HEURE_END']) === false) {
        makeErreur("", "Erreur !", "L'heure de fin n'est pas valide.");
    }


    $target_file = "NULL";
    if (!isErreur() && $_FILES['justification']["name"]!="") {
        $target_dir = "uploads/";
        $target_file = $target_dir  . CURRENT_ID . "_" . time() . "_" . basename($_FILES["justification"]["name"]);

        $fichier_extension = strtolower(pathinfo($_FILES['justification']['name'], PATHINFO_EXTENSION));
        if ($fichier_extension == "exe" || $fichier_extension == "js" || $fichier_extension == "com" || $fichier_extension == "bat") {
            makeErreur("", "Erreur !", "Extension de fichier invalide.");
        } else {
            if (!move_uploaded_file($_FILES["justification"]["tmp_name"], $target_file)) {
                makeErreur("", "Erreur !", "Erreur lors de l'upload du fichier.");
            }
        }
    }

    if (!isErreur()) {
        mysql_start_transaction();
        $_POST['bfmw_orig_*JUSTIF_DATE_START'] = transformDate($_POST['bfmw_orig_DATE_START']);
        $_POST['bfmw_num_*JUSTIF_DATE_START'] = get_numeric($_POST['bfmw_orig_*JUSTIF_DATE_START']);
        $_POST['bfmw_orig_*JUSTIF_DATE_END'] = transformDate($_POST['bfmw_orig_DATE_END']);
        $_POST['bfmw_num_*JUSTIF_DATE_END'] = get_numeric($_POST['bfmw_orig_*JUSTIF_DATE_END']);
        $_POST['bfmw_orig_*JUSTIF_HEURE_START'] = transformHeure($_POST['bfmw_orig_HEURE_START']);
        $_POST['bfmw_num_*JUSTIF_HEURE_START'] = get_numeric($_POST['bfmw_orig_*JUSTIF_HEURE_START']);
        $_POST['bfmw_orig_*JUSTIF_HEURE_END'] = transformHeure($_POST['bfmw_orig_HEURE_END']);
        $_POST['bfmw_num_*JUSTIF_HEURE_END'] = get_numeric($_POST['bfmw_orig_*JUSTIF_HEURE_END']);
        bfmw_add_secured($_POST,"*JUSTIF_JUSTIFICATION", "non");
        bfmw_add_secured($_POST,"*JUSTIF_ATTENTE", ($_FILES['justification']["name"]!=""?'1':'0'));
        bfmw_add_secured($_POST,"*JUSTIF_CHEMIN", ($_FILES['justification']["name"]!=""?addslashes($target_file):"NULL"));
        bfmw_add_secured($_POST,"*JUSTIF_ET_ID", CURRENT_ID);
        bfmw_add_secured($_POST,"*JUSTIF_DATE_DEPOT", time());

        if ($_POST['bfmw_num_*JUSTIF_DATE_START']+$_POST['bfmw_num_*JUSTIF_HEURE_START'] >= $_POST['bfmw_num_*JUSTIF_DATE_END']+$_POST['bfmw_num_*JUSTIF_HEURE_END']) {
            makeErreur("", "Erreur !", "La date de début est postérieure à la date de fin.");
        }

        if (!isErreur()) {
            if (createData("common_absences_justifications", $_POST, 10) > 0) {
                makeErreur("success", "Déclaration d'une absence", "La déclaration a été correctement enregistrée.");
                Absences::autojustification($_POST['bfmw_num_*JUSTIF_ET_ID']);
                mysql_commit();
            } else {
                makeErreur("", "Erreur !", "Impossible de créer la justification.");
                mysql_rollback();
            }
        }
    }

    if (isset($_GET["bfmw_num_a"])) {
        $data .= "&amp;a=".$_GET["bfmw_num_a"];
    }
    if (isset($_GET["bfmw_num_nonclose"])) {
        $data .= "&amp;nonclose=".$_GET["bfmw_num_nonclose"];
    }
}

/**
 * Candidature à un stage
 */
if (isset($_POST['bfmw_orig_stage']) && $_GET['bfmw_orig_p2']=="stages") {
    $annee_courante = Annees::getIdAnneeCourante();
    if (!Stages::peutCandidater(CURRENT_ID,$_POST["bfmw_num_stage"],$annee_courante)) {
        makeErreur("","Candidater à un stage","Vous ne pouvez pas candidater à ce stage");
    }

    if (!isErreur() && $_FILES['cv']['tmp_name']!="" && mime_content_type($_FILES['cv']['tmp_name']) !== "application/pdf") {
            makeErreur("", "Candidater à un stage", "Votre CV doit être un pdf");
    }

    if (!isErreur() && ($_FILES['cv']["name"]=="" || $_FILES['cv']["tmp_name"]=="")) {
        makeErreur("", "Candidater à un stage", "Votre CV est obligatoire");
    }

    if (!isErreur() && $_FILES['lm']["tmp_name"]!="" && mime_content_type($_FILES['lm']['tmp_name']) !== "application/pdf") {
        makeErreur("", "Candidater à un stage", "Votre lettre de motivation doit être un pdf");
    }

    if (!isErreur() && ($_FILES['lm']["name"]=="" || $_FILES['lm']["tmp_name"]=="")) {
        makeErreur("", "Candidater à un stage", "Votre lettre de motivation est obligatoire");
    }

    if (!isErreur() && $_FILES['lm']["name"]===$_FILES['cv']["name"]) {
        makeErreur("", "Candidater à un stage", "Vos deux fichiers sont identiques");
    }

    if (!isErreur()) {
        $zip = new ZipArchive();
        $base_dir = "uploads/".$_POST["bfmw_num_stage"].CURRENT_ID.uniqid()."/";
        if (!mkdir($base_dir)) {
            makeErreur("", "Candidater à un stage", "Erreur grave n°648, contactez Cédric BOUHOURS cedric.bouhours@uca.fr");
        } else {
            $fichier = "CV LM " . $_SESSION['etudiants_nom'] . ".zip";
            $filename = $base_dir . $fichier;

            if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
                makeErreur("", "Candidater à un stage", "Erreur grave n°875, contactez Cédric BOUHOURS cedric.bouhours@uca.fr");
            } else {
                move_uploaded_file($_FILES['cv']['tmp_name'], $base_dir . $_FILES['cv']['name']);
                move_uploaded_file($_FILES['lm']['tmp_name'], $base_dir . $_FILES['lm']['name']);
                $zip->addFile($base_dir . $_FILES['cv']['name'], $_FILES['cv']['name']);
                $zip->addFile($base_dir . $_FILES['lm']['name'], $_FILES['lm']['name']);
                $zip->close();
                unlink($base_dir . $_FILES['cv']['name']);
                unlink($base_dir . $_FILES['lm']['name']);
                $leStage = Stages::getStage($_POST["bfmw_num_stage"], $annee_courante)[0];
                $lesResponsablesDeStage = Enseignants::getResponsablesDeStages();
                $les_adresses_des_responsables = array();
                foreach ($lesResponsablesDeStage as $un_responsable) {
                    $les_adresses_des_responsables[] = $un_responsable['ENS_MAIL'];
                }
                $etudiant = Etudiants::getEtudiant(CURRENT_ID, $annee_courante)[0];
                $leFichier = array(
                    "tmp_name" => $filename,
                    "type" => mime_content_type($filename),
                    "name" => $fichier
                );

                if (sendMail($leStage['STAGE_MAIL'], "Candidature à un stage", "Bonjour,\n\n" . $etudiant['ET_NOM'] . " étudiant au " . $etudiant['DEPT_NOM'] . " en " . $etudiant['FORM_NOM'] . " souhaite candidater à votre proposition de stage suivante :\n" . $leStage['STAGE_SUJET'] . "\n\n Vous trouverez en pièces jointes son CV et sa lettre de motivation.\n\nCordialement", implode(",", $les_adresses_des_responsables), $etudiant["ET_MAIL"], "Plateforme ODIN <noreply+odin@uca.fr>", $leFichier)) {
                    if (Stages::candidater(CURRENT_ID, $_POST["bfmw_num_stage"])) {
                        makeErreur("success", "Candidater à un stage", "Votre candidature a été correctement enregistrée");
                    } else {
                        makeErreur("", "Candidater à un stage", "Erreur grave n°342, contactez Cédric BOUHOURS cedric.bouhours@uca.fr");
                    }
                } else {
                    makeErreur("", "Candidater à un stage", "Erreur grave n°854, contactez Cédric BOUHOURS cedric.bouhours@uca.fr");
                }
                unlink($filename);
                rmdir($base_dir);
            }
        }
    }

    if (isset($_GET["bfmw_num_a"])) {
        $data .= "&amp;a=".$_GET["bfmw_num_a"];
    }
    if (isset($_GET["bfmw_num_nonclose"])) {
        $data .= "&amp;nonclose=".$_GET["bfmw_num_nonclose"];
    }
}

/**
 * Répondre questionnaire
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_SUBMIT_RESPONSES']) && $_GET['bfmw_orig_p2']=="retour" && isset($_POST['bfmw_num_val']) ) {
    mysql_start_transaction();
    $les_questions = Formations::getQuestionsEvaluation($_POST['bfmw_num_val']);

    foreach ($les_questions as $une_question) {
        Formations::repondreQuestion(CURRENT_ID,$_POST['bfmw_num_val'],$_POST['bfmw_orig_reponse_q_' . $une_question['EVALQ_ID']],addslashes($une_question['EVALQ_QUESTION']),$une_question['EVALQ_ORDRE']);
    }
    mysql_commit();
    if (isset($_GET["bfmw_num_a"])) {
        $data .= "&amp;a=".$_GET["bfmw_num_a"];
    }
    if (isset($_GET["bfmw_num_nonclose"])) {
        $data .= "&amp;nonclose=".$_GET["bfmw_num_nonclose"];
    }
}


/**
 * Emprunter du matériel
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_emprunter'])) {
    $_POST["bfmw_orig_*EMPRUNT_ET_ID"] = CURRENT_ID;
    $_POST["bfmw_num_*EMPRUNT_ET_ID"] = CURRENT_ID;
    $_POST['bfmw_orig_*EMPRUNT_DATE_OUT'] = date("Y-m-d");
    $_POST['bfmw_num_*EMPRUNT_DATE_OUT'] = null;
    if (trim($_POST['bfmw_orig_*EMPRUNT_DATE_RETOUR']) != "") {
        mysql_start_transaction();

        $req = "SELECT IFNULL(OBJ_STOCK-sum(EMPRUNT_NOMBRE)-".$_POST['bfmw_num_*EMPRUNT_NOMBRE'].",OBJ_STOCK) AS OBJ_RESTE FROM etudiants_emprunts_objets WHERE `OBJ_ID` = " . $_POST['bfmw_num_*EMPRUNT_OBJ_ID'];
        $res = $conn->query($req);
        $fail = true;
        if ($obj = $res->fetch_assoc()) {
            $fail = ($obj['OBJ_RESTE'] < 0);
        }
        if (!$fail) {
            createData("common_emprunt_etudiant", $_POST, 6);
            if ($conn->affected_rows <= 0) {
                $req = "UPDATE common_emprunt_etudiant SET EMPRUNT_NOMBRE = EMPRUNT_NOMBRE+" . $_POST['bfmw_num_*EMPRUNT_NOMBRE'] . " WHERE EMPRUNT_OBJ_ID=" . $_POST['bfmw_num_*EMPRUNT_OBJ_ID'] . " AND EMPRUNT_ENS_ID=" . $_POST['bfmw_num_*EMPRUNT_ENS_ID'] . " AND EMPRUNT_ET_ID=" . CURRENT_ID;
                $conn->query($req);
                if ($conn->affected_rows == 1) {
                    envoyerMailEnseignant();
                } else {
                    makeErreur("", "Emprunt", "L'emprunt n'a pas été enregistré. Réessayez.");
                    mysql_rollback();
                }
            } else {
                envoyerMailEnseignant();
            }
        } else {
            makeErreur("", "Emprunt", "Impossible d'enregistrer l'emprunt.");
        }
    } else {
        makeErreur("", "Emprunt", "La date de retour est obligatoire.");
    }
    if (isset($_GET["bfmw_num_a"])) {
        $data .= "&amp;a=".$_GET["bfmw_num_a"];
    }
    if (isset($_GET["bfmw_num_nonclose"])) {
        $data .= "&amp;nonclose=".$_GET["bfmw_num_nonclose"];
    }
}

/**
 * Réserver un créneau de soutenance
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "stages" && isset($_POST['bfmw_orig_selection_creneau']) && isset($_POST['bfmw_orig_selection_creneau'])) {
    $tab = explode("$",$_POST['bfmw_orig_selection_creneau']);
    if (isset($tab[0]) && isset($tab[1]) && isset($tab[2]) && isset($tab[3])) {
        $annee_courante = Annees::getIdAnneeCourante();
        $le_stage = Stages::getStageDUnEtudiant(CURRENT_ID,$annee_courante);
        if ($le_stage != null) {
            if (Stages::inPlanning($le_stage['STAGE_ID'],$tab[3],$annee_courante)) {
                if (Generation_Planning_Soutenances::affecterCreneauDeSoutenance(CURRENT_ID, $le_stage['STAGE_ID'], $tab[3], $annee_courante, CURRENT_DEPT_ID, $tab[1], $tab[0], $tab[2], $le_stage['STAGE_ENS_ID'])) {
                    makeErreur("success", "Réservation de créneau de soutenance", "Le créneau a été réservé.");
                } else {
                    makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau, réessayez.");
                }
            } else {
                makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau.");
            }
        } else {
            makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau, vous n'avez pas de stage.");
        }
    } else {
        makeErreur("", "Réservation de créneau de soutenance", "Impossible de réserver le créneau.");
    }
    if (isset($_GET["bfmw_num_a"])) {
        $data .= "&amp;a=".$_GET["bfmw_num_a"];
    }
    if (isset($_GET["bfmw_num_nonclose"])) {
        $data .= "&amp;nonclose=".$_GET["bfmw_num_nonclose"];
    }
}

function envoyerMailEnseignant() {
    global $conn;
    
    $req = "SELECT OBJ_NOM FROM etudiants_emprunts_objets WHERE OBJ_ID=" . $_POST['bfmw_num_*EMPRUNT_OBJ_ID'];
    $res = $conn->query($req);
    if ($obj = $res->fetch_assoc()) {
        $req = "SELECT ENS_MAIL FROM common_enseignant WHERE ENS_ID=" . $_POST['bfmw_num_*EMPRUNT_ENS_ID'];
        $res = $conn->query($req);
        if ($mail = $res->fetch_assoc()) {
            sendMail($mail['ENS_MAIL'], "Un objet a été emprunté", "Bonjour,\n\n" . $_SESSION['etudiants_nom'] . " vient de déclarer l'emprunt de l'objet '" . $obj['OBJ_NOM'] . "' avec votre autorisation. Il annonce une date de rendue pour le " . $_POST['bfmw_orig_*EMPRUNT_DATE_RETOUR'] . ".\n\nCe sera à vous de déclarer l'objet rendu, en vous rendant sur la plateforme Odin (https://odin.iut.uca.fr)\n\nCordialement");
            mysql_commit();
            makeErreur("success", "Emprunt", "Votre emprunt a été enregistré. Un mail a été envoyé à l'enseignant.");
        } else {
            makeErreur("", "Emprunt", "L'emprunt n'a pas été enregistré. Réessayez.");
            mysql_rollback();
        }
    } else {
        makeErreur("", "Emprunt", "L'emprunt n'a pas été enregistré. Réessayez.");
        mysql_rollback();
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
