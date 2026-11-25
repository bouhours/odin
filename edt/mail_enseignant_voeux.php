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

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

require_once __DIR__.'/../common/Model/Edt.php';
Edt::static_init($conn);

$today = new DateTime();
$today->setTime(0,0,0);
$today = $today->getTimestamp();


$req = "SELECT * FROM edt_access_enseignants";
$resEns = $conn->query($req);
while ($un_enseignant = $resEns->fetch_assoc()) {
    $les_affectations = Edt::getFichesEnseignant($un_enseignant["ENS_ID"],$un_enseignant["ACCESS_DEPT_ID"]);
    $les_periodes = array();
    foreach ($les_affectations as $une_affectation) {
        if (!($une_affectation["PERIODE_DEBUT_WARNING_UNIX"] <= $today && $une_affectation["PERIODE_LIMIT_UNIX"]>=$today && $une_affectation["HAS_FICHE"] == 0)) {
            continue;
        }
        $les_periodes[] = $une_affectation["PERIODE_NOM"]." (date limite le ".$une_affectation['PERIODE_LIMIT_AFFICHAGE'].")";
    }

    if (count($les_periodes) > 0) {
        $lemail = "Bonjour,\n\nAfin de créer vos emplois du temps pour " . (count($les_periodes) === 1 ? "la période" : "les périodes") . " " . implode(", ",$les_periodes) . ", merci de bien vouloir remplir vos fiches de voeux que vous trouverez sur la plateforme Odin (https://odin.iut.uca.fr), application \"Emploi du temps\".\n\nSi vous avez déjà saisi une fiche, vous recevez ce mail parce qu'elle est incomplète.\n\nSi vous n'intervenez pas sur " . (count($les_periodes) === 1 ? "la période indiquée" : "les périodes indiquées") . ", merci de le signaler au secrétariat. \n\nMerci d'avance.\n\nCordialement";
        sendMail($un_enseignant['ENS_MAIL'], "Fiches de voeux pour l'emploi du temps", $lemail);
    }
}

$conn->close();
exit;