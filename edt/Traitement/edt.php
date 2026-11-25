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

if (!isset($param_edt)) {
    $param_edt="";
}

if (isset($_POST['bfmw_orig_creneau'])) {
    $_POST['bfmw_orig_creneau'] = unserialize(stripslashes(html_entity_decode($_POST['bfmw_orig_creneau'])));
}

verifSession();

setAttachment($template, "edt", "edt.html");

$req = "SELECT * FROM edt_access_enseignants WHERE ENS_ID =" . CURRENT_ID;
$res = $conn->query($req);
$events_affiche = array();
$enseignant = $res->fetch_assoc();
$semaines=0;
if ($enseignant['ENS_ADE'] != '') {

    //Edt::collectEDT("http://edt.uca.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=" . $enseignant['ENS_ADE'] . "&projectId=".Edt::$current_project_id."&nbWeeks=$semaines&calType=ical", $events_affiche);
    if (! Edt::collectEDTv2(Edt::$current_project_id,array($enseignant['ENS_ADE']),$events_affiche,($param_edt === "modification")?50:8)) {
        openBloc($template,"erreur");
    } else {
        $jour_courant = "";
        if (empty($events_affiche)) {
            openBloc($template, "rien");
        } else {
            foreach ($events_affiche as $un_evt) {
                if ($param_edt !== "recap" || ($param_edt === "recap" && isset($_POST['bfmw_orig_creneau']) && in_array($un_evt["UID"], $_POST['bfmw_orig_creneau']))) {
                    if ($jour_courant !== $un_evt["DATE_DEBUT"]) {
                        $jour_courant = $un_evt["DATE_DEBUT"];
                        affectToBloc($template, "un_creneau", $un_evt);
                    }
                    affectToBloc($template, "un_creneau.un_jour", $un_evt);
                }
            }
        }
    }
} else {
    openBloc($template, "no_ade");
}
$mailing = $enseignant['ENS_EDT'] === "1";

affectToXHTML($template, array(
    "TODAY" => date("d/m/Y"),
    "MAILING" => $mailing == 0 ? "" : "checked",
    "SELECTOR" => $param_edt === "modification",
    "RECAP" => $param_edt === "recap"
));


generateCompleteXHTML($template, "edt");
