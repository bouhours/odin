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

/**
 * Inscription des étudiants par leur numéro
 * @param string $numero
 * @return array
 */
function ldap_numeros_etudiant(string $numero) : array
{
    $ds = ldap_connect(LDAP_URI);
    if ($ds) {
        $retour = array();
        try {
            ldap_bind($ds, LDAP_LOGIN, LDAP_PWD);
            $sr = ldap_search($ds, "ou=utilisateurs,dc=uca,dc=local", "postalcode=$numero", array("cn", "sn", "givenname", "mail", "postalcode", "postofficebox"));
            $info = ldap_get_entries($ds, $sr);
            for ($i = 0; $i < $info["count"]; $i++) {
                if ($info[$i]["postalcode"][0] == $numero) {
                    $retour["*ET_LOGIN"] = $info[$i]["cn"][0];
                    $retour["*ET_NOM"] = addslashes(utf8_encode($info[$i]["sn"][0] . " " . $info[$i]["givenname"][0]));
                    $retour["*ET_MAIL"] = $info[$i]["mail"][0];
                    $retour["*ET_NUMERO"] = $numero;
                    $retour["*ET_NAISSANCE"] = $info[$i]["postofficebox"][0][0] . $info[$i]["postofficebox"][0][1] . "/" . $info[$i]["postofficebox"][0][2] . $info[$i]["postofficebox"][0][3] . "/" . $info[$i]["postofficebox"][0][4] . $info[$i]["postofficebox"][0][5] . $info[$i]["postofficebox"][0][6] . $info[$i]["postofficebox"][0][7];
                }
            }

            ldap_close($ds);
        } catch (Exception $e) {
        }

        return $retour;
    } else {
        return array();
    }
}


function ldap_login(string $mail) : string
{

    $ds = ldap_connect(LDAP_URI);
    if ($ds) {
        $retour = "";
        try {
            ldap_bind($ds, LDAP_LOGIN, LDAP_PWD);
            $sr = ldap_search($ds, "ou=utilisateurs,dc=uca,dc=local", "mail=$mail*", array("cn", "sn", "givenname", "mail", "postalcode"));
            $info = ldap_get_entries($ds, $sr);

            for ($i = 0; $i < $info["count"]; $i++) {
                if ($info[$i]["mail"][0] == $mail) {
                    $retour = $info[$i]["cn"][0];
                }
                if ($retour != "") {
                    break;
                }
            }

            ldap_close($ds);
        } catch (Exception $e) {
        }

        return $retour;
    } else {
        return "";
    }
}

/**
 * Récupération des informations sur le ldap
 * @param string $filtre
 * @return array
 */
function ldap_infos(string $filtre) : array
{
    $ds = ldap_connect(LDAP_URI);
    if ($ds) {
        ldap_bind($ds, LDAP_LOGIN, LDAP_PWD);
        $retour = array();
        try {
            $sr = ldap_search($ds, "ou=utilisateurs,dc=uca,dc=local", $filtre);
            $info = ldap_get_entries($ds, $sr);

            for ($i = 0; $i < $info["count"]; $i++) {
                try {
                    $une_val = array();
                    $une_val["login"] = $info[$i]["cn"][0];
                    $une_val["nom"] = utf8_encode($info[$i]["sn"][0]);
                    $une_val["prenom"] = utf8_encode($info[$i]["givenname"][0]);
                    $une_val["mail"] = $info[$i]["mail"][0];
                    if (isset($info[$i]["employeeid"])) {
                        $une_val["employeeid"] = $info[$i]["employeeid"][0];
                    } else {
                        $une_val["employeeid"] = "";
                    }
                    if (isset($info[$i]["postalcode"])) {
                        $une_val["numero"] = $info[$i]["postalcode"][0];
                    } else {
                        $une_val["numero"] = "";
                    }
                    if (isset($info[$i]["postofficebox"])) {
                        $une_val["naissance"] = $info[$i]["postofficebox"][0][0].$info[$i]["postofficebox"][0][1]."/".$info[$i]["postofficebox"][0][2].$info[$i]["postofficebox"][0][3]."/".$info[$i]["postofficebox"][0][4].$info[$i]["postofficebox"][0][5].$info[$i]["postofficebox"][0][6].$info[$i]["postofficebox"][0][7];
                    } else {
                        $une_val["naissance"] = "";
                    }
                    array_push($retour, $une_val);
                } catch (exception $e) {

                }
            }

            ldap_close($ds);
        } catch (Exception $e) {
        }

        return $retour;
    } else {
        return array();
    }
}