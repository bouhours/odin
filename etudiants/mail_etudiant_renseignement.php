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

require_once __DIR__.'/../common/Model/Fiches_Renseignements.php';
Fiches_Renseignements::static_init($conn);

$req = "SELECT * FROM common_annee WHERE ANNEE_COURANTE = 1";
$res = $conn->query($req);
$annee_courante = $res->fetch_assoc()['ANNEE_ID'];

$les_etudiants = Fiches_Renseignements::getEtudiantsAyantDesFichesNonRemplies($annee_courante);

$destinataires = array();
foreach ($les_etudiants as $un_etudiant) {
    $destinataires[] = $un_etudiant['ET_MAIL'];
}

if (count($destinataires) > 0) {
    sendMail("Plateforme ODIN <noreply+odin@uca.fr>", "Fiche de renseignements incomplète",
        "Bonjour,\n\nVotre fiche de renseignements est incomplète.\n\nMerci de vous rendre sur la plateforme Odin (https://odin.iut.uca.fr) dans l'application \"Etudiants\" pour compléter les champs obligatoires manquants.\n\nMerci d'avance.\n\nCordialement",
        implode(",",$destinataires));
}

$conn->close();
exit;

