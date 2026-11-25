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

if (!isRegistered()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "validerControle", "validerControle.html");

if (!isset($_GET['bfmw_orig_c']) || !isset($_GET['bfmw_orig_m'])) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}
$controle_courant = $_GET['bfmw_num_c'];
$matiere_courante = Formations::getMatiere($_GET['bfmw_num_m']);
$formation_courante = Formations::getFormationDeLaMatiere($matiere_courante["MAT_ID"]);
if ($formation_courante == null) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

affectToXHTML($template,array(
    "FORM_ID" => $formation_courante["FORM_ID"]
));

$controle = Controles::getControle($controle_courant,CURRENT_ID,$matiere_courante["MAT_ID"]);
foreach ($controle as $un_controle) {
    if ($un_controle["CONTROLE_VALIDE"] == 1 || $un_controle["CONTROLE_ID"] == "") {
        continue;
    }
    affectToXHTML($template,$un_controle);
    $les_notes = Controles::getGroupesEtNotesDuControle($un_controle["CONTROLE_ID"],$matiere_courante["MAT_ID"],$matiere_courante["MAT_UE_ID"],$un_controle["CONTROLE_ANNEE_ID"],$formation_courante["FORM_ID"]);
    affectToBlocAndRepeat($template,"un_groupe.un_etudiant",$les_notes,null,array(
        'un_groupe' => array("-1","GROUPE_ID")
    ));
}


//if (isset($_GET['bfmw_orig_c']) && isset($_GET['bfmw_orig_m'])) {
//    $annee_courante = Annees::getIdAnneeCourante();
//    $req = "SELECT * FROM affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ENS_MAT_ANNEE_ID=$annee_courante AND MAT_ID=" . $_GET['bfmw_num_m'] . " AND MAT_ENS_ID=" . CURRENT_ID . " AND MAT_LOCK_ANNEE_ID < $annee_courante";
//    $res = $conn->query($req);
//    if ($res->num_rows === 0) {
//        makeErreur("", "Validation d'un contrôle", "Piratage détecté");
//        $send = "p=accueil";
//       if (isErreur()) {
//            $send .= "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
//            $send .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
//            $send .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
//        }
//        require 'refresh.php';
//        exit;
//    }
//    $ue_id = $res->fetch_assoc()['UE_ID'];
//
//    $req = "SELECT *,ROUND(AVG(NOTES_VALEUR),2) AS CALCUL_MOYENNE FROM common_controle,common_notes WHERE CONTROLE_ID=NOTES_CONTROLE_ID AND CONTROLE_MAT_ID=" . $_GET['bfmw_num_m'] . " AND CONTROLE_ID=" . $_GET['bfmw_num_c'] . " AND CONTROLE_ENS_ID=" . CURRENT_ID . " GROUP BY CONTROLE_ID";
//    $res = $conn->query($req);
//    if ($controle = $res->fetch_assoc()) {
//        $controle['m'] = $_GET['bfmw_orig_m'];
//        switch ($controle['CONTROLE_MOYENNE']) {
//            case "0" :
//                $controle['COMPTE_MOYENNE'] = "Non";
//                break;
//            case "1" :
//                $controle['COMPTE_MOYENNE'] = "Oui";
//                break;
//            default :
//                $controle['COMPTE_MOYENNE'] = "Sous forme de bonus";
//        }
//        switch ($controle['CONTROLE_VISIBLE']) {
//            case "0" :
//                $controle['CONTROLE_VISIBLE'] = "Non";
//                break;
//            default :
//                $controle['CONTROLE_VISIBLE'] = "Oui";
//                break;
//        }
//
//        affectToXHTML($template, $controle);
//
//
//        /**
//         * Etudiants
//         */
//        $req = "SELECT DISTINCT GROUPE_ID,GROUPE_NOM FROM common_notes,etudiants_groupes,affectations_enseignants,semestres_groupes_code WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ET_GROUPE_ANNEE_ID=$annee_courante AND ENS_MAT_ANNEE_ID=$annee_courante AND MAT_ID=".$_GET['bfmw_num_m']." AND SEM_ID=GROUPE_SEM_ID AND GROUPE_ID=SEM_GROUPE_ID AND GROUPE_FEUILLE=1 AND ET_ID=NOTES_ET_ID AND (NOTES_VALEUR IS NOT NULL OR NOTES_SPECIAL IS NOT NULL)  AND NOTES_CONTROLE_ID=" . $_GET['bfmw_num_c'] . " ORDER BY GROUPE_NOM";
//        $res = $conn->query($req);
//        $fail_validation = false;
//        $novalidate = false;
//        if ($res->num_rows === 0) {
//            $novalidate = true;
//            $fail_validation = true;
//        }
//        while ($groupe = $res->fetch_assoc()) {
//            $req = "SELECT * FROM (etudiants_groupes LEFT JOIN common_dispense_ue on (ET_ID=DISP_ET_ID AND DISP_UE_ID=$ue_id AND DISP_ANNEE_ID=$annee_courante) LEFT JOIN common_dispense_matieres on (ET_ID=common_dispense_matieres.DISP_ET_ID AND DISP_MAT_ID=".$_GET['bfmw_num_m']." AND common_dispense_matieres.DISP_ANNEE_ID=$annee_courante)) LEFT JOIN common_controle on (CONTROLE_ID=" . $_GET['bfmw_num_c'] . ") left join common_notes on (ET_ID=NOTES_ET_ID AND CONTROLE_ID=NOTES_CONTROLE_ID) WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND `GROUPE_ID`=" . $groupe['GROUPE_ID'] . " ORDER BY ET_NOM";
//            $res2 = $conn->query($req);
//            if ($res2->num_rows > 0) {
//                affectToBloc($template, "un_groupe", $groupe);
//            }
//            while ($etu = $res2->fetch_assoc()) {
//                if ($etu['NOTES_VALEUR'] == null) {
//                    $etu['NOTES_VALEUR'] = $etu['NOTES_SPECIAL'];
//                }
//                $supprimable = true;
//                if ($etu['NOTES_VALEUR'] == null) {
//                    $etu['NOTES_VALEUR'] = "??";
//                    if ($etu['DISP_ET_ID'] == "") {
//                        $fail_validation = true;
//                    }
//                    $supprimable = false;
//                }
//                affectToBloc($template, "un_groupe.un_etudiant", $etu);
//                if ($supprimable) {
//                    openBloc($template, "un_groupe.un_etudiant.supprimable");
//                }
//            }
//        }
//
//        if ($fail_validation && !$novalidate) {
//            openBloc($template, "no_validable");
//        } else if ($novalidate) {
//            openBloc($template, "nothing");
//        } else {
//            openBloc($template, "validable");
//        }
//
//    }
//}

generateCompleteXHTML($template, "validerControle");
