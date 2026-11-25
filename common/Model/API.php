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

class API extends Connectable
{
    public static function response(int $status,string $status_message,string $data) : void
    {
        header("HTTP/1.1 ".$status);

        echo $status_message;
        echo $data;
    }

    public static function getGroupesAvecEtudiants(string $dept_code, int $annee_courante) : array
    {
        $req = "SELECT GROUPE_ID, GROUPE_NOM, ET_LOGIN, FORM_NOM
                FROM common_etudiant
                         JOIN common_inscription ON (ET_ID = INSCRIPT_ET_ID)
                         JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID)
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_departement ON (DEPT_ID = FORM_DEPT_ID)
                         JOIN common_groupes ON (GROUPE_FORM_ID = FORM_ID)
                         JOIN common_etudiant_groupes ON (ET_ID = GROUPE_ET_ID AND ET_GROUPE_ANNEE_ID = INSCRIPT_ANNEE_ID AND
                                                          ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE, '%') AND GROUPE_FEUILLE = 1)
                WHERE INSCRIPT_ANNEE_ID = $annee_courante
                  AND DEPT_CODE = '$dept_code'
                GROUP BY ET_ID
                ORDER BY GROUPE_NOM, GROUPE_ID,ET_NOM";
        return self::getRequete($req);
    }

    public static function getEnseignantsDuDepartement(string $dept_code) : array
    {
        $req = "SELECT ENS_LOGIN as login, ENS_DEPT_VACATAIRE AS vacataire
                FROM common_enseignant
                    JOIN common_enseignants_departement ON (DEPT_ENS_ID = ENS_ID)
                    JOIN common_departement ON (DEPT_ID = ENS_DEPT_ID)
                WHERE DEPT_CODE = '$dept_code' AND ENS_MAIL <> ''
                ORDER BY ENS_MAIL";
        return self::getRequete($req);
    }

    public static function verifierToken(array $headers) : bool
    {
        $token = $headers["X-Auth-Token"]??-1;
        return ($token == 's8C__V_lqs_zer3_' || $token == 'UfRD5OPsdfeukz_' || $token == 'JIOSH5QSFOUIH65df_' || $token == 'JISDFGJKHERLKNH65df_'  || $_SERVER['SERVER_NAME'] === LOCALHOST);
    }

    public static function getFormations(int $annee_id, string $ens_login) : array
    {
        $req = "SELECT FORM_ID, FORM_NOM
                FROM common_formation
                JOIN common_enseignants_departement ON (ENS_DEPT_ID = FORM_DEPT_ID)
                JOIN common_enseignant ON (ENS_LOGIN = '$ens_login' AND ENS_ID = DEPT_ENS_ID)
                WHERE ENS_DEPT_CURRENT=1 AND 
                      FORM_START_ANNEE_ID <= $annee_id AND 
                      (FORM_END_ANNEE_ID > $annee_id OR FORM_END_ANNEE_ID IS NULL)
                ORDER BY FORM_NOM";
        return self::getRequete($req);
    }

    public static function getGroupes(int $annee_id, int $form_id) : array
    {
        $req = "SELECT DISTINCT GROUPE_NOM, GROUPE_ID
                FROM common_groupes
                JOIN common_etudiant_groupes ON (ET_GROUPE_CODE = GROUPE_CODE AND ET_GROUPE_ANNEE_ID = $annee_id)
                WHERE GROUPE_FORM_ID = $form_id AND 
                      GROUPE_FEUILLE = 1
                ORDER BY GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function getEtudiants(int $annee_id, int $groupe_id) : array
    {
        $req = "SELECT ET_NOM, ET_NUMERO
                FROM common_etudiant
                JOIN common_etudiant_groupes ON (ET_ID = GROUPE_ET_ID AND ET_GROUPE_ANNEE_ID = $annee_id)
                JOIN common_groupes ON (GROUPE_CODE = ET_GROUPE_CODE)
                WHERE GROUPE_ID=$groupe_id
                ORDER BY ET_NOM";
        return self::getRequete($req);
    }

    public static function getEvaluations(int $et_numero, string $ens_login, int $eval_date) : array
    {
        $req = "SELECT EVAL_ID,EVAL_JSON
                FROM common_evaluator
                JOIN common_enseignant ON (EVAL_ENS_ID = ENS_ID)
                JOIN common_etudiant ON (EVAL_ET_ID = ET_ID)
                WHERE ET_NUMERO='$et_numero' AND ENS_LOGIN='$ens_login' AND EVAL_DATE=$eval_date
                ";
        sendMail("cedric.bouhours@uca.fr","REQUETE GET",$req);
        return self::getRequete($req);
    }

    public static function putEvaluations(int $et_numero, string $ens_login, int $eval_date, string $evaluation) : bool
    {
        $req = "INSERT INTO common_evaluator (EVAL_DATE, EVAL_JSON, EVAL_ENS_ID, EVAL_ET_ID)
            SELECT
                '$eval_date',
                '$evaluation',
                ens.ENS_ID,
                et.ET_ID
            FROM common_enseignant ens
            JOIN common_etudiant et
            WHERE ens.ENS_LOGIN = '$ens_login'
              AND et.ET_NUMERO = '$et_numero'
            ON DUPLICATE KEY UPDATE
                EVAL_JSON = VALUES(EVAL_JSON)
        ";
        sendMail("cedric.bouhours@uca.fr","REQUETE PUT",$req);
        return self::execRequete($req);
    }

    public static function getADERessource(string $et_login, int $annee_id) : array
    {
        $req = "SELECT GROUPE_ADE
                FROM common_groupes
                 JOIN common_etudiant_groupes
                              ON (ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE, '%'))
                 JOIN common_etudiant ON (ET_LOGIN = '$et_login' AND GROUPE_ET_ID=ET_ID)
                WHERE ET_GROUPE_ANNEE_ID = $annee_id AND GROUPE_FEUILLE=1";
        return self::getRequete($req);
    }

    public static function getEtudiantFromUniqID(string $uniqdi, int $annee_id) : array
    {
        $req = "SELECT ET_ID, DEPT_CODE
                    FROM common_etudiant_qr
                    JOIN common_etudiant ON (ET_ID = QR_ET_ID)
                    JOIN common_inscription ON (ET_ID = INSCRIPT_ET_ID)
                    JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID)
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                    JOIN common_departement ON (DEPT_ID = FORM_DEPT_ID)
                    WHERE QR_DATA = '$uniqdi'
                      AND QR_ET_QR_TIME IS NOT NULL
                      AND QR_ET_QR_TIME > UNIX_TIMESTAMP(NOW() - INTERVAL 7 DAY)
                      AND INSCRIPT_ANNEE_ID = $annee_id
                    GROUP BY ET_ID";
        return self::getRequete($req);
    }
}
