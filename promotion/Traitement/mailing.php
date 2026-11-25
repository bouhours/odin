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

$annee_courante = $_GET['bfmw_num_a']??Annees::getIdAnneeCourante();

setAttachment($template, "mailing", "mailing.html");

$les_annees = Annees::getAnneeNonClose();
$annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annees,new Comparateur("ANNEE_ID",$annee_courante));

/**
 * Groupes
 */
if (isset($_GET['bfmw_orig_e'])) {
    $req = "SELECT * FROM etudiants_groupes WHERE GROUPE_DELETED=0 AND ET_GROUPE_ANNEE_ID=$annee_courante AND ET_ID=".$_GET['bfmw_num_e'];
    $res = $conn->query($req);
    if ($res->num_rows != 0) {
        $etu = $res->fetch_assoc();
        affectToXHTML($template,$etu);
    } else {
        unset($_GET['bfmw_orig_e']);
    }
}
if (! isset($_GET['bfmw_orig_e'])) {
    $req = "SELECT * FROM common_groupes,common_formation WHERE GROUPE_DELETED=0 AND FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
    $res = $conn->query($req);
    $formation_courante = -1;
    while ($un_groupe = $res->fetch_assoc()) {
        if ($formation_courante != $un_groupe['FORM_ID']) {
            $formation_courante = $un_groupe['FORM_ID'];
            affectToBloc($template, "une_formation", $un_groupe);
        }
        if (isset($_GET['bfmw_orig_choix_groupe']) && $_GET['bfmw_orig_choix_groupe'] == $un_groupe['GROUPE_ID']) {
            $un_groupe['SELECTED'] = "selected";
        } else {
            $un_groupe['SELECTED'] = "";
        }
        affectToBloc($template, "une_formation.un_groupe", $un_groupe);
    }
}

affectToXHTML($template,array(
    "SUJET_MAIL" => isset($_GET['bfmw_orig_sujet_mail'])?$_GET['bfmw_orig_sujet_mail']:"",
    "MESSAGE" => isset($_GET['bfmw_orig_message'])?$_GET['bfmw_orig_message']:"",
    "MAXI" => ini_get('post_max_size'),
    "SIMPLE" => isset($_GET['bfmw_orig_e']),
    "AFFICHER_ANNEE" => count($les_annees) > 1,
    "ANNEE_COURANTE" => $annee_courante
));

generateCompleteXHTML($template, "mailing");