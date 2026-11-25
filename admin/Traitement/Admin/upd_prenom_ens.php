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

$ds = ldap_connect(LDAP_URI);

if ($ds) {

    mysql_start_transaction();
    $r=ldap_bind($ds, LDAP_LOGIN, LDAP_PWD);

    $req = "SELECT ENS_LOGIN FROM common_enseignant FOR UPDATE";
    $res = $conn->query($req);
    while ($un_enseignant = $res->fetch_assoc()) {
        if ($un_enseignant['ENS_LOGIN'] == "") {
            continue;
        }
        $sr=ldap_search($ds,"ou=utilisateurs,dc=uca,dc=local", "cn=".$un_enseignant['ENS_LOGIN']);
        $info = ldap_get_entries($ds, $sr);
        for ($i=0; $i<$info["count"]; $i++) {

            $req = "UPDATE common_enseignant SET ENS_NOM_DE_FAMILLE='".addslashes(utf8_encode($info[$i]["sn"][0]))."', ENS_PRENOM='".addslashes(utf8_encode($info[$i]["givenname"][0]))."' WHERE ENS_LOGIN='".$un_enseignant['ENS_LOGIN']."'";
            $conn->query($req);
        }
    }
    mysql_commit();
    ldap_close($ds);

} else {

    echo '<h4>Impossible de se connecter au serveur LDAP.</h4>';

}
