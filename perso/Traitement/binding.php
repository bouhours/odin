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

//Récupération des charges
if (isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_f']) && isset($_POST['bfmw_orig_lazyLoad_charge'])) {
    $valeurs = ChargeEnseignements::getChargeEquipe($_POST['bfmw_num_f'],$_POST['bfmw_num_a'], CURRENT_ID);
    genererTemplate($valeurs);
    exit;
}

// Suppression d'une ligne pour un enseignant particulier
if (isset($_POST['bfmw_orig_id']) && isset($_POST['bfmw_orig_supprimercharge']) && isset($_POST['bfmw_orig_charge']) && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_num_f'])) {
    if (ChargeEnseignements::supprimerCharge($_POST['bfmw_num_charge'],CURRENT_DEPT_ID) > 0) {
        $valeurs = ChargeEnseignements::getChargeEquipePourUneMatiere($_POST['bfmw_num_id'], CURRENT_ID, $_POST['bfmw_num_a'], $_POST['bfmw_num_f']);
        genererTemplate($valeurs);
    }
    exit;
}

// Suppression d'une enseignant pour une matière
if (isset($_POST['bfmw_orig_id']) && isset($_POST['bfmw_orig_m']) && isset($_POST['bfmw_orig_supprimerenseignant']) && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_num_f'])) {
    if (ChargeEnseignements::supprimerAffectation($_POST['bfmw_num_id'],CURRENT_DEPT_ID) > 0) {
        $valeurs = ChargeEnseignements::getChargeEquipePourUneMatiere($_POST['bfmw_num_m'], CURRENT_ID, $_POST['bfmw_num_a'], $_POST['bfmw_num_f']);
        genererTemplate($valeurs);
    }
    exit;
}


// Ajout d'une ligne pour un enseignant particulier
if (isset($_POST['bfmw_orig_id']) && isset($_POST['bfmw_orig_m']) && isset($_POST['bfmw_orig_ajoutercharge']) && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_num_f'])) {
    if (ChargeEnseignements::ajouterChargeVierge($_POST['bfmw_num_id']) > 0) {
        $valeurs = ChargeEnseignements::getChargeEquipePourUneMatiere($_POST['bfmw_num_m'], CURRENT_ID, $_POST['bfmw_num_a'], $_POST['bfmw_num_f']);
        genererTemplate($valeurs);
    }
    exit;
}

// Ajout d'un enseignant existant dans une matière
if (isset($_POST['bfmw_orig_m']) && isset($_POST['bfmw_orig_ajouterenseignantexistant']) && isset($_POST['bfmw_num_value']) && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_num_f'])) {
    if (ChargeEnseignements::ajouterEnseignantExistant($_POST['bfmw_num_m'],$_POST['bfmw_num_a'],$_POST['bfmw_num_value']) > 0) {
        $valeurs = ChargeEnseignements::getChargeEquipePourUneMatiere($_POST['bfmw_num_m'], CURRENT_ID, $_POST['bfmw_num_a'], $_POST['bfmw_num_f']);
        genererTemplate($valeurs);
    }
    exit;
}

//Récupération de la charge à la matière
if (isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_m']) && isset($_POST['bfmw_orig_computetdensmat'])) {
    echo ChargeEnseignements::computeChargeEqTDMatiereEnseignantV2($_POST['bfmw_num_a'],null,$_POST['bfmw_num_m']);
    exit;
}

//Récupration de toutes les charges
if (isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_f']) && isset($_POST['bfmw_orig_computeetdtoutesmat'])) {
    $retour = "{\"infos\":[";
    $valeurs = ChargeEnseignements::getChargeEquipePourToutesMatieres(CURRENT_ID, $_POST['bfmw_num_a'], $_POST['bfmw_num_f']);
    foreach ($valeurs as $element) {
        $retour .= "{\"MAT_ID\":\"".$element["MAT_ID"]."\",";
        $retour .= "\"TOTAL\":\"".round($element["TOTAL"],3)."\"},";
    }
    $retour .= "{}]}";
    echo $retour;
    exit;
}

if (isset($_GET['bfmw_orig_count']) && $_GET['bfmw_orig_count']=="disponibilites" && isset($_POST['bfmw_orig_s'])) {
    $annee_courante = Annees::getIdAnneeCourante();
    if (isset($_SESSION['ANNEE_COURANTE'])) {
        $annee_courante = $_SESSION['ANNEE_COURANTE'];
    }
    echo Soutenances::getNombreSoutenancesPourUnEnseignant(CURRENT_ID,$annee_courante);
    echo "$";
    $total = Stages::getNombreEncadrementPourEnseignants(CURRENT_ID,$annee_courante,$_POST['bfmw_num_s']);
    if (isset($total[CURRENT_ID])) {
        echo $total[CURRENT_ID]["TOTAL"]*2+1;
    } else {
        echo 1;
    }
    echo "$";
    $total = Generation_Planning_Soutenances::getNombreCreneauxReels(CURRENT_ID,$annee_courante,$_POST['bfmw_num_s']);
    if (isset($total[CURRENT_ID])) {
        echo $total[CURRENT_ID];
    } else {
        echo 0;
    }
    exit;
}


if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $retour = false;
    switch ($_POST['bfmw_orig_type']) {
        case "qlfuynqsldjfhsqlsjhf" :
            $retour = Soutenances::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "opzieruxczenuxrazerx" :
            $retour = ChargeEnseignements::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        default : exit();
    }

    if ($retour) {
        echo "OK";
    }

    exit();
}

// Mise en forme des charges
function genererTemplate(array $valeurs)
{
    $template1 = attachXHTML();
    setAttachment($template1, "equipe_template_charge", "equipe_template_charge.html");
    affectToBlocAndRepeat($template1, "une_matiere.un_enseignant.une_charge", $valeurs, null, array(
        "une_matiere" => array(-1, "MAT_ID"),
        "une_matiere.un_enseignant" => array(-1, "ENS_ID")
    ));
    $selection = -1;
    $enseignants = Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID);
    $composant = Components::generateOptions($enseignants,"ENS_ID","ENS_NOM",$selection,null);
    affectToXHTML($template1,
    array(
        "SELECT_ENSEIGNANT" => $composant
    ));
    generateCompleteXHTML($template1, "equipe_template_charge");
}
