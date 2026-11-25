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

define('FRONT_ACCESS',7);

if (isset($_GET['bfmw_orig_p2'])) {
    switch ($_GET['bfmw_orig_p2']) {
        case "vacataire" :
            require_once 'fronts/front_gerermail.php';
            break;
        case "periodes" :
            require_once 'fronts/front_gererperiodes.php';
            break;
        case "gererenseignant" :
            require_once 'fronts/front_gereraffectations.php';
            break;
        case "do_update_enseignants":
        case "creerenseignants" :
            require_once 'fronts/front_gererenseignants.php';
            break;
        case "gereretudiants" :
            require_once 'fronts/front_gereretudiants.php';
            break;
        case "gererinscriptions" :
            require_once 'fronts/front_gererinscriptions.php';
            break;
        case "gererformation" :
            require_once 'fronts/front_gererformation.php';
            break;
        case "creergroupe" :
        case "groupe" :
            require_once 'fronts/front_gerergroupes.php';
            break;
        case "clotures" :
        case "poursuite" :
            require_once 'fronts/front_gererpoursuites.php';
            break;
        case "feries" :
            require_once 'fronts/front_gererferies.php';
            break;
        case "evaluation" :
            require_once 'fronts/front_gererevaluations.php';
            break;
        case "jury" :
        case "resultats" :
            require_once 'fronts/front_gererjury.php';
            break;
        case "soutenances" :
            require_once 'fronts/front_soutenances.php';
            break;
        case "renseignement" :
            require_once 'fronts/front_renseignement.php';
            break;
        case "planning" :
            require_once 'fronts/front_planning.php';
            break;
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
