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

if (!isGestionnaire()) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$periode_en_cours = -1;
if (isset($_GET['bfmw_num_periode'])) {
    $periode_en_cours = $_GET['bfmw_num_periode'];
}

$enseignant_courant = null;
if (isset($_GET['bfmw_orig_specific'])) {
    $enseignant_courant = $_GET['bfmw_num_specific'];
}

$fiche_courante = null;
if (isset($_GET['bfmw_orig_fiche'])) {
    $fiche_courante = $_GET['bfmw_num_fiche'];
}

$annee_courante = Annees::getIdAnneeCourante();

setAttachment($template, "gestion_voeux", "gestion_voeux.html");

/**
 * Les périodes
 */
$les_periodes = Edt::getPeriodesDuDepartement($annee_courante,CURRENT_DEPT_ID);
$periode_en_cours = affectToBlocAndRepeat($template,"une_periode",$les_periodes,new Comparateur("PERIODE_ID",$periode_en_cours));


/**
 * Les fiches
 */
if ($enseignant_courant == null) {
    $les_retardataires = Edt::getRetardataires($periode_en_cours);
    affectToBlocAndRepeat($template,"un_retard",$les_retardataires);
    affectToBlocAndRepeat($template,"une_fiche",Edt::getFiches($periode_en_cours));
}

affectToXHTML($template,array(
    "IS_SPECIFIC" => $enseignant_courant !=  null,
    "PERIODE" => $periode_en_cours
));

affectToBlocAndRepeat($template,"une_matiere.un_enseignant.une_charge",Edt::getMatieres($periode_en_cours,$enseignant_courant),null,
array(
    "une_matiere" => array(-1,"MAT_ID"),
    "une_matiere.un_enseignant" => array(-1,"ENS_ID")
));

if ($fiche_courante != null) {
    $disponibilites = array();
    $les_indisponibilites = Edt::getIndisponibilites($fiche_courante);
    $enseignant = Enseignants::getEnseigant($enseignant_courant);
    $type_fiche = Edt::getPeriodeID($periode_en_cours)[0]["PERIODE_TYPE"];
    for ($i = 0; $i < 55; $i++) {
        if ($type_fiche == "A" && ($i == 27 || $i == 33 || $i == 38 || $i == 43 || $i == 48 || $i == 53)) {
            continue;
        }

        if (isset($les_indisponibilites[$i])) {
            $disponibilites['DISPO_'.$i] = "";
        } else {
            $disponibilites['DISPO_'.$i] = $enseignant[0]['ENS_NOM'] ;
        }
    }
    affectToXHTML($template,$disponibilites);
}


///**
// * Les disponibilités
// */
//$specific="";
//if (isset($_GET['bfmw_orig_specific'])) {
//    $specific = " AND ENS_ID=".$_GET['bfmw_num_specific']." ";
//}

