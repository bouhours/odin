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

if (!Formations::isResponsable() && !Formations::isSecretaire()) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

$les_formations_autorisees = Formations::getFormationsDuConnecteString();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "chef", "chef.html");

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Créneaux horaires
 */
$req = "SELECT * FROM common_absences_creneau WHERE CRENEAU_CLASSIQUE=1 AND CRENEAU_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY CRENEAU_REAL_START,CRENEAU_REAL_END";
$res = $conn->query($req);
while ($creneau = $res->fetch_assoc()) {
    affectToBloc($template, "un_creneau_frequent", $creneau);
}

$req = "SELECT * FROM common_absences_creneau WHERE CRENEAU_CLASSIQUE=0 AND CRENEAU_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY CRENEAU_REAL_START,CRENEAU_REAL_END";
$res = $conn->query($req);
while ($creneau = $res->fetch_assoc()) {
    affectToBloc($template, "un_creneau", $creneau);
}

/**
 * Types d'absences
 */
$req = "SELECT * FROM common_absences_type";
$res = $conn->query($req);
while ($type = $res->fetch_assoc()) {
    affectToBloc($template, "un_type", $type);
}

/**
 * Cours
 */
$req = "SELECT * FROM affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND  FORM_ID IN (".$les_formations_autorisees.") AND ENS_DEPT_ID=".CURRENT_DEPT_ID." AND MAT_LOCK_ANNEE_ID<$annee_courante GROUP BY MAT_ID ORDER BY FORM_NOM,SEM_NOM,UE_NOM,MAT_NOM";
$res = $conn->query($req);
$form_en_cours = -1;
$sem_en_cours = -1;
$ue_en_cours = -1;
$les_semestres = array();
while ($une_affectation = $res->fetch_assoc()) {

    $req = "SELECT DISTINCT GROUPE_NOM,GROUPE_ID FROM etudiants_groupes,semestres_groupes_code,common_inscription WHERE GROUPE_SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$annee_courante AND ET_GROUPE_ANNEE_ID=$annee_courante AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=SEM_GROUPE_ID AND GROUPE_SEM_ID = " . $une_affectation['SEM_ID'];
    if ($conn->query($req)->num_rows === 0) {
        continue;
    }

    if ($form_en_cours != $une_affectation['FORM_ID']) {
        $form_en_cours = $une_affectation['FORM_ID'];
        affectToBloc($template,"une_formation",$une_affectation);
    }
    if ($sem_en_cours != $une_affectation['SEM_ID']) {
        $sem_en_cours = $une_affectation['SEM_ID'];
        $les_semestres[] = $une_affectation['SEM_ID'];
        affectToBloc($template,"une_formation.un_semestre",$une_affectation);
    }
    if ($ue_en_cours != $une_affectation['MAT_UE_ID']) {
        $ue_en_cours = $une_affectation['MAT_UE_ID'];
        affectToBloc($template,"une_formation.un_semestre.une_ue",$une_affectation);
    }

    affectToBloc($template,"une_formation.un_semestre.une_ue.une_matiere",$une_affectation);
}

affectToXHTML($template,array(
    "NB" => count($les_semestres)
));


generateCompleteXHTML($template, "chef");
