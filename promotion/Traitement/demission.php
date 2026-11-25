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

setAttachment($template, "demission", "demission.html");

/**
 * Etudiants
 */
$annee_courante = Annees::getIdAnneeCourante();

$les_etudiants = Etudiants::getEtudiantsDemissionnaires($annee_courante,CURRENT_DEPT_ID);
$nb_alternants = 0;
foreach ($les_etudiants as $un_etudiant) {
    $un_etudiant['ET_AGE'] = getAge($un_etudiant['ET_NAISSANCE']);
    if ($un_etudiant['ET_PROFESSIONNALISATION'] == "1") {
        $nb_alternants++;
    }
    affectToBloc($template, "un_etudiant", $un_etudiant);
}

affectToXHTML($template,array(
    "EFFECTIF" => count($les_etudiants),
    "ALTERNANTS" => $nb_alternants
));

generateCompleteXHTML($template, "demission");