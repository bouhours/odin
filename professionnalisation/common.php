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

define ('PATTERN_SIGNATURE', "/^qskhjbgkjhQZLHFGBQlqsdhgbqdnlqfhsdgfbzzaoefhq$/");
define('CURRENT_VERSION', "0.0");

if (CURRENT_USE != '') {
    $req = "SELECT * FROM pro_access_enseignants WHERE ENS_LOGIN='" . CURRENT_USE . "'";
    $res = $conn->query($req);

    if ($tab = $res->fetch_assoc()) {
        $_SESSION['pro_nom'] = $tab["ENS_NOM"];
        define('CURRENT_ID', $tab["ENS_ID"]);
        define('CURRENT_DEPT', $tab['DEPT_CODE']);
        define('CURRENT_DEPT_ID', $tab['ACCESS_DEPT_ID']);
        define('IS_ENSEIGNANT', true);
        define('IS_ETUDIANT', false);
    } else {
        unset($_SESSION['pro_nom']);
        define('IS_ENSEIGNANT', false);
    }

    if (!IS_ENSEIGNANT) {
        $req = "SELECT * FROM pro_access_etudiants WHERE ET_LOGIN='" . CURRENT_USE . "'";
        $res = $conn->query($req);

        if ($tab = $res->fetch_assoc()) {
            $_SESSION['pro_nom'] = $tab["ET_NOM"];
            define('CURRENT_DEPT', '');
            define('CURRENT_DEPT_ID', -1);
            define('CURRENT_ID', $tab["ET_ID"]);
            define('IS_ETUDIANT', true);
        } else {
            unset($_SESSION['pro_nom']);
            define('CURRENT_ID', 0);
            die("Accès non autorisé");
        }
    }
}

/*function generateAbsencePro($annee_courante,$edt_uid,$groupe_id, $ens_id): bool
{
    global $conn;

    $req = "SELECT * FROM common_backup_ade_etudiant,etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID=EDT_GROUPE_ID AND EDT_UID='$edt_uid' AND GROUPE_ID=$groupe_id AND ET_ID NOT IN (SELECT SIGNATURE_ET_ID FROM common_pro_signatures WHERE SIGNATURE_GROUPE_ID=$groupe_id AND SIGNATURE_EDT_UID='$edt_uid' AND SIGNATURE_ENS_ID IS NULL)";
    $res = $conn->query($req);
    $fail = false;
    while ($une_absence = $res->fetch_assoc()) {
        $toinsert['*ABS_ENS_ID'] = $ens_id;
        $toinsert['*ABS_ET_ID'] = $une_absence['ET_ID'];
        $toinsert['*ABS_EDT_UID'] = $edt_uid;
        $toinsert['*ABS_DATE'] = date('d/m/Y', $une_absence['EDT_DATE_DEBUT']);
        $toinsert['*ABS_JUSTIFICATION '] = 'non';
        $toinsert['*ABS_MAIL'] = 0;
        $toinsert['*ABS_REAL_DATE'] = $une_absence['EDT_DATE_DEBUT'];
        $toinsert['*ABS_EXPIRE'] = 0;
        $toinsert['*ABS_ANNEE_ID'] = $annee_courante;
        $data = array($toinsert);
        manual_bfmw_secure($data);
        $id = createData("common_absences_v2", $data[0], 9);
        if ($id <= 0) {
            $fail = true;
        }
        Absences::autojustification_uid($une_absence['ET_ID']);
    }
    return $fail;
}*/