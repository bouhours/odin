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
require_once __DIR__ . '/../bfmw/includes/functions.php';
require_once __DIR__ . '/../common/Model/Edt.php';

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

$today = date("Y-m-d");

Edt::static_init($conn);
$resInterventions = Edt::getMailLimiteNotes($today);

$enseignant_en_cours = -1;

$les_periodes = array();
$last_mail = "";
while ($une_periode = $resInterventions->fetch_assoc()) {
    if ($enseignant_en_cours != $une_periode['ENS_ID']) {
        $enseignant_en_cours = $une_periode['ENS_ID'];

        doMail($les_periodes, $last_mail);
    }

    $les_periodes[$une_periode['PERIODE_LIMIT_AFFICHAGE']][] = $une_periode['PERIODE_NOM'];
    $last_mail = $une_periode['ENS_MAIL'];
}

doMail($les_periodes, $last_mail);

$conn->close();
exit;

function doMail(array &$les_periodes, string $mail): void
{
    if (count($les_periodes) > 0 && $mail != "") {
        $phrase = "";
        foreach ($les_periodes as $date => $periodes) {
            $phrase .= "- " . implode(", ", $periodes) . " : $date\n";
        }

        $lemail = "Bonjour,\n\nAttention, la date limite de saisie des notes approche :\n$phrase\nMerci de vous assurer que vous avez bien validé tous vos contrôles sur la plateforme Odin (https://odin.iut.uca.fr), application \"Notes\".\n\nSi vous avez déjà saisi toutes vos notes, ne tenez pas compte de ce mail.\n\nMerci d'avance.\n\nCordialement";
        sendMail($mail, "La date limite de saisie des notes approche", $lemail);
        $les_periodes = array();
    }
}