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

if (!isRegistered() || !Formations::isSecretaire()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "orthographe", "orthographe.html");

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Matières
 */
$req = "SELECT * FROM common_poursuite_matiere WHERE PMAT_ENS_ID IS NOT NULL AND PMAT_DEPT_ID=".CURRENT_DEPT_ID." AND PMAT_ENS_ID <> ".CURRENT_ID;
$res = $conn->query($req);
if ($res->num_rows != 0) {
    openBloc($template, "locked");
    if ($data = $res->fetch_assoc()) {
        affectToXHTML($template, $data);
    }
} else {
    $req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=" . CURRENT_ID . " WHERE PMAT_DEPT_ID=".CURRENT_DEPT_ID;
    $conn->query($req);

    openBloc($template, "unlocked");

    $req = "SELECT * FROM etudiants_groupes, common_formation, common_poursuite_avis, common_poursuite_matiere WHERE GROUPE_POURSUITE=1 AND FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND PMAT_DEPT_ID=".CURRENT_DEPT_ID." AND PMAT_ID=AVIS_PMAT_ID AND ET_ID = AVIS_ET_ID AND ET_GROUPE_ANNEE_ID = $annee_courante AND AVIS_ANNEE_ID = $annee_courante GROUP BY ET_ID,AVIS_PMAT_ID";
    $res = $conn->query($req);
    while ($un_etudiant = $res->fetch_assoc()) {
        affectToBloc($template, "unlocked.une_ligne", $un_etudiant);
    }
}


generateCompleteXHTML($template, "orthographe");
