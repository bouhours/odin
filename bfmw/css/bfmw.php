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

function getBFMWcss() : string{
    $les_fichiers = array(
        "global.css",
        "main.css",
        "master.css",
        "detail.css",
        "mdresponsive.css",
        "menu.css",
        "alert.css",
        "tooltip.css",
        "table.css",
        "treeview.css",
        "update_box.css",
        "resultat.css"
    );

    $retour = "";

    foreach ($les_fichiers as $un_fichier) {
        $retour .= "\t\t<link href=\"../bfmw/css/".$un_fichier."?v=".filemtime(__DIR__."/".$un_fichier)."\" rel=\"stylesheet\" type=\"text/css\">\n";
    }

    $fichier_print = "print.css";

    $retour .= "\t\t<link href=\"../bfmw/css/".$fichier_print."?v=".filemtime(__DIR__."/".$fichier_print)."\" rel=\"stylesheet\" type=\"text/css\" media=\"print\">\n";

    return $retour;
}