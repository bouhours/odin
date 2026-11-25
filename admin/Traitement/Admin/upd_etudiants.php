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

if (!isAdmin()) {
    echo "Non autorisé";
    exit;
}

$req = "SELECT ET_LOGIN FROM common_etudiant FOR UPDATE ";
$res = $conn->query($req);
$update = "";
while ($un_etudiant = $res->fetch_assoc()) {
    if ($un_etudiant['ET_LOGIN'] == "") {
        continue;
    }
    echo $un_etudiant['ET_LOGIN']."<br>";
    $les_infos = Ldap::ldap_infos("cn=".$un_etudiant['ET_LOGIN']);

    foreach ($les_infos as $une_info) {
         $update .= "UPDATE common_etudiant SET ET_NOM_DE_FAMILLE='".addslashes($une_info['nom'])."', ET_PRENOM='".addslashes($une_info['prenom'])."', ET_NOM='".addslashes($une_info['nom']." ".$une_info['prenom'])."',  ET_NAISSANCE='".$une_info['naissance']."', ET_MAIL='".$une_info['mail']."' WHERE ET_LOGIN='".$un_etudiant['ET_LOGIN']."';";
        break;
    }
}

if (!empty($update)) {
    mysql_start_transaction();
    echo $update;
    echo ">".$conn->multi_query($update)."<";

    mysql_commit();
}

