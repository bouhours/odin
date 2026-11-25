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

verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "info", "info.html");

$planning_courant = -1;
$planning = null;
if (isset($_GET["bfmw_orig_pl"])) {
    $les_plannings = Plannings::getPlanningAvecUid($_GET["bfmw_orig_pl"],time());
    foreach ($les_plannings as $planning_id=>$un_planning) {
        $planning_courant = $planning_id;
        $planning = $un_planning;
        break;
    }
}

if ($planning_courant > 0 && $planning != null) {
    $rdv_courant = -1;
    if (isset($_GET["bfmw_orig_r"])) {
        $rdv_courant = $_GET["bfmw_orig_r"];
        $les_rdv = Plannings::getRendezVousTemporaire($rdv_courant,session_id());
        if (count($les_rdv) != 1) {
            $send="p=accueil&pl=".$_GET["bfmw_orig_pl"];
            require 'refresh.php';
            exit;
        }
        foreach ($les_rdv as $un_rdv) {
            affectToXHTML($template,$un_rdv);
            affectToXHTML($template,array("PLANNING_UID"=>$_GET["bfmw_orig_pl"]));
        }
    }

}

affectToXHTML($template,array(

));

generateCompleteXHTML($template, "info");