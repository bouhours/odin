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

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Validation d'un contrôle
 */
if (isset($_POST['bfmw_orig_valider_controle']) && isset($_POST['bfmw_orig_visible']) && isset($_POST['bfmw_orig_controle']) && isset($_POST['bfmw_orig_annee'])) {
    if (Controles::validerControle($_POST['bfmw_num_controle'],CURRENT_ID,$_POST['bfmw_num_annee'],$_POST['bfmw_num_visible']==1)) {
        makeErreur("success", "Validation d'un contrôle", "Le contrôle a été correctement validé");
    } else {
        makeErreur("", "Validation d'un contrôle", "Il y a eu une erreur lors de la validation du contrôle.");
    }
    $data .= "&m=" . $_POST['bfmw_num_m'] . "&c=" . $_POST['bfmw_num_controle'] . "&f=" . $_POST['bfmw_num_f'] . "&a=" . $_POST['bfmw_num_annee'];
}

/**
 * Envoie d'un mail sur modification
 */
if (isset($_GET['bfmw_orig_mail']) && isset($_GET['bfmw_orig_m']) && isset($_GET['bfmw_orig_c']) && $_GET['bfmw_orig_p2'] === "accueil") {
    $data .= "&m=" . $_GET['bfmw_num_m'] . "&c=" . $_GET['bfmw_num_c'] . "&f=" . $_GET['bfmw_num_f'];

    if (isset($_GET['bfmw_num_a'])) {
        $annee_courante= $_GET['bfmw_num_a'];
    }

    Notes::envoyerMail($annee_courante,$_GET['bfmw_num_c']);

    makeErreur("success", "Validation d'un contrôle", "Un mail a été envoyé aux étudiants.");
}

/**
 * Création d'un nouveau contrôle
 */
if (isset($_GET['bfmw_orig_newc']) && isset($_GET['bfmw_orig_m']) && isset($_GET['bfmw_orig_p2'])) {
    $donnees = array(array(
        "*CONTROLE_NOM" => (isset($_SESSION['notes_chef'])?"--CONTROLE MIS EN FORCE--":"Contrôle_".addslashes($_SESSION["notes_nom"])."_".rand(1,9)),
        "*CONTROLE_MAT_ID" => $_GET['bfmw_num_m'],
        "*CONTROLE_ANNEE_ID" => ((isset($_SESSION['notes_chef']) || count(Annees::getAnneeNonClose())>1)?$_GET['bfmw_num_a']:$annee_courante),
        "*CONTROLE_ENS_ID" => CURRENT_ID,
        "*CONTROLE_VALIDE" => (isset($_SESSION['notes_chef'])?1:0),
        "*CONTROLE_VISIBLE" => (isset($_SESSION['notes_chef'])?0:1),
        "*CONTROLE_MOYENNE" => (isset($_SESSION['notes_chef'])?1:2),
        "*CONTROLE_COEFF" => 1
    ));
    manual_bfmw_secure($donnees);
    $donnees = $donnees[0];
    $id_controle = Controles::creerControle($donnees);

    if (isset($_SESSION['notes_chef']) || count(Annees::getAnneeNonClose())>1) {
        $data .= "&a=".$_GET['bfmw_num_a'];
    }

    if ($id_controle < 1) {
        makeErreur("", "Erreur !", "Impossible de créer le contrôle. Erreur grave, contactez le responsable de formation");
        unset($_GET['bfmw_orig_m']);
        unset($_GET['bfmw_num_m']);
    } else {
        $data .= "&m=" . $_GET['bfmw_num_m'] . "&c=" . $id_controle . "&f=" . $_GET['bfmw_num_f'];
    }
}

/**
 * Suppression d'un  contrôle
 */
