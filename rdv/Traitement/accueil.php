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

setAttachment($template, "accueil", "accueil.html");

Plannings::cleanRendezVousTemporaires();

$planning_courant = -1;
$planning = null;
if (isset($_GET["bfmw_orig_pl"])) {
    $les_plannings = Plannings::getPlanningAvecUid($_GET["bfmw_orig_pl"],time());
    foreach ($les_plannings as $planning_id=>$un_planning) {
        $planning_courant = $planning_id;
        $planning = $un_planning;
        break;
    }
}

$nombre_de_disponibilites = 0;
if ($planning_courant > 0 && $planning != null) {
    $date_debut = $planning["PLANNING_START"];
    $date_fin = $planning["PLANNING_END"];

    $date_courante = new DateTime();
    $date_courante->setTimestamp($date_debut);

    $date_eliminatoire = new DateTime();
    $date_pour_elimination = new DateTime();
    $date_eliminatoire = $date_eliminatoire->add(new DateInterval("P1D"))->getTimestamp();

    while ($date_courante->getTimestamp() <= $date_fin) {
        $date_pour_elimination->setTimestamp($date_courante->getTimestamp());
        $date_pour_elimination->setTime(13,0);
        if ($date_pour_elimination->getTimestamp() < $date_eliminatoire) {
            $date_courante->add(new DateInterval("P1D"));
            continue;
        }

        $les_diponibilites = Plannings::getMixDisponibilites($planning_courant,$date_courante->getTimestamp());
        $nombre_de_disponibilites += count($les_diponibilites);
        if (count($les_diponibilites) > 0) {
            affectToBloc($template,"une_date",array(
                "DATE_DISPO_AFFICHAGE"=>$date_courante->format('d/m/Y'),
                "DISPO_DATE" => $date_courante->getTimestamp()
            ));
        }
        affectToBlocAndRepeat($template,"une_date.un_creneau",$les_diponibilites);

        $date_courante->add(new DateInterval("P1D"));
    }

}

affectToXHTML($template,array(
    "VALID"=> !($planning_courant == -1 || $planning == null),
    "NO_DISPO" => $nombre_de_disponibilites == 0,
    "PLANNING_UID" => $_GET["bfmw_orig_pl"]??-1
));

generateCompleteXHTML($template, "accueil");