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

setAttachment($template, "update_enseignants", "admin/update_enseignants.html");

Enseignants::supprimerEnseignantsSansCodeEmploye();

$les_enseignants = Enseignants::getEnseignantsSansCodeEmploye();
$les_enseignants_a_afficher = array();

foreach ($les_enseignants as $un_enseignant) {
    $les_infos = Ldap::ldap_infos("(&(sn=*".preg_split('/[ _-]+/', trim($un_enseignant["ENS_NOM"]))[0]."*)(|(employeetype=9)(department=*:enseignants)(department=*:administratifs)(department=*:heberges)(department=*:vacataires)))");
    foreach ($les_infos as $une_info) {
        $les_enseignants_a_afficher[] = array(
            "ENS_ID" => $un_enseignant["ENS_ID"],
            "ENS_NOM" => $un_enseignant["ENS_NOM"],
            "ENS_ADE" => $un_enseignant["ENS_ADE"],
            "ENS_LOGIN" => $un_enseignant["ENS_LOGIN"],
            "LDAP_NOM" => $une_info['nom']." ".$une_info['prenom'],
            "LDAP_LOGIN" => $une_info['login'],
            "LDAP_CODE_EMPLOYE" => $une_info['employeeid']
        );
    }
}

affectToBlocAndRepeat($template,"un_enseignant.une_option", $les_enseignants_a_afficher,null,
    array("un_enseignant" => array("-1","ENS_ID"))
);

generateCompleteXHTML($template, "update_enseignants");