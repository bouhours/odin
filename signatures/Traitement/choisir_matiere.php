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

$send_may_i = "choisir_matiere";
require_once ('check_tablette.php');
verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}
$annee_courante = Annees::getIdAnneeCourante();

$uid_courant = $_POST['bfmw_orig_d']??-1;
$enseignant_courant = $_POST['bfmw_orig_p']??-1;
$enseignant_nom = $_POST['bfmw_orig_n']??"";


if (! isset($_POST['bfmw_orig_signer_prof']) || $uid_courant==-1 || $enseignant_courant==-1 || $enseignant_nom==="") {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

setAttachment($template, "choisir_matiere", "choisir_matiere.html");

$tab_enseignants = explode("$",$enseignant_courant);
$noms_enseignants = explode(", ",$enseignant_nom);
$i = -1;
foreach ($tab_enseignants as $enseignant_courant) {
    $enseignant_nom = $noms_enseignants[++$i];
    $departement_courant = Departements::getDepartementCourantDeLEnseignant($enseignant_courant);

    if (count($departement_courant) === 1) {
        $departement_courant = $departement_courant[0];
    } else {
        $send = "p=accueil";
        require 'refresh.php';
        exit;
    }

    $recherche_groupe = Absences::getGroupeDeCreneauxDeCours($annee_courante, $uid_courant);
    $les_groupes = array();
    foreach ($recherche_groupe as $un_creneau) {
        $les_groupes[] = $un_creneau['EDT_GROUPE_ID'];
    }

    $les_groupes = array_unique($les_groupes);

    $la_maquette = Formations::getMaquettePourEnseignant($enseignant_courant, $departement_courant["ENS_DEPT_ID"], $annee_courante, "MAT_LOCK_ANNEE_ID<$annee_courante AND (FORM_ABSENCES_AUTO=1 OR FORM_PRO=1) AND  ", implode(",", $les_groupes));

    $template_composant = attachXHTML();
    setAttachment($template_composant, "signature", "template_selecteur_matieres.html");
    MatieresListView::generateListView($la_maquette, $template_composant, $annee_courante, "listview_template_module_open.html", "listview_template_module_close.html",
        function (array $uneMatiere) use (&$nombreDeMatieres) {
            global $uid_courant;
            global $enseignant_courant;
            global $enseignant_nom;
            global $les_groupes;
            $template1 = attachXHTML();
            setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
            affectToXHTML($template1, $uneMatiere);
            affectToXHTML($template1, array(
                "EDT_UID" => $uid_courant,
                "EDT_ENS_ID" => $enseignant_courant,
                "ENS_NOM" => $enseignant_nom,
                "GROUPES" => implode("$", $les_groupes)
            ));
            return generateCompleteXHTML($template1, "listview_template_matiere", true);
        }, function (array $un_element, int $annee_courante) {
            return Formations::getMatieresAffectees($un_element['UE_ID'], $un_element['MAT_ENS_ID'], $annee_courante);
        }, -1, "", "", true);

    affectToBloc($template, "un_enseignant", array(
        "COMPOSANT" => generateCompleteXHTML($template_composant, "signature", true),
        "ENS_NOM" => $enseignant_nom
    ));
}
generateCompleteXHTML($template, "choisir_matiere");