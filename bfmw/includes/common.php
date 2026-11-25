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

require_once("header.php");

require_once ("secure.php");

require_once ("init_query_string.php");

require_once ("functions.php");

require_once('tpl_functions.php');

$autoloadTrouve = false;
foreach (array(
    __DIR__ . "/../vendor/autoload.php",
    __DIR__ . "/../../vendor/autoload.php",
) as $cheminAutoload) {
    if (!file_exists($cheminAutoload)) {
        continue;
    }
    require_once $cheminAutoload;
    $autoloadTrouve = true;
    break;
}

if (!$autoloadTrouve) {
    throw new RuntimeException("Impossible de charger l'autoload Composer pour BFMW.");
}

$template = attachXHTML();

$lang = array();

$conn = openConnexion($db_server,$db_user,$db_pwd,$db_database);

$_ERREUR = array();


spl_autoload_register(function ($name) {
    global $conn;

    @include_once __DIR__."/../../common/Model/$name.php";
    if (method_exists($name,"static_init")) {
        $name::static_init($conn);
    }
    @include_once __DIR__."/../../common/View/$name.php";
    if (method_exists($name,"static_init")) {
        $name::static_init($conn);
    }
});

define('FICHIER_SYNCHRONISATION', $dossier_racine . "/cache/BFMWsynchronization.php");

define('FICHIER_XSTR_LOG', $dossier_racine . "/info.log");

define('CHEMIN_LANGUE', $dossier_racine . "/language/");
