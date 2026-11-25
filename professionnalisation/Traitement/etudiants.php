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

if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$formation_courante = $_GET["bfmw_num_f"]??-1;
setAttachment($template, "etudiants", "etudiants.html");
$les_enseignants = Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID);
$annee_courante = Annees::getIdAnneeCourante();
$les_formations_autorisees = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante, "AND FORM_PRO=1 ");
$formation_courante = affectToBlocAndRepeat($template,"une_formation_filtre",$les_formations_autorisees,new Comparateur("FORM_ID",$formation_courante));
affectToXHTML($template,array(
    "ID_FORM" => $formation_courante
));
$les_etudiants = Etudiants::getEtudiantsInscrits($formation_courante,$annee_courante);
affectToBlocAndRepeat($template,"un_etudiant",$les_etudiants,null,null,
    function($une_ligne){
        global $template;
        global $les_enseignants;

        affectToBloc($template,"un_etudiant",$une_ligne);
        affectToBlocAndRepeat($template,"un_etudiant.un_enseignant",$les_enseignants);

});
/*


$req = "SELECT *,common_formation.FORM_ID AS ID_FORM,common_formation.FORM_NOM AS NOM_FORM FROM (etudiants_groupes,common_formation) left join enseignants_formations on (ENS_ID=ET_TUTEUR_ENS_ID) WHERE common_formation.FORM_ID=GROUPE_FORM_ID AND common_formation.FORM_PRO=1 AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FORM_ID IN (".Formations::getFormationsDuConnecteString().") GROUP BY ET_ID ORDER BY common_formation.FORM_NOM,ET_NOM";
$res = $conn->query($req);
$formation_en_cours = -1;
while ($infos = $res->fetch_assoc()) {
    if ($formation_en_cours != $infos['ID_FORM']) {
        $formation_en_cours = $infos['ID_FORM'];
        affectToBloc($template,"une_formation",$infos);
    }

    if ($infos['ET_PROFESSIONNALISATION'] == 1) {
        $infos['ET_PRO'] = "checked";
    } else {
        $infos['ET_PRO'] = "";
    }
    affectToBloc($template, "une_formation.un_etudiant", $infos);
    foreach ($les_enseignants as $un_enseignant) {
        if ($un_enseignant['ENS_ID'] == $infos['ET_TUTEUR_ENS_ID']) {
            $un_enseignant['SELECTED'] = "selected";
        } else {
            $un_enseignant['SELECTED'] = "";
        }
        affectToBloc($template, "une_formation.un_etudiant.un_enseignant", $un_enseignant);
    }
}
*/
generateCompleteXHTML($template, "etudiants");
