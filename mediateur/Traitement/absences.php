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

setAttachment($template, "master", "master.html");



$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$groupe_valide = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_valide = $_GET['bfmw_num_g'];
}
$etudiant_valide = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_valide = $_GET['bfmw_num_e'];
}

$les_formations_autorisees = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);

$annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));

/**
 * Affichage des groupes
 */
$groupe_valide = affectToBlocAndRepeat($template,"une_formation.un_groupe",Groupes::getGroupesDuResponsable(implode(",",array_keys($les_formations_autorisees)),$annee_courante,CURRENT_ID),
    new Comparateur("GROUPE_ID",$groupe_valide),
    array("une_formation" => array(-1,"FORM_ID")));

if ($groupe_valide !== "-1") {

    $groupe_complet = Groupes::getGroupe($groupe_valide);

    /**
     * Affichage des étudiants
     */
    $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante, $groupe_valide);
    foreach ($les_etudiants as $etudiant) {
        $etudiant['NB_ABSENCES'] = Absences::getNombreDeDemiJourneesNonJustifiees($etudiant['ET_ID'], 0, "ABS_ENS_ID", $annee_courante);
        $etudiant['NB_JUSTIF'] = Absences::getNombreJustificationsAValider($etudiant['ET_ID']);
        $etudiant['HIDDEN'] = $etudiant['NB_ABSENCES']==0?"to_hide":"";
        $etudiant['SELECTED'] = $etudiant_valide==$etudiant["ET_ID"]?"jaune_force":"";
        affectToBloc($template, "un_etudiant", $etudiant);
    }

    $table = array(
        "GROUPE" => $groupe_valide,
        "GROUPE_ID" => $groupe_valide,
        "ANNEE_ID" => $annee_courante
    );

    affectToXHTML($template, $table);

    generateCompleteXHTML($template, "master");

    /**
     * Détail
     */
    $etudiant = Etudiants::getEtudiant($etudiant_valide, $annee_courante);
    if ($etudiant != null) {
        openBloc($template, "show");
        affectToBlocAndRepeat($template, "show.une_justification", Absences::getJustifications($etudiant_valide));

        //Récupération des absences
        $lesAbsences = Absences::getAbsencesNewGen($annee_courante, 0, "=" . $_GET['bfmw_num_e']);
        $nom = "";
        $nbtotal = Absences::getNombreAbsencesNewGen($_GET['bfmw_num_e'], $annee_courante, 0);
        $absences_affichees = array();
        foreach ($lesAbsences as $date) {
            $date['ET_GROUPE'] = $groupe_valide;
            if (!isset($absences_affichees[$date['ABS_ID']])) {
                affectToBloc($template, "show.une_absence", $date);
                $absences_affichees[$date['ABS_ID']] = $date;
            }
        }

        //Récupération de l'étudiant
        $etu = $etudiant[0];
        $nom = $etu['ET_NOM'];
        $numero = $etu['ET_NUMERO'];


        $table = array(
            "ET_NOM" => $nom,
            "ET_ID" => $_GET['bfmw_num_e'],
            "ET_NUMERO" => $numero,
            "GROUPE_ID" => $groupe_valide,
            "ANNEE_ID" => $annee_courante,
            "NOMBRE_ABSENCES" => Absences::constructeurNombreAbsences(0, "NB", $nbtotal, $etudiant_valide)["NB"]
        );

        affectToXHTML($template, $table);
    } else {
        openBloc($template, "global");

        $les_absences = Absences::getAbsencesNewGen($annee_courante, 0, "=ET_ID", "ENS_ID", "GROUPE_CODE LIKE '" . $groupe_complet[0]   ['GROUPE_CODE'] . "%' AND ");

        $groupe_precedent = -1;
        $etudiant_precedent = -1;
        foreach ($les_absences as $etudiant) {
            if ($groupe_precedent != $etudiant['GROUPE_ID']) {
                $groupe_precedent = $etudiant['GROUPE_ID'];
                $etudiant_precedent = -1;
                affectToBloc($template, "global.un_groupe", $etudiant);
            }

            if ($etudiant_precedent != $etudiant['ET_ID']) {
                $etudiant_precedent = $etudiant['ET_ID'];
                $phrase = Absences::constructeurNombreAbsences("0", "NOMBRE_ABSENCES", Absences::getNombreAbsencesNewGen($etudiant['ET_ID'], $annee_courante, 0), $etudiant['ET_ID'], $annee_courante);
                $etudiant["NOMBRE_ABSENCES"] = $phrase['NOMBRE_ABSENCES'];
                affectToBloc($template, "global.un_groupe.un_etudiant", $etudiant);
            }

            affectToBloc($template, "global.un_groupe.un_etudiant.une_absence", $etudiant);

        }
    }

    setAttachment($template, "detail", "detail.html");

    generateCompleteXHTML($template, "detail");
}
