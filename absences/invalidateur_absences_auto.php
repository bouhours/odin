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

require_once('self_server_concrete.php');
require_once __DIR__.'/../bfmw/includes/functions.php';
date_default_timezone_set("Europe/Paris");
$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

require_once __DIR__.'/../common/Model/Absences_Automatiques.php';
Absences_Automatiques::static_init($conn);

$date = new DateTime();
$date->sub(new DateInterval("P7D"));

$nb_transforme = Absences_Automatiques::masquerCreneauxNonSigneesParEnseignantInferieurA($date->getTimestamp());
sendMail("cedric.bouhours@uca.fr","Masquage des absences","$nb_transforme ont été masqués aujourd'hui");

$conn->close();
exit;

