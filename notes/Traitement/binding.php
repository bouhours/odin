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

$annee_courante = Annees::getIdAnneeCourante();

if (isset($_POST['bfmw_orig_compute']) && $_POST['bfmw_orig_compute'] === "moyenne" && isset($_POST['bfmw_orig_groupe'])) {
    $valeurs = explode("$", $_POST['bfmw_orig_groupe']);
    $valeurs[0] = get_numeric($valeurs[0]);
    if ($valeurs[1] === "all") {
        $req = "SELECT ROUND(AVG(NOTES_VALEUR),2) AS MOYENNE FROM common_notes WHERE NOTES_CONTROLE_ID=" . $valeurs[0];
    } else {
        $valeurs[1] = get_numeric($valeurs[1]);
        $req = "SELECT ROUND(AVG(NOTES_VALEUR),2) AS MOYENNE FROM etudiants_groupes,common_notes WHERE ET_GROUPE_ANNEE_ID=".$valeurs[2]." AND NOTES_CONTROLE_ID=" . $valeurs[0] . " AND ET_ID = NOTES_ET_ID AND GROUPE_FEUILLE = 1 AND (NOTES_VALEUR IS NOT NULL OR NOTES_SPECIAL IS NOT NULL) AND GROUPE_ID=" . $valeurs[1];
    }
    $resMOY = $conn->query($req);

    if ($resMOY !== false) {
        if ($une_moyenne = $resMOY->fetch_assoc()) {
            echo $une_moyenne['MOYENNE'];
        }
    } else {
        echo -1;
    }
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $req = "";

    switch ($_POST['bfmw_orig_type']) {
        case "slkjf5ezlmkj" :
            //Contrôle
            switch ($_POST['bfmw_orig_tag']) {
                case "CONTROLE_NOM":
                case "CONTROLE_COEFF":
                case "CONTROLE_BAREME":
                case "CONTROLE_MOYENNE":
                case "CONTROLE_VISIBLE":
                case "CONTROLE_ANNEE_ID":
                    $req = "UPDATE common_controle SET " . $_POST['bfmw_orig_tag'] . "='" . $_POST['bfmw_orig_valeur'] . "' WHERE CONTROLE_ID=" . $_POST['bfmw_num_where'] . " AND " . $annee_courante . ">(SELECT MAT_LOCK_ANNEE_ID FROM common_matiere WHERE MAT_ID=CONTROLE_MAT_ID)";
                    break;
                case "CONTROLE_MAT_ID":
                    $req = "UPDATE common_controle SET CONTROLE_MAT_ID=" . $_POST['bfmw_num_valeur'] . " WHERE CONTROLE_ID=" . $_POST['bfmw_num_where'] . " AND " . $annee_courante . ">(SELECT MAT_LOCK_ANNEE_ID FROM common_matiere WHERE MAT_ID=" . $_POST['bfmw_orig_valeur'] . ")";
                    $conn->query($req);
                    if ($conn->affected_rows == 1) {
                        echo "OK";
                    }
                    exit;
                    break;
                case "ENSEIGNANT_ID":
                    if (isset($_SESSION['notes_chef'])) {
                        $req = "UPDATE common_controle SET CONTROLE_ENS_ID=" . $_POST['bfmw_num_valeur'] . " WHERE CONTROLE_ID=" . $_POST['bfmw_num_where'] . " AND " . $annee_courante . ">(SELECT MAT_LOCK_ANNEE_ID FROM common_matiere WHERE MAT_ID=" . $_POST['bfmw_orig_valeur'] . ")";
                        $conn->query($req);
                        if ($conn->affected_rows == 1) {
                            echo "OK";
                        }
                    }
                    exit;
                    break;
            }
            break;
        case "lkutfbydgvosdfyngl" :
            $req = "UPDATE common_formation SET FORM_CODE_APOGEE='".$_POST['bfmw_orig_valeur']."' WHERE FORM_ID=".$_POST['bfmw_num_where'];
            break;
        case "sdflkg43sdfljhg" :
            //Notes
            $where = explode("$", $_POST['bfmw_orig_where']);
            if ($_POST['bfmw_orig_tag'] === "NOTES_AVIS") {
                $req = "SELECT * FROM common_controle,common_matiere WHERE MAT_START_ANNEE_ID <= " . get_numeric($where[3]) . " AND (MAT_END_ANNEE_ID > " . get_numeric($where[3]) . " OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=CONTROLE_MAT_ID AND CONTROLE_ID=" . get_numeric($where[1]);
            } else {
                $req = "SELECT * FROM common_controle,common_matiere WHERE MAT_START_ANNEE_ID <= " . get_numeric($where[3]) . " AND (MAT_END_ANNEE_ID > " . get_numeric($where[3]) . " OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=CONTROLE_MAT_ID AND CONTROLE_ID=" . get_numeric($where[1]) . " AND MAT_LOCK_ANNEE_ID<" . get_numeric($where[3]);
            }
            if ($conn->query($req)->num_rows > 0) {
                if ($_POST['bfmw_orig_tag'] === "NOTES_AVIS") {
                    $valeur = $_POST['bfmw_orig_valeur'];
                    $req = "INSERT INTO common_notes(NOTES_ID,NOTES_CONTROLE_ID,NOTES_ET_ID,NOTES_VALEUR,NOTES_SPECIAL,NOTES_AVIS) VALUES (" . (get_numeric($where[0])==null?"NULL":get_numeric($where[0])) . "," . get_numeric($where[1]) . "," . get_numeric($where[2]) . ",NULL,NULL,'".$_POST['bfmw_orig_valeur']."') ON DUPLICATE KEY UPDATE NOTES_AVIS='".$_POST['bfmw_orig_valeur']."'";
                } else {
                    $valeur = get_numeric(str_replace(",", ".", $_POST['bfmw_orig_valeur']));
                    $req = "INSERT INTO common_notes(NOTES_ID,NOTES_CONTROLE_ID,NOTES_ET_ID,NOTES_VALEUR,NOTES_SPECIAL) VALUES (" . (get_numeric($where[0])==null?"NULL":get_numeric($where[0])) . "," . get_numeric($where[1]) . "," . get_numeric($where[2]) . "," . (is_numeric($valeur) ? $valeur : 'NULL') . "," . (($valeur === "ABI" || $valeur === "ABJ") ? "'" . $_POST['bfmw_orig_valeur'] . "'" : 'NULL') . ") ON DUPLICATE KEY UPDATE ";
                    if (is_numeric($valeur)) {
                        $req .= "NOTES_VALEUR = $valeur, NOTES_SPECIAL = NULL";
                    } else {
                        if ($_POST['bfmw_orig_valeur'] === "ABI") {
                            $req .= "NOTES_VALEUR = NULL, NOTES_SPECIAL='" . $_POST['bfmw_orig_valeur'] . "'";
                        } else {
                            $req .= "NOTES_VALEUR = NULL, NOTES_SPECIAL = NULL";
                        }
                    }

                    if ($_POST['bfmw_orig_valeur'] === "ABI") {
                        $req2 = "SELECT * FROM common_controle, common_matiere WHERE MAT_START_ANNEE_ID <= " . get_numeric($where[3]) . " AND (MAT_END_ANNEE_ID > " . get_numeric($where[3]) . " OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=CONTROLE_MAT_ID AND CONTROLE_VALIDE = 1 AND CONTROLE_ID=" . get_numeric($where[1]);
                        $res = $conn->query($req2);
                        while ($un_controle = $res->fetch_assoc()) {
                            $req2 = "SELECT * FROM etudiants_groupes, common_enseignant WHERE ET_GROUPE_ANNEE_ID=" . get_numeric($where[3]) . " AND ENS_ID=GROUPE_ENS_ID AND ET_ID=".get_numeric($where[2])." GROUP BY ENS_ID";
                            $res = $conn->query($req2);
                            $les_mediateurs = array();
                            while ($un_mediateur = $res->fetch_assoc()) {
                                sendMail($un_mediateur['ENS_MAIL'], "Une note ABI a été saisie", "Bonjour\n\nUne note ABI a été saisie dans un des contrôles de '" . $un_controle['MAT_NOM'] . "' pour ".$un_mediateur['ET_NOM'].".\n\nCordialement");
                            }
                        }
                    }

                }
            } else {
                $req = "";
            }
            break;
        default :
            exit();
    }

    if ($req=="") {
        exit();
    }

    if ($conn->query($req) == 1) {
        echo "OK";
    }

    exit();
}

