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
 * Libération de la saisir en cours
 */
if (CURRENT_USE != '') {
    $req = "SELECT * FROM poursuites_access_enseignants WHERE ENS_LOGIN='" . CURRENT_USE . "'";
    $res = $conn->query($req);

    if ($tab = $res->fetch_assoc()) {
        define('CURRENT_ID', $tab["ENS_ID"]);
        $req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=NULL WHERE PMAT_ENS_ID=".CURRENT_ID;
        $conn->query($req);
    }
}


phpCAS::logout();