//if (count($les_enseignants) > 0) {
//    $req = "SELECT FICHE_ID, ENS_NOM,ENS_ID, FICHE_ID,IFNULL((54-(COUNT(DISPO_ENS_ID)+6))*PERIODE_SEMAINES,0) AS TOTAL FROM (common_edt_fiche,common_enseignant,common_edt_periode) LEFT JOIN common_edt_indisponibilite ON (FICHE_ID = DISPO_FICHE_ID) WHERE PERIODE_ANNEE_ID=$annee_id AND PERIODE_ID=FICHE_PERIODE_ID AND ENS_ID=FICHE_ENS_ID AND FICHE_ENS_ID IN (" . implode(",", array_keys($les_enseignants)) . ") AND FICHE_ANNEE_ID=$annee_id AND FICHE_PERIODE_ID=" . $periode_en_cours . " $specific GROUP BY ENS_ID";
//    $res = $conn->query($req);
//
//    while ($un_enseignant = $res->fetch_assoc()) {
//        if (isset($les_enseignants[$un_enseignant['ENS_ID']])) {
//            $les_enseignants[$un_enseignant['ENS_ID']] = $un_enseignant['TOTAL'] - $les_enseignants[$un_enseignant['ENS_ID']];
//        } else {
//            $les_enseignants[$un_enseignant['ENS_ID']] = $un_enseignant['TOTAL'];
//        }
//        $les_dispos[$un_enseignant['ENS_ID']] = $un_enseignant;
//    }
//    asort($les_enseignants);
//}
//
//$disponibilites = array();
//foreach ($les_enseignants as $ens_id=>$une_contrainte) {
//    if (!isset($les_dispos[$ens_id])) {
//        continue;
//    }
//    $les_dispos[$ens_id]['POSSIBILITES'] = $une_contrainte;
//    affectToBloc($template,"une_disponibilite",$les_dispos[$ens_id]);
//    for ($i=0;$i<55;$i++) {
//        if ($_GET['FICHE_A'] && ($i == 27 || $i == 33 || $i == 38 || $i == 43 || $i == 48 || $i == 53)) {
//            continue;
//        }
//        $req = "SELECT * FROM common_edt_indisponibilite WHERE DISPO_INDISPO=$i AND DISPO_FICHE_ID = ".$les_dispos[$ens_id]['FICHE_ID']." AND DISPO_ENS_ID=$ens_id";
//        $indispo = $conn->query($req)->num_rows != 0;
//        if (!$indispo) {
//            $disponibilites[$i][] = "<div class='un_prof no_wrap text_overflow' title='".$les_dispos[$ens_id]['ENS_NOM']."' data-bfmw='".$les_dispos[$ens_id]['FICHE_ID']."'>".$les_dispos[$ens_id]['ENS_NOM']."</div>";
//        }
//    }
//}
//
//$table_affection = array();
//for ($i=0;$i<55;$i++) {
//    if (isset($disponibilites[$i])) {
//        $table_affection['DISPO_' . $i] = implode("", $disponibilites[$i]);
//    } else {
//        $table_affection['DISPO_' . $i] = "";
//    }
//}
//
//affectToXHTML($template,$table_affection);
//
///**
// * Les matières
// */
//$req = "SELECT ENS_NOM, MAT_ID, MAT_NOM, FORM_NOM, common_edt_commentaires.*,common_charge_enseignant.* FROM (common_periodes_matieres, common_charge_enseignant, common_enseignants_matieres, common_enseignant, common_matiere, common_ue, common_semestre, common_formation) LEFT JOIN common_edt_commentaires ON (ID=COMMENTAIRE_AFFECT_ID) WHERE UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND FORM_ID=SEM_FORM_ID AND MAT_ID=ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL) AND ENS_MAT_ANNEE_ID=$annee_id AND ENS_ID=MAT_ENS_ID AND ID=CHARGE_AFFECT_ID AND MAT_ID=PERIODE_MAT_ID AND MAT_PERIODE_ID=".$periode_en_cours." $specific ORDER BY MAT_ORDRE, ENS_NOM";
//$res = $conn->query($req);
//$mat_en_cours = -1;
//
//while ($une_contrainte = $res->fetch_assoc()) {
//    if ($mat_en_cours != $une_contrainte['MAT_ID']) {
//        $mat_en_cours = $une_contrainte['MAT_ID'];
//        affectToBloc($template,"une_matiere",$une_contrainte);
//    }
//    if ($une_contrainte['COMMENTAIRE_DONE'] == 1) {
//        $une_contrainte['COMMENTAIRE_CHECKED'] = "checked";
//    } else {
//        $une_contrainte['COMMENTAIRE_CHECKED'] = "";
//    }
//    $une_contrainte['CHARGE_TP_ALL'] = $une_contrainte['CHARGE_TP']+$une_contrainte['CHARGE_TPR']+$une_contrainte['CHARGE_TPV'];
//    $une_contrainte['CHARGE_SEMAINES_TP_ALL'] = $une_contrainte['CHARGE_SEMAINES_TP']+$une_contrainte['CHARGE_SEMAINES_TPR']+$une_contrainte['CHARGE_SEMAINES_TPV'];
//    $une_contrainte['CHARGE_GROUPES_TP_ALL'] = $une_contrainte['CHARGE_GROUPES_TP']+$une_contrainte['CHARGE_GROUPES_TPR']+$une_contrainte['CHARGE_GROUPES_TPV'];
//    $une_contrainte['COMMENTAIRE'] = nl2br($une_contrainte['COMMENTAIRE']);
//        affectToBloc($template,"une_matiere.un_enseignant",$une_contrainte);
//}
//
///**
// * Les exams
// */
//$req = "SELECT * FROM common_edt_exams, common_edt_fiche, common_enseignant , common_matiere, common_ue, common_semestre, common_formation WHERE UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND FORM_ID=SEM_FORM_ID AND MAT_ID=EXAM_MAT_ID AND MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL)  AND ENS_ID=EXAM_ENS_ID AND FICHE_ANNEE_ID=$annee_id AND FICHE_ID=EXAM_FICHE_ID AND FICHE_PERIODE_ID=".$periode_en_cours." $specific ORDER BY EXAM_MAT_ID, ENS_NOM";
//$res = $conn->query($req);
//$mat_en_cours = -1;
//while ($un_exam = $res->fetch_assoc()) {
//    if ($mat_en_cours != $un_exam['EXAM_MAT_ID']) {
//        $mat_en_cours = $un_exam['EXAM_MAT_ID'];
//        affectToBloc($template,"un_exam",$un_exam);
//    }
//    if ($un_exam['EXAM_DONE'] == 1) {
//        $un_exam['EXAM_CHECKED'] = "checked";
//    } else {
//        $un_exam['EXAM_CHECKED'] = "";
//    }
//    affectToBloc($template,"un_exam.un_enseignant",$un_exam);
//}

generateCompleteXHTML($template, "gestion_voeux");
