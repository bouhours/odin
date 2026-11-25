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

if (!isRegistered() && !isAdmin()) {
    echo "Non autorisé";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "creergroupe", "creergroupe.html");

$annee_courante = Annees::getIdAnneeCourante();
$lesFormations = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);
affectToBlocAndRepeat($template,"une_formation",$lesFormations);

$les_groupes = Groupes::getGroupesVides(Formations::getFormationsDuConnecteString(),"");
$nb_groupes = count($les_groupes);
affectToBlocAndRepeat($template,"un_departement.une_formation.un_groupe",$les_groupes,null,array(
    "un_departement" => array(-1,"FORM_DEPT_ID"),
    "un_departement.une_formation" => array(-1,"FORM_ID")
));

$lesGroupesDeFormation = array();
foreach ($les_groupes as &$unGroupe) {
    if ($unGroupe["GROUPE_PARENT"] == null) {
        $unGroupe["GROUPE_PARENT"] = "";
    }
    $unGroupe['IS_ADMIN'] = isAdmin();
    $lesGroupesDeFormation[$unGroupe['FORM_NOM']][$unGroupe["GROUPE_PARENT"]][] = $unGroupe;
}

$lesSemestres = Formations::getSemestres(Formations::getFormationsDuConnecteString(),$annee_courante);
$lesAssoc = array();
foreach ($lesSemestres as $unSemestre) {
    $lesGroupesDuSemestre = Groupes::getGroupesPourUnSemestre($unSemestre['SEM_ID'],$annee_courante);
    foreach ($lesGroupesDuSemestre as $unGroupe) {
        $lesAssoc[$unSemestre['SEM_ID'] . "$" . $unGroupe['GROUPE_ID']] = true;
    }
}

$les_groupes_a_afficher = "";
$formation_en_cours = -1;

$lesEnseignantDuDepartement = Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID);

foreach ($lesGroupesDeFormation as $form_nom => $lesGroupes) {
    foreach ($lesGroupes as $un_id => $lesGroupesContenus) {
        if ($un_id == "") {
            $les_groupes_a_afficher = emboiter_groupes($form_nom,$lesGroupes, "", $lesAssoc, $lesSemestres, $lesEnseignantDuDepartement);
        }
    }
    affectToBloc($template,"un_formation_groupe",array(
        "FORM_NOM"=>$form_nom,
        "LES_GROUPES" => $les_groupes_a_afficher
    ));
}

affectToXHTML($template, array(
    "HAS_GROUPE" => $nb_groupes > 0,
    "NB_GROUPES" => $nb_groupes
));

generateCompleteXHTML($template, "creergroupe");

function emboiter_groupes(string $form_nom,array $lesGroupesContenus,string $groupe_id, array $lesAssoc, array $lesSemestres, array $lesEnseignantDuDepartement) : string{
    $retour = "";
    if (isset($lesGroupesContenus[$groupe_id])) {
        foreach ($lesGroupesContenus[$groupe_id] as $un_groupe) {
            if ($un_groupe['GROUPE_FEUILLE'] == 0) {
                $template1 = attachXHTML();
                setAttachment($template1, "creergroupe_template_sousgroupe_open", "creergroupe_template_sousgroupe_open.html");
                $un_groupe['HAS_CHILDREN'] = isset($lesGroupesContenus[$un_groupe['GROUPE_ID']]);
                affectToXHTML($template1, $un_groupe);
                detail_groupes($form_nom,$template1,$lesAssoc,$lesSemestres,$un_groupe,$lesEnseignantDuDepartement);
                $retour .= generateCompleteXHTML($template1,"creergroupe_template_sousgroupe_open",true);
                $retour .= emboiter_groupes($form_nom,$lesGroupesContenus, $un_groupe['GROUPE_ID'], $lesAssoc, $lesSemestres, $lesEnseignantDuDepartement);
                $template2 = attachXHTML();
                affectToXHTML($template2, $un_groupe);
                setAttachment($template2, "creergroupe_template_sousgroupe_close", "creergroupe_template_sousgroupe_close.html");
                $retour .= generateCompleteXHTML($template2,"creergroupe_template_sousgroupe_close",true);
            } else {
                $template3 = attachXHTML();
                setAttachment($template3, "creergroupe_template_groupefeuille", "creergroupe_template_groupefeuille.html");
                affectToXHTML($template3, $un_groupe);
                detail_groupes($form_nom,$template3,$lesAssoc,$lesSemestres,$un_groupe,$lesEnseignantDuDepartement);
                $retour .= generateCompleteXHTML($template3,"creergroupe_template_groupefeuille",true);
            }
        }
    }
    return $retour;
}

function detail_groupes(string $form_nom,Template &$template, array $lesAssoc, array $lesSemestres, array $unGroupe, array $lesEnseignantDuDepartement) {
    global $conn;

    foreach ($lesEnseignantDuDepartement as  $unEnseignant) {
        if ($unGroupe['GROUPE_ENS_ID'] == $unEnseignant['ENS_ID']) {
            $unEnseignant['SELECTED'] = 'selected="selected"';
        } else {
            $unEnseignant['SELECTED'] = '';
        }

        affectToBloc($template, "un_enseignant", $unEnseignant);
    }
    foreach ($lesSemestres as $unSemestre) {
        if (array_key_exists($unSemestre['SEM_ID'] . "$" . $unGroupe['GROUPE_ID'],$lesAssoc)) {
            $unSemestre['SEM_SEL'] = 'checked';
        } else {
            $unSemestre['SEM_SEL'] = '';
        }
        if ($unSemestre['FORM_NOM'] !== $form_nom) {
            continue;
        }

        affectToBloc($template, "un_semestre", $unSemestre);
    }
}
