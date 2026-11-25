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

setAttachment($template, "accueil", "accueil.html");

if (isset($_GET['bfmw_num_d']) && !ETU) {
    $req = "UPDATE common_enseignants_departement SET ENS_DEPT_CURRENT=0 WHERE DEPT_ENS_ID=".CURRENT_ID;
    $conn->query($req);
    $req = "UPDATE common_enseignants_departement SET ENS_DEPT_CURRENT=1 WHERE DEPT_ENS_ID=".CURRENT_ID." AND ENS_DEPT_ID=".$_GET['bfmw_num_d'];
    $conn->query($req);
}

if (ETU) {
    $req = "SELECT * FROM portail_access_etudiants WHERE et_login = '" . CURRENT_USE . "'";
    $res = $conn->query($req);
    while ($access = $res->fetch_assoc()) {
        $etu = true;
        affectToBloc($template, "appli", $access);
    }

    if ($etu) {
        generateCompleteXHTML($template, "accueil");
        exit;
    }
}


$req = "SELECT * FROM common_enseignants_departement,common_departement WHERE DEPT_ID=ENS_DEPT_ID AND common_enseignants_departement.DEPT_ENS_ID=" . CURRENT_ID . " ORDER BY DEPT_NOM";
$res = $conn->query($req);
$nb_rows = $res->num_rows;
$id_dept = -1;
if ($nb_rows > 1) {
    openBloc($template, "plusieurs_departement");
    while ($un_dept = $res->fetch_assoc()) {
        if ($un_dept["ENS_DEPT_CURRENT"] == 1) {
            $un_dept['SELECTED'] = "selected";
            $id_dept =  $un_dept['DEPT_ID'];
        } else {
            $un_dept['SELECTED'] = "";
            if ($id_dept === -1) {
                $id_dept =  $un_dept['DEPT_ID'];
            }
        }
        affectToBloc($template, "plusieurs_departement.un_departement", $un_dept);
    }
} else if ($nb_rows == 1) {
    $id_dept = $res->fetch_assoc()['DEPT_ID'];
}

//Oui, je fais la requête 2 fois, mais c'est pour éviter un piratage
$req = "UPDATE common_enseignants_departement SET ENS_DEPT_CURRENT=1 WHERE DEPT_ENS_ID=".CURRENT_ID." AND ENS_DEPT_ID=$id_dept";
$conn->query($req);


$req = "SELECT * FROM portail_access_enseignants WHERE ACCESS_DEPT_ID=$id_dept AND ens_login = '" . CURRENT_USE . "' ORDER BY ACCESS_NOM";
$res = $conn->query($req);
while ($access = $res->fetch_assoc()) {
    affectToBloc($template, "appli", $access);
}

generateCompleteXHTML($template, "accueil");
