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

if (!isRegistered() && !isset($_GET['bfmw_orig_p2'])) {
    echo "Non autorisé";
    exit;
}

$param = "";



/**
 * Insertion de l'absence
 */
if (isset($_POST['bfmw_orig_submit_absences'])) {
    mysql_start_transaction();

    $annee_courante = Annees::getIdAnneeCourante();

    if (isset($_POST['bfmw_orig_creneau_special'])) {
        $le_creneau = explode(" - ",$_POST['bfmw_orig_creneau_horaire']);
        if (count($le_creneau) !== 2) {
            makeErreur("", "Erreur !", "Impossible d'utiliser le créneau choisi.");
        } else {
            $les_creneaux = Absences::getCreneauxHoraire(transformHeure($le_creneau[0]),transformHeure($le_creneau[1]),CURRENT_DEPT_ID);
            if (count($les_creneaux) == 0) {
                $creneau_id = Absences::creerCreneauHoraire(transformHeure($le_creneau[0]), transformHeure($le_creneau[1]), CURRENT_DEPT_ID);
            } else {
                $creneau_id = array_keys($les_creneaux)[0];
            }

            bfmw_add_secured($_POST,"creneau",array($creneau_id));
        }
    }


    if (!isErreur()) {
        try {
            transformDate($_POST['bfmw_orig_ABS_DATE']);
        } catch (Exception $e) {
            makeErreur("", "Erreur !", "Vous devez indiquer le date de l'absence.");
            mysql_rollback();
        }
    }

    if (!isErreur() && !isset($_POST['bfmw_orig_MAT_ID'])) {
        makeErreur("", "Erreur !", "Impossible d'utiliser le cours choisi.");
        mysql_rollback();
    }

    $isChef = Formations::isResponsable() || Formations::isSecretaire() || Formations::isChef();

    if (!isErreur()) {
        if (isset($_POST['bfmw_orig_etudiant'])) {
            if (isset($_POST['bfmw_orig_creneau'])) {
                $nbAbsences = 0;
                foreach ($_POST['bfmw_num_etudiant'] as $un_etudiant) {
                    foreach ($_POST['bfmw_num_creneau'] as $un_creneau) {
                        $ENS_ID = CURRENT_ID;
                        if ($isChef && isset($_POST['bfmw_num_ENS_ID'])) {
                            $ENS_ID = $_POST['bfmw_num_ENS_ID'];
                        } else {
                            $isChef = false;
                        }

                        $req = "INSERT INTO common_absences_v2(ABS_ENS_ID,ABS_ET_ID,ABS_CRENEAU_ID,ABS_MAT_ID,ABS_DATE,ABS_REAL_DATE, ABS_ANNEE_ID, ABS_ABST_ID) VALUES(" . $ENS_ID . "," . $un_etudiant . "," . $un_creneau . "," . $_POST['bfmw_num_MAT_ID'] . ",'" . date('d/m/Y', transformDate($_POST['bfmw_orig_ABS_DATE'])) . "',".transformDate($_POST['bfmw_orig_ABS_DATE']).",$annee_courante,".($_POST['bfmw_num_type']==0?"NULL":$_POST['bfmw_num_type']).")";
                        try {
                            $conn->query($req);
                        } catch (Exception $e)
                        {
                            //nothing to do except refactor this awful code !
                        }
                        $nbAbsences += ($conn->affected_rows==-1?0:$conn->affected_rows);
                    }

                    Absences::autojustification($un_etudiant);
                }
                mysql_commit();
                if ($nbAbsences < 2) {
                    makeErreur("success", "Déclaration d'une absence", "$nbAbsences absence a été correctement insérée");
                } else {
                    makeErreur("success", "Déclaration de plusieurs absences", "$nbAbsences absences ont été correctement insérées");
                }
            } else {
                makeErreur("", "Erreur !", "Aucun créneau n'a été sélectionné");
                mysql_rollback();
            }
        } else {
            makeErreur("", "Erreur !", "Aucun étudiant n'a été sélectionné");
            mysql_rollback();
        }
    }

    if ($isChef) {
        $param .= "&chef=98e4sdfze51";
    }
}

/**
 * Suppression d'une absence
 */
if (isset($_GET['bfmw_orig_del']) && $_GET['bfmw_orig_p2'] == "lire") {
    $req = "DELETE FROM common_absences_v2 WHERE ABS_ID=".$_GET['bfmw_num_del']." AND ABS_ENS_ID=".CURRENT_ID;
    if ($conn->query($req) === false) {
        makeErreur("", "Erreur grave", "Contactez le responsable de formation");
    } else {
        if ($conn->affected_rows === 0) {
            makeErreur("", "Suppression", "Impossible de supprimer cette absence.");
        } else {
            makeErreur("success", "Suppression", "L'absence a correctement été supprimée.");
        }
    }

}


$message_erreur = "";
if (isErreur()) {
    $message_erreur = "&cpl=" . urlencode($_ERREUR[0]['COMPLEMENT']);
    $message_erreur .= "&ttr=" . urlencode($_ERREUR[0]['TITRE']);
    $message_erreur .= "&mss=" . urlencode($_ERREUR[0]['MESSAGE']);
}
$send = "p=" . $_GET['bfmw_orig_p2'] . $message_erreur . $param;
require 'refresh.php';

