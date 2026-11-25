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

function construireGroupes(array $les_groupes, bool $inclure_formation = false): array
{
    $retour = array();
    $groupe_id = null;
    $groupe_nom = "";
    $formation = "";
    $membres = array();

    foreach ($les_groupes as $un_groupe) {
        if ($groupe_id !== $un_groupe['GROUPE_ID']) {
            if (!is_null($groupe_id)) {
                $groupe = array("groupe" => $groupe_nom, "membres" => $membres);
                if ($inclure_formation) {
                    $groupe["formation"] = $formation;
                }
                $retour[] = $groupe;
            }

            $groupe_id = $un_groupe['GROUPE_ID'];
            $groupe_nom = $un_groupe['GROUPE_NOM'];
            $formation = $un_groupe['FORM_NOM'] ?? "";
            $membres = array();
        }
        $membres[] = array("login" => $un_groupe['ET_LOGIN']);
    }

    if (!is_null($groupe_id)) {
        $groupe = array("groupe" => $groupe_nom, "membres" => $membres);
        if ($inclure_formation) {
            $groupe["formation"] = $formation;
        }
        $retour[] = $groupe;
    }

    return $retour;
}

if (!API::verifierToken(getallheaders())) {
    API::response(401, "Unauthorized", "");
    exit;
}
if (isset($_GET['bfmw_orig_departement']) && isset($_GET['bfmw_orig_annee'])) {
    require_once __DIR__ . "/../../../common/Model/Annees.php";
    Annees::static_init($conn);

    $les_groupes = API::getGroupesAvecEtudiants($_GET['bfmw_orig_departement'], $_GET['bfmw_num_annee']);
    $retour = construireGroupes($les_groupes);
    API::response(200, "", json_encode($retour));
    exit;
}

if (isset($_GET['bfmw_orig_projet']) && isset($_GET['bfmw_orig_annee']) && $_GET['bfmw_orig_projet'] == "SQLCheck") {
    require_once __DIR__ . "/../../../common/Model/Annees.php";
    Annees::static_init($conn);
    $les_groupes = API::getGroupesAvecEtudiants("inf63", $_GET['bfmw_num_annee']);
    $retour = construireGroupes($les_groupes, true);
    API::response(200, "", json_encode($retour));
    exit;
}

API::response(400, "Invalid Request", "");

