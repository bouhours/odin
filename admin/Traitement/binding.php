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

if (isset($_POST['bfmw_orig_s']) && isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_computetd'])) {
    echo ChargeEnseignements::computeChargeEqTDSemestreV2($_POST['bfmw_num_s'],$_POST['bfmw_num_a']);
    exit;
}

if (isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_e']) && isset($_POST['bfmw_orig_m']) && isset($_POST['bfmw_orig_computetdensmat'])) {
    echo ChargeEnseignements::computeChargeEqTDMatiereEnseignantV2($_POST['bfmw_num_a'],$_POST['bfmw_num_e'],$_POST['bfmw_num_m']);
    exit;
}

if (isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_s']) && isset($_POST['bfmw_orig_computeetdmat'])) {
    $retour = "{\"infos\":[";
    $valeurs = ChargeEnseignements::computeChargeEqTDSemestreMultipleV2($_POST['bfmw_num_s'],$_POST['bfmw_num_a']);
    foreach ($valeurs as $element) {
        $retour .= "{\"ENS_ID\":\"".$element["ENS_ID"]."\",";
        $retour .= "\"MAT_ID\":\"".$element["MAT_ID"]."\",";
        $retour .= "\"TOTAL\":\"".round($element["TOTAL"],3)."\"},";
    }
    $retour .= "{}]}";
    echo $retour;
    exit;
}

//Récupération des charges
if (isset($_POST['bfmw_orig_a']) && isset($_POST['bfmw_orig_s']) && isset($_POST['bfmw_orig_lazyLoad_charge'])) {
    $valeurs = ChargeEnseignements::getChargeEnseignantV2($_POST['bfmw_num_s'],$_POST['bfmw_num_a']);
    genererTemplate($valeurs);
    exit;
}

// Suppression d'une ligne pour un enseignant particulier
if (isset($_POST['bfmw_orig_id']) && isset($_POST['bfmw_orig_supprimercharge']) && isset($_POST['bfmw_orig_charge'])) {
    if (ChargeEnseignements::supprimerCharge($_POST['bfmw_num_charge'],CURRENT_DEPT_ID) > 0) {
        $valeurs = ChargeEnseignements::getChargeEnseignantAvecAffectation($_POST['bfmw_orig_id']);
        genererTemplate($valeurs);
    }
    exit;
}


// Ajout d'une ligne pour un enseignant particulier
if (isset($_POST['bfmw_orig_id']) && isset($_POST['bfmw_orig_ajoutercharge'])) {
    if (ChargeEnseignements::ajouterChargeVierge($_POST['bfmw_num_id']) > 0) {
        $valeurs = ChargeEnseignements::getChargeEnseignantAvecAffectation($_POST['bfmw_orig_id']);
        genererTemplate($valeurs);
    }
    exit;
}

/**
 * Création d'un créneau
 */
if (isset($_GET['bfmw_orig_submit_creneau']) && isset($_POST['bfmw_orig_CRENEAU_DEBUT']) && isset($_POST['bfmw_orig_CRENEAU_FIN']) && isset($_POST['bfmw_orig_PLANNING_ID'])) {
    try {
        bfmw_add_secured($_POST, "*CRENEAU_PLANNING_ID", $_POST['bfmw_num_PLANNING_ID']);
        bfmw_add_secured($_POST, "*CRENEAU_DEBUT", transformHeure($_POST['bfmw_orig_CRENEAU_DEBUT']));
        bfmw_add_secured($_POST, "*CRENEAU_FIN", transformHeure($_POST['bfmw_orig_CRENEAU_FIN']));
        if (Soutenances::creerCreneau($_POST) > 0) {
            echo "De " . $_POST['bfmw_orig_CRENEAU_DEBUT'] . " à " . $_POST['bfmw_orig_CRENEAU_FIN'];
        } else {
            echo "KO";
        }
    } catch (Exception $e) {
        echo "KO";
    }
    exit;
}

/**
 * Création d'un créneau pour un planning
 */
