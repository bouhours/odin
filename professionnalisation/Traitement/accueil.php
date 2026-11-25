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

$send="p=etudiants";
require 'refresh.php';
exit;

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

affectToXHTML($template, array(
    "IS_ETUDIANT" => IS_ETUDIANT,
    "IS_ENSEIGNANT" => IS_ENSEIGNANT
));

setAttachment($template, "accueil", "accueil.html");
if (IS_ETUDIANT) {
    $req = "SELECT * FROM common_etudiant left join enseignants_formations on ENS_ID=ET_TUTEUR_ENS_ID WHERE ET_ID=" . CURRENT_ID;
    $res = $conn->query($req);
    if ($infos = $res->fetch_assoc()) {
        affectToXHTML($template, $infos);
    }
} else if (IS_ENSEIGNANT) {
    $req = "SELECT * FROM etudiants_groupes, common_formation WHERE ET_GROUPE_ANNEE_ID=".Annees::getIdAnneeCourante()." AND FORM_ID=GROUPE_FORM_ID AND ET_TUTEUR_ENS_ID=".CURRENT_ID." GROUP BY ET_ID ORDER BY GROUPE_FORM_ID,ET_NOM";
    $res = $conn->query($req);
    $formation_en_cours = -1;
    while ($infos = $res->fetch_assoc()) {
        if ($formation_en_cours != $infos['GROUPE_FORM_ID']) {
            $formation_en_cours = $infos['GROUPE_FORM_ID'];
            affectToBloc($template,"une_formation", $infos);

        }
        affectToBloc($template,"une_formation.un_etudiant", $infos);
    }
}

generateCompleteXHTML($template, "accueil");
