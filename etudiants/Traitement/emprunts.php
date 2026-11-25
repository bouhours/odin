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

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,Annees::getIdAnneeCourante())) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

setAttachment($template, "emprunts", "emprunts.html");


$req = "SELECT *,IFNULL(OBJ_STOCK-sum(EMPRUNT_NOMBRE),OBJ_STOCK) AS OBJ_RESTE FROM etudiants_emprunts_objets GROUP BY OBJ_ID HAVING OBJ_RESTE > 0 ORDER BY OBJ_NOM";
$res = $conn->query($req);
while ($objet = $res->fetch_assoc()) {
    affectToBloc($template, "un_objet", $objet);
}

$req = "SELECT * FROM common_enseignant,common_enseignants_departement WHERE ENS_ID=DEPT_ENS_ID AND ENS_DEPT_ID=".CURRENT_DEPT_ID." AND ENS_PRETEUR=1 ORDER BY ENS_NOM";
$res = $conn->query($req);
while ($ens = $res->fetch_assoc()) {   
    affectToBloc($template, "un_enseignant", $ens);
}

$req = "SELECT * FROM etudiants_emprunts_objets,common_enseignant WHERE ENS_ID=EMPRUNT_ENS_ID AND EMPRUNT_ET_ID=".CURRENT_ID." ORDER BY OBJ_NOM ";
$res = $conn->query($req);
if ($res->num_rows > 0) {
    openBloc($template, "show");
}
while ($objet = $res->fetch_assoc()) {  
    affectToBloc($template, "show.un_objet_emprunte", $objet);
}

affectToXHTML($template,array(
    "ANNEE_COURANTE" => Annees::getIdAnneeCourante()
));

generateCompleteXHTML($template, "emprunts");
