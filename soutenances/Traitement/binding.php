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

if (isset($_GET['bfmw_orig_do_detail']) && $_GET['bfmw_orig_do_detail']=="harmonisation" && isset($_POST['bfmw_orig_et']) && isset($_POST['bfmw_orig_f']) && isset($_POST['bfmw_orig_s']) && isset($_POST['bfmw_orig_a'])) {
    setAttachment($template, "detail", "template_detail.html");
    $les_enseignants = Notation_Soutenances::getEnseignantAyantMisUneNote($_POST['bfmw_num_et'],$_POST['bfmw_num_a'],$_POST['bfmw_num_s']);
    $retour = array(-1);
    foreach ($les_enseignants as $un_enseignant) {
        $retour[] = $un_enseignant['ENS_ID'];
    }
    $etudiant = Etudiants::getEtudiant($_POST['bfmw_num_et'],$_POST['bfmw_num_a'])[0];
    affectToBlocAndRepeat($template,"un_enseignant",$les_enseignants);
    affectToBlocAndRepeat($template,"une_destination.une_section.un_critere.un_enseignant", Notation_Soutenances::getEtudiantValorise($_POST['bfmw_num_et'],$_POST['bfmw_num_f'],$_POST['bfmw_num_a'],implode(",",$retour),$_POST['bfmw_num_s']),null,
    array(
        "une_destination" => array(-1,"DEST_ID"),
        "une_destination.une_section" => array(-1,"SECTION_ID"),
        "une_destination.une_section.un_critere" => array(-1,"CRITERE_ID")
    ));
    affectToXHTML($template,array(
        "NB_COLS" => count($les_enseignants)+3,
        "NB_COLS_1" => count($les_enseignants)+2,
        "NOM_ETUDIANT" => $etudiant['ET_NOM'],
        "NUMERO_ETUDIANT" => $etudiant['ET_NUMERO']
    ));
    generateCompleteXHTML($template, "detail");
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $validation = false;
    switch ($_POST['bfmw_orig_type']) {
        case "sdfgunysdofiugnslejkrht" :
        case "sdklfchjcndcf" :
            $validation = Notation_Soutenances::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        default : exit();
    }

    if ($validation) {
        echo "OK";
    } else {
        echo "KO";
    }

    exit();
}

