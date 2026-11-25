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

verifSession();

setAttachment($template, "edt", "edt_lazy.html");

$req = "SELECT * FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=".Annees::getIdAnneeCourante()." AND GROUPE_FEUILLE=1 AND GROUPE_ET_ID=" . CURRENT_ID;
$res = $conn->query($req);
$groupe = array();
while ($un_groupe = $res->fetch_assoc()) {
    if ($un_groupe['GROUPE_ADE'] != "") {
        $groupe[] = $un_groupe['GROUPE_ADE'];
    }
}

$events_affiche = array();
//Edt::collectEDT("http://edt.uca.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=$groupe&projectId=".Edt::$current_project_id."&nbWeeks=1&calType=ical",$events_affiche);
if (!Edt::collectEDTv2(Edt::$current_project_id,$groupe,$events_affiche,8,false,true,false,true)) {
    openBloc($template,"erreur");
} else {

    if (empty($events_affiche)) {
        openBloc($template, "rien");
    } else {
        $jour_courant = "";
        foreach ($events_affiche as $un_evt) {
            if ($jour_courant !== $un_evt["DATE_DEBUT"]) {
                $jour_courant = $un_evt["DATE_DEBUT"];
                affectToBloc($template, "un_creneau", $un_evt);
            }
            affectToBloc($template, "un_creneau.un_jour", $un_evt);
        }
    }
}
affectToXHTML($template, array(
    "TODAY" => date("d/m/Y"),
    "SEMAINES" => 8
));

generateCompleteXHTML($template, "edt");