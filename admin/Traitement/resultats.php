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

setAttachment($template, "resultats", "resultats.html");

$annee_courante = Annees::getIdAnneeCourante();

$diplome_en_cours = -1;
if (isset($_GET['bfmw_num_d'])) {
    $diplome_en_cours = $_GET['bfmw_num_d'];
}

$diplome_en_cours = affectToBlocAndRepeat($template,"un_diplome_filtre",Resultats::getDiplomes(CURRENT_DEPT_ID),new Comparateur("DIPLOME_ID",$diplome_en_cours));

if ($diplome_en_cours != -1) {
    $regroupement_done = array();
    affectToBlocAndRepeat($template,"un_diplome.un_niveau.un_regroupement.une_ue",Resultats::getDiplome($diplome_en_cours),null,array(
        "un_diplome" => array(-1,"DIPLOME_ID"),
        "un_diplome.un_niveau" => array(-1,"NIVEAU_ID"),
        "un_diplome.un_niveau.un_regroupement" => array(-1,"REGROUP_ID_1")
    ),function($une_ligne) {
        global $template;
        global $annee_courante;
        global $formation_done;
        affectToBloc($template,"un_diplome.un_niveau.un_regroupement.une_ue",$une_ligne);
        if (! isset($formation_done[$une_ligne["REGROUP_ID_1"]])) {
            $formation_done[$une_ligne["REGROUP_ID_1"]] = true;
            if ($une_ligne["NIVEAU_FORM_ID"] != "") {
                affectToBlocAndRepeat($template, "un_diplome.un_niveau.un_regroupement.un_semestre.une_ue2", Formations::getUEDeLaFormation($une_ligne["NIVEAU_FORM_ID"], $annee_courante), null, array(
                    "un_diplome.un_niveau.un_regroupement.un_semestre" => array(-1, "SEM_ID")
                ));
            }
        }
    });
}

$tampon = -1;
affectToXHTML($template,array(
    "DIPLOME_COURANT" => $diplome_en_cours,
    "FORMATIONS_DU_DEPARTEMENT" => Components::generateOptions(Formations::getFormationsDuConnecte(CURRENT_DEPT_ID),"FORM_ID","FORM_NOM",$tampon,new Comparateur("FORM_ID",-1)),
    "REGROUPEMENTS" => Components::generateOptions(Resultats::getRegroupements($diplome_en_cours),"REGROUP_ID","REGROUP_NOM",$tampon,new Comparateur("REGROUP_ID",-1))
));

generateCompleteXHTML($template, "resultats");
