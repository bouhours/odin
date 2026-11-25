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

if (isset($_GET['bfmw_orig_etudiant']) && isset($_GET['bfmw_orig_annee']) && isset($_GET['bfmw_orig_date_debut']) && isset($_GET['bfmw_orig_date_fin'])  && $_GET['bfmw_orig_projet'] == "OdinPlus") {
    require_once __DIR__ . "/../../../common/Model/Edt.php";
    Edt::static_init($conn);
    require_once __DIR__ . "/../../../common/Model/WS_ADE.php";
    WS_ADE::static_init($conn);
    require_once __DIR__ . "/../../../common/Model/Groupes.php";
    Groupes::static_init($conn);
    require_once __DIR__ . "/../../../common/Model/Enseignants.php";
    Enseignants::static_init($conn);
    require_once __DIR__ . "/../../../common/Model/Departements.php";
    Departements::static_init($conn);
    require_once __DIR__ . "/../../../common/Model/WS_Event.php";
    $les_ressourcesADE = API::getADERessource($_GET['bfmw_orig_etudiant'], $_GET['bfmw_num_annee']);
    foreach ($les_ressourcesADE as $une_ressource) {
        $events_affiche = array();
        $date_debut = new DateTime();
        $date_debut->setTimestamp($_GET['bfmw_num_date_debut']);
        $date_fin = new DateTime();
        $date_fin->setTimestamp($_GET['bfmw_num_date_fin']);
        Edt::collectEDTv2(Edt::$current_project_id,[$une_ressource["GROUPE_ADE"]],$events_affiche,4,true,true,true,true,$date_debut,$date_fin);
        foreach ($events_affiche as &$un_event) {
            unset($un_event["ACTIVITE_ID"]);
            unset($un_event["DATE_DEBUT"]);
            unset($un_event["DATE_FIN"]);
            unset($un_event["HEURE_DEBUT"]);
            unset($un_event["HEURE_FIN"]);
            unset($un_event["JOUR_DATE_DEBUT"]);
            unset($un_event["NUMERO_DATE_DEBUT"]);
            unset($un_event["MOIS_DATE_DEBUT"]);
            unset($un_event["ANNEE_DATE_DEBUT"]);
            unset($un_event["SALLE_PROTECTED"]);
            unset($un_event["NOM_PROTECTED"]);
            unset($un_event["UID"]);
            unset($un_event["RID"]);
            unset($un_event["DEPARTEMENTS"]);
            unset($un_event["*EDT_DATE_DEBUT"]);
            unset($un_event["*EDT_DATE_FIN"]);
            unset($un_event["*EDT_HEURE_DEBUT"]);
            unset($un_event["*EDT_HEURE_FIN"]);
            unset($un_event["*EDT_SALLE"]);
            unset($un_event["*EDT_NOM"]);
            unset($un_event["*EDT_UID"]);
        }
        API::response(200, "", json_encode($events_affiche));
        exit;
    }
}


API::response(400, "Invalid Request", "");

