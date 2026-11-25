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
 * Mise à jour de la configuration
 */
if (isset($_POST['bfmw_orig_saveConfig']) && $_GET['bfmw_orig_p2']=="jury") {
    $formations_autorisees = Formations::getFormationsDuConnecteString();

    $req = "SELECT * FROM common_formation WHERE FORM_ID IN ($formations_autorisees) AND FORM_ID=".$_GET['bfmw_num_f'];
    if (isAdmin()) {
        $req = "SELECT * FROM common_formation WHERE FORM_ID=".$_GET['bfmw_num_f'];
    }
    $res = $conn->query($req);
    $is_modifiable = $res->num_rows > 0;

    if ($is_modifiable) {
        if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/", $_POST['bfmw_orig_DDEBUT']) === false) {
            makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
        }
        if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/", $_POST['bfmw_orig_DFIN']) === false) {
            makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
        }
        if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/", $_POST['bfmw_orig_HDEBUT']) === false) {
            makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
        }
        if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/", $_POST['bfmw_orig_HFIN']) === false) {
            makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
        }

        $req = "UPDATE common_formation SET FORM_JURY_DEBUT=" . transformDateHeureSepares($_POST['bfmw_orig_DDEBUT'], $_POST['bfmw_orig_HDEBUT']) . ", FORM_JURY_FIN=" . transformDateHeureSepares($_POST['bfmw_orig_DFIN'], $_POST['bfmw_orig_HFIN']) . " WHERE FORM_ID=" . $_GET['bfmw_num_f'];
        $conn->query($req);
       } else {
        makeErreur("", "Erreur !", "Piratage détecté.");
    }

    $param .= "&f=".$_GET['bfmw_num_f'];
}


/**
 * Expiration de date
 */
if (isset($_POST['bfmw_orig_expire']) && isset($_GET['bfmw_orig_f']) && $_GET['bfmw_orig_p2'] == "jury" && isset($_POST['bfmw_orig_date_expire']) && (Formations::isResponsable() || Formations::isSecretaire())) {
    $formations_autorisees = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,Annees::getIdAnneeCourante());
    if (! key_exists($_GET['bfmw_num_f'],$formations_autorisees)) {
        makeErreur("", "Erreur !", "Il y a eu une erreur lors de l'expiration");
    }

    $nombre = Absences::expirerAbsences($_GET['bfmw_num_f'],transformDate($_POST['bfmw_orig_date_expire']));
    makeErreur("success", "Expiration des absences", "$nombre abences ont été expirées");

    $param .= "&f=".$_GET['bfmw_num_f'];
}

/**
 * Création d'un diplôme
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_POST['bfmw_orig_creer_diplome']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    $data = array();
    bfmw_add_secured($data,"*DIPLOME_NOM","Nouveau diplôme");
    bfmw_add_secured($data,"*DIPLOME_ELIM",8);
    bfmw_add_secured($data,"*DIPLOME_VAL",10);
    bfmw_add_secured($data,"*DIPLOME_DEPT_ID",CURRENT_DEPT_ID);
    $diplome = createData("common_resultats_diplome",$data,4);

    if ($diplome > 0) {
        makeErreur("success", "Création d'un diplôme", "Le diplôme a été correctement créé");
    } else {
        makeErreur("", "Création d'un diplôme", "Il y a eu une erreur lors de la création du diplome");
    }


    $param .= "&d=".$diplome;
}

/**
 * Création d'un niveau
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_POST['bfmw_orig_creer_niveau']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    $niveau = createData("common_resultat_niveau",$_POST,3);

    if ($niveau > 0) {
        makeErreur("success", "Création d'un niveau", "Le niveau a été correctement créé");
    } else {
        makeErreur("", "Création d'un niveau", "Il y a eu une erreur lors de la création du niveau");
    }


    $param .= "&d=".$_POST["bfmw_num_*NIVEAU_DIPLOME_ID"];
}

/**
 * Création d'un regroupement
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_POST['bfmw_orig_creer_regroupement']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    $niveau = createData("common_resultat_regroupement_ue",$_POST,3);

    if ($niveau > 0) {
        makeErreur("success", "Création d'un regroupement cohérent d'ue", "Le regroupement a été correctement créé");
    } else {
        makeErreur("", "Création d'un regroupement cohérent d'ue", "Il y a eu une erreur lors de la création du regroupement");
    }


    $param .= "&d=".$_POST["bfmw_num_DIPLOME_ID"];
}

/**
 * Ajouter une UE à un regroupement
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_POST['bfmw_orig_creer_resultat_ue']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {
    $niveau = createData("common_resultat_ue",$_POST,3);

    if ($niveau != -1) {
        makeErreur("success", "Ajouter une UE à un regroupement cohérent d'ue", "L'UE a été correctement ajoutée");
    } else {
        makeErreur("", "Ajouter une UE à un regroupement cohérent d'ue", "Il y a eu une erreur lors de l'ajout de l'UE");
    }


    $param .= "&d=".$_POST["bfmw_num_DIPLOME_ID"];
}

/**
 * Supprimer un diplôme
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_GET['bfmw_orig_deld']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {

    $done = Resultats::supprimerDiplome($_GET['bfmw_num_deld'],CURRENT_DEPT_ID);

    if ($done) {
        makeErreur("success", "Suppression d'un diplôme", "Le diplôme a été correctement supprimé");
    } else {
        makeErreur("", "Suppression d'un diplôme", "Il y a eu une erreur lors de la suppression du diplôme");
        $param .= "&d=".$_GET['bfmw_num_deld'];
    }
}

/**
 * Supprimer un niveau
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_GET['bfmw_orig_deln']) && isset($_GET['bfmw_orig_d']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {

    $done = Resultats::supprimerNiveau($_GET['bfmw_num_deln'],CURRENT_DEPT_ID);

    if ($done) {
        makeErreur("success", "Suppression d'un niveau", "Le niveau a été correctement supprimé");
    } else {
        makeErreur("", "Suppression d'un niveau", "Il y a eu une erreur lors de la suppression du niveau");
    }
    $param .= "&d=".$_GET['bfmw_num_d'];
}

/**
 * Supprimer un regroupement
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_GET['bfmw_orig_delr']) && isset($_GET['bfmw_orig_d']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {

    $done = Resultats::supprimerRegroupement($_GET['bfmw_num_delr'],CURRENT_DEPT_ID);

    if ($done) {
        makeErreur("success", "Suppression d'un regroupement", "Le regroupement a été correctement supprimé");
    } else {
        makeErreur("", "Suppression d'un regroupement", "Il y a eu une erreur lors de la suppression du regroupement");
    }
    $param .= "&d=".$_GET['bfmw_num_d'];
}

/**
 * Supprimer une ue
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] == "resultats" && isset($_GET['bfmw_orig_delrue']) && isset($_GET['bfmw_orig_d']) && isset($_GET['bfmw_orig_r']) && (Formations::isChef() || Formations::isResponsable() || Formations::isSecretaire())) {

    $done = Resultats::supprimerUE($_GET['bfmw_num_delrue'],$_GET['bfmw_num_r'],CURRENT_DEPT_ID);

    if ($done) {
        makeErreur("success", "Suppression d'une UE", "L'UE a été correctement supprimé");
    } else {
        makeErreur("", "Suppression d'une UE", "Il y a eu une erreur lors de la suppression de l'UE");
    }
    $param .= "&d=".$_GET['bfmw_num_d'];
}