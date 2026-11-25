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

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}
$annee_courante = Annees::getIdAnneeCourante();

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,$annee_courante)) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

setAttachment($template, "absences", "absences.html");

/**
 * Detail
 */
if (CURRENT_ID != -1) {
    $les_justifications = Absences::getJustifications(CURRENT_ID,"ORDER BY JUSTIF_DATE_START,JUSTIF_HEURE_START,JUSTIF_DATE_END,JUSTIF_HEURE_END");
    affectToBlocAndRepeat($template,"une_justification",$les_justifications);

    $absences_affichees = array();
    $les_absences = Absences::getAbsencesNewGen($annee_courante,0,"=".CURRENT_ID);
    $absences_affichees = array();
    foreach ($les_absences as $date) {
        if (!isset($absences_affichees[$date['ABS_ID']])) {
            affectToBloc($template, "une_absence", $date);
            $absences_affichees[$date['ABS_ID']] = $date;
        }
    }
    //affectToBlocAndRepeat($template,"une_absence",$les_absences);

    $nb_total = Absences::getNombreAbsencesNewGen(CURRENT_ID,$annee_courante,0);
    $nb_non = Absences::getNombreAbsencesNonJustifiees(CURRENT_ID,0,"ABS_ENS_ID",$annee_courante);
    $nb_demi = Absences::getNombreDeDemiJourneesNonJustifiees(CURRENT_ID,0,"ABS_ENS_ID",$annee_courante);
    $nb_exuses =  Absences::getNombreAbsencesExcusees(CURRENT_ID,0,"ABS_ENS_ID",$annee_courante);

    $nb_justif = $nb_total - $nb_non;
    
    affectToXHTML($template, array(
        "ET_NOM" => $_SESSION['etudiants_nom'],
        "NB_ABSENCES" => $nb_total,
        "NB_ABSENCES_NON" => $nb_non,
        "NB_ABSENCES_JUSTIF" => $nb_justif,
        "NB_DEMI" => $nb_demi,
        "NB_ABSENCES_EXCUSES" => $nb_exuses,
        "HAS_JUSTIFICATIONS" => count($les_justifications)>0
    ));
}

affectToXHTML($template,array(
    "ANNEE_COURANTE" => $annee_courante
));

generateCompleteXHTML($template, "absences");