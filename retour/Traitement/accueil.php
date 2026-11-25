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

$annee_courante = Annees::getIdAnneeCourante();

$la_maquette = Formations::getMaquettePourEnseignant(CURRENT_ID,CURRENT_DEPT_ID,$annee_courante,"FORM_EVALUABLE=1 AND ",null,"MAT_ID");
affectToBlocAndRepeat($template,"une_formation.une_mat",$la_maquette,null, array(
    "une_formation" => array(-1,"FORM_ID")
),function ($une_ligne_de_la_table) {
    global $template;
    global $annee_courante;

    affectToBloc($template, "une_formation.une_mat", $une_ligne_de_la_table);

    $les_groupes = Groupes::getGroupesEvaluablesPourEnseignant($une_ligne_de_la_table["ID"],$une_ligne_de_la_table["FORM_ID"],$annee_courante,"GROUPE_FEUILLE=1 AND ");
    affectToBlocAndRepeat($template,"une_formation.une_mat.un_groupe",$les_groupes);

});



/*$req = "SELECT * FROM affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND FORM_EVALUABLE=1 AND MAT_HAS_NOTE=1 AND ENS_MAT_ANNEE_ID=$annee_courante AND DEPT_ENS_ID=".CURRENT_ID." ORDER BY FORM_ID,MAT_NOM";
$res = $conn->query($req);
$formation_en_cours = -1;
$les_groupes = array();
while ($une_affectation = $res->fetch_assoc()) {
    if ($formation_en_cours != $une_affectation['FORM_ID']) {
        $formation_en_cours = $une_affectation['FORM_ID'];
        affectToBloc($template,"une_formation",$une_affectation);

        $req = "SELECT * FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_FEUILLE = 1 AND GROUPE_FORM_ID=".$une_affectation['FORM_ID']." ORDER BY GROUPE_CODE";
        $resGROUPE = $conn->query($req);
        while ($un_groupe = $resGROUPE->fetch_assoc()) {
            $les_groupes[] = $un_groupe;
        }

    }

    $une_affectation['CHECKED'] = ($une_affectation['ENS_MAT_EVALUABLE'] == 1?"checked":"");
    affectToBloc($template,"une_formation.un_cours",$une_affectation);

    foreach ($les_groupes as $groupe) {
        $req = "SELECT * FROM common_eval_groupe_enseignement WHERE GROUPE_ID_ID=".$une_affectation['ID']." AND ID_GROUPE_ID=".$groupe['GROUPE_ID'];
        if ($conn->query($req)->num_rows == 1) {
            $groupe['CHECKED'] = "checked";
        } else {
            $groupe['CHECKED'] = "";
        }
        affectToBloc($template,"une_formation.un_cours.un_groupe",$groupe);
    }
}


*/
generateCompleteXHTML($template, "accueil");
