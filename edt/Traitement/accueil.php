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

verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "accueil", "accueil.html");

$req = "SELECT * FROM edt_access_enseignants WHERE ENS_ID =" . CURRENT_ID;
$res = $conn->query($req);
$enseignant = $res->fetch_assoc();
$mailing = $enseignant['ENS_EDT'] === "1";
$mailing_hebdo = $enseignant['ENS_EDT_HEBDO'] === "1";

affectToXHTML($template, array(
    "MAILING" => $mailing == 0 ? "" : "checked",
    "MAILING_HEBDO" => $mailing_hebdo == 0 ? "" : "checked"
));


generateCompleteXHTML($template, "accueil");
