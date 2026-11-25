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

$lesFormationsDuConnecte = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,Annees::getIdAnneeCourante(),"AND FORM_EVALUABLE=1");
$is_evaluable = count($lesFormationsDuConnecte) > 0;

if (!isRegistered() || !$is_evaluable) {
    $send = "accueil";
    require "refresh.php";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "evaluation", "evaluation.html");
$formation_selectionnee = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_selectionnee =  $_GET['bfmw_num_f'];
}

$formation_selectionnee = affectToBlocAndRepeat($template,"une_formation",$lesFormationsDuConnecte,new Comparateur("FORM_ID",$formation_selectionnee));

foreach (Formations::getFormation($formation_selectionnee) as $formation) {
    $formation['FORCE_CHECKED'] = (($formation['FORM_EVAL_DEBUT']=="" && $formation['FORM_EVAL_FIN']=="")?"checked":"");
    $formation['NO_FORCE_CHECKED'] = (($formation['FORM_EVAL_DEBUT']=="" && $formation['FORM_EVAL_FIN']=="")?"":"checked");
    if ($formation['FORM_EVAL_DEBUT']!="" && $formation['FORM_EVAL_FIN']!="") {
        $formation['DDEBUT'] = date("j/m/Y", $formation['FORM_EVAL_DEBUT']);
        $formation['DFIN'] = date("j/m/Y", $formation['FORM_EVAL_FIN']);
        $formation['HDEBUT'] = date("H\hi", $formation['FORM_EVAL_DEBUT']);
        $formation['HFIN'] = date("H\hi", $formation['FORM_EVAL_FIN']);
    }
    affectToXHTML($template,$formation);


    $lesPeriodes = Edt::getPeriode($formation_selectionnee,$formation_selectionnee);
    affectToBlocAndRepeat($template,"une_periode",$lesPeriodes,new Comparateur("PERIODE_ID",$formation['FORM_EVAL_PERIODE_ID']));
}


generateCompleteXHTML($template, "evaluation");
