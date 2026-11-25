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

$is_evaluable = count(Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,Annees::getIdAnneeCourante(),"AND FORM_EVALUABLE=1"))>0;

$active = "ACTIVE_SAISIR";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "groupe":
            $active = "ACTIVE_GROUPES";
            break;
        case "creergroupe":
            $active = "ACTIVE_CREER";
            break;
        case "gererformation":
            $active = "ACTIVE_GERER_FORMATION";
            break;
        case "gererenseignant":
            $active = "ACTIVE_GERER_ENSEIGNANT";
            break;
        case "creerenseignants":
            $active = "ACTIVE_CREER_ENSEIGNANT";
            break;
        case "accessenseignant":
            $active = "ACTIVE_ACCESS_ENSEIGNANT";
            break;
        case "gereretudiants":
            $active = "ACTIVE_GERER_ETUDIANTS";
            break;
        case "poursuite":
            $active = "ACTIVE_POURSUITE";
            break;
        case "clotures":
            $active = "ACTIVE_CLOTURES";
            break;
        case "gererinscriptions":
            $active = "ACTIVE_GERER_INSCRIPTIONS";
            break;
        case "aide":
            $active = "ACTIVE_AIDE";
            break;
        case "evaluation":
            $active = "ACTIVE_EVAL";
            break;
        case "jury":
            $active = "ACTIVE_JURY";
            break;
        case "vacataire":
            $active = "ACTIVE_VACATAIRE";
            break;
        case "periodes":
            $active = "ACTIVE_PERIODE";
            break;
        case "resultats":
            $active = "ACTIVE_RESULTATS";
            break;
        case "soutenances":
            $active = "ACTIVE_SOUTENANCES";
            break;
        case "renseignement":
            $active = "ACTIVE_RENSEIGNEMENTS";
            break;
        case "planning":
            $active = "ACTIVE_PLANNING";
            break;
    }
    if ($_GET['bfmw_orig_p'] == "vacataire" && isset($_GET['bfmw_orig_perm'])) {
        $active = "ACTIVE_PERMANENT";
    }
}

$table = array(
      $active => "class=\"active\"",
    "EVALUABLE" => $is_evaluable,
    "ANNEE" => (isset($_GET["bfmw_orig_a"])?"&amp;a=".$_GET["bfmw_orig_a"]:""),
    "FORMATION" => (isset($_GET["bfmw_orig_f"])?"&amp;f=".$_GET["bfmw_orig_f"]:"")
);

affectToXHTML($template, $table);

if (isAdmin()) {
    openBloc($template, "admin");
}

generateCompleteXHTML($template, "menu");