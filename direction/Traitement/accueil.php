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
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$groupe_courant = -1;
if (isset($_GET['bfmw_num_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

$etudiant_courant = -1;
if (isset($_GET['bfmw_num_e'])) {
    $etudiant_courant = $_GET['bfmw_num_e'];
}

$les_annees_non_closes = Annees::getAnneeNonClose();
$annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annees_non_closes,new Comparateur("ANNEE_ID",$annee_courante));


affectToXHTML($template, array(
    "ANNEE_COURANTE" => $annee_courante,
    "OPEN_ANNEE" => count($les_annees_non_closes) > 1
));

/**
 * Affichage des formations
 */
$formation_courante = affectToBlocAndRepeat($template,"un_departement.une_formation", Formations::getFormations($annee_courante),new Comparateur("FORM_ID",$formation_courante),
    array(
        "un_departement" =>array(-1,"DEPT_ID")
    ));

$les_groupes = Groupes::getGroupesOLD($formation_courante,$annee_courante);
$groupe_courant = affectToBlocAndRepeat($template,"un_groupe",$les_groupes,new Comparateur("GROUPE_ID",$groupe_courant));

affectToXHTML($template, array(
    "FORMATION_COURANTE" => $formation_courante,
    "GROUPE_COURANT" => $groupe_courant,
    "COMPLET" => false
));

if ($groupe_courant != -1) {
    BilanEtudiant::generateMaster($template,$annee_courante,$groupe_courant,-1,$etudiant_courant);

    if ($etudiant_courant != -1) {

        affectToBlocAndRepeat($template, "un_etudiant_selected", Etudiants::getEtudiantSimple($etudiant_courant));

        $les_semestres = Formations::getSemestresSeuls($annee_courante);
        $les_annees = Annees::getAnnee();
        $les_inscriptions = array();
        $les_inscriptions_annees = array();
        Etudiants::getInscriptions($etudiant_courant, $les_inscriptions, $les_inscriptions_annees);
        $les_groupes = array();
        $les_groupes_annees = array();
        Etudiants::getGroupes($etudiant_courant, $les_groupes, $les_groupes_annees);

        /**
         * Fiches de renseignements
         */
        $les_champs = Fiches_Renseignements::getChampsDeLaFormationValorises($formation_courante, $etudiant_courant);
        affectToBlocAndRepeat($template, "un_etudiant_selected.un_champ", $les_champs);

        $semestre_en_cours = 0;
        foreach ($les_semestres as $un_semestre) {
            if (isset($les_inscriptions[$un_semestre['SEM_ID']])) {
                $un_semestre['SELECTED'] = "checked";
            } else {
                $un_semestre['SELECTED'] = "";
            }

            $first = true;
            foreach ($les_annees as $une_annee) {
                if (isset($les_inscriptions_annees[$un_semestre['SEM_ID'] . "$" . $une_annee['ANNEE_ID']])) {
                    if ($semestre_en_cours != $un_semestre['FORM_ID'] && $first) {
                        $semestre_en_cours = $un_semestre['FORM_ID'];
                        affectToBloc($template, "un_etudiant_selected.une_formation", $un_semestre);
                    }
                    if ($first) {
                        affectToBloc($template, "un_etudiant_selected.une_formation.un_semestre", $un_semestre);
                        $first = false;
                    }
                    affectToBloc($template, "un_etudiant_selected.une_formation.un_semestre.une_annee", $une_annee);
                }
            }
        }

        $groupe_en_cours = 0;
        foreach ($les_groupes as $un_groupe) {
            $first = true;
            foreach ($les_annees as $une_annee) {
                if (isset($les_groupes_annees[$un_groupe['GROUPE_ID'] . "$" . $une_annee['ANNEE_ID']])) {
                    if ($une_annee['ANNEE_ID'] == $annee_courante) {
                        affectToXHTML($template, array(
                            "GROUPE_ID" => $un_groupe['GROUPE_ID']
                        ));
                    }
                    if ($groupe_en_cours != $un_groupe['GROUPE_FORM_ID'] && $first) {
                        $groupe_en_cours = $un_groupe['GROUPE_FORM_ID'];
                        affectToBloc($template, "un_etudiant_selected.une_formation_groupe", $un_groupe);
                    }
                    if ($first) {
                        affectToBloc($template, "un_etudiant_selected.une_formation_groupe.un_groupe", $un_groupe);
                        $first = false;
                    }
                    affectToBloc($template, "un_etudiant_selected.une_formation_groupe.un_groupe.une_annee", $une_annee);
                }
            }
        }

        affectToBlocAndRepeat($template, "un_etudiant_selected.un_semestre.une_ue", Etudiants::getDisepensesUE($etudiant_courant, $annee_courante), null, array("un_etudiant_selected.un_semestre" => array(-1, "SEM_ID")));
        affectToBlocAndRepeat($template, "un_etudiant_selected.un_semestre_mat.une_ue_mat.une_matiere_mat", Etudiants::getDisepensesMat($etudiant_courant, $annee_courante), null, array("un_etudiant_selected.un_semestre_mat" => array(-1, "SEM_ID"), "un_etudiant_selected.un_semestre_mat.une_ue_mat" => array(-1, "UE_ID")));

        affectToXHTML($template, array(
            "IS_ADMIN" => isAdmin(),
            "COMPLET" => false
        ));
    }
}

generateCompleteXHTML($template, "accueil");