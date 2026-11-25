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

if (!(isset($_GET['bfmw_num_s']) && isset($_SESSION['HARMONISATION_OUVERTE_'.$_GET['bfmw_num_s']]))) {
    $send="p=accueil";
    require 'refresh.php';
    exit;
}

$session_courante = $_GET['bfmw_num_s'];

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$formation_courante = -1;
if (isset($_GET['bfmw_orig_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

setAttachment($template, "harmonisation", "harmonisation.html");

$formation_courante = affectToBlocAndRepeat($template,"une_formation",Formations::getFormationsAyantDesExplications(CURRENT_DEPT_ID,$annee_courante,$session_courante),new Comparateur("FORM_ID",$formation_courante));

$mode_groupe = isset($_SESSION["SESSION_OUVERTE_GROUPE_".$session_courante]);

$destinations = Notation_Soutenances::getDestination($formation_courante,$annee_courante,"SESSION_ID = $session_courante AND ");
$grille_valorisee = Notation_Soutenances::getEtudiantsValorises($formation_courante,$annee_courante,$mode_groupe,$session_courante,$destinations);

if (count($grille_valorisee) > 0) {

    affectToBlocAndRepeat($template, "une_destination", $destinations);
    if ($mode_groupe) {
        affectToBlocAndRepeat($template, "un_groupe.un_etudiant.une_dest.une_destination_val", $grille_valorisee, null,
            array(
                "un_groupe" => array(-1, "GROUPE_ID"),
                "un_groupe.un_etudiant" => array(-1, "ET_ID"),
                "un_groupe.un_etudiant.une_dest" => array(-1, "DEST_ID")
            )
        );
    } else {
        affectToBlocAndRepeat($template, "un_groupe.un_etudiant.une_dest.une_destination_val", $grille_valorisee, null,
            array(
                "un_groupe" => array(-1,"ET_ID"),
                "un_groupe.un_etudiant" => array(-1, "ET_ID"),
                "un_groupe.un_etudiant.une_dest" => array(-1, "DEST_ID")
            )
        );
    }

    affectToXHTML($template, array(
        "NB_COLS" => count($destinations) * 3 + 3,
        "FORMATION_COURANTE" => $formation_courante,
        "ANNEE_COURANTE" => $annee_courante,
        "MOYENNE_GENERALE" => $grille_valorisee[0]["MOYENNE_GENERALE"],
        "MOYENNE_MINIMUM" => $grille_valorisee[0]["MOYENNE_MINIMUM"],
        "MOYENNE_MAXIMUM" => $grille_valorisee[0]["MOYENNE_MAXIMUM"],
        "SESSION_COURANTE" => $session_courante,
        "HAS_GROUPE" => $mode_groupe
    ));
}

generateCompleteXHTML($template, "harmonisation");