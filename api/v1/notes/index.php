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

if (isset($_POST['bfmw_orig_etudiant']) && isset($_GET['bfmw_num_annee']) && isset($_GET['bfmw_orig_projet']) && $_GET['bfmw_orig_projet'] == "OdinPlus") {
    $les_etudiants = API::getEtudiantFromUniqID($_POST['bfmw_orig_etudiant'], $_GET['bfmw_num_annee']);
    foreach ($les_etudiants as $un_etudiant) {
        define("CURRENT_DEPT",$un_etudiant["DEPT_CODE"]);
        require_once __DIR__ . "/../../../common/View/ReleveNotes.php";
        ReleveNotes::static_init($conn);
        require_once __DIR__ . "/../../../common/Model/Etudiants.php";
        Etudiants::static_init($conn);
        require_once __DIR__ . "/../../../common/Model/Formations.php";
        Etudiants::static_init($conn);
        $resSEMESTRE = Etudiants::getSemestresInscritsPourUneAnnee($un_etudiant['ET_ID'], $_GET['bfmw_num_annee']);
        require_once __DIR__ . "/../../../bfmw/includes/tpl_functions.php";
        $template = attachXHTML();
        setAttachment($template, "notes", "retour.json");
        openBloc($template, "show");
        ReleveNotes::genererMoyennesSemestre($resSEMESTRE, $template, $un_etudiant['ET_ID'], "show");
        $retour = generateCompleteXHTML($template, "notes", true);
        API::response(200, "", $retour);
        exit;
    }
    API::response(400, "Invalid Request", "");
}
API::response(400, "Invalid Request", "");

