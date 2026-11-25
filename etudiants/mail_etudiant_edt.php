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

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set("Europe/Paris");
require_once 'self_server_concrete.php';
require_once __DIR__.'/../bfmw/includes/functions.php';

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

require_once __DIR__.'/../common/Model/Edt.php';
Edt::static_init($conn);

$req = "SELECT * FROM common_annee WHERE ANNEE_COURANTE = 1";
$res = $conn->query($req);
$annee_courante = $res->fetch_assoc()['ANNEE_ID'];

$req = "SELECT * FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND `ET_EDT`='1' AND GROUPE_ADE IS NOT NULL AND GROUPE_ADE <> '' ORDER BY `GROUPE_ADE`";
$res = $conn->query($req);
$codeADEencours = "0";
$today = date("d/m/Y");
$emploidutemps = "";
$events_affiche = array();
$mails_groupe = "";

while ($un_mail = $res->fetch_assoc()) {
    if ($codeADEencours !== $un_mail['GROUPE_ADE']) {
        envoyer_mails($mails_groupe, $emploidutemps);
        $mails_groupe = "";

        $codeADEencours = $un_mail['GROUPE_ADE'];
        try {
            $events_affiche = array();
            $emploidutemps = "";
            Edt::collectEDT("http://edt.uca.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=$codeADEencours&projectId=".Edt::$current_project_id."&nbWeeks=1&calType=ical", $events_affiche);
            if (!empty($events_affiche)) {
                $first = 0;
                foreach ($events_affiche as $un_evt) {
                    if ($today === $un_evt["DATE_DEBUT"]) {
                        if (++$first == 1) {
                            $emploidutemps = $un_evt['JOUR_DATE_DEBUT'] . " " . $un_evt['NUMERO_DATE_DEBUT'] . " " . $un_evt['MOIS_DATE_DEBUT'] . " " . $un_evt['ANNEE_DATE_DEBUT'] . "\n";
                        }
                        $emploidutemps .= "\t* " . $un_evt['HEURE_DEBUT'] . " - " . $un_evt['HEURE_FIN'] . " : " . html_entity_decode($un_evt['NOM'], ENT_QUOTES) . ($un_evt['SALLE']===""?"":" (" . html_entity_decode($un_evt['SALLE'], ENT_QUOTES).")") . "\n";
                    }
                }
            }
        } catch (Exception $e) {
            //Nothing to do
        }
    }

    $mails_groupe .= $un_mail['ET_MAIL'].",";
}

envoyer_mails($mails_groupe, $emploidutemps);

$conn->close();
exit;

function envoyer_mails($mails_groupe, $emploidutemps)
{
    if ($mails_groupe !== "" && $emploidutemps !== "") {
        sendMail("Plateforme ODIN <noreply+odin@uca.fr>", "Emploi du temps quotidien", "Bonjour\n\nVoici votre emploi du temps du jour (sous réserve de modification non encore signalée) : \n\n$emploidutemps\n\nVous pouvez vous désabonner de ce mail directement sur la plateforme Odin (https://odin.iut.uca.fr)", $mails_groupe);
    }
}