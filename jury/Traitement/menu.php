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

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$formations = implode(",",array_keys(Formations::getFormationDuDepartement(CURRENT_DEPT_ID,$annee_courante)));
$jurys_actifs = Jury::getFormationsAyantDesJurys($formations,$annee_courante,"JURY_START <= ".time(). " AND JURY_END >= ".time()." AND ");
unset($_SESSION['session_vote_formation']);
foreach ($jurys_actifs as $un_jury) {
    if (isset($_GET['bfmw_num_f']) && $_GET['bfmw_num_f']==$un_jury['FORM_ID'] && isset($_GET['bfmw_orig_p']) && $_GET['bfmw_orig_p']=="vote") {
        $un_jury['ACTIVE_VOTE'] = "class=\"active\"";
        $_SESSION['session_vote_formation'] = $un_jury['FORM_ID'];
    } else {
        $un_jury['ACTIVE_VOTE'] = "";
    }
    affectToBloc($template, "une_formation_ayant_jury", $un_jury);
}



$active = "ACTIVE_ACCUEIL";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "accueil" : $active = "ACTIVE_ACCUEIL";break;
        case "preparation" : $active = "ACTIVE_PREPARATION";break;
        case "vote" : $active = " ";break;
    }
}

$table = array(
    $active => "class=\"active\"",
    "ANNEE_COURANTE" => $annee_courante,
    "IS_RESPONSABLE" => Formations::isResponsable() || Formations::isSecretaire()
);
affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");