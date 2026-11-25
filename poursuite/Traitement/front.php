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
 * Message au locker
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_m']) && isset($_GET['bfmw_orig_mail'])) {
    $req = "SELECT common_enseignant.ENS_MAIL,PMAT_NOM, common_enseignant.ENS_NOM FROM poursuites_pmatieres, common_enseignant WHERE common_enseignant.ENS_ID=PMAT_ENS_ID AND poursuites_pmatieres.ENS_ID=".CURRENT_ID." AND PMAT_ID=".$_GET['bfmw_num_m'];
    $res = $conn->query($req);
    if ($mail = $res->fetch_assoc()) {
        sendMail($mail['ENS_MAIL'], "Accès aux poursuites d'études", "Bonjour,\n\n".$mail['ENS_NOM']." cherche à saisir les fiches de poursuites d'études pour ".$mail['PMAT_NOM'].". Cependant, vous avez bloqué la page. Si vous êtes en train de saisir, pas de problème. Sinon, c'est qu'il y a eu un problème lors de la fermeture de votre navigateur. A ce moment là, retournez sur la page de poursuite d'études sur Odin (https://odin.iut.uca.fr), puis cliquez sur 'Se déconnecter'.\n\nMerci d'avance\n\nCordialement");
        makeErreur("success", "Mail", "Un message vient d'être envoyé.");
    } else {
        makeErreur("", "Mail", "Impossible d'envoyer le message.");
    }
}

/**
 * Suppression d'un semestre
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "jury_edit" && isset($_GET['bfmw_orig_clotdels'])  && isset($_GET['bfmw_orig_clotdela']) && (Formations::isResponsable() || Formations::isSecretaire())) {
    $req = "DELETE FROM common_cloture_sem WHERE (CLOT_ANNEE_ID=".$_GET['bfmw_num_clotdela']." OR CLOT_ANNEE_ID=".$_GET['bfmw_num_clotdela']."-1) AND CLOT_SEM_ID=".$_GET['bfmw_num_clotdels'];
    if ($conn->query($req)) {
        makeErreur("success", "Suppression d'un semestre", "Le semestre a été correctement supprimé.");
    } else {
        makeErreur("", "Suppression d'un semestre", "Le semestre n'a pas été correctement supprimé.");
    }
}

/**
 * Suppression d'une ue
 */
if (isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2'] === "jury_edit" && isset($_GET['bfmw_orig_clotdelue'])  && isset($_GET['bfmw_orig_clotdela']) && (Formations::isResponsable() || Formations::isSecretaire())) {
    $req = "DELETE FROM common_cloture_ue WHERE (CLOT_ANNEE_ID=".$_GET['bfmw_num_clotdela']." OR CLOT_ANNEE_ID=".$_GET['bfmw_num_clotdela']."-1) AND CLOT_UE_ID=".$_GET['bfmw_num_clotdelue'];
    if ($conn->query($req)) {
        makeErreur("success", "Suppression d'une UE", "L'UE a été correctement supprimée.");
    } else {
        makeErreur("", "Suppression d'une UE", "L'UE n'a pas été correctement supprimée.");
    }
}

$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=".urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=".urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=".urlencode($_ERREUR[0]['MESSAGE']);
}
$send="p=".$_GET['bfmw_orig_p2'].$message_erreur.$data;
require 'refresh.php';
