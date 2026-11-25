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

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');
$conn->query("START TRANSACTION");

$ds = ldap_connect(LDAP_URI);

if ($ds) {

    $r=ldap_bind($ds, LDAP_LOGIN, LDAP_PWD);

    $req = "SELECT ENS_ID,ENS_NOM,ENS_LOGIN FROM common_enseignant WHERE ENS_LOGIN IS NOT NULL AND ENS_CODE_EMPLOYE IS NULL FOR UPDATE ";
    $res = $conn->query($req);
    while ($un_enseignant = $res->fetch_assoc()) {
        $sr = ldap_search($ds, "ou=utilisateurs,dc=uca,dc=local", "cn=" . $un_enseignant['ENS_LOGIN'], array("employeeid"));

        $info = ldap_get_entries($ds, $sr);

        for ($i = 0; $i < $info["count"]; $i++) {
            if (!isset($info[$i]['employeeid'])) {
                continue;
            }
            $req = "UPDATE common_enseignant SET ENS_CODE_EMPLOYE='".$info[$i]['employeeid'][0]."' WHERE ENS_ID=". $un_enseignant['ENS_ID'];
            $conn->query($req);
            echo $un_enseignant['ENS_NOM']."=>".$info[$i]['employeeid'][0]."<br/>";
        }
    }

    ldap_close($ds);

} else {

    echo '<h4>Impossible de se connecter au serveur LDAP.</h4>';

}

$req = "SELECT ENS_CODE_EMPLOYE,ENS_NOM, ENS_ID FROM common_enseignant WHERE (ENS_ADE IS NULL OR ENS_ADE = '') AND ENS_CODE_EMPLOYE IS NOT NULL FOR UPDATE ";
$res = $conn->query($req);

while ($un_enseignant = $res->fetch_assoc()) {
    $req = "SELECT * FROM extraction_res_ade WHERE EXTRACT_CODE='".$un_enseignant['ENS_CODE_EMPLOYE']."'";
    $resEXTRACT = $conn->query($req);
    if ($resEXTRACT->num_rows != 1) {
        echo $un_enseignant['ENS_NOM']." = ".$resEXTRACT->num_rows."<br/>";
    } else {
        echo $un_enseignant['ENS_NOM']." = ".$resEXTRACT->num_rows."<br/>";
        $req = "UPDATE common_enseignant SET ENS_ADE='".$resEXTRACT->fetch_assoc()['EXTRACT_NUMERO']."' WHERE ENS_ID=".$un_enseignant['ENS_ID'];
        $conn->query($req);
    }
}

$conn->query("COMMIT");

$conn->close();

exit;


