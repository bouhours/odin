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

if (!isGestionnaire()) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "gestion_demande", "gestion_demande.html");

$req = "SELECT * FROM common_edt_changement,common_enseignants_departement, common_enseignant WHERE ENS_ID=DEPT_ENS_ID AND ENS_ID=DEMANDE_ENS_ID AND DEMANDE_DONE=0 AND ENS_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY ENS_ID,DEMANDE_DONE,DEMANDE_EXECUTOR_ENS_ID DESC";
$res = $conn->query($req);
$enseignant_en_cours = -1;
while ($une_demande = $res->fetch_assoc()) {
    $une_demande['CURRENT_ID'] = CURRENT_ID;

    $req = "SELECT * FROM common_edt_changement,common_enseignant WHERE ENS_ID=DEMANDE_EXECUTOR_ENS_ID AND DEMANDE_ID=".$une_demande['DEMANDE_ID'];
    $res2 = $conn->query($req);

    if ($executor = $res2->fetch_assoc()) {
        $une_demande['EXECUTOR_ENS_NOM'] = $executor['ENS_NOM'];
    }

    if ($enseignant_en_cours != $une_demande['ENS_ID']) {
        $enseignant_en_cours = $une_demande['ENS_ID'];
        affectToBloc($template,"un_enseignant",$une_demande);
    }
    affectToBloc($template,"un_enseignant.une_demande",$une_demande);
}


generateCompleteXHTML($template, "gestion_demande");
