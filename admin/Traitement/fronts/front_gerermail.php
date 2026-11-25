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

/*****************************************************************
 * MAILING *******************************************************
 *****************************************************************/
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="vacataire" && isset($_POST['bfmw_orig_sujet_mail']) && isset($_POST['bfmw_orig_message'])) {

    $annee_courante = $_GET['bfmw_num_a'];

    $param .= "&a=".$_GET['bfmw_num_a'];

    if (trim($_POST['bfmw_orig_sujet_mail']) == "") {
        makeErreur("warning","Envoyer un mail","Attention, le sujet du mail est obligatoire");
        $param .= "&sujet_mail=".$_POST['bfmw_orig_sujet_mail']."&message=".$_POST['bfmw_orig_message'];
    } else if (trim($_POST['bfmw_orig_message']) == "") {
        makeErreur("warning","Envoyer un mail","Attention, le corps du mail est obligatoire");
        $param .= "&sujet_mail=".$_POST['bfmw_orig_sujet_mail']."&message=".$_POST['bfmw_orig_message'];
    } else {
        if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isChef()) {
            makeErreur("","Envoyer un mail","Erreur, piratage détecte.");
        } else {
            $req = "SELECT ENS_MAIL FROM common_enseignant WHERE ENS_ID=".CURRENT_ID;
            $ens = $conn->query($req)->fetch_assoc();
            if (isset($_GET['bfmw_orig_perm'])) {
                $param .= "&perm=vac";
                $req = "SELECT ENS_NOM,ENS_MAIL FROM common_enseignant,common_enseignants_departement,common_enseignants_matieres,common_matiere WHERE MAT_ID=ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ENS_DEPT_VACATAIRE=0 AND ENS_ID=MAT_ENS_ID AND ENS_MAT_ANNEE_ID=$annee_courante AND ENS_ID=DEPT_ENS_ID AND ENS_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY ENS_ID ORDER BY ENS_NOM";
            } else {
                $req = "SELECT ENS_NOM,ENS_MAIL FROM common_enseignant,common_enseignants_departement,common_enseignants_matieres,common_matiere WHERE MAT_ID=ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ENS_DEPT_VACATAIRE=1 AND ENS_ID=MAT_ENS_ID AND ENS_MAT_ANNEE_ID=$annee_courante AND ENS_ID=DEPT_ENS_ID AND ENS_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY ENS_ID ORDER BY ENS_NOM";
            }
            $res = $conn->query($req);
            if ($res->num_rows == 0) {
                makeErreur("","Envoyer un mail","Erreur, il n'y a personne à contacter.");
            } else {
                $first = true;
                $complement = "Mail envoyé à : \n";
                $destinataires = "";
                while ($un_intervenant = $res->fetch_assoc()) {
                    if ($un_intervenant['ENS_MAIL'] == "") {
                        continue;
                    }
                    $complement .= $un_intervenant['ENS_NOM']."\n";

                    if ($destinataires != "") {
                        $destinataires .= ",";
                    }
                    $destinataires .= $un_intervenant['ENS_MAIL'];
                }

                if (isset($_FILES['piece_jointe']) && isset($_FILES['piece_jointe']['tmp_name']) && trim($_FILES['piece_jointe']['tmp_name']) != "") {
                    sendMail("", html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), $destinataires, $ens['ENS_MAIL'], $ens['ENS_MAIL'],$_FILES['piece_jointe']);
                    $_POST['bfmw_orig_message'] = $complement."\n\n\n".$_POST['bfmw_orig_message'];
                    sendMail($ens['ENS_MAIL'], html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), "", $ens['ENS_MAIL'], $ens['ENS_MAIL'],$_FILES['piece_jointe']);
                } else {
                    sendMail("", html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), $destinataires, $ens['ENS_MAIL'], $ens['ENS_MAIL']);
                    $_POST['bfmw_orig_message'] = $complement."\n\n\n".$_POST['bfmw_orig_message'];
                    sendMail($ens['ENS_MAIL'], html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), "", $ens['ENS_MAIL'], $ens['ENS_MAIL']);
                }
                makeErreur("success","Envoyer un mail","Le mail a été correctement envoyé");
            }
        }
    }
}
