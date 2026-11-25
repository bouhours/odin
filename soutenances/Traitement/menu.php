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

setAttachment($template, "menu", "menu.html");

$active = "ACTIVE_ACCUEIL";

if (isset($_GET['bfmw_orig_p'])) {
    switch ($_GET['bfmw_orig_p']) {
        case "creergroupe" : $active = "ACTIVE_CREERGROUPE";break;
        case "individuel" :
        case "groupe" :
        case "harmonisation" :
        case "verif" :
            $active = "_";
            break;
    }
}

$annee_courante = Annees::getIdAnneeCourante();
if (isset($_GET['bfmw_num_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}
$les_sessions = Notation_Soutenances::getSession($annee_courante,null,Formations::getFormationDuDepartementString(CURRENT_DEPT_ID,$annee_courante));

$session_courante = -1;
if (isset($_GET['bfmw_num_s'])) {
    $session_courante = $_GET['bfmw_num_s'];
}

foreach ($les_sessions as $une_session) {
    if ($une_session['SESSION_START'] <= time() && $une_session['SESSION_END'] > time() ) {
        $une_session['HAS_GROUPE'] = count(Notation_Soutenances::getGroupes($annee_courante,$une_session['SESSION_ID']))>0;

        $une_session['ACTIVE_INDIVIDUEL'] = "";
        $une_session['ACTIVE_GROUPE'] = "";
        $une_session['ACTIVE_VERIF'] = "";
        if ($session_courante == $une_session['SESSION_ID']) {
            if (isset($_GET['bfmw_orig_p'])) {
                switch ($_GET['bfmw_orig_p']) {
                    case "individuel" :
                        $une_session['ACTIVE_INDIVIDUEL'] = "class=\"active\"";
                        break;
                    case "groupe" :
                        $une_session['ACTIVE_GROUPE'] = "class=\"active\"";
                        break;
                    case "verif" :
                        $une_session['ACTIVE_VERIF'] = "class=\"active\"";
                        break;
                }
            }
        }

        affectToBloc($template,"une_session_menu",$une_session);
        $_SESSION['SESSION_OUVERTE_'.$une_session['SESSION_ID']] = true;
        if ($une_session['HAS_GROUPE']) {
            $_SESSION['SESSION_OUVERTE_GROUPE_' . $une_session['SESSION_ID']] = true;
        } else {
            unset($_SESSION['SESSION_OUVERTE_GROUPE_' . $une_session['SESSION_ID']]);
        }
    } else {
        unset($_SESSION['SESSION_OUVERTE_'.$une_session['SESSION_ID']]);
        unset($_SESSION['SESSION_OUVERTE_GROUPE_' . $une_session['SESSION_ID']]);
    }
    if (($une_session['SESSION_HARMONISATION_START'] <= time() && $une_session['SESSION_HARMONISATION_END'] > time() ) ||
        ((Formations::isResponsableFormation($une_session['SESSION_FORM_ID']) || Formations::isSecretaireFormation($une_session['SESSION_FORM_ID'])) && $une_session['SESSION_HARMONISATION_END'] > time())){
        if (!isset($_SESSION['SESSION_OUVERTE_GROUPE_' . $une_session['SESSION_ID']])) {
            if (count(Notation_Soutenances::getGroupes($annee_courante,$une_session['SESSION_ID']))>0) {
                $_SESSION['SESSION_OUVERTE_GROUPE_' . $une_session['SESSION_ID']] = true;
            }
        }
        $une_session['ACTIVE_HARMONISATION'] = "";
        if ($session_courante == $une_session['SESSION_ID']) {
            if (isset($_GET['bfmw_orig_p'])) {
                switch ($_GET['bfmw_orig_p']) {
                    case "harmonisation" :
                        $une_session['ACTIVE_HARMONISATION'] = "class=\"active\"";
                        break;
                }
            }
        }

        affectToBloc($template,"une_session_menu_harmonisation",$une_session);
        $_SESSION['HARMONISATION_OUVERTE_'.$une_session['SESSION_ID']] = true;
    } else {
        unset($_SESSION['HARMONISATION_OUVERTE_'.$une_session['SESSION_ID']]);
    }
}

$table = array(
    $active => "class=\"active\"",
    "ETUDIANT" => isset($_GET['bfmw_num_e'])?("&amp;e=".$_GET['bfmw_num_e']."#".$_GET['bfmw_num_e']):"",
    "GROUPE" => isset($_GET['bfmw_num_g'])?("&amp;g=".$_GET['bfmw_num_g']):"",
    "GROUPE_PROJET" => isset($_GET['bfmw_num_gp'])?("&amp;gp=".$_GET['bfmw_num_gp']):"",
    "IS_ADMINISTRATIF" => Formations::isSecretaire() || Formations::isResponsable() || Formations::isChef(),
    "IS_ADMIN" => isAdmin(),
    "ANNEE_COURANTE" => $annee_courante
);

$_SESSION['ANNEE_COURANTE'] = $annee_courante;

affectToXHTML($template, $table);

generateCompleteXHTML($template, "menu");
