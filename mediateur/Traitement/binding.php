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

if (isset($_POST['bfmw_orig_sign'])) {
    Signatures::enregistrerSignature($_POST['bfmw_num_sign'],$_POST['bfmw_num_u'],$_POST['bfmw_orig_c'],$_POST['bfmw_orig_g'],$_POST['bfmw_orig_b'],$_POST['bfmw_num_m']);
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    switch ($_POST['bfmw_orig_type']) {
        case "sdfkjhze83475zsdf" :
            $req = "UPDATE common_absences_v2 SET ABS_EXCUSE='".$_POST['bfmw_orig_valeur']."' WHERE ABS_ID=".$_POST['bfmw_num_where'];
            break;
        case "skqdjghcgbksqdjbhgkqs" :
            if (Notes::modifierNote($_POST['bfmw_orig_valeur'],$_POST['bfmw_num_where']) == 1) {
                echo "OK";
            }
            exit();
        case "sdfsljghnsdf" :
            switch ($_POST['bfmw_orig_tag']) {
                case "EDT_FACTURE" :
                    if ($_POST['bfmw_num_valeur'] != 1) {
                        $req = "INSERT INTO common_backup_ade_enseignant_nonfacture(NONFACTURE_EDT_UID) VALUES('".$_POST['bfmw_orig_where']."')";
                    } else {
                        $req = "DELETE FROM common_backup_ade_enseignant_nonfacture WHERE NONFACTURE_EDT_UID='".$_POST['bfmw_orig_where']."'";
                    }
                    break;
            }
            break;
        default : exit();
    }

    if ($conn->query($req) == 1) {
        echo "OK";
    }

    exit();
}