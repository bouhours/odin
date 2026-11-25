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

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Envoie d'un mail
 */
if (isset($_GET['bfmw_orig_p']) && isset($_GET['bfmw_orig_p2']) && $_GET['bfmw_orig_p2']=="mailing" && isset($_POST['bfmw_orig_sujet_mail']) && (isset($_POST['bfmw_orig_choix_groupe']) || isset($_POST['bfmw_orig_simple'])) && isset($_POST['bfmw_orig_message']) && isset($_GET['bfmw_orig_mailing']) && isset($_POST['bfmw_orig_copie_mail'])  && isset($_POST['bfmw_orig_choix_annee'])) {

    if (Annees::getAnneeWithId($_POST['bfmw_num_choix_annee'])[0]['ANNEE_CLOSE'] != 0) {
        exit;
    }
    $annee_courante = $_POST['bfmw_num_choix_annee'];

    if (isset($_POST['bfmw_orig_simple'])) {
        $param = "&e=".$_POST['bfmw_num_simple']."&a=".$annee_courante;
    } else {
        $param = "&choix_groupe=".$_POST['bfmw_num_choix_groupe']."&a=".$annee_courante;
    }

    if (trim($_POST['bfmw_orig_sujet_mail']) == "") {
        makeErreur("warning","Envoyer un mail","Attention, le sujet du mail est obligatoire");
        $param .= "&sujet_mail=".$_POST['bfmw_orig_sujet_mail']."&message=".$_POST['bfmw_orig_message'];
    } else if (trim($_POST['bfmw_orig_message']) == "") {
        makeErreur("warning","Envoyer un mail","Attention, le corps du mail est obligatoire");
        $param .= "&sujet_mail=".$_POST['bfmw_orig_sujet_mail']."&message=".$_POST['bfmw_orig_message'];
    } else {
        $enseignant_courant = Enseignants::getEnseigant(CURRENT_ID);
        if (count($enseignant_courant) != 1) {
            makeErreur("","Envoyer un mail","Erreur, piratage détecte.");
        } else {
            $enseignant_courant = $enseignant_courant[0];

            $les_etudiants = array();

            if (isset($_POST['bfmw_orig_simple'])) {
                $les_etudiants = Etudiants::getEtudiantSimple($_POST['bfmw_num_simple']);
            } else {
                $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$_POST['bfmw_num_choix_groupe']);
            }
            if (count($les_etudiants) == 0) {
                makeErreur("","Envoyer un mail","Erreur, il n'y a aucun étudiant dans ce groupe.");
            } else {
                $first = true;
                $complement = "Mail envoyé ";
                $destinataires = array();
                foreach ($les_etudiants as $un_etudiant) {
                    if ($first) {
                        $first = false;
                        if (isset($_POST['bfmw_orig_simple'])) {
                            $complement .= "à ".$un_etudiant['ET_NOM']."\n\n";
                        } else {
                            $completement2 = "";
                            if ($un_etudiant['GROUPE_FORM_ID'] != "") {
                                $formation = Formations::getFormation($un_etudiant['GROUPE_FORM_ID'])[$un_etudiant['GROUPE_FORM_ID']];
                                $departement = Departements::getDepartement($formation['FORM_DEPT_ID'])[0];
                                $completement2 = "de ".$formation['FORM_NOM']." du ".$departement["DEPT_NOM"];
                            }

                            $complement .= "au groupe ".$un_etudiant['GROUPE_NOM']." ".$completement2."\n\n";
                        }
                    }

                    $destinataires[] = $un_etudiant['ET_MAIL'];
                }

                $destinataires = implode(",",$destinataires);

                if (isset($_FILES['piece_jointe']) && isset($_FILES['piece_jointe']['tmp_name']) && trim($_FILES['piece_jointe']['tmp_name']) != "") {
                    sendMail("", html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), $destinataires, $enseignant_courant['ENS_MAIL'], $enseignant_courant['ENS_MAIL'],$_FILES['piece_jointe']);
                    $_POST['bfmw_orig_message'] = $complement.$_POST['bfmw_orig_message'];
                    sendMail($enseignant_courant['ENS_MAIL'], html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), "", $enseignant_courant['ENS_MAIL'], $enseignant_courant['ENS_MAIL'],$_FILES['piece_jointe'],"cedric.bouhours@uca.fr",$_POST['bfmw_orig_copie_mail']);
                } else {
                    sendMail("", html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), $destinataires, $enseignant_courant['ENS_MAIL'], $enseignant_courant['ENS_MAIL']);
                    $_POST['bfmw_orig_message'] = $complement.$_POST['bfmw_orig_message'];
                    sendMail($enseignant_courant['ENS_MAIL'], html_entity_decode($_POST['bfmw_orig_sujet_mail'], ENT_QUOTES), html_entity_decode($_POST['bfmw_orig_message'], ENT_QUOTES), "", $enseignant_courant['ENS_MAIL'], $enseignant_courant['ENS_MAIL'],"","cedric.bouhours@uca.fr",$_POST['bfmw_orig_copie_mail']);
                }
                makeErreur("success","Envoyer un mail","Le mail a été correctement envoyé");
            }
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