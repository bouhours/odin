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

$annee_courante = Annees::getIdAnneeCourante();

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,$force_annee_courante)) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

$les_goupes = Etudiants::getGroupesEtudiantString(CURRENT_ID,$force_annee_courante);

if (!isset($_POST['bfmw_num_val']) && $les_goupes !== "") {

    $req = "SELECT * FROM etudiants_retour,affectations_enseignants,common_periodes_matieres, common_enseignant, common_eval_groupe_enseignement WHERE ID=GROUPE_ID_ID AND ID_GROUPE_ID IN ($les_goupes) AND MAT_ID=PERIODE_MAT_ID AND affectations_enseignants.MAT_ENS_ID=common_enseignant.ENS_ID AND MAT_PERIODE_ID=etudiants_retour.FORM_EVAL_PERIODE_ID AND etudiants_retour.FORM_ID=affectations_enseignants.FORM_ID AND ENS_MAT_EVALUABLE=1 AND ET_ID=" . CURRENT_ID . " AND etudiants_retour.FORM_EVAL_DEBUT <= " . time() . " AND etudiants_retour.FORM_EVAL_FIN >= " . time() . " ORDER BY MAT_NOM,ENS_NOM";

    $resRETOUR = $conn->query($req);
    $retour = $resRETOUR->num_rows >= 1;

    $req = "SELECT * FROM affectations_enseignants,common_inscription, common_enseignant,common_eval_groupe_enseignement WHERE ID=GROUPE_ID_ID AND ID_GROUPE_ID IN ($les_goupes) AND common_enseignant.ENS_ID=affectations_enseignants.MAT_ENS_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ANNEE_ID=" . Annees::getIdAnneeCourante() . " AND INSCRIPT_ET_ID=" . CURRENT_ID . " AND ENS_MAT_EVAL_DATE_DEBUT<=" . time() . " AND ENS_MAT_EVAL_DATE_FIN>=" . time() . " ORDER BY MAT_NOM,ENS_NOM";
    $resINDIV = $conn->query($req);
    $retour |= $resINDIV->num_rows >= 1;

    if (!$retour) {
        $send = "accueil";
        require "refresh.php";
    }

    if (isErreur()) {
        require_once 'Traitement/alerts.php';
    }
    setAttachment($template, "retour", "retour.html");

    while ($un_cours = $resRETOUR->fetch_assoc()) {
        $req = "SELECT * FROM common_evaluation WHERE EVAL_AFFECT_ID=".$un_cours['ID']." AND EVAL_ET_ID=".CURRENT_ID;
        $un_cours['OK'] = $conn->query($req)->num_rows > 0;
        affectToBloc($template, "un_cours", $un_cours);
    }
    while ($un_cours = $resINDIV->fetch_assoc()) {
        $req = "SELECT * FROM common_evaluation WHERE EVAL_AFFECT_ID=".$un_cours['ID']." AND EVAL_ET_ID=".CURRENT_ID;
        $un_cours['OK'] = $conn->query($req)->num_rows > 0;
        affectToBloc($template, "un_cours", $un_cours);
    }

    affectToXHTML($template,array(
        "ANNEE_COURANTE" => $annee_courante
    ));

    generateCompleteXHTML($template, "retour");
} else {
    setAttachment($template, "retour", "retour_questionnaire.html");
    $req = "SELECT * FROM common_evaluation WHERE EVAL_AFFECT_ID=".$_POST['bfmw_num_val']." AND EVAL_ET_ID=".CURRENT_ID;
    if ($conn->query($req)->num_rows > 0) {
        $send="p=retour";
        require "refresh.php";
        exit;
    }

    $req = "SELECT * FROM etudiants_retour,affectations_enseignants,common_periodes_matieres, common_enseignant, common_eval_groupe_enseignement WHERE ID=GROUPE_ID_ID AND ID_GROUPE_ID IN ($les_goupes) AND ID=".$_POST['bfmw_num_val']." AND MAT_ID=PERIODE_MAT_ID AND affectations_enseignants.MAT_ENS_ID=common_enseignant.ENS_ID AND MAT_PERIODE_ID=etudiants_retour.FORM_EVAL_PERIODE_ID AND etudiants_retour.FORM_ID=affectations_enseignants.FORM_ID AND ENS_MAT_EVALUABLE=1 AND ET_ID=" . CURRENT_ID . " AND etudiants_retour.FORM_EVAL_DEBUT <= " . time() . " AND etudiants_retour.FORM_EVAL_FIN >= " . time();
    $resRETOUR = $conn->query($req);
    $retour = $resRETOUR->num_rows >= 1;

    $req = "SELECT * FROM affectations_enseignants,common_inscription, common_enseignant, common_eval_groupe_enseignement WHERE ID=GROUPE_ID_ID AND ID_GROUPE_ID IN ($les_goupes) AND ID=".$_POST['bfmw_num_val']." AND common_enseignant.ENS_ID=affectations_enseignants.MAT_ENS_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ANNEE_ID=" . Annees::getIdAnneeCourante() . " AND INSCRIPT_ET_ID=" . CURRENT_ID . " AND ENS_MAT_EVAL_DATE_DEBUT<=" . time() . " AND ENS_MAT_EVAL_DATE_FIN>=" . time();
    $resINDIV = $conn->query($req);
    $retour |= $resINDIV->num_rows >= 1;

    if (!$retour) {
        $send="p=retour";
        require "refresh.php";
        exit;
    }

    $req = "SELECT * FROM affectations_enseignants, common_enseignant WHERE affectations_enseignants.MAT_ENS_ID=common_enseignant.ENS_ID AND ID=".$_POST['bfmw_num_val']." AND ENS_MAT_EVALUABLE=1";
    if ($affectation_en_cours = $conn->query($req)->fetch_assoc()) {
        $req = "SELECT * FROM common_eval_questions WHERE EVALQ_FORM_ID=".$affectation_en_cours['FORM_ID']." ORDER BY EVALQ_ORDRE";
        $resQUESTION = $conn->query($req);
        while ($une_question = $resQUESTION->fetch_assoc()) {
            affectToBloc($template,"une_question",$une_question);
            $req = "SELECT * FROM common_eval_reponse WHERE EVALR_EVALQ_ID=".$une_question['EVALQ_ID']." ORDER BY EVALR_ORDRE";
            $resREPONSE = $conn->query($req);
            while ($une_reponse = $resREPONSE->fetch_assoc()) {
                affectToBloc($template,"une_question.une_reponse",$une_reponse);
            }
        }
        affectToXHTML($template,$affectation_en_cours);
    }
    affectToXHTML($template,array(
        "ANNEE_COURANTE" => $annee_courante
    ));
    generateCompleteXHTML($template, "retour");
}