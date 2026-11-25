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

setAttachment($template, "accueil", "admin/accueil.html");

$req = "SELECT * FROM common_enseignant WHERE ENS_ADE IS NOT NULL ORDER BY ENS_NOM";
$les_enseignants = $conn->query($req)->fetch_all(MYSQLI_ASSOC);
affectToBlocAndRepeat($template,"un_enseignant",$les_enseignants);

$req = "SELECT * FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_FEUILLE=1 ORDER BY GROUPE_ID";
$les_groupes = $conn->query($req)->fetch_all(MYSQLI_ASSOC);
affectToBlocAndRepeat($template,"un_groupe",$les_groupes);

generateCompleteXHTML($template, "accueil");
