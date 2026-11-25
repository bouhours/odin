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

    $r=ldap_bind($ds,LDAP_LOGIN, LDAP_PWD);


    //$sr=ldap_search($ds,"ou=utilisateurs,dc=iut,dc=local", "sn=".$_GET['nom']."*",array("name", "sn", "givenname", "mail", "postalcode"));
    $sr=ldap_search($ds,"ou=utilisateurs,dc=uca,dc=local", "sn=".$_POST['bfmw_orig_nom']."*");

    $info = ldap_get_entries($ds, $sr);

    echo "<pre>";
    for ($i=0; $i<$info["count"]; $i++) {

        echo '----------' . '<br />';

        print_r($info[$i]);
    }
    echo "</pre>";
    ldap_close($ds);

} else {

    echo '<h4>Impossible de se connecter au serveur LDAP.</h4>';

}
