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

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_edt']) && ($_POST['bfmw_orig_edt']==="lazy" || $_POST['bfmw_orig_edt']==="modification" || $_POST['bfmw_orig_edt']==="recap") ){
    if ($_POST['bfmw_orig_edt']==="lazy") {
        require 'edt.php';
    }
    if ($_POST['bfmw_orig_edt']==="modification") {
        $param_edt = "modification";
        require 'edt.php';
    }
    if ($_POST['bfmw_orig_edt']==="recap") {
        $param_edt = "recap";
        require 'edt.php';
    }
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    switch ($_POST['bfmw_orig_type']) {
        case "jkhkfdc5G76T" :
            switch ($_POST['bfmw_orig_tag']) {
                case "ENS_EDT":
                case "ENS_EDT_HEBDO":
                $req = "UPDATE common_enseignant SET ".$_POST['bfmw_orig_tag']."=" . $_POST['bfmw_num_valeur'] . " WHERE ENS_ID=" . CURRENT_ID;
                break;
            }
            break;
        case "lsjcnhlseufnclsf" :
            $where = explode("$",$_POST['bfmw_orig_where']);
            $where[0] = get_numeric($where[0]);
            $force = isGestionnaire() && count($where) === 2;
            if ($force) {
                $where[1] = get_numeric($where[1]);
            }
            $req = "SELECT * FROM edt_periode,common_edt_fiche WHERE FICHE_ID=".$where[0]." AND PERIODE_ID = FICHE_PERIODE_ID";
            $res = $conn->query($req);
            if ($res === false) {
                exit();
            }
            $une_periode = $res->fetch_assoc();
            $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
            if ((time() > $date_maxi->getTimestamp()) && !$force) {
                $req = "";
            } else {
                $req = "SELECT * FROM common_edt_indisponibilite WHERE DISPO_ENS_ID = " . ($force?$where[1]:CURRENT_ID) . " AND DISPO_INDISPO = " . $_POST['bfmw_num_valeur'] . " AND DISPO_FICHE_ID=" . $where[0];
                if ($conn->query($req)->num_rows === 0) {
                    $req = "INSERT INTO common_edt_indisponibilite(DISPO_FICHE_ID, DISPO_INDISPO, DISPO_ENS_ID) VALUES(" . $where[0] . "," . $_POST['bfmw_num_valeur'] . "," . ($force?$where[1]:CURRENT_ID) . ")";
                } else {
                    $req = "DELETE FROM common_edt_indisponibilite WHERE DISPO_FICHE_ID=" . $where[0] . " AND DISPO_INDISPO=" . $_POST['bfmw_num_valeur'] . " AND DISPO_ENS_ID=" . ($force?$where[1]:CURRENT_ID);
                }
            }
            break;
        case "jytkhthdxhjgftzeatyu" :
            $where = explode("$",$_POST['bfmw_orig_where']);
            $where[0] = get_numeric($where[0]);
            $where[1] = get_numeric($where[1]);
            $force = isGestionnaire() && count($where) === 3;
            if ($force) {
                $where[2] = get_numeric($where[2]);
            }
            $req = "SELECT PERIODE_LIMIT FROM common_edt_periode,common_edt_fiche WHERE PERIODE_ID = FICHE_PERIODE_ID AND FICHE_ID=".$where[1];
            $res = $conn->query($req);
            $une_periode = $res->fetch_assoc();
            $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
            if ((time() > $date_maxi->getTimestamp()) && !$force) {
                $req = "";
            } else {
                switch ($_POST['bfmw_orig_tag']) {
                    case "CHARGE_COMMENTAIRE" :
                        $req = "INSERT INTO common_edt_commentaires(COMMENTAIRE_AFFECT_ID, COMMENTAIRE_FICHE_ID, COMMENTAIRE) VALUES (".$where[0].",".$where[1].",'".$_POST['bfmw_orig_valeur']."') ON DUPLICATE KEY UPDATE COMMENTAIRE='".$_POST['bfmw_orig_valeur']."'";
                        break;
                }
            }
            break;
        case "oliuoiusfegsdfg" :
            $where = explode("$",$_POST['bfmw_orig_where']);
            $where[0] = get_numeric($where[0]);
            $force = isAdmin() && count($where) === 2;
            if ($force) {
                $where[1] = get_numeric($where[1]);
            }
            $req = "SELECT * FROM edt_periode,common_edt_fiche,common_edt_exams WHERE EXAM_FICHE_ID=FICHE_ID AND EXAM_ID=".$where[0]." AND PERIODE_ID = FICHE_PERIODE_ID";
            $res = $conn->query($req);
            $une_periode = $res->fetch_assoc();
            $date_maxi = new DateTime($une_periode['PERIODE_LIMIT']." 23:59:59", new DateTimeZone("Europe/Paris"));
            if ((time() > $date_maxi->getTimestamp()) && !$force) {
                $req = "";
            } else {
                switch ($_POST['bfmw_orig_tag']) {
                    case "EXAM_DUREE" :
                    case "EXAM_SALLE" :
                    case "EXAM_COMMENTAIRE" :
                    case "EXAM_MAT_ID" :
                        $req = "UPDATE common_edt_exams SET " . $_POST['bfmw_orig_tag'] . "='" . $_POST['bfmw_orig_valeur'] . "' WHERE EXAM_ID=" . $where[0] . " AND EXAM_ENS_ID=" . ($force?$where[1]:CURRENT_ID);
                        break;
                }
            }
            break;
        case "jxfhchgk(tç-_yer" :
            $where = explode("$",$_POST['bfmw_orig_where']);
            $where[0] = get_numeric($where[0]);
            $where[1] = get_numeric($where[1]);
            switch($_POST['bfmw_orig_tag']) {
                case "COMMENTAIRE_DONE" :
                case "COMMENTAIRE_GESTIONNAIRE" :
                    $req = "INSERT INTO common_edt_commentaires(COMMENTAIRE_AFFECT_ID, COMMENTAIRE_FICHE_ID, ".$_POST['bfmw_orig_tag'].") VALUES (".$where[0].",".$where[1].",'".$_POST['bfmw_orig_valeur']."') ON DUPLICATE KEY UPDATE ".$_POST['bfmw_orig_tag']."='".$_POST['bfmw_orig_valeur']."'";
                    break;
            }
            break;
        case "mljhqedpfibaqerpfimibhj" :
            switch($_POST['bfmw_orig_tag']) {
                case "EXAM_DONE" :
                case "EXAM_GESTIONNAIRE" :
                    $req = "UPDATE common_edt_exams SET ".$_POST['bfmw_orig_tag']."='".$_POST['bfmw_orig_valeur']."' WHERE EXAM_ID=".$_POST['bfmw_num_where'];
                    break;
            }
            break;
        default :
            exit();
    }
    if ($conn->query($req) == 1) {
        echo "OK";
    }

    exit();
}

