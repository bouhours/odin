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

if (!Formations::isSecretaire() && !Formations::isMediateur() && !Formations::isResponsable()) {
    echo "Non autorisé.";
    exit;
}

$formations_autorisees = Formations::getFormationsDuConnecteString();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = -1;
if (!isset($_GET['bfmw_num_a'])) {
    $annee_courante = Annees::getIdAnneeCourante();
} else {
    $annee_courante = $_GET['bfmw_num_a'];
}

$groupe_courant = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}

setAttachment($template, "bilan", "bilan.html");

if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isChef()) {
    $annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnneeNonClose(),new Comparateur("ANNEE_ID",$annee_courante));
} else {
    $annee_courante = affectToBlocAndRepeat($template,"une_annee",Annees::getAnnee(),new Comparateur("ANNEE_ID",$annee_courante));
}

affectToXHTML($template, array(
    "ANNEE_COURANTE" => $annee_courante
));

$les_groupes = Groupes::getGroupesDuResponsable($formations_autorisees,$annee_courante,CURRENT_ID);

$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",$les_groupes, new Comparateur("GROUPE_ID",$groupe_courant), array("une_formation"=>array(-1,"FORM_ID")));

if ($groupe_courant != "") {
    $les_moyennes = Moyennes::getMoyennesMatieresUnionSurMatieres(CURRENT_DEPT,$annee_courante);
    $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$groupe_courant);

    $les_matieres = array();
    $notes_presentes = false;
    foreach ($les_moyennes as $une_moyenne) {
        if (isset($les_etudiants[$une_moyenne['MOYMAT_ET_ID']])) {
            $notes_presentes = true;
            $les_matieres[$une_moyenne['MOYMAT_SEM_ID']][$une_moyenne['MOYMAT_UE_ID']][$une_moyenne['MOYMAT_MAT_ID']] = 1;
        }
    }

    if (!$notes_presentes) {
        openBloc($template, "no_matiere");
    } else {
        openBloc($template, "matiere");
        $maquette = Formations::getMaquette(CURRENT_DEPT_ID,$annee_courante);
        $les_semestres_possibles = Formations::getSemestresPourUnGroupe(Groupes::getGroupe($groupe_courant)[0]["GROUPE_CODE"],$annee_courante);
        $les_semestres_autorises = array();
        foreach ($les_semestres_possibles as $un_semestre_possible) {
            $les_semestres_autorises[$un_semestre_possible['GROUPE_SEM_ID']] = 1;
        }
        $ue_courante = -1;
        $sem_courante = -1;
        foreach ($maquette as $une_matiere) {
            if ($une_matiere['MAT_CODE_APOGE']=="") {
                continue;
            }
            if ($sem_courante != $une_matiere['SEM_ID']) {
                if (!isset($les_matieres[$une_matiere['SEM_ID']]) || !isset($les_semestres_autorises[$une_matiere['SEM_ID']])) {
                    continue;
                }
                $sem_courante = $une_matiere['SEM_ID'];
                affectToBloc($template, "un_semestre", $une_matiere);
            }

            if ($ue_courante != $une_matiere['UE_ID']) {
                if (isset($les_matieres[$une_matiere['SEM_ID']])) {
                    if (!isset($les_matieres[$une_matiere['SEM_ID']][$une_matiere['UE_ID']])) {
                        continue;
                    }
                }
                $ue_courante = $une_matiere['UE_ID'];
                affectToBloc($template, "un_semestre.une_ue", $une_matiere);
            }

            if (isset($les_matieres[$une_matiere['SEM_ID']])) {
                if (isset($les_matieres[$une_matiere['SEM_ID']][$une_matiere['UE_ID']])) {
                    if (!isset($les_matieres[$une_matiere['SEM_ID']][$une_matiere['UE_ID']][$une_matiere['MAT_ID']])) {
                        continue;
                    }
                }
            }
            affectToBloc($template, "un_semestre.une_ue.une_matiere", $une_matiere);
        }
    }
}

generateCompleteXHTML($template, "bilan");
