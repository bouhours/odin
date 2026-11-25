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

if (isset($_POST['bfmw_orig_nom'])) {
    $les_logins = array();
    if (isset($_POST['bfmw_orig_ens'])) {
        $les_logins = Enseignants::getLoginEnseignant($_POST['bfmw_orig_nom']);
    }
    if (isset($_POST['bfmw_orig_et'])) {
        $les_logins = Etudiants::getLoginEtudiant($_POST['bfmw_orig_nom']);
    }
    foreach ($les_logins as $un_login) {
        echo $un_login["NOM"]. " => <a href=\"../portail?asUser=".$un_login["LOGIN"]."\" >" . $un_login["LOGIN"] ."</a><br/>";
    }
}