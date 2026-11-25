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

if (!(isset($_GET['bfmw_num_s']) && isset($_SESSION['SESSION_OUVERTE_'.$_GET['bfmw_num_s']]))) {
    $send="p=accueil";
    require 'refresh.php';
    exit;
}

$session_courante = $_GET['bfmw_num_s'];

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "groupe", "groupe.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$groupe_valide = -1;
if (isset($_GET['bfmw_orig_gp'])) {
    $groupe_valide = $_GET['bfmw_num_gp'];
}
$formation_courante = -1;
if (isset($_GET['bfmw_orig_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}
$etudiant_valide = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}


$formation_courante = affectToBlocAndRepeat($template,"une_formation",Formations::getFormationsAyantDesExplications(CURRENT_DEPT_ID, $annee_courante,$session_courante),new Comparateur("FORM_ID",$formation_courante));

/**
 * Affichage des groupes
 */
affectToBlocAndRepeat($template,"un_groupe.un_etudiant",Notation_Soutenances::getGroupes($annee_courante,$session_courante), new Comparateur("GROUPE_ID",$groupe_valide,"SELECTED","jaune_force"),
    array(
        "un_groupe" => array(-1,"GROUPE_ID")
    ));


if ($formation_courante !== "-1") {

    $table = array(
        "GROUPE" => $groupe_valide,
        "SESSION_COURANTE" => $session_courante,
        "ANNEE_COURANTE" => $annee_courante
    );

    affectToXHTML($template, $table);

    /**
     * Detail
     */
    if ($groupe_valide != -1) {
        $template2 = new Template(BFWM_TEMPLATE_ROOT);
        setAttachment($template2, "template_grille", "template_grille.html");

        $les_id = array();
        foreach (Notation_Soutenances::getEtudiantsDuGroupe($groupe_valide) as $un_etudiant) {
            if ($un_etudiant['ET_DEM'] == 0) {
                $les_id[] = $un_etudiant['GROUPE_ET_ID'];
                $les_noms[] = $un_etudiant['ET_NOM'];
            }
        }
        if (count($les_id) > 0) {
            $les_grilles = Notation_Soutenances::getGrilles($formation_courante, CURRENT_ID, $annee_courante, $session_courante, implode(",", $les_id));
            affectToBlocAndRepeat($template2, "une_destination.une_section.un_critere.un_niveau.une_explication", $les_grilles, null,
                array(
                    "une_destination" => array(-1, "DEST_ID"),
                    "une_destination.une_section" => array(-1, "SECTION_ID"),
                    "une_destination.une_section.un_critere" => array(-1, "CRITERE_ID"),
                    "une_destination.une_section.un_critere.un_niveau" => array(-1, "NIVEAU_ID"),
                ));

            affectToXHTML($template2, array(
                "TEXTE" => Notation_Soutenances::getGroupe($groupe_valide)["GROUPE_NOM"],
                "DETAIL" => implode(", ", $les_noms),
                "IDENTIFIANT" => implode("$", $les_id),
                "PAGE" => "groupe",
                "IDDEL" => "delgpens",
                "VALDEL" => $groupe_valide,
                "FORMATION_COURANTE" => $formation_courante,
                "SESSION_COURANTE" => $session_courante,
                "ANNEE_COURANTE" => $annee_courante
            ));

            affectToXHTML($template, array(
                "GRILLE" => generateCompleteXHTML($template2, "template_grille", true)
            ));
        }
    }
}

generateCompleteXHTML($template, "groupe");