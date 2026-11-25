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

setAttachment($template, "suivi", "suivi.html");

$annee_courante = Annees::getIdAnneeCourante();
$les_annees = Annees::getAnneeNonClose();
if ((Formations::isResponsable() || Formations::isSecretaire())) {
    $les_annees = Annees::getAnnee();
    if (isset($_GET['bfmw_orig_a'])) {
        $annee_courante = $_GET['bfmw_num_a'];
    }
}

if (isset($_GET['bfmw_orig_a'])) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annees,new Comparateur("ANNEE_ID",$annee_courante));

$les_formations_autorisees = Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante);

/**
 * Affichage des groupes
 */
$req = "SELECT * FROM etudiants_groupes,common_formation WHERE FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ENS_ID='" . CURRENT_ID . "' GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
if (Formations::isSecretaire() || Formations::isResponsable()) {
    $req = "SELECT * FROM etudiants_groupes,common_formation WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FORM_ID IN (".implode(",",array_keys($les_formations_autorisees)).") AND FORM_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";

}
$res = $conn->query($req);
$i = 0;
$groupe_valide = -1;
$formation_valide = -1;
$fail = true;
$formation_en_cours = -1;
while ($groupe = $res->fetch_assoc()) {
    if (++$i == 1) {
        $groupe_valide = $groupe['GROUPE_ID'];
        $formation_valide = $groupe["FORM_ID"];
        if (!isset($_GET['bfmw_orig_g'])) {
            $_GET['bfmw_orig_g'] = $groupe['GROUPE_ID'];
            $_GET['bfmw_num_g'] = get_numeric($groupe['GROUPE_ID']);
        }
    }
    if ($_GET['bfmw_orig_g'] == $groupe['GROUPE_ID']) {
        $groupe["SELECTED"] = "selected=\"selected\"";
        $formation_valide = $groupe["FORM_ID"];
        $fail = false;
    } else {
        $groupe["SELECTED"] = "";
    }

    if ($formation_en_cours != $groupe['FORM_ID']) {
        $formation_en_cours = $groupe['FORM_ID'];
        affectToBloc($template,"une_formation",$groupe);
    }

    affectToBloc($template, "une_formation.un_groupe", $groupe);
}

if ($fail) {
    $_GET['bfmw_orig_g'] = $groupe_valide;
}

/**
 * Affichage des étudiants
 */
$req = "SELECT DISTINCT ET_NOM,ET_ID, ET_NUMERO FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=" . (isset($_GET['bfmw_orig_g']) && is_numeric($_GET['bfmw_orig_g']) ? $_GET['bfmw_orig_g'] : "GROUPE_ID") . " ORDER BY ET_NOM";
$res = $conn->query($req);
while ($etudiant = $res->fetch_assoc()) {
    $etudiant["SELECTED"] = ((isset($_GET['bfmw_num_e']) && $etudiant["ET_ID"]==$_GET['bfmw_num_e'])?"jaune_force":"");
    affectToBloc($template, "un_etudiant", $etudiant);
}

$table = array(
    "GROUPE" => $_GET['bfmw_orig_g'],
    "ANNEE_ID" => $annee_courante,
    "ETUDIANT_ID" => isset($_GET['bfmw_orig_e']) ? $_GET['bfmw_orig_e'] : ""
);

affectToXHTML($template, $table);

/**
 * Detail
 */
if (isset($_GET['bfmw_orig_e'])) {
    $req = "SELECT * FROM etudiants_groupes WHERE ET_ID=".$_GET['bfmw_num_e']."  GROUP BY ET_ID";
    $res = $conn->query($req);
    while ($un_etudiant = $res->fetch_assoc()) {
        openBloc($template, "show");
        affectToXHTML($template,$un_etudiant);
    }

    $req = "SELECT * FROM common_suivi,common_enseignant WHERE ENS_ID=SUIVI_ENS_ID AND SUIVI_ET_ID=".$_GET['bfmw_num_e']." ORDER BY SUIVI_DATE DESC";
    $res = $conn->query($req);
    while ($un_suivi = $res->fetch_assoc()) {
        $un_suivi["DATE_SUIVI"] = date("j/m/Y",$un_suivi['SUIVI_DATE']);
        $un_suivi['AUTEUR'] = $un_suivi['SUIVI_ENS_ID'] == CURRENT_ID;
        $un_suivi['SUIVI_MESSAGE'] = nl2br($un_suivi['SUIVI_MESSAGE']);
        affectToBloc($template,"show.un_suivi",$un_suivi);
    }

}

generateCompleteXHTML($template, "suivi");
