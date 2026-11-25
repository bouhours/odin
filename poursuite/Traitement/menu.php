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

setAttachment($template,"menu", "menu.html");

$active = "ACTIVE_CONSULTER";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        /*case "saisir" : $active = "ACTIVE_SAISIR";break;
        case "orthographe" : $active = "ACTIVE_ORTHO";break;
        case "jury" : $active = "ACTIVE_JURY";break;
        case "jury_edit" : $active = "ACTIVE_JURY_EDIT";break;*/
    }
}

$req = "SELECT * FROM poursuites_access_enseignants WHERE ENS_ID=".CURRENT_ID;
if ($conn->query($req)->num_rows > 0 && !Formations::isSecretaire()) {
    openBloc($template,"saisisseur");
}
if (Formations::isSecretaire()) {
    openBloc($template,"orthographe");
}
if (Formations::isResponsable()) {
    openBloc($template,"admin");
}

affectToBlocAndRepeat($template,"une_categ",Poursuites::getCategorie(CURRENT_DEPT_ID,(isset($_GET['bfmw_num_categ'])?$_GET['bfmw_num_categ']:null)));

$table = array(
      $active => "class=\"active\""
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");