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

define('CURRENT_VERSION', "0.0");

if (CURRENT_USE != '') {
    $req = "SELECT * FROM etudiants_access_etudiants WHERE ET_LOGIN='" . CURRENT_USE . "'";
    $res = $conn->query($req);
    $les_connexions = $res->fetch_all(MYSQLI_ASSOC);

    if (count($les_connexions) == 0) {
        unset($_SESSION['etudiants_nom']);
        define('CURRENT_ID', 0);
        define('CURRENT_DEPT_ID', 0);
        define('CURRENT_DEPT', 0);
    } else {
        $connecteur = $les_connexions[0];

        if (count($les_connexions) > 1) {
            foreach ($les_connexions as $une_connexion) {
                $req = "SELECT * FROM common_inscription,common_formation,common_semestre,common_annee WHERE FORM_ID=SEM_FORM_ID AND INSCRIPT_SEM_ID=SEM_ID AND FORM_DEPT_ID=".$une_connexion['ACCESS_DEPT_ID']." AND INSCRIPT_ET_ID=".$une_connexion['ET_ID']." AND ANNEE_ID=INSCRIPT_ANNEE_ID AND ANNEE_COURANTE=1";
                $res = $conn->query($req);
                if ($res->num_rows > 0) {
                    $connecteur = $une_connexion;
                    break;
                }
            }
        }

        $_SESSION['etudiants_nom'] = $connecteur["ET_NOM"];
        define('CURRENT_ID', $connecteur["ET_ID"]);
        define('CURRENT_DEPT_ID', $connecteur["ACCESS_DEPT_ID"]);
        define('CURRENT_DEPT', $connecteur['DEPT_CODE']);
    }
}