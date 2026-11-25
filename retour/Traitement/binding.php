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


if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $req = "";
    $validation = false;
    switch ($_POST['bfmw_orig_type']) {
        case "qsdfhkbqsdfqsd" :
            $validation = Groupes::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;
        case "qsdfsfherfthbdfg" :
            $validation = Formations::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            break;

    }

    if ($validation) {
        echo "OK";
    } else {
        echo "KO";
    }

    exit();
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    switch ($_POST['bfmw_orig_type']) {
        case "qqsdflkjhgqsfd" :
            break;
        case "qsdfhkbqsdfqsd" :
            $where = explode("$",$_POST['bfmw_orig_where']);
            if ($_POST['bfmw_num_valeur'] == 1) {
                $req = "UPDATE common_enseignants_matieres SET ENS_MAT_EVALUABLE=".$_POST['bfmw_num_valeur']." WHERE ID=".$_POST['bfmw_num_where']." AND MAT_ENS_ID=".CURRENT_ID;
                $req = "INSERT INTO common_eval_groupe_enseignement(GROUPE_ID_ID, ID_GROUPE_ID) VALUES (".$where[1].",".$where[0].")";
            } else {
                $req = "DELETE FROM common_eval_groupe_enseignement WHERE GROUPE_ID_ID=".$where[1]." AND ID_GROUPE_ID=".$where[0];
            }
            break;
        default :
            exit();
    }

    if ($conn->query($req) == 1) {
        echo "OK";
    }

    exit();
}
