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

if (!isRegistered()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "accueil", "accueil.html");


$req = "SELECT *,IFNULL(OBJ_STOCK-sum(EMPRUNT_NOMBRE),OBJ_STOCK) AS OBJ_RESTE FROM common_objet LEFT JOIN emprunt ON (OBJ_ID=EMPRUNT_OBJ_ID) GROUP BY OBJ_ID HAVING OBJ_RESTE > 0 ORDER BY OBJ_NOM";
$res = $conn->query($req);
while ($objet = $res->fetch_assoc()) {
    affectToBloc($template, "un_objet", $objet);
}

$req = "SELECT * FROM common_enseignant ORDER BY ENS_NOM";
$res = $conn->query($req);
while ($ens = $res->fetch_assoc()) {
    if ($ens["ENS_ID"] == CURRENT_ID) {
        $ens["SELECTED"] = 'selected="selected"';
    } else {
        $ens["SELECTED"] = '';
    }
    
    affectToBloc($template, "un_enseignant", $ens);
}


generateCompleteXHTML($template, "accueil");
