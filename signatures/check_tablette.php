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

if ($_SERVER['SERVER_NAME'] !== LOCALHOST) {
    if (preg_match(PATTERN_SIGNATURE, $_SERVER['HTTP_USER_AGENT']) !== 1) {
        unset($_SESSION['POST']);
        die("Vous ne pouvez pas signer avec ce support. Utilisez les tablettes fournies par votre département.");
    }

    if (isset($_GET['bfmw_orig_die'])) {
        unset($_SESSION['POST']);
        die("Vous ne pouvez pas signer avec ce support. Utilisez les tablettes fournies par votre département.");
    }

    if (!isset($_GET['bfmw_orig_mayi'])) {
        unset($_SESSION['POST']);
        unset($_SESSION['GET']);
        $_SESSION['POST'] = $_POST;
        $_SESSION['GET'] = $_GET;

        $send = "p=mayi&d=$send_may_i";
        require "refresh.php";
        exit;
    } else {

        $tablette_courante = Tablettes::getTablette($_GET['bfmw_orig_mayi']);
        if (count($tablette_courante) != 1) {
            Tablettes::createTabletteAsk($_GET['bfmw_orig_mayi']);
            die("La tablette que vous utilisez n'est pas une tablette officielle. Utilisez les tablettes fournies par votre département.");
        }

        if (isset($_SESSION["POST"])) {
            $_POST = $_SESSION["POST"];
        }
        if (isset($_SESSION["GET"])) {
            $_GET = $_SESSION["GET"];
        }

        if (!defined("CURRENT_DEPT_ID")) {
            define('CURRENT_DEPT_ID', $tablette_courante[0]["FORM_DEPT_ID"]);
        }
    }
} else {
    if (!defined("CURRENT_DEPT_ID")) {
        define('CURRENT_DEPT_ID', 1);
    }
    $tablette_courante[]["TABLETTE_FORM_ID"] = 108;
}

