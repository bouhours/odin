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

setAttachment($template, "menu", "menu.html");

$active = "ACTIVE_ACCUEIL";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "voeux" :
            $active = "ACTIVE_VOEUX";
            break;
        case "fiche" :
            $active = "ACTIVE_VOEUX";
            break;
        case "demande" :
        case "recap_demande" :
            $active = "ACTIVE_DEMANDE";
            break;
        case "gestion_demande" :
            $active = "ACTIVE_GESTION_DEMANDE";
            break;
        case "gestion_voeux" :
            $active = 'ACTIVE_GESTION_VOEUX';
            break;
        case "gestion_fiches" :
            $active = 'ACTIVE_GESTION_FICHES';
            break;
    }
}

$table = array(
    $active => "class=\"active\"",
    "IS_GESTIONNAIRE" => isGestionnaire(),
    "IS_ADMIN" => isAdmin()
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");
