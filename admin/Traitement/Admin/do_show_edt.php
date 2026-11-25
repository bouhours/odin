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

if (!isAdmin()) {
    echo "Non autorisé";
    exit;
}

if (isset($_POST['bfmw_orig_ens_val'])) {
    $req = "DELETE FROM common_backup_ade_enseignant WHERE EDT_DATE_DEBUT=".$_POST['bfmw_num_*EDT_DATE_DEBUT']." AND EDT_DATE_FIN=".$_POST['bfmw_num_*EDT_DATE_FIN']." AND EDT_HEURE_DEBUT=".$_POST['bfmw_num_*EDT_HEURE_DEBUT']." AND EDT_HEURE_FIN=".$_POST['bfmw_num_*EDT_HEURE_FIN']." AND EDT_ENS_ID=".$_POST['bfmw_num_EDT_ENS_ID']." AND EDT_ANNEE_ID=".$_POST['bfmw_num_*EDT_ANNEE_ID'];
    $conn->query($req);
    $retour = "FIRST DEL : ".$conn->affected_rows."<br/>";
    $req = "DELETE FROM common_backup_ade_enseignant WHERE EDT_UID='".$_POST['bfmw_orig_*EDT_UID']."' AND EDT_ENS_ID=".$_POST['bfmw_num_EDT_ENS_ID']." AND EDT_ANNEE_ID=".$_POST['bfmw_num_*EDT_ANNEE_ID'];
    $conn->query($req);
    $retour .= "SECOND DEL : ".$conn->affected_rows."<br/>";
    bfmw_add_secured($_POST,"*EDT_ENS_ID",$_POST["bfmw_num_EDT_ENS_ID"]);
    $id = createData("common_backup_ade_enseignant",$_POST,9);
    $retour .= "INSERT : ".$id."<br/>";
    makeErreur("warning","ADE UPD",$retour);
} else if (isset($_POST['bfmw_orig_et_val'])) {
    $tab = explode(", ",$_POST['bfmw_orig_EDT_ET']);
    $retour = "";
    foreach ($tab as $un_groupe_ade) {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_ADE = $un_groupe_ade";
        $les_groupes = $conn->query($req)->fetch_all(MYSQLI_ASSOC);
        if (count($les_groupes)==0) {
            $req = "SELECT RES_ID FROM extraction_groupes_ade
                    WHERE RES_LEAF=1
                      AND RES_PATH LIKE CONCAT(
                          (SELECT RES_PATH FROM extraction_groupes_ade WHERE RES_ID=$un_groupe_ade),
                          (SELECT RES_NAME FROM extraction_groupes_ade WHERE RES_ID=$un_groupe_ade AND RES_LEAF=0),
                          '%')";
            $les_groupes = $conn->query($req)->fetch_all(MYSQLI_ASSOC);
            $les_res[] = -1;
            foreach ($les_groupes as $un_groupe) {
                $les_res[] = $un_groupe['RES_ID'];
            }
            $req = "SELECT * FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_ADE IN (" . implode(",", $les_res) . ")";
            $les_groupes = $conn->query($req)->fetch_all(MYSQLI_ASSOC);
        }
        foreach ($les_groupes as $un_groupe) {
            $retour .= "------------<br/>GROUPE : ".$un_groupe["GROUPE_NOM"]."<br/>";
            $req = "DELETE FROM common_backup_ade_etudiant WHERE EDT_DATE_DEBUT=".$_POST['bfmw_num_*EDT_DATE_DEBUT']." AND EDT_DATE_FIN=".$_POST['bfmw_num_*EDT_DATE_FIN']." AND EDT_HEURE_DEBUT=".$_POST['bfmw_num_*EDT_HEURE_DEBUT']." AND EDT_HEURE_FIN=".$_POST['bfmw_num_*EDT_HEURE_FIN']." AND EDT_GROUPE_ID=".$un_groupe["GROUPE_ID"]." AND EDT_ANNEE_ID=".$_POST['bfmw_num_*EDT_ANNEE_ID'];
            $conn->query($req);
            $retour .= "FIRST DEL : ".$conn->affected_rows."<br/>";
            $req = "DELETE FROM common_backup_ade_etudiant WHERE EDT_UID='".$_POST['bfmw_orig_*EDT_UID']."' AND EDT_GROUPE_ID=".$un_groupe["GROUPE_ID"]." AND EDT_ANNEE_ID=".$_POST['bfmw_num_*EDT_ANNEE_ID'];
            $conn->query($req);
            $retour .= "SECOND DEL : ".$conn->affected_rows."<br/>";
            bfmw_add_secured($_POST,"*EDT_GROUPE_ID",$un_groupe["GROUPE_ID"]);
            $id = createData("common_backup_ade_etudiant",$_POST,9);
            $retour .= "INSERT : ".$id."<br/>";
        }
    }
    makeErreur("warning","ADE UPD",$retour);
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "show_ade", "admin/show_ade.html");
if (isset($_POST["bfmw_orig_ENS"])) {
    $tab = explode("$", $_POST["bfmw_orig_ENS"]);
    $event_affiche = array();
    if (!Edt::collectEDTv2(Edt::$current_project_id, array($tab[0]), $event_affiche, 0, true, false)) {
        echo "Erreur";
        exit;
    }
    affectToBlocAndRepeat($template, "un_edt", $event_affiche);

    affectToXHTML($template, array(
        "ANNEE_COURANTE" => Annees::getIdAnneeCourante(),
        "ENS_ID" => $tab[1],
        "RED" => isset($_GET["bfmw_orig_r"]) ? $_GET["bfmw_orig_r"] : "",
        "ENS" => $_POST["bfmw_orig_ENS"],
        "GROUPE" => null
    ));
}

if (isset($_POST["bfmw_orig_GROUPE"])) {
    $tab = explode("$", $_POST["bfmw_orig_GROUPE"]);
    $event_affiche = array();
    if (!Edt::collectEDTv2(Edt::$current_project_id, array($tab[0]), $event_affiche, 0, true, false)) {
        die ("Erreur");
    }
    affectToBlocAndRepeat($template, "un_edt", $event_affiche);

    affectToXHTML($template, array(
        "ANNEE_COURANTE" => Annees::getIdAnneeCourante(),
        "GROUPE_ID" => $tab[1],
        "RED" => isset($_GET["bfmw_orig_r"]) ? $_GET["bfmw_orig_r"] : "",
        "ENS" => null,
        "GROUPE" => $_POST["bfmw_orig_GROUPE"]
    ));
}

generateCompleteXHTML($template, "show_ade");
