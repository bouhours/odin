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

class Ldap extends Connectable
{
    /**
     * Recherche des étudiants par leur numéro
     * @param string $numero
     * @return array
     */
    public static function ldap_rechercher_etudiant_avec_numeros(string $numero) : array
    {
        $donnees = self::ldap_infos("postalcode=$numero");
        $retour = array();
        foreach ($donnees as $une_donnee) {
            if ($une_donnee["numero"] == $numero) {
                $retour["*ET_LOGIN"] = $une_donnee["login"];
                $retour["*ET_NOM"] = addslashes($une_donnee["nom"] . " " . $une_donnee["prenom"]);
                $retour["*ET_NOM_DE_FAMILLE"] = addslashes($une_donnee["nom"]);
                $retour["*ET_PRENOM"] = addslashes($une_donnee["prenom"]);
                $retour["*ET_MAIL"] = $une_donnee["mail"];
                $retour["*ET_NUMERO"] = $numero;
                $retour["*ET_NAISSANCE"] = $une_donnee["naissance"];
            }
        }
        return $retour;
    }

    /**
     * Recherche des mails
     * @param string $start
     * @return array
     */
    public static function ldap_mail(string $start) : array
    {
        $retour = array();
        $donnees = self::ldap_infos("(|(mail=$start*)(sn=$start*))");
        foreach ($donnees as $une_donnee) {
            $retour[] = $une_donnee["mail"];
        }

       return $retour;
    }

    /**
     * Recherche du login d'un étudiant par son mail
     * @param string $mail
     * @return string
     */
    public static function ldap_recherche_login_etudiant(string $mail) : string
    {

        $donnees = self::ldap_infos("mail=$mail*");
        foreach ($donnees as $une_donnee) {
            return $une_donnee["login"];
        }

        return "";
    }

    /**
     * Récupération des informations sur le ldap
     * @param string $filtre
     * @return array
     */
    public static function ldap_infos(string $filtre) : array
    {
        $ds = ldap_connect(LDAP_URI);
        if ($ds) {
            ldap_bind($ds, LDAP_LOGIN, LDAP_PWD);
            $retour = array();
            try {
                $sr = ldap_search($ds, "ou=utilisateurs,dc=uca,dc=local", $filtre, array("cn", "sn", "givenname", "mail", "employeeid", "postalcode", "postofficebox"));
                $info = ldap_get_entries($ds, $sr);

                for ($i = 0; $i < $info["count"]; $i++) {
                    try {
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
                        $retour[] = $une_val;
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
}

