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

if (!defined('FRONT_ACCESS')) {
    die ('Piratage détecté');
}

/**
 * Mise à jour de la configuration
 */
if (isset($_POST['bfmw_orig_saveConfig']) && $_GET['bfmw_orig_p2']=="evaluation") {
    $formations_autorisees = Formations::getFormationsDuConnecteString();

    $req = "SELECT * FROM common_formation WHERE FORM_ID IN ($formations_autorisees) AND FORM_ID=".$_GET['bfmw_num_f']." AND FORM_EVALUABLE=1";
    $res = $conn->query($req);
    $is_evaluable = $res->num_rows > 0;

    if ($is_evaluable) {
        if ($_POST['bfmw_num_force_date'] == 0) {
            $req = "UPDATE common_formation SET FORM_EVAL_DEBUT=NULL, FORM_EVAL_FIN=NULL WHERE FORM_ID=" . $_GET['bfmw_num_f'];
            $conn->query($req);
        } else {
            if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/", $_POST['bfmw_orig_DDEBUT']) === false) {
                makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
            }
            if (preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/", $_POST['bfmw_orig_DFIN']) === false) {
                makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
            }
            if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/", $_POST['bfmw_orig_HDEBUT']) === false) {
                makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
            }
            if (preg_match("/^([01]\d|2[0-3])h([0-5]\d)$/", $_POST['bfmw_orig_HFIN']) === false) {
                makeErreur("", "Erreur !", "Impossible de mémoriser les informations.");
            }

            $req = "UPDATE common_formation SET FORM_EVAL_DEBUT=" . transformDateHeureSepares($_POST['bfmw_orig_DDEBUT'], $_POST['bfmw_orig_HDEBUT']) . ", FORM_EVAL_FIN=" . transformDateHeureSepares($_POST['bfmw_orig_DFIN'], $_POST['bfmw_orig_HFIN']) . ", FORM_EVAL_PERIODE_ID=".$_POST['bfmw_num_PERIODE']." WHERE FORM_ID=" . $_GET['bfmw_num_f'];
            $conn->query($req);
        }
    } else {
        makeErreur("", "Erreur !", "Piratage détecté.");
    }

    $param .= "&f=".$_GET['bfmw_num_f'];
}
