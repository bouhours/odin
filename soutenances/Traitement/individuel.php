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

setAttachment($template, "individuel", "individuel.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$groupe_valide = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_valide = $_GET['bfmw_num_g'];
}
$etudiant_valide = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}


$retour = Formations::getFormationsAyantDesExplications(CURRENT_DEPT_ID, $annee_courante,$session_courante);
$les_formations_autorisees[] = -1;
foreach ($retour as $une_formation) {
    $les_formations_autorisees[] = $une_formation['FORM_ID'];
}
$les_formations_autorisees = implode(",",$les_formations_autorisees);

/**
 * Affichage des groupes
 */
$groupe_valide = affectToBlocAndRepeat($template,"une_formation.un_groupe",Groupes::getGroupesOLD($les_formations_autorisees,$annee_courante),
    new Comparateur("GROUPE_ID",$groupe_valide),
    array("une_formation" => array(-1,"FORM_ID")));


if ($groupe_valide !== "-1") {


    /**
     * Affichage des étudiants
     */
    affectToBlocAndRepeat($template, "un_etudiant", Etudiants::getEtudiantsGroupes($annee_courante, $groupe_valide), new Comparateur("ET_ID",$etudiant_valide,"SELECTED","jaune_force"));


    $table = array(
        "GROUPE" => $groupe_valide,
        "ETUDIANT_ID" => $etudiant_valide,
        "SESSION_ID" => $session_courante,
        "ANNEE_COURANTE" => $annee_courante
    );

    affectToXHTML($template, $table);

    /**
     * Detail
     */
    if ($etudiant_valide != -1) {

        $template2 = new Template(BFWM_TEMPLATE_ROOT);
        setAttachment($template2, "template_grille", "template_grille.html");
        $formation_courante = Groupes::getFormation($groupe_valide)[0];
        if ($formation_courante == null) {
            exit;
        }

        $les_grilles = Notation_Soutenances::getGrilles($formation_courante['FORM_ID'],CURRENT_ID,$annee_courante,$session_courante,$etudiant_valide);
        affectToBlocAndRepeat($template2,"une_destination.une_section.un_critere.un_niveau.une_explication",$les_grilles,null,
            array(
                "une_destination" => array(-1,"DEST_ID"),
                "une_destination.une_section" => array(-1,"SECTION_ID"),
                "une_destination.une_section.un_critere" => array(-1,"CRITERE_ID"),
                "une_destination.une_section.un_critere.un_niveau" => array(-1,"NIVEAU_ID"),
            ));

        affectToXHTML($template2,array(
            "TEXTE" => Etudiants::getEtudiant($etudiant_valide,$annee_courante)[0]["ET_NOM"],
            "IDENTIFIANT" => $etudiant_valide,
            "PAGE" => "individuel",
            "IDDEL" => "deleens",
            "VALDEL" => $etudiant_valide,
            "FORMATION_COURANTE" => -1,
            "ANNEE_COURANTE" => $annee_courante,
            "SESSION_COURANTE" => $session_courante
        ));

        affectToXHTML($template,array(
            "GRILLE" => generateCompleteXHTML($template2,"template_grille",true)
        ));
    }
}

generateCompleteXHTML($template, "individuel");