if (isset($_GET['bfmw_orig_submit_creneau_planning']) && isset($_POST['bfmw_orig_CRENEAU_DEBUT']) && isset($_POST['bfmw_orig_CRENEAU_FIN']) && isset($_POST['bfmw_orig_PLANNING_ID'])) {
    try {
        bfmw_add_secured($_POST, "*CRENEAU_PLANNING_ID", $_POST['bfmw_num_PLANNING_ID']);
        bfmw_add_secured($_POST, "*CRENEAU_DEBUT", transformHeure($_POST['bfmw_orig_CRENEAU_DEBUT']));
        bfmw_add_secured($_POST, "*CRENEAU_FIN", transformHeure($_POST['bfmw_orig_CRENEAU_FIN']));
        if (Plannings::creerCreneau($_POST) > 0) {
            echo "De " . $_POST['bfmw_orig_CRENEAU_DEBUT'] . " à " . $_POST['bfmw_orig_CRENEAU_FIN'];
        } else {
            echo "KO";
        }
    } catch (Exception $e) {
        echo "KO";
    }
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $req = "";
    $validation = false;
    switch ($_POST['bfmw_orig_type']) {
        case "djsplhgqjzilgcqsdf" :
        case "hgdljhhgsfdbhkgvjlyf" :
        case "zerqsfdaedfae(ty" :
            $validation = Poursuites::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "syuknbvderth" :
        case "oigyfkhgfdjtrdgj65khglj" :
            $validation = Groupes::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "oiuioy45itgfkjgh" :
        case "dxwcvjkcvbnjkutyfgcb" :
            //Modification d'une formation
            $validation = Formations::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "zeklhsdlfghnlsuidnczljekshfqsd" :
        case "qsdqsfd" :
        case "55fgh43241dfgh557sh" :
            $validation = Enseignants::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case 'sdilunysodukfncsldfgbcqys' :
            $validation = Edt::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "iuzeksdf54szdfgjkdf1" :
            //Modification d'un étudiant
            $validation = Etudiants::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case 'opzieruxczenuxrazerx':
        case "uybalzdscbqlsduyfazefqsdf" :
            //Modification de la charge enseignement et de la possibilité de noter
            //Ou suppression d'une mise en paiement vacataire
            $validation = ChargeEnseignements::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "erunzeurinzerhxlsdjkkhnc":
            //Modification des soutenances
            $validation = Notation_Soutenances::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            if (!$validation) {
                $validation = Soutenances::doBind($_POST['bfmw_orig_tag'], $_POST['bfmw_orig_valeur'], $_POST['bfmw_orig_where'], $_POST['bfmw_num_valeur'], $_POST['bfmw_num_where']);
            }
            break;
        case "seirubgyflqsdjkfnhqlsudyfb":
            //Modification des plannings
            $validation = Plannings::doBind($_POST['bfmw_orig_tag'], $_POST['bfmw_orig_valeur'], $_POST['bfmw_orig_where'], $_POST['bfmw_num_valeur'], $_POST['bfmw_num_where']);
            break;
        case "totuyrhqskdjhgbazerf" :
            // Modification des champs des fiches de renseignements
            $validation = Fiches_Renseignements::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "oqzoeiurnysqldqs" :
            $validation = Resultats::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "sdlfitbzelrutnchsdlj" :
            $validation = Poursuites::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);

    }

    if ($validation) {
        echo "OK";
    } else {
        echo "KO";
    }

    exit();
}

// Mise en forme des charges
function genererTemplate(array $valeurs)
{
    $template1 = attachXHTML();
    setAttachment($template1, "gererenseignant_template_charge", "gererenseignant_template_charge.html");
    affectToBlocAndRepeat($template1, "une_affectation.une_charge", $valeurs, null, array(
        "une_affectation" => array(-1, "CHARGE_AFFECTATION_ID")
    ));
;
    generateCompleteXHTML($template1, "gererenseignant_template_charge");
}