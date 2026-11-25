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

$annee_courante = $force_annee_courante;
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$semestre_courant = -1;
if (isset($_GET['bfmw_num_s'])) {
    $semestre_courant = $_GET['bfmw_num_s'];
}

if (Fiches_Renseignements::hasDesFichesNonRemplies(CURRENT_ID,Annees::getIdAnneeCourante())) {
    $send="p=accueil";
    require "refresh.php";
    exit;
}

setAttachment($template, "notes", "notes.html");

/**
 * Detail
 */
if (CURRENT_ID != -1) {
    openBloc($template, "show");

    $annee_courante = affectToBlocAndRepeat($template,"show.une_annee",Etudiants::getAnneeInscription(CURRENT_ID),new Comparateur("ANNEE_ID",$annee_courante));
    $semestre_courant = affectToBlocAndRepeat($template,"show.un_semestre_filtre", Etudiants::getSemestresInscritsPourUneAnneeArray(CURRENT_ID,$annee_courante),new Comparateur("SEM_ID",$semestre_courant));

    $req = "SELECT * FROM common_semestre,etudiants_access_etudiants,common_inscription WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID = INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$annee_courante AND ET_ID = " . CURRENT_ID . " AND SEM_ID=$semestre_courant GROUP BY ET_ID,SEM_ID ORDER BY SEM_NOM";
    $resSEMESTRE = $conn->query($req);
    ReleveNotes::genererMoyennesSemestre($resSEMESTRE,$template,CURRENT_ID,"show");
}

affectToXHTML($template,array(
    "SEM_COURANT" => $semestre_courant,
    "ANNEE_COURANTE" => $annee_courante
));

generateCompleteXHTML($template, "notes");