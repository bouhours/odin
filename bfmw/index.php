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

require_once 'common.php';

require_once 'Traitement/binding.php';

$_SESSION["projet_page"] = "accueil";

if (isset($_GET['bfmw_orig_p'])) {
    $_SESSION["projet_page"] = $_GET['bfmw_orig_p'];
    if (isAdmin()) {
        if (!file_exists("Traitement/Admin/" . $_GET['bfmw_orig_p'] . ".php")) {
            if (!file_exists("Traitement/" . $_GET['bfmw_orig_p'] . ".php")) {
                $_SESSION["projet_page"] = "accueil";
            } else {
                $_SESSION["projet_page"] = $_GET['bfmw_orig_p'];
            }
        } else {
            $_SESSION["projet_page"] = "Admin/".$_GET['bfmw_orig_p'];
        }
    } else {
        if (!file_exists("Traitement/" . $_GET['bfmw_orig_p'] . ".php")) {
            $_SESSION["projet_page"] = "accueil";
        } else {
            $_SESSION["projet_page"] = $_GET['bfmw_orig_p'];
        }
    }
} else {
    $_SESSION["projet_page"] = "accueil";

}

require_once 'Traitement/overall_header.php';

require_once 'Traitement/menu.php';

require_once("Traitement/".$_SESSION["projet_page"].".php");

require_once 'Traitement/overall_footer.php';