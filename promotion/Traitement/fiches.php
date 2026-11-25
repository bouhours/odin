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

if (!Formations::isSecretaire() && !Formations::isChef() && !Formations::isResponsable() && !isAdmin()) {
    echo "Accès interdit";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = Annees::getIdAnneeCourante();

setAttachment($template, "fiches", "fiches.html");

$semestre_en_cours = -1;
if (isset($_GET['bfmw_num_s'])) {
    $semestre_en_cours = $_GET['bfmw_num_s'];
}
$groupe_en_cours = -1;
if (isset($_GET['bfmw_num_g'])) {
    $groupe_en_cours = $_GET['bfmw_num_g'];
}
$formation_autorisees = Formations::getFormationsDuConnecteString();

/**
 * Groupes d'étudiants
 */
$semestre_en_cours = affectToBlocAndRepeat($template,"une_formation.un_semestre",Formations::getSemestres($formation_autorisees,$annee_courante),new Comparateur("SEM_ID",$semestre_en_cours),array("une_formation" => array(-1,"FORM_ID")));
$groupe_en_cours = affectToBlocAndRepeat($template,"un_groupe",Groupes::getGroupesPourUnSemestre($semestre_en_cours,$annee_courante),new Comparateur("GROUPE_ID",$groupe_en_cours));


affectToXHTML($template,array(
    "GROUPE_ID" => $groupe_en_cours,
    "SEM_ID" => $semestre_en_cours
));

/*$req = "SELECT * FROM common_groupes,common_formation, common_etudiant_groupes WHERE ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE,'%') AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
$res = $conn->query($req);
$formation_courante = -1;
while ($groupe = $res->fetch_assoc()) {
    if ($formation_courante != $groupe['FORM_ID']) {
        $formation_courante = $groupe['FORM_ID'];
        affectToBloc($template,"une_formation_groupe", $groupe);
    }
    affectToBloc($template, "une_formation_groupe.un_groupe", $groupe);
}

$req = "SELECT * FROM common_groupes,common_formation, common_etudiant_groupes WHERE ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE,'%') AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND GROUPE_FEUILLE = 1 GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
$res = $conn->query($req);
$formation_courante = -1;
while ($groupe = $res->fetch_assoc()) {
    if ($formation_courante != $groupe['FORM_ID']) {
        $formation_courante = $groupe['FORM_ID'];
        affectToBloc($template,"une_formation_groupe_tp", $groupe);
    }
    affectToBloc($template, "une_formation_groupe_tp.un_groupe_tp", $groupe);
}
*/
/**
 * Formations
 */
/*$req = "SELECT * from common_formation,common_semestre, common_inscription WHERE SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=SEM_FORM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND INSCRIPT_ANNEE_ID=$annee_courante AND FORM_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY SEM_ID ORDER BY FORM_NOM, SEM_NOM";
$res = $conn->query($req);
$formation_courante = -1;
while ($une_formation = $res->fetch_assoc()) {
    if ($formation_courante != $une_formation['FORM_ID']) {
        $formation_courante = $une_formation['FORM_ID'];
        affectToBloc($template,"une_formation", $une_formation);
    }
    affectToBloc($template,"une_formation.un_semestre", $une_formation);
}*/

/**
 * Relevés de notes
 */
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
affectToBlocAndRepeat($template,"une_formation_releve.un_etudiant",Etudiants::getEtudiantsDuDepartement(CURRENT_DEPT_ID,$annee_courante,"FORM_NOM,FORM_ID,ET_NOM",$formation_autorisees),null,
    array(
        "une_formation_releve" => array(-1,"FORM_ID")
    )
);


generateCompleteXHTML($template, "fiches");
