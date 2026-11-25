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

if (isset($_GET['bfmw_orig_count']) && $_GET['bfmw_orig_count']=="disponibilites" && isset($_POST['bfmw_orig_s'])) {
    $total = Plannings::getQuotaEnseignants(CURRENT_ID,$_POST['bfmw_num_s']);
    if (count($total) == 0) {
        echo 0;
    }
    foreach ($total as $une_ligne) {
        echo $une_ligne["PLANNING_SOUT_MAX"] - $une_ligne["PLANNING_SOUT_FAITES"];
    }
    echo "$";
    $total = Plannings::getNombreCreneauxReels(CURRENT_ID,$_POST['bfmw_num_s']);
    echo $total;
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $validation = false;
    switch ($_POST['bfmw_orig_type']) {
        case "iserytfbzoerudtyzpbncfyozhrbt" :
            $validation = Plannings::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        default : exit();
    }

    if ($validation) {
        echo "OK";
    }

    exit();
}

