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

$annee_courante = Annees::getIdAnneeCourante();

if (!isset($_GET['bfmw_num_eval'])) {

    setAttachment($template, "lire", "lire.html");

    $req = "SELECT * FROM affectations_enseignants,common_evaluation WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND EVAL_AFFECT_ID=ID AND ENS_MAT_EVALUABLE=1 AND DEPT_ENS_ID=" . CURRENT_ID . " GROUP BY MAT_ID ORDER BY FORM_ID,MAT_NOM";
    $res = $conn->query($req);
    $formation_en_cours = -1;
    while ($une_affectation = $res->fetch_assoc()) {
        if ($formation_en_cours != $une_affectation['FORM_ID']) {
            $formation_en_cours = $une_affectation['FORM_ID'];
            affectToBloc($template, "une_formation", $une_affectation);

        }

        $une_affectation['CHECKED'] = ($une_affectation['ENS_MAT_EVALUABLE'] == 1 ? "checked" : "");
        affectToBloc($template, "une_formation.un_cours", $une_affectation);

    }

    generateCompleteXHTML($template, "lire");
} else {
    setAttachment($template, "stat", "stat.html");

        $req = "SELECT * FROM common_evaluation,affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ID=EVAL_AFFECT_ID AND EVAL_AFFECT_ID=" . $_GET['bfmw_num_eval'] . " AND DEPT_ENS_ID=".CURRENT_ID." GROUP BY MAT_ID";
        $res = $conn->query($req);
        if ($lesMats = $res->fetch_assoc()) {
            $req = "SELECT COUNT(*) AS TOTAL FROM common_evaluation WHERE EVAL_AFFECT_ID=" . $_GET['bfmw_num_eval'] . " AND EVAL_QUESTION=(SELECT MIN(EVAL_QUESTION) FROM common_evaluation WHERE EVAL_AFFECT_ID=" . $_GET['bfmw_num_eval'] . ")";
            $res = $conn->query($req);
            $old = $res->fetch_assoc()["TOTAL"];
            $lesMats["TOTAL"] = $old;

            affectToXHTML($template, $lesMats);
            $req = "SELECT eval_question AS QUESTION ,COUNT(*) AS NOMBRE,ROUND(COUNT(*)*100/" . $old . ") AS POURCENT, eval_reponse AS REPONSE FROM common_evaluation WHERE EVAL_AFFECT_ID=" . $_GET['bfmw_num_eval'] . " GROUP BY eval_reponse,eval_question ORDER BY eval_q_ordre,NOMBRE DESC";
            $res = $conn->query($req);
            $question_precedente = "";
            while ($tab = $res->fetch_assoc()) {
                if ($question_precedente != $tab['QUESTION']) {
                    $question_precedente = $tab['QUESTION'];
                } else {
                    $tab['QUESTION'] = "";
                }
                affectToBloc($template, "une_ligne", $tab);
            }
        }


    generateCompleteXHTML($template, "stat");
}
