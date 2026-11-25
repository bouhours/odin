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

    /*if (!Formations::isResponsable() && !Formations::isSecretaire()) {
        if (preg_match(PATTERN_SIGNATURE, $_SERVER['HTTP_USER_AGENT']) !== 1) {
            die("Vous ne pouvez pas signer avec ce support. Utilisez les tablettes ARCHOS.");
        }
    }*/

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
    Signatures::enregistrerSignature($_POST['bfmw_num_sign'],$_POST['bfmw_num_u'],$_POST['bfmw_orig_c'],$_POST['bfmw_orig_g'],$_POST['bfmw_orig_b'],-1);
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    switch ($_POST['bfmw_orig_type']) {
        case "jiluysdflgbtyutrt" :
            $where = explode("$",$_POST['bfmw_orig_where']);
            $where[0] = get_numeric($where[0]);
            $force = isAdmin() && count($where) === 2;
            if ($force) {
                $where[1] = get_numeric($where[1]);
            }
            if ($_POST['bfmw_num_where'] == "") {
                $_POST['bfmw_num_where'] = CURRENT_ID;
            }
            switch ($_POST['bfmw_orig_tag']) {
                case "ET_ORIGINE" :
                case "ET_TEL" :
                case "ET_ADRESSE" :
                case "ET_ADRESSE_2" :
                case "ET_ENTREPRISE" :
                case "ET_ADRESSE_ENTREPRISE" :
                case "ET_DEBUT" :
                case "ET_LIEU" :
                case "ET_INFO_LIEU" :
                case "ET_TUTEUR" :
                case "ET_MAIL_TUTEUR" :
                case "ET_TEL_TUTEUR" :
                    $req = "UPDATE common_etudiant SET ".$_POST['bfmw_orig_tag']."=".($_POST['bfmw_orig_valeur']=='NULL'?"NULL":"'".$_POST['bfmw_orig_valeur']."'")." WHERE ET_ID=".$_POST['bfmw_num_where'];
                    break;
                case "ET_TUTEUR_ENS_ID" :
                    mysql_start_transaction();
                    $tab = explode("$",$_POST['bfmw_orig_where']);
                    $annee_courante = Annees::getIdAnneeCourante();
                    if ($_POST['bfmw_orig_valeur']=='NULL') {
                        if (Stages::desaffecterStageEnAlternance($tab[0],$annee_courante)) {
                            if (Etudiants::setTuteurEnseignant($tab[0],null)) {
                                mysql_commit();
                                echo "OK";
                                exit;
                            }
                        }
                    } else {
                        if (Stages::affecterStageEnAlternance($tab[0], $annee_courante,$tab[1], $_POST['bfmw_num_valeur'])) {
                            if (Etudiants::setTuteurEnseignant($tab[0],$_POST['bfmw_num_valeur'])) {
                                mysql_commit();
                                echo "OK";
                                exit;
                            }
                        }
                    }

                    mysql_rollback();
                    exit;
                case "ET_HEURES_MAX" :
                case "ET_HEURES_FACTUREES" :
                case "ET_PROFESSIONNALISATION" :
                case "ET_MAX_SEMAINE" :
                    $req = "UPDATE common_etudiant SET ".$_POST['bfmw_orig_tag']."=".$_POST['bfmw_num_valeur']." WHERE ET_ID=".$_POST['bfmw_num_where'];
                    break;
            }
            break;
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
        default :
            exit();
    }

    if ($conn->query($req) == 1) {
        echo "OK";
    }

    exit();
}
