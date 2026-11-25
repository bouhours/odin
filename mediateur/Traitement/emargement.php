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


if (!isset($_SESSION['ACTIVE_ABSENCES_AUTO'])) {
    $send="?p=accueil";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();

$groupe_valide = $_GET['bfmw_num_g']??-1;
$groupe_nom = "";

setAttachment($template, "emargement", "emargement.html");
$les_formations_autorisees = Formations::getFormationsDuConnecteString();
$les_groupes_autorises = Groupes::getGroupesDuResponsable($les_formations_autorisees,$annee_courante,CURRENT_ID,"FORM_ABSENCES_AUTO=1 AND ");

$les_groupes_valides = array();
foreach ($les_groupes_autorises as $un_groupe) {
    $les_sous_groupes = Groupes::getGroupeFeuille($un_groupe['GROUPE_CODE'],$annee_courante);
    foreach ($les_sous_groupes as $un_sous_groupe) {
        if (! in_array($un_sous_groupe['GROUPE_ID'],array_keys($les_groupes_valides))) {
            $les_groupes_valides[$un_sous_groupe['GROUPE_ID']] = $un_sous_groupe;
        }
    }
}

$groupe_valide = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes_valides,
    new Comparateur("GROUPE_ID",$groupe_valide),
    array(
        "une_formation" => array(-1,"FORM_ID")
    ));

$les_cours = array();
$lesFiches = Signatures::getFicheEmargement($groupe_valide,$annee_courante,"DESC");
affectToBlocAndRepeat($template, "un_jour.un_cours", $lesFiches,null,array(
    "un_jour" => array(-1,"TRIEUR")
));

affectToXHTML($template, array(
    "PAS_DE_FICHE" => count($lesFiches) == 0,
    "GROUPE_ID" => $groupe_valide,
    "ANNEE_ID" => $annee_courante,
    "GROUPE_PRO" => Groupes::isPro($groupe_valide)
));
//foreach ($lesFiches as $un_cours) {
//    if ($un_cours["NONFACTURE_EDT_UID"] == "") {
//        $un_cours["FACTURER"] = "checked";
//    } else {
//        $un_cours["FACTURER"] = "";
//    }
//    $les_cours[$un_cours['EDT_GROUPE_ID']][] = $un_cours;
//}
//
//$req = "SELECT *,count(*) AS NB_TOTAL FROM etudiants_groupes,common_formation WHERE GROUPE_ID=$groupe_valide AND FORM_ABSENCES_AUTO=1 AND FORM_ID=GROUPE_FORM_ID AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FEUILLE=1 GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_NOM";
//$res = $conn->query($req);
//
//affectToXHTML($template,array(
//    "PAS_DE_FICHE" => !isset($les_cours[$groupe_valide]),
//    "GROUPE_ID" => $groupe_valide,
//    "GROUPE_NOM" => $groupe_nom,
//    "IS_ADMIN" => isAdmin()
//));
//
//while ($un_groupe = $res->fetch_assoc()) {
//    $les_manques = array();
//    $req = "SELECT SIGNATURE_EDT_UID,count(*) AS TOTAL FROM etudiants_groupes,common_absences_signatures WHERE ET_ID=SIGNATURE_ET_ID AND SIGNATURE_GROUPE_ID=GROUPE_ID AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FEUILLE=1 AND GROUPE_ID=" . $un_groupe['GROUPE_ID'] . " GROUP BY SIGNATURE_EDT_UID";
//    $resMANQUE = $conn->query($req);
//    while ($un_manque = $resMANQUE->fetch_assoc()) {
//        $les_manques[$un_manque['SIGNATURE_EDT_UID']] = (($un_manque['TOTAL'] != $un_groupe['NB_TOTAL'])?0:1);
//    }
//    $req = "SELECT SIGNATURE_EDT_UID FROM common_absences_signatures WHERE SIGNATURE_GROUPE_ID=" . $un_groupe['GROUPE_ID'] . " AND SIGNATURE_ENS_ID IS NOT NULL GROUP BY SIGNATURE_EDT_UID";
//    $resMANQUE = $conn->query($req);
//    while ($un_manque = $resMANQUE->fetch_assoc()) {
//        if (isset($les_manques[$un_manque['SIGNATURE_EDT_UID']])) {
//            $les_manques[$un_manque['SIGNATURE_EDT_UID']] += 1;
//        }
//    }
//    $req = "SELECT * FROM etudiants_groupes,common_absences_v2 WHERE ET_ID=ABS_ET_ID AND GROUPE_ID=" . $un_groupe['GROUPE_ID'] . " AND ABS_JUSTIFICATION != 'non' GROUP BY GROUPE_ID,ABS_EDT_UID";
//    $resMANQUE = $conn->query($req);
//    while ($un_manque = $resMANQUE->fetch_assoc()) {
//        if (isset($les_manques[$un_manque['ABS_EDT_UID']])) {
//            $les_manques[$un_manque['ABS_EDT_UID']] -= 2;
//        }
//    }
//
//    if (isset($les_cours[$un_groupe['GROUPE_ID']])) {
//        $jour_precedent = "";
//        foreach ($les_cours[$un_groupe['GROUPE_ID']] as $un_cours) {
//            if ($jour_precedent != date("j/m/Y", $un_cours['EDT_DATE_DEBUT'])) {
//                $jour_precedent = date("j/m/Y", $un_cours['EDT_DATE_DEBUT']);
//                $un_cours['SEPARATEUR'] = $jour_precedent;
//            } else {
//                $un_cours['SEPARATEUR'] = "";
//            }
//            $un_cours['MANQUE'] = (isset($les_manques[$un_cours['EDT_UID']]) ? $les_manques[$un_cours['EDT_UID']] : 0);
//            $un_cours['DEBUT'] = date("j/m/Y", $un_cours['EDT_DATE_DEBUT']);
//            $un_cours['HORAIRE_START'] = date("H:i", $un_cours['EDT_DATE_DEBUT']);
//            $un_cours['HORAIRE_END'] = date("H:i", $un_cours['EDT_DATE_FIN']);
//            affectToBloc($template, "un_cours", $un_cours);
//        }
//    }
//}

generateCompleteXHTML($template, "emargement");
