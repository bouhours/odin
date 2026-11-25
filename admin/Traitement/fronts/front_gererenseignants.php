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
 * GERER ENSEIGNANTS ************************************************
 *****************************************************************/
/**
 * Créer enseignant
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "creerenseignants" && isset($_POST['bfmw_orig_creerenseignant'])) {
    $req = "SELECT * FROM common_enseignant WHERE ENS_LOGIN='".$_POST['bfmw_orig_*ENS_LOGIN']."'";
    $id = -1;
    $res = $conn->query($req);
    if ($res->num_rows > 0) {
        $id = $res->fetch_assoc()["ENS_ID"];
    } else {
        $req = "SELECT * FROM extraction_res_ade WHERE EXTRACT_CODE='".$_POST['bfmw_orig_*ENS_CODE_EMPLOYE']."'";
        $resEXTRACTEUR_ADE = $conn->query($req);
        if ($resEXTRACTEUR_ADE->num_rows === 1) {
            $numero = $resEXTRACTEUR_ADE->fetch_assoc()['EXTRACT_NUMERO'];
            $_POST['bfmw_orig_*ENS_ADE'] = $numero;
            $_POST['bfmw_num_*ENS_ADE'] = get_numeric($numero);
            $id = createData("common_enseignant", $_POST, 8);
        } else {
            $id = createData("common_enseignant", $_POST, 7);
        }
    }
    if ($id != -1) {
        $tab = array(array(
           "*DEPT_ENS_ID" => $id,
           "*ENS_DEPT_CURRENT" => 1,
           "*ENS_DEPT_ID" => CURRENT_DEPT_ID
        ));
        manual_bfmw_secure($tab);

        createData("common_enseignants_departement",$tab[0],3);
        makeErreur("success", "Ajouter un enseignant", "L'enseignant a été ajouté avec succès");
    } else {
        makeErreur("", "Ajouter un enseignant", "Une erreur est survenue lors de l'ajout de l'enseignant. Contactez le responsable de formation.");
    }
}

/**
 * Créer enseignantManuel
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "creerenseignants" && isset($_GET['bfmw_orig_manuel']) && isset($_GET['bfmw_orig_name'])) {
    $datapost = array(array(
        "*ENS_NOM" => $_GET['bfmw_orig_name'],
        "*ENS_LOGIN" => "NULL",
        "*ENS_MAIL" => ""
    ));
    manual_bfmw_secure($datapost);
    $id = createData("common_enseignant", $datapost[0], 3);
    if ($id > 0) {
        $tab = array(array(
            "*DEPT_ENS_ID" => $id,
            "*ENS_DEPT_CURRENT" => 1,
            "*ENS_DEPT_ID" => CURRENT_DEPT_ID
        ));
        manual_bfmw_secure($tab);

        createData("common_enseignants_departement",$tab[0],3);

        makeErreur("success", "Ajouter un enseignant", "L'enseignant a été ajouté avec succès");
    } else {
        makeErreur("", "Ajouter un enseignant", "Une erreur est survenue lors de l'ajout de l'enseignant. Contactez le responsable de formation.");
    }
}

/**
 * Suppression d'un enseignant
 */
if (isset($_GET['bfmw_orig_delens'])) {
    mysql_start_transaction();
    $valide = Enseignants::supprimerEnseignantDuDepartement($_GET['bfmw_num_delens'],CURRENT_DEPT_ID,$annee_courante);
    if ($valide) {
        makeErreur("success", "Suppression d'un enseignant", "L'enseignant a été supprimé du département avec succès");
        mysql_commit();
    } else {
        makeErreur("", "Suppression d'un enseignant", "Une erreur est survenue lors de la suppression de l'enseignant. Contactez le responsable de formation.");
        mysql_rollback();
    }
}

/**
 * Mise à jour d'un enseignant par le ldap
 */
if (isAdmin() && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="do_update_enseignants" && isset($_POST["bfmw_orig_login_to_update"]) && isset($_POST["bfmw_num_ENS_ID"])) {
    if ($_POST["bfmw_orig_login_to_update"] != "NULL") {
        $les_infos = Ldap::ldap_infos("(&(cn=".$_POST["bfmw_orig_login_to_update"].")(|(employeetype=9)(department=*:enseignants)(department=*:administratifs)(department=*:heberges)(department=*:vacataires)))");
        foreach ($les_infos as $une_info) {
            Enseignants::updateEnseignant($_POST["bfmw_num_ENS_ID"], $une_info["login"], $une_info["nom"],$une_info["prenom"], $une_info["employeeid"],$une_info["naissance"],$une_info["mail"]);
            break;
        }
    }
}