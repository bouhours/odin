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
 * GERER INSCRIPTIONS*********************************************
 *****************************************************************/

function inscrire($numeroEtudiant,&$nb_inscrits, $annee_id, $sem_id) {
    global $conn;
    if ($numeroEtudiant!="") {
        $id_etudiant = -1;
        $req = "SELECT * FROM common_etudiant WHERE ET_NUMERO='".$numeroEtudiant."'";
        $resEtu = $conn->query($req);
        if ($resEtu->num_rows === 1) {
            //L'étudiant existe
            $id_etudiant = $resEtu->fetch_assoc()['ET_ID'];
        } else {
            //L'étudiant n'existe pas
            require_once 'Traitement/ldap.php';
            $etudiant = Ldap::ldap_rechercher_etudiant_avec_numeros($numeroEtudiant);
            $etudiant = array($etudiant);
            if (count($etudiant) > 0) {
                manual_bfmw_secure($etudiant);
                $id_etudiant = createData("common_etudiant",$etudiant[0],7);
            }

        }
        if ($id_etudiant > 0) {
            $req = "INSERT INTO common_inscription(INSCRIPT_ET_ID,INSCRIPT_ANNEE_ID,INSCRIPT_SEM_ID) VALUES(" . $id_etudiant . "," . $annee_id . "," .$sem_id . ")";
            $conn->query($req);
            $nb_inscrits++;
        }
    }
}

if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gererinscriptions" && ((isset($_POST['bfmw_orig_inscription']) && isset($_POST['bfmw_orig_ANNEE_ID'])  && isset($_POST['bfmw_orig_SEM_ID'])) || (isset($_GET['bfmw_orig_auto']) && isset($_GET['bfmw_orig_a']) && isset($_GET['bfmw_orig_s']) && isset($_GET['bfmw_orig_n'])))) {
    $ok = true;
    $nb_inscrits = 0;
    mysql_start_transaction();
    if (isset($_GET['bfmw_orig_auto'])) {
        inscrire($_GET['bfmw_num_n'], $nb_inscrits,$_GET['bfmw_num_a'], $_GET['bfmw_num_s']);
        $_POST['bfmw_num_ANNEE_ID'] = $_GET['bfmw_num_a'];
    } else {
        $lesEtudiants = explode("\r\n", $_POST['bfmw_orig_etudiants']);

        $req = "DELETE FROM common_inscription WHERE INSCRIPT_SEM_ID = " . $_POST['bfmw_num_SEM_ID'] . " AND INSCRIPT_ANNEE_ID = " . $_POST['bfmw_num_ANNEE_ID'];
        $conn->query($req);

        if (count($lesEtudiants) == 1) {
            $nb_inscrits = 0;
        }
        $ok = false;
        foreach ($lesEtudiants as $numeroEtudiant) {
            if ($numeroEtudiant !== "") {
                $ok = true;
                inscrire($numeroEtudiant, $nb_inscrits, $_POST['bfmw_num_ANNEE_ID'], $_POST['bfmw_num_SEM_ID']);
            }
        }
    }

    $param .= "&a=".$_POST['bfmw_num_ANNEE_ID'];

    if (!$ok) {
        mysql_commit();
        makeErreur("success", "Inscriptions d'étudiants", "Tous les étudiants ont été désinscrits");
    } else if ($nb_inscrits > 0) {
        mysql_commit();
        makeErreur("success", "Inscriptions d'étudiants", $nb_inscrits." étudiants on été inscrits");
    } else {
        mysql_rollback();
        makeErreur("success", "Inscriptions d'étudiants", "Erreur lors de l'inscription");
    }
}

/**
 * Création d'un étudiant
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "gererinscriptions" && isset($_POST['bfmw_orig_creeretudiant'])) {
    require_once 'Traitement/ldap.php';
    $_POST['bfmw_orig_*ET_LOGIN'] = Ldap::ldap_recherche_login_etudiant($_POST['bfmw_orig_*ET_MAIL']);
    if ($_POST['bfmw_orig_*ET_LOGIN'] != "") {
        makeErreur("", "Ajouter un étudiant", "Une erreur est survenue lors de l'ajout de l'étudiant. Un étudiant identique semble exister.");
    }
    $_POST['bfmw_num_*ET_LOGIN'] = null;
    $_POST['bfmw_orig_*ET_BAC'] = " ";
    $_POST['bfmw_num_*ET_BAC'] = null;
    $_POST['bfmw_num_*ET_NUMERO'] = "";
    $id = createData("common_etudiant", $_POST, 5);

    if ($id > 0) {
        $datapost = array(array(
            "*INSCRIPT_ET_ID" => $id,
            "*INSCRIPT_ANNEE_ID" => $_POST['bfmw_num_ANNEE_COURANTE'],
            "*INSCRIPT_SEM_ID" => $_POST['bfmw_num_SEM_ID']
        ));
        manual_bfmw_secure($datapost);
        createData("common_inscription", $datapost[0], 3);
        makeErreur("success", "Ajouter un étudiant", "L'étudiant a été ajouté avec succès");
    } else {
        makeErreur("", "Ajouter un étudiant", "Une erreur est survenue lors de l'ajout de l'étudiant. Contactez le responsable de formation.");
    }

    $param .= "&a=".$_POST['bfmw_num_ANNEE_COURANTE'];
}