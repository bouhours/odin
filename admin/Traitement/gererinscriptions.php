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

setAttachment($template, "gererinscriptions", "gererinscriptions.html");

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

affectToXHTML($template,array(
   "ANNEE_ID" => $annee_courante,
    "IS_ADMIN" => isAdmin()
));

affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

/**
 * Affichage des formations
 */
$les_semestres = Formations::getSemestres(Formations::getFormationsDuConnecteString(),$annee_courante);
affectToBlocAndRepeat($template,"un_departement.une_formation.un_semestre",$les_semestres,null,
    array(
        "un_departement" => array(-1,"DEPT_ID"),
        "un_departement.une_formation" => array(-1,"FORM_ID")
    ),function($element){
            global $annee_courante;
            global $template;

            $inscrits = Etudiants::getEtudiantsInscritsAuSemestre($element['SEM_ID'],$annee_courante);
            $nb_inscrits = count($inscrits);
            $element['INSCRITS'] = $nb_inscrits."&nbsp;".($nb_inscrits>1?"inscrits":"inscrit");
            affectToBloc($template, "un_departement.une_formation.un_semestre", $element);

            foreach ($inscrits as $inscrit) {
                $inscrit['RETURN'] = "\n";
                affectToBloc($template, "un_departement.une_formation.un_semestre.un_etudiant", $inscrit);
            }
        }
);

generateCompleteXHTML($template, "gererinscriptions");
