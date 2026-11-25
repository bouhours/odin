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

if (!isset($_SESSION['perso_session_ouverte'])) {
    echo "Accès non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}
$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$planning_courant = -1;
if (isset($_GET['bfmw_num_s'])) {
    $planning_courant = $_GET['bfmw_num_s'];
}

Soutenances::creerDisponibiliteAutomatiquement(CURRENT_ID,$annee_courante,$les_planning);

setAttachment($template, "disponibilites", "disponibilites.html");

//$les_planning proviennent du menu
$planning_courant = affectToBlocAndRepeat($template,"un_planning",$les_planning,new Comparateur("PLANNING_ID",$planning_courant));

if ($planning_courant != -1) {
    $les_disponibilites = Soutenances::getDisponibilites(CURRENT_ID,$annee_courante,$planning_courant);

    affectToBlocAndRepeat($template,"une_dispo.un_creneau", $les_disponibilites,null,
    array(
        "une_dispo" => array (-1,"DISPO_ID")
    ));

    affectToXHTML($template,array(
        "SESSION_COURANTE" => $planning_courant,
        "SESSION_DEBUT" => $les_planning[$planning_courant]['PLANNING_SOUTENANCES_START_AFFICHAGE_DATE'],
        "SESSION_FIN" => $les_planning[$planning_courant]['PLANNING_SOUTENANCES_END_AFFICHAGE_DATE'],
        "ANNEE_COURANTE" => $annee_courante,
        "HAS_DISPO" => count($les_disponibilites) > 0
    ));
}

generateCompleteXHTML($template, "disponibilites");