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

setAttachment($template,"menu", "menu.html");

$active = "ACTIVE_BILAN";

$annee_courante = Annees::getIdAnneeCourante();

$les_formations_avec_absences_auto = array();
$les_groupes = Groupes::getGroupesDuResponsable(0,$annee_courante,CURRENT_ID);
if (count($les_groupes) > 0) {
    $formations_filtre = Groupes::getFormation(implode(",",array_keys($les_groupes)));
    foreach ($formations_filtre as $une_formation) {
        if ($une_formation['FORM_ABSENCES_AUTO'] == 1) {
            $les_formations_avec_absences_auto[] = $une_formation;
        }
    }
}

if (count($les_formations_avec_absences_auto) > 0) {
    $_SESSION["ACTIVE_ABSENCES_AUTO"] = 1;
} else {
    unset($_SESSION["ACTIVE_ABSENCES_AUTO"]);
}

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "accueil":
            $active = "ACTIVE_BILAN";
            break;
        case "notes":
            $active = "ACTIVE_NOTES";
            break;
        case "aide":
            $active = "ACTIVE_AIDE";
            break;
        case "absences":
            $active = "ACTIVE_ABSENCE";
            break;
        case "suivi":
            $active = "ACTIVE_SUIVI";
            break;
        case "emargement":
        case "fiche":
            $active = "ACTIVE_ABSENCES_AUTO";
            break;
    }
}

$table = array(
    "PARAM" => (isset($_GET['bfmw_orig_a'])?"&amp;a=".$_GET['bfmw_num_a']:"").(isset($_GET['bfmw_orig_g'])?"&amp;g=".$_GET['bfmw_num_g']:"").(isset($_GET['bfmw_orig_e'])?"&amp;e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e']:""),
      $active => "class=\"active\"",
    "IS_ABSENCES_AUTO" => isset($_SESSION["ACTIVE_ABSENCES_AUTO"])
);

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");