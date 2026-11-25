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

require_once 'self_server_concrete.php';

require_once __DIR__ . '/../bfmw/includes/secure.php';
require_once __DIR__ . '/../bfmw/includes/functions.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set("Europe/Paris");

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

require_once __DIR__ . '/../common/Model/Edt.php';
Edt::static_init($conn);
require_once __DIR__ . '/../common/Model/WS_ADE.php';
WS_ADE::static_init($conn);
require_once __DIR__ . '/../common/Model/WS_Event.php';
require_once __DIR__ . '/../common/Model/Annees.php';
Annees::static_init($conn);
$annee_courante = Annees::getIdAnneeCourante();

$req = "SELECT * FROM enseignants_formations WHERE ENS_ADE IS NOT NULL AND ENS_ADE <> '' GROUP BY ENS_ID";
$res = $conn->query($req);
$today = new DateTime();
$deuxsemainespast = new DateTime();
$deuxsemainespast->sub(new DateInterval("P2W"));
$tomorrow = new DateTime();
$tomorrow->add(new DateInterval("P1D"));

$nb = 0;
while ($un_enseignant = $res->fetch_assoc()) {
    try {
        mysql_start_transaction();
        $les_creneaux = Edt::getCreneaux($un_enseignant['ENS_ID'],$deuxsemainespast->getTimestamp());

        Edt::deleteCreneaux($un_enseignant['ENS_ID'],$deuxsemainespast->getTimestamp());

        $events_affiche = array();
        $try = 0;
        while ($try < 2 && $try != -1) {
            if (!Edt::collectEDTv2(Edt::$current_project_id, array($un_enseignant['ENS_ADE']), $events_affiche, 0, false, false, false, false, $deuxsemainespast, $tomorrow)) {
                $try++;
            } else {
                $try = -1;
            }
        }
        if ($try != -1) {
            sendMail("cedric.bouhours@uca.fr", "BACKUP EDT", "Exception : " . $un_enseignant['ENS_NOM']);
            mysql_rollback();
            continue;
        }
        if (!empty($events_affiche)) {
            foreach ($events_affiche as $un_evt) {
                $un_evt['*EDT_ENS_ID']=$un_enseignant['ENS_ID'];
                $un_evt['*EDT_ANNEE_ID']=$annee_courante;
                $params = array();
                $params[] = $un_evt;
                manual_bfmw_secure($params);
                createData("common_backup_ade_enseignant",$params[0],9);
                $nb++;
            }
        }
        mysql_commit();
    } catch (Exception $e) {
        sendMail("cedric.bouhours@uca.fr", "BACKUP EDT", "Exception : ".$un_enseignant['ENS_NOM']."\n".$e->getTraceAsString());
        mysql_rollback();
    }
}

$conn->close();
exit;
