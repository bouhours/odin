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

setAttachment($template, "header", "overall_header.html");

if (isset($_SESSION["soutenances_page"])) {
    $nom_fichier = "css/specific_" . $_SESSION["soutenances_page"] . ".css";
    if (file_exists($nom_fichier)) {
        openBloc($template, "specific");

        affectToXHTML($template, array(
            "STYLE_SPECIFIQUE" => "$nom_fichier",
            "AGE_STYLE_SPECIFIQUE" => filemtime($nom_fichier)
        ));
    }

    $nom_fichier = "js/specific_" . $_SESSION["soutenances_page"] . ".js";
    if (file_exists($nom_fichier)) {
        openBloc($template, "specific_js");

        affectToXHTML($template, array(
            "JS_SPECIFIQUE" => "$nom_fichier",
            "AGE_JS_SPECIFIQUE" => filemtime($nom_fichier)
        ));
    }
}

$bfmw_style = "../bfmw/css/bfmw.css";
$bfmw_js = "../bfmw/js/bfmw.js";
$local_style = "css/style.css";
$local_js = "js/main.js";

require_once "../bfmw/css/bfmw.php";

affectToXHTML($template, array(
    "BFMW_STYLE" => getBFMWcss(),
    "LOCAL_STYLE" => "$local_style?v=".filemtime($local_style),
    "BFMW_JS" => "$bfmw_js?v=".filemtime($bfmw_js),
    "LOCAL_JS" => "$local_js?v=".filemtime($local_js)
));

generateCompleteXHTML($template, "header");