if (isset($_GET['bfmw_orig_del']) && isset($_GET['bfmw_orig_m']) && ($_GET['bfmw_orig_p2'] === "accueil" || $_GET['bfmw_orig_p2'] === "valider")) {
    if (Controles::supprimerControle($_GET['bfmw_num_del'],$_GET['bfmw_num_m'],CURRENT_ID)) {
        makeErreur("success", "Suppression", "Le contrôle a correctement été supprimé.");
    } else {
        makeErreur("", "Suppression", "Impossible de supprimer ce contrôle.");
    }

    $data = "&m=" . $_GET['bfmw_num_m'] . "&f=" . $_GET['bfmw_num_f'];
    if (isset($_GET['bfmw_num_a'])) {
        $data .= "&a=".$_GET['bfmw_num_a'];
    }
}

/**
 * Suppression d'une note
 */
if (isset($_GET['bfmw_orig_del']) && isset($_GET['bfmw_orig_c']) && isset($_GET['bfmw_orig_m']) && $_GET['bfmw_orig_p2'] === "validerControle") {
    if (! Notes::supprimerNote($_GET['bfmw_num_del'],$_GET['bfmw_num_c'])) {
        makeErreur("", "Suppression", "Impossible de supprimer cette note.");
    } else {
        makeErreur("success", "Suppression", "La note a correctement été supprimée.");
    }
    $data = "&c=" . $_GET['bfmw_num_c'] . "&m=" . $_GET['bfmw_num_m'];
}

/**
 * Passage d'un contrôle au brouillon
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_c']) && isset($_GET['bfmw_orig_a']) && isset($_GET['bfmw_orig_m']) && isset($_GET['bfmw_orig_f']) && isset($_GET['bfmw_orig_c'])) {
    if (isset($_SESSION['notes_chef'])) {
        $annee_courante=$_GET['bfmw_num_a'];
        $data .= "&a=" . $annee_courante;

        if (Controles::setControleToBrouillon($_GET['bfmw_num_m'],$_GET['bfmw_num_c'])) {
            makeErreur("success", "Mise au brouillon", "Le contrôle a été replacé au brouillon");
        } else {
            makeErreur("", "Mise au brouillon", "Impossible de repositionner le brouillon.");
        }
    } else {
        makeErreur("", "Erreur !", "Impossible de repositionner le brouillon. 2");
    }


    $data .= "&m=" . $_GET['bfmw_num_m']."&f=" . $_GET['bfmw_num_f'];
}

/**
 * verrouillage d'une matière
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_lock']) && isset($_GET['bfmw_orig_m'])) {
    if (isset($_SESSION['notes_chef'])) {
        $annee_courante= $_GET['bfmw_num_a'];
        $data .= "&a=" . $annee_courante;

        if (Formations::verrouillerMatiere($_GET['bfmw_num_m'],$annee_courante)) {
            makeErreur("success", "Verrouillage de la matière", "La matière a correctement été verrouillée.");
        } else {
            makeErreur("", "Verrouillage de la matière", "Impossible de verrouiler la matière.");
        }

    } else {
        makeErreur("", "Erreur !", "Impossible de verrouiller la matière. 2");
    }


    $data .= "&m=" . $_GET['bfmw_num_m']."&f=" . $_GET['bfmw_num_f'];
}

/**
 * Déverrouillage d'une matière
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_unlock']) && isset($_GET['bfmw_orig_m'])) {
    if (isset($_SESSION['notes_chef'])) {
        $annee_courante = $_GET['bfmw_num_a'];
        $data .= "&a=" . $annee_courante;

        if (Formations::verrouillerMatiere($_GET['bfmw_num_m'],$annee_courante,true)) {
            makeErreur("success", "Déverrouillage de la matière", "La matière a correctement été déverrouillée.");
        } else {
            makeErreur("", "Déverrouillage de la matière", "Impossible de déverrouiler la matière.");
        }
    } else {
        makeErreur("", "Erreur !", "Impossible de déverrouiller la matière.");
    }


    $data .= "&m=" . $_GET['bfmw_num_m']."&f=" . $_GET['bfmw_num_f'];
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $data . $message_erreur;
require 'refresh.php';
