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
    if ($_GET['bfmw_orig_p'] == "mailing") {
        $active = isset($_GET['bfmw_orig_e'])?"ACTIVE_MAILING_P":"ACTIVE_MAILING_G";
    }
    if ($_GET['bfmw_orig_p'] == "demission") {
        $active = "ACTIVE_DEM";
    }
    if ($_GET['bfmw_orig_p'] == "fiches") {
        $active = "ACTIVE_FICHES";
    }
}

$table = array(
    $active => "class=\"active\"",
    "PARAM" => isset($_GET['bfmw_orig_e']),
    "IS_SECRETAIRE" => Formations::isSecretaire() || Formations::isChef() || Formations::isResponsable() || isAdmin(),
    "GROUPE" => (isset($_GET['bfmw_num_g'])?("&amp;choix_groupe=".$_GET['bfmw_num_g']):""),
    "ANNEE" => (isset($_GET['bfmw_num_a'])?("&amp;a=".$_GET['bfmw_num_a']):""),
    "GROUPE_TROMBI" => (isset($_GET['bfmw_num_choix_groupe'])?("&amp;g=".$_GET['bfmw_num_choix_groupe']):"")
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");
