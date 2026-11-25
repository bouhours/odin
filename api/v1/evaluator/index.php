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
require_once __DIR__ . "/../../self_server_concrete.php";
require_once __DIR__ . "/../../../bfmw/includes/secure.php";
require_once __DIR__ . "/../../../bfmw/includes/header.php";
require_once __DIR__ . "/../../../bfmw/includes/init_query_string.php";
require_once __DIR__ . "/../../../bfmw/includes/Connectable.php";
require_once __DIR__ . "/../../../bfmw/includes/functions.php";
$conn = openConnexion($db_server, $db_user, $db_pwd, $db_database);
require_once __DIR__ . "/../../../common/Model/API.php";
API::static_init($conn);
header("Content-Type:text/plain; charset=utf-8");

if (!API::verifierToken(getallheaders())) {
    API::response(401, "Unauthorized", "");
    exit;
}
if (isset($_GET['bfmw_orig_getAnnee']) && isset($_GET['bfmw_orig_login'])) {
    require_once __DIR__ . "/../../../common/Model/Annees.php";
    Annees::static_init($conn);
    API::response(200, "", json_encode(API::getFormations(Annees::getIdAnneeCourante(),$_GET['bfmw_orig_login'])));
    exit;
}
if (isset($_GET['bfmw_orig_getGroupe']) && isset($_GET['bfmw_orig_formation'])) {
    require_once __DIR__ . "/../../../common/Model/Annees.php";
    Annees::static_init($conn);
    API::response(200, "", json_encode(API::getGroupes(Annees::getIdAnneeCourante(),$_GET['bfmw_num_formation'])));
    exit;
}
if (isset($_GET['bfmw_orig_getEtudiants']) && isset($_GET['bfmw_orig_groupe'])) {
    require_once __DIR__ . "/../../../common/Model/Annees.php";
    Annees::static_init($conn);
    API::response(200, "", json_encode(API::getEtudiants(Annees::getIdAnneeCourante(),$_GET['bfmw_num_groupe'])));
    exit;
}

if (isset($_GET['bfmw_orig_getEvaluations']) && isset($_GET['bfmw_orig_etudiant']) && isset($_GET['bfmw_orig_login']) && isset($_GET['bfmw_orig_date'])) {
    API::response(200, "", json_encode(API::getEvaluations($_GET['bfmw_num_etudiant'],$_GET['bfmw_orig_login'], $_GET['bfmw_num_date'])));
    exit;
}

if (isset($_GET['bfmw_orig_putEvaluations']) && isset($_POST['bfmw_orig_etudiant']) && isset($_POST['bfmw_orig_login']) && isset($_POST['bfmw_orig_date']) && isset($_POST['bfmw_orig_evaluation'])) {
    API::response(200, "", json_encode(API::putEvaluations($_POST['bfmw_num_etudiant'],$_POST['bfmw_orig_login'], $_POST['bfmw_num_date'], $_POST['bfmw_orig_evaluation'])));
    exit;
}

API::response(400, "Invalid Request", "");