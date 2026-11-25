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
 * Création d'un rdv temporaire
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_GET['bfmw_orig_pl']) && isset($_POST['bfmw_orig_DISPO']) && isset($_POST['bfmw_orig_CRENEAU'])) {

    mysql_start_transaction();
    if (Plannings::checkStep2RDV($_GET['bfmw_orig_pl'],time(),$_POST)) {
        $no_rendezvous = Plannings::creerRDVtemporaire($_GET['bfmw_orig_pl'],time(),$_POST);
        if ($no_rendezvous > 0) {
            mysql_commit();
            $param .= "&p=info&pl=".$_GET['bfmw_orig_pl']."&r=$no_rendezvous";
        } else {
            makeErreur("", "Prise de rendez-vous", "Il est impossible de réserver ce créneau. Veuillez réessayer.");
            $param .= "&p=accueil&pl=".$_GET['bfmw_orig_pl'];
            mysql_rollback();
        }
    } else {
        makeErreur("", "Prise de rendez-vous", "Il est impossible de réserver ce créneau. Veuillez réessayer.");
        $param .= "&p=accueil&pl=".$_GET['bfmw_orig_pl'];
        mysql_rollback();
    }

}

/**
 * Création d'un rdv définitif
 */
if (isset($_GET['bfmw_orig_p2']) && isset($_POST['bfmw_orig_pl']) && isset($_POST['bfmw_orig_r']) && isset($_POST['bfmw_orig_*RDV_NOM']) && isset($_POST['bfmw_orig_*RDV_PRENOM']) && isset($_POST['bfmw_orig_*RDV_NUMERO']) && isset($_POST['bfmw_orig_*RDV_TEL']) && isset($_POST['bfmw_orig_*RDV_MAIL'])) {

    mysql_start_transaction();
    if (Plannings::checkStep3RDV($_POST['bfmw_orig_pl'],time())) {
        $no_rendezvous = Plannings::creerRDVdefinitif($_POST['bfmw_orig_pl'],time(),$_POST);
        if ($no_rendezvous == 0) {
            mysql_commit();
            Plannings::confirmerRDV(Plannings::getRendezVous($_POST['bfmw_num_r']));
            $param .= "&p=end&pl=".$_POST['bfmw_orig_pl']."&r=".$_POST['bfmw_num_r'];
        } else {
            makeErreur("", "Prise de rendez-vous", "Il est impossible de réserver ce créneau. Veuillez réessayer.");
            $param .= "&p=accueil&pl=".$_POST['bfmw_orig_pl'];
            mysql_rollback();
        }
    } else {
        makeErreur("", "Prise de rendez-vous", "Il est impossible de réserver ce créneau. Veuillez réessayer.");
        $param .= "&p=accueil&pl=".$_POST['bfmw_orig_pl'];
        mysql_rollback();
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

