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

$req = "SELECT * FROM etudiants_groupes,common_departement WHERE DEPT_POURSUITE_DDEB <= ".time()." AND DEPT_POURSUITE_DFIN > ".time()." AND GROUPE_POURSUITE=1 AND ET_ID=".CURRENT_ID." AND DEPT_ID=".CURRENT_DEPT_ID." GROUP BY ET_ID";

if ($conn->query($req)->num_rows === 0) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = $force_annee_courante;

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,$annee_courante)) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

setAttachment($template, "poursuites", "poursuites.html");

$req = "SELECT PMAT_ID,PMAT_NOM,ENS_NOM,ENS_ID, CHOIX_PMAT_ID, CHOIX_ET_ID FROM (common_enseignant, common_poursuite_matiere, common_poursuite_matiere_composition, affectations_enseignants) LEFT JOIN common_poursuite_choix_etudiant ON (ENS_ID=CHOIX_ENS_ID AND CHOIX_ANNEE_ID=$annee_courante AND CHOIX_ET_ID=".CURRENT_ID.") WHERE PMAT_ID=MAT_PMAT_ID AND PMAT_MAT_ID=ENS_MAT_ID AND ENS_MAT_ANNEE_ID=$annee_courante AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND ENS_ID=MAT_ENS_ID AND ENS_MAT_POURSUITE=1 GROUP BY PMAT_ID,MAT_ENS_ID ORDER BY PMAT_NOM,PMAT_ID, ENS_NOM";
$res = $conn->query($req);
$descipline_courante = -1;
while ($une_discipline = $res->fetch_assoc()) {
    if ($une_discipline['CHOIX_ET_ID'] == CURRENT_ID && $une_discipline['PMAT_ID'] == $une_discipline['CHOIX_PMAT_ID']) {
        $une_discipline['SELECTED'] = "checked";
    } else {
        $une_discipline['SELECTED'] = "";
    }

    if ($descipline_courante != $une_discipline['PMAT_ID']) {
        $descipline_courante = $une_discipline['PMAT_ID'];
        affectToBloc($template,"une_discipline",$une_discipline);
    }
    affectToBloc($template,"une_discipline.un_enseignant",$une_discipline);
}


generateCompleteXHTML($template, "poursuites");
