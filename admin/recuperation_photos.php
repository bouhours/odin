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

require_once __DIR__ . '/../bfmw/includes/secure.php';
require_once __DIR__ . '/../bfmw/includes/functions.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set("Europe/Paris");

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

require_once __DIR__ . '/../common/Model/Etudiants.php';
Etudiants::static_init($conn);

$les_etudiants = Etudiants::getTousLesEtudiants();

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-AUTH-TOKEN: " . PHOTO_TOKEN));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$fichier_fantome = realpath(__DIR__ . "/../trombi/fantome.jpg");
foreach ($les_etudiants as $un_etudiant) {
    $fichier_etudiant = __DIR__ . "/../trombi/" . $un_etudiant['ET_NUMERO'] . ".jpg";
    if (@unlink($fichier_etudiant) === false) {
        echo 'Impossible de supprimer la photo -' . $un_etudiant['ET_LOGIN'] . '\n';
    }
    curl_setopt($ch, CURLOPT_URL, PHOTO_URI . $un_etudiant['ET_LOGIN']);
    $data = curl_exec($ch);
    if (curl_getinfo($ch, CURLINFO_RESPONSE_CODE) != 200) {
        @symlink($fichier_fantome,$fichier_etudiant);
        echo 'Fantome -' . $un_etudiant['ET_LOGIN'] . '\n';
        continue;
    }
    if (file_put_contents($fichier_etudiant, $data, LOCK_EX) === false) {
        @symlink($fichier_fantome,$fichier_etudiant);
        echo 'Impossible de créer la photo -' . $un_etudiant['ET_LOGIN'] . '\n';
    }
}

curl_close($ch);

exit;