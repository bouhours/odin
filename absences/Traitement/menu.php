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

if (!Formations::isSecretaire()) {
    openBloc($template, "isIntervenant");
}

if (Formations::isSecretaire()) {
    openBloc($template,"isSecretaire");
}

if (Formations::isSecretaire() || Formations::isResponsable() || Formations::isChef()) {
    openBloc($template,"isChef");
}

$annee_courante = Annees::getIdAnneeCourante();

$les_formations_avec_absences_auto = Formations::getFormation(Formations::getFormationsDeLEnseignantConnecteString(CURRENT_ID,$annee_courante,CURRENT_DEPT_ID,"FORM_ABSENCES_AUTO = 1 AND "));

if (count($les_formations_avec_absences_auto) > 0) {
    $_SESSION["ACTIVE_ABSENCES_AUTO"] = 1;
} else {
    unset($_SESSION["ACTIVE_ABSENCES_AUTO"]);
}

$les_formations_avec_absences_pro = Formations::getFormation(Formations::getFormationsDeLEnseignantConnecteString(CURRENT_ID,$annee_courante,CURRENT_DEPT_ID,"FORM_PRO = 1 AND "));

if (count($les_formations_avec_absences_pro) > 0) {
    $_SESSION["ACTIVE_ABSENCES_PRO"] = 1;
} else {
    unset($_SESSION["ACTIVE_ABSENCES_PRO"]);
}

$active = "ACTIVE_DECLARE";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "lire":
            $active = "ACTIVE_LIRE";
            break;
        case "aide":
            $active = "ACTIVE_AIDE";
            break;
        case "fiches":
            $active = "ACTIVE_FICHES";
            break;
        case "signature":
        case "signer":
            $active = "ACTIVE_ABSENCES_AUTO";
            break;
    }
    if ($_GET['bfmw_orig_p'] == "accueil" && isset($_GET['bfmw_orig_chef'])) {
        $active = "ACTIVE_CHEF";
    }
}

$table = array(
    $active => "class=\"active\"",
    "IS_ABSENCES_AUTO" => isset($_SESSION["ACTIVE_ABSENCES_AUTO"]),
    "IS_ABSENCES_PRO" => isset($_SESSION["ACTIVE_ABSENCES_PRO"])
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");
