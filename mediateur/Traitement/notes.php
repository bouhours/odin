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
setAttachment($template, "mediateur", "notes.html");

$groupe_valide = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_valide = $_GET['bfmw_num_g'];
}
$etudiant_valide = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}
$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

affectToXHTML($template,array(
    "IS_ADMIN" => isAdmin(),
    "IS_RESPONSABLE" => false,
    "ANNEE_ID" => $annee_courante
));

$les_formations_autorisees = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);

/**
 * Affichage des groupes
 */
$groupe_valide = affectToBlocAndRepeat($template,"une_formation.un_groupe",Groupes::getGroupesDuResponsable(implode(",",array_keys($les_formations_autorisees)),$annee_courante,CURRENT_ID),
    new Comparateur("GROUPE_ID",$groupe_valide),
    array("une_formation" => array(-1,"FORM_ID")));

if ($groupe_valide !== "-1") {

    $formation_valide = Groupes::getFormation($groupe_valide)[0]['FORM_ID'];
    /**
     * Affichage des étudiants
     */
    affectToBlocAndRepeat($template, "un_etudiant", Etudiants::getEtudiantsGroupes($annee_courante, $groupe_valide), new Comparateur("ET_ID",$etudiant_valide,"SELECTED","jaune_force"));

    $table = array(
        "GROUPE" => $groupe_valide,
        "ETUDIANT_ID" => $etudiant_valide,
        "ANNEE_ID" => $annee_courante,
        "IS_RESPONSABLE" => Formations::isResponsableFormation($formation_valide)
    );

    affectToXHTML($template, $table);

    /**
     * Detail
     */
    if ($etudiant_valide != -1) {
        openBloc($template, "show");


        /**
         * ANNEE
         */
        affectToBlocAndRepeat($template, "show.une_annee", Etudiants::getAnneeInscription($etudiant_valide),
            new Comparateur("ANNEE_ID", $annee_courante));

        /**
         * NOTES
         */
        ReleveNotes::genererMoyennesSemestre(Etudiants::getSemestresInscritsPourUneAnnee($etudiant_valide, $annee_courante), $template, $etudiant_valide, "show");
    } else if ($groupe_valide != -1) {
        if (isset($_GET['bfmw_orig_selon'])) {
            $selon = $_GET['bfmw_orig_selon'];
        } else {
            $selon = "AN" . $annee_courante;
        }
        PV::generatePV($annee_courante, "pv.", $template, $groupe_valide, $selon, $formation_valide);
    }

    generateCompleteXHTML($template, "mediateur");
}


