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

if ((!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) || !isset($_GET['bfmw_orig_u']) || !isset($_GET['bfmw_orig_g'])) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}


$les_formations_autorisees = Formations::getFormationsDuConnecteString();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$archive = isset($_GET["bfmw_orig_archive"]);

$annee_courante = $_GET["bfmw_num_a"]??Annees::getIdAnneeCourante();
$groupe_courant = $_GET['bfmw_orig_g'];
$edt_courant = $_GET['bfmw_orig_u'];
$le_groupe = Groupes::getGroupe($groupe_courant)[0];

setAttachment($template, "fiche", "fiche.html");
$table = ($archive?"common_pro_signatures_backup":"common_pro_signatures");

$matiere_courante = -1;
$les_matieres = Absences_Automatiques::getMatiere($edt_courant);
foreach ($les_matieres as $une_matiere) {
    $matiere_courante = $une_matiere['MAT_ID'];
    break;
}

$les_signatures = Absences_Automatiques::getSignaturesPourUnGroupe($groupe_courant,$edt_courant,$annee_courante,$matiere_courante,Formations::isAbsenceAutomatique($groupe_courant)?"":"ET_PROFESSIONNALISATION = 1 AND");
$groupe_nom = "";
foreach ($les_signatures as $une_signature) {
    try {
        $une_signature['SIGNATURE'] = gzuncompress(base64_decode($une_signature['SIGNATURE']));
    } catch (Exception $e) {
        try {
            $une_signature['SIGNATURE'] = base64_decode($une_signature['SIGNATURE']);
        } catch(Exception $e) {
            $une_signature['SIGNATURE'] = "";
        }
    }
    $groupe_nom = $une_signature['GROUPE_NOM'];
    if ($matiere_courante != "") {
        $une_signature['SIGNATURE_MAT_ID'] = $matiere_courante;
    }
    affectToBloc($template, "un_etudiant", $une_signature);
}

$creneau = Signatures::getCreneauEnseignant($groupe_courant,$edt_courant);
foreach ($creneau as &$un_creneau) {
    try {
        $un_creneau['SIGNATURE'] = gzuncompress(base64_decode($un_creneau['SIGNATURE']));
    } catch (Exception $e) {
        $un_creneau['SIGNATURE'] = base64_decode($un_creneau['SIGNATURE']??"");
    }
    $un_creneau['GROUPE_NOM'] = $groupe_nom;
}
affectToBlocAndRepeat($template, "un_creneau.un_enseignant", $creneau, null, array(
    "un_creneau" => array(-1,"EDT_UID")
));

//$req = "SELECT * FROM (etudiants_groupes left join $table on (ET_ID=SIGNATURE_ET_ID AND SIGNATURE_GROUPE_ID=GROUPE_ID AND  SIGNATURE_EDT_UID='" . $_GET['bfmw_orig_u'] . "')) LEFT JOIN common_absences_v2 on (ABS_EDT_UID='" . $_GET['bfmw_orig_u'] . "' AND ET_ID=ABS_ET_ID) WHERE  ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FEUILLE=1 AND GROUPE_ID=" . $_GET['bfmw_orig_g'] . " AND GROUPE_FORM_ID IN (" . $les_formations_autorisees . ") ORDER BY ET_NOM";
//$res = $conn->query($req);
//while ($une_signature = $res->fetch_assoc()) {
//    try {
//        $une_signature['SIGNATURE'] = gzuncompress(base64_decode($une_signature['SIGNATURE']));
//    } catch (ErrorException $e) {
//        $une_signature['SIGNATURE'] = base64_decode($une_signature['SIGNATURE']??"");
//    }
//    affectToBloc($template, "un_etudiant", $une_signature);
//}
//
//$req = "SELECT * FROM common_backup_ade_etudiant,common_backup_ade_enseignant,common_groupes,enseignants_formations WHERE common_backup_ade_etudiant.EDT_ANNEE_ID=$annee_courante AND GROUPE_DELETED=0 AND ENS_ID=EDT_ENS_ID AND GROUPE_ID=EDT_GROUPE_ID AND common_backup_ade_etudiant.EDT_UID=common_backup_ade_enseignant.EDT_UID AND common_backup_ade_enseignant.EDT_UID='" . $_GET['bfmw_orig_u'] . "' AND EDT_GROUPE_ID=" . $_GET['bfmw_orig_g'] . " GROUP BY common_backup_ade_etudiant.EDT_UID ORDER BY common_backup_ade_etudiant.EDT_DATE_DEBUT,common_backup_ade_etudiant.EDT_HEURE_DEBUT";
//$res = $conn->query($req);
//$ens_id = -1;
//$goupe_id = -1;
//$secours_uid = "";
//if ($cours = $res->fetch_assoc()) {
//    $cours['DEBUT'] = date("j/m/Y", $cours['EDT_DATE_DEBUT']);
//    $cours['HORAIRE_START'] = date("H:i", $cours['EDT_DATE_DEBUT']);
//    $cours['HORAIRE_END'] = date("H:i", $cours['EDT_DATE_FIN']);
//    $ens_id = $cours['EDT_ENS_ID'];
//    $goupe_id = $cours['GROUPE_ID'];
//    $secours_uid = $cours['EDT_UID'];
//    affectToXHTML($template, $cours);
//}
//
//$req = "SELECT * FROM $table WHERE SIGNATURE_GROUPE_ID=$goupe_id AND SIGNATURE_EDT_UID='" . $_GET['bfmw_orig_u'] . "' AND SIGNATURE_ENS_ID=$ens_id";
//$res = $conn->query($req);
//if ($ens = $res->fetch_assoc()) {
//    try {
//        $ens['SIGNATURE'] = gzuncompress(base64_decode($ens['SIGNATURE']));
//    } catch (ErrorException $e) {
//        $ens['SIGNATURE'] = base64_decode($ens['SIGNATURE']);
//    }
//    affectToXHTML($template, $ens);
//} else {
//    $ens['SIGNATURE'] = "";
//    $ens['SIGNATURE_GROUPE_ID'] = $goupe_id;
//    $ens['SIGNATURE_EDT_UID'] = $secours_uid;
//    affectToXHTML($template, $ens);
//}

affectToXHTML($template,array(
    "ARCHIVE" => $archive,
    "GROUPE_COURANT" => $groupe_courant,
    "EDT_COURANT" => $edt_courant
));

generateCompleteXHTML($template, "fiche");
