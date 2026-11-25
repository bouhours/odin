<?php
/**
 * Auteur : Cédric BOUHOURS
 * Ce code est mis à disposition selon les termes de la Licence Creative Commons Attribution
 * Pas d'Utilisation Commerciale - Pas de Modification 4.0 International.
 *
 ant vous soutient ou soutient la façon dont vous avez utilisé son Oeuvre.
 *
 * Pas d’Utilisation Commerciale — Vous n'êtes pas autorisé à faire un usage commercial de cette Oeuvre, tout ou partie du matériel la composant.
 *
 * Pas de modifications — Dans le cas où vous effectuez un remix, que vous transformez, ou créez à partir du matériel composant l'Oeuvre originale, vous n'êtes pas autorisé à distribuer ou mettre à disposition l'Oeuvre modifiée.
 *
 * Pas de restrictions complémentaires — Vous n'êtes pas autorisé à appliquer des conditions légales ou des mesures techniques qui restreindraient légalement autrui à utiliser l'Oeuvre dans les conditions décrites par la licence.
 *
 *
 */

function isRegistered() : bool
{
    global $clef_session;
    return (CURRENT_USE != '' && CURRENT_ID != 0 && isset($_SESSION[$clef_session]));
}

function isAdmin() : bool
{
    return CURRENT_USE == USER_ADMIN;
}

function verifSession() : void
{
    if (!isRegistered()) {
        echo "Accès refusé.";
        exit;
    }
}

date_default_timezone_set("Europe/Paris");

require_once('self_server_concrete.php');
require_once __DIR__ . '/framework_bootstrap.php';

if (isset($no_cas) && $no_cas && defined("USER_SIGNATURE")) {
    $cas_user = USER_SIGNATURE;
    session_start();
} else {
    require_once('../common/configCAS.php');

    $cas_user = "";
    if ($_SERVER['SERVER_NAME'] === LOCALHOST) {
        $cas_user = USER_ADMIN;
    } else {
        $cas_user = phpCAS::getUser();
    }
}

if ($cas_user == USER_ADMIN && (isset($_GET['bfmw_orig_asUser']) || isset($_SESSION['global_as_user']))) {
    if (!isset($_GET['bfmw_orig_asUser'])) {
        define('CURRENT_USE', $_SESSION['global_as_user']);
    } else {
        define('CURRENT_USE', $_GET['bfmw_orig_asUser']);
        $_SESSION['global_as_user'] = $_GET['bfmw_orig_asUser'];
    }
} else {
    unset($_SESSION['global_as_user']);
    define('CURRENT_USE', $cas_user);
}

if (isset($_GET['bfmw_orig_p'])) {
    if ($_GET['bfmw_orig_p'] === "logout") {
        require_once("Traitement/logout.php");
        exit;
    }
}

require_once 'common.php';

if (!isset($_SESSION[$clef_session])) {
    echo "Accès non autorisé !";
    exit;
}

if (isset($_GET['bfmw_orig_generate'])) {
    require_once 'Traitement/generer' . $_GET['bfmw_orig_generate'] . '.php';
    exit;
}

foreach ($required as $un_require) {
    require_once($un_require);
}

if (! isset($_GET['bfmw_orig_p'])) {
    $_GET['bfmw_orig_p'] = "accueil";
}
$_SESSION[$page_session] = $_GET['bfmw_orig_p'];
if (isAdmin()) {
    if (!file_exists("Traitement/Admin/" . $_GET['bfmw_orig_p'] . ".php")) {
        if (!file_exists("Traitement/" . $_GET['bfmw_orig_p'] . ".php")) {
            $_SESSION[$page_session] = "accueil";
        } else {
            $_SESSION[$page_session] = $_GET['bfmw_orig_p'];
        }
    } else {
        $_SESSION[$page_session] = "Admin/" . $_GET['bfmw_orig_p'];
    }
} else {
    if (!file_exists("Traitement/" . $_GET['bfmw_orig_p'] . ".php")) {
        $_SESSION[$page_session] = "accueil";
    } else {
        $_SESSION[$page_session] = $_GET['bfmw_orig_p'];
    }
}

require_once 'Traitement/overall_header.php';

require_once 'Traitement/menu.php';

require_once("Traitement/" . $_SESSION[$page_session] . ".php");

require_once 'Traitement/overall_footer.php';