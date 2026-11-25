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

if (!isRegistered() && !isAdmin()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "periodes", "periodes.html");

$annee_courante = Annees::getIdAnneeCourante();

$les_formations_concernees = Formations::getFormationsDuConnecteString();
$les_formations = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID);
$has_formation = count($les_formations);
affectToBlocAndRepeat($template,"une_formation",$les_formations);

$les_annees = Annees::getAnnee();

$les_periodes = Edt::getPeriodes($les_formations_concernees);

foreach ($les_periodes as $une_periode) {
    $une_periode['AFFECTED'] = count(Edt::getPeriodeMatieresParPeriode($une_periode['PERIODE_ID']))>0;
    $une_periode['FORM1_AFFECTED'] = count(Edt::getPeriodeMatieresParFormation($une_periode['PERIODE_FORM_ID_1'],$une_periode['PERIODE_ID']))>0;
    if ($une_periode['PERIODE_FORM_ID_2'] == "") {
        $une_periode['NOT_FORMATION_2'] = "selected";
        $une_periode['FORM2_AFFECTED'] = false;
    } else {
        $une_periode['NOT_FORMATION_2'] = "";
        $une_periode['FORM2_AFFECTED'] = count(Edt::getPeriodeMatieresParFormation($une_periode['PERIODE_FORM_ID_2'],$une_periode['PERIODE_ID']))>0;
    }

    $une_periode['SELECTEDA'] = ($une_periode['PERIODE_TYPE']=="A"?"selected":"");
    $une_periode['SELECTEDB'] = ($une_periode['PERIODE_TYPE']=="B"?"selected":"");

    affectToBloc($template,"une_periode",$une_periode);
    foreach ($les_formations as $une_formation) {
        if ($une_periode['PERIODE_FORM_ID_1'] == $une_formation['FORM_ID']) {
            $une_formation['SELECTED1'] = "selected";
        } else {
            $une_formation['SELECTED1'] = "";
        }
        if ($une_periode['PERIODE_FORM_ID_2'] == $une_formation['FORM_ID']) {
            $une_formation['SELECTED2'] = "selected";
        } else {
            $une_formation['SELECTED2'] = "";
        }
        affectToBloc($template,"une_periode.une_formation",$une_formation);
    }

    foreach ($les_annees as $une_annee) {
        if ($une_periode['PERIODE_ANNEE_ID'] == $une_annee["ANNEE_ID"]) {
            $une_annee['SELECTED'] = "selected";
        } else {
            $une_annee['SELECTED'] = "";
        }
        affectToBloc($template,"une_periode.une_annee",$une_annee);
    }
}

affectToXHTML($template,array(
    "HAS_FORMATION" => $has_formation,
    "ANNEE_COURANTE" => $annee_courante,
    "IS_ADMIN" => isAdmin()
));

generateCompleteXHTML($template, "periodes");


