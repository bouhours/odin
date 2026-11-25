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

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_edt']) && $_POST['bfmw_orig_edt']==="lazy" ){
    require 'edt_lazy.php';
    exit;
}

if (isset($_POST['bfmw_orig_getDoSign'])) {
    if (Signatures::executeSignature($_POST['bfmw_num_getDoSign'],$_POST['bfmw_num_u'],$_POST['bfmw_orig_g'],$_POST['bfmw_orig_b'])) {
        setAttachment($template, "do_sign", "do_sign.html");
        affectToXHTML($template, array(
            "NOM" => $_POST['bfmw_orig_n']
        ));
        generateCompleteXHTML($template, "do_sign");
    }
    exit;
}

if (isset($_POST['bfmw_orig_sign']) && isset($_POST['bfmw_num_u'])) {
    Signatures::enregistrerSignature($_POST['bfmw_num_sign'],$_POST['bfmw_num_u'],$_POST['bfmw_orig_c'],$_POST['bfmw_orig_g'],$_POST['bfmw_orig_b']);
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $req = "";
    switch ($_POST['bfmw_orig_type']) {
        case "jkhkfdc5G76T" :
            $req = "UPDATE etudiants_access_etudiants SET ET_EDT=" . $_POST['bfmw_num_valeur'] . " WHERE ET_ID=" . CURRENT_ID;
            $validation = $conn->query($req) == 1;
            break;
        case "sdfouycqiufcnyqsldjfqhqscd" :
            $req = "DELETE FROM common_poursuite_choix_etudiant WHERE CHOIX_ET_ID=" . CURRENT_ID . " AND CHOIX_PMAT_ID=" . $_POST['bfmw_num_where'] . " AND CHOIX_ANNEE_ID=$annee_courante";
            $conn->query($req);
            $req = "INSERT INTO common_poursuite_choix_etudiant(CHOIX_ET_ID, CHOIX_ENS_ID, CHOIX_ANNEE_ID, CHOIX_PMAT_ID) VALUES(" . CURRENT_ID . "," . $_POST['bfmw_num_valeur'] . ",$annee_courante," . $_POST['bfmw_num_where'] . ")";
            $validation = $conn->query($req) == 1;
            break;
        case "azeoruqsdlfkjhzudd" :
            $validation = Fiches_Renseignements::doBind($_POST['bfmw_orig_tag'], $_POST['bfmw_orig_valeur'], $_POST['bfmw_orig_where'], $_POST['bfmw_num_valeur'], $_POST['bfmw_num_where']);
            break;
        default :
            exit();
    }

    if ($validation) {
        echo "OK";
    } else {
        echo "KO";
    }

    exit();
}

