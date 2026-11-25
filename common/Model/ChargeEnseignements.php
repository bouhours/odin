<?php
/**
 * Auteur : Cédric BOUHOURS
 * Ce code est mis à disposition selon les termes de la Licence Creative Commons Attribution
 * Pas d'Utilisation Commerciale - Pas de Modification $annee_courante.0 International.
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

class ChargeEnseignements extends Connectable
{
    public static function computeChargeEqTDSemestre(int $SEM_ID, int $annee_courante) : float
    {
        if ($annee_courante >= 9) {
            return self::computeChargeEqTDSemestreV2($SEM_ID,$annee_courante);
        }
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL
            FROM common_charge_enseignant,common_enseignants_matieres, common_ue,common_semestre, common_matiere WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=$SEM_ID AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND MAT_ID=ENS_MAT_ID AND ID=CHARGE_AFFECT_ID AND ENS_MAT_ANNEE_ID=$annee_courante";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDSemestreV2(int $SEM_ID, int $annee_courante) : float
    {

        $req = "SELECT SUM(CHARGE_VALEUR * (
                    IF(CHARGE_TYPE = 'CM', 1.5,
                       IF(CHARGE_TYPE = 'DS', 0,
                          IF(CHARGE_TYPE = 'TP',
                             IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                           * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR) AS TOTAL, ANNEE_CLOSE
                FROM common_enseignants_matieres
                         JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL))
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL))
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_enseignants_departement ON (ENS_ID = DEPT_ENS_ID AND ENS_DEPT_ID = FORM_DEPT_ID)
                         JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                WHERE UE_SEM_ID = $SEM_ID
                  AND ENS_MAT_ANNEE_ID = $annee_courante
                  AND MAT_START_ANNEE_ID <= $annee_courante
                  AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDEnseignantDepartement(int $annee_courante, int $ENS_ID, int $DEPT_ID) : float
    {
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL
            FROM common_charge_enseignant,common_enseignants_matieres,common_matiere,common_ue,common_semestre,common_formation
            WHERE UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND FORM_ID=SEM_FORM_ID AND MAT_ENS_ID=$ENS_ID AND MAT_ID=ENS_MAT_ID AND ID=CHARGE_AFFECT_ID AND ENS_MAT_ANNEE_ID=$annee_courante AND FORM_DEPT_ID=$DEPT_ID
              AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDEnseignant(int $annee_courante, int $ENS_ID) : float
    {
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL
            FROM common_charge_enseignant,common_enseignants_matieres,common_matiere
            WHERE MAT_ID=ENS_MAT_ID AND MAT_ENS_ID=$ENS_ID AND ID=CHARGE_AFFECT_ID AND ENS_MAT_ANNEE_ID=$annee_courante AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDSemestreEnseignant(int $SEM_ID, int $annee_courante, int $ENS_ID) : float
    {
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL
            FROM common_charge_enseignant,common_enseignants_matieres, common_ue,common_semestre, common_matiere WHERE MAT_ENS_ID=$ENS_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=$SEM_ID AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND MAT_ID=ENS_MAT_ID AND ID=CHARGE_AFFECT_ID AND ENS_MAT_ANNEE_ID=$annee_courante";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDMatiereEnseignant(int $annee_courante, int $ENS_ID, int $MAT_ID) : float
    {

        if ($annee_courante >= 9) {
            return self::computeChargeEqTDMatiereEnseignantV2($annee_courante,$ENS_ID,$MAT_ID);
        }
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL
            FROM common_matiere,common_enseignants_matieres left join common_charge_enseignant ON (ID=CHARGE_AFFECT_ID)
            WHERE MAT_ID=ENS_MAT_ID AND ENS_MAT_ID=$MAT_ID AND MAT_ENS_ID=$ENS_ID  AND ENS_MAT_ANNEE_ID=$annee_courante
                AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)
            ";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDMatiereEnseignantV2(int $annee_courante, ?int $ENS_ID, int $MAT_ID) : float
    {
        if ($ENS_ID == null) {
            $complement = "";
            $group = "";
        } else {
            $complement = "AND ENS_ID = $ENS_ID";
            $group = "MAT_ENS_ID,";
        }

        $req = "SELECT SUM(CHARGE_VALEUR * (
                    IF(CHARGE_TYPE = 'CM', 1.5,
                       IF(CHARGE_TYPE = 'DS', 0,
                          IF(CHARGE_TYPE = 'TP',
                             IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                           * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR) AS TOTAL, MAT_ENS_ID,MAT_ID, ANNEE_CLOSE
                FROM common_enseignants_matieres
                    LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                    JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                     JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                     JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL))
                     JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL))
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                    JOIN common_enseignants_departement ON (ENS_ID = DEPT_ENS_ID AND ENS_DEPT_ID = FORM_DEPT_ID)
                    JOIN common_annee ON (ANNEE_ID= ENS_MAT_ANNEE_ID)
                WHERE MAT_ID = $MAT_ID $complement
                  AND ENS_MAT_ANNEE_ID = $annee_courante
                  AND MAT_START_ANNEE_ID <= $annee_courante
                  AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)
                GROUP BY $group MAT_ID";

        $res = self::$conn->query($req);
        if ($total = $res->fetch_assoc()) {
            return $total['TOTAL']==null?0:$total['TOTAL'];
        }

        return 0;
    }

    public static function computeChargeEqTDPeriode(int $annee_courante, int $periode_id) : array
    {
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL,MAT_ENS_ID
            FROM (common_periodes_matieres,common_enseignants_matieres,common_matiere)
                left join common_charge_enseignant ON (ID=CHARGE_AFFECT_ID)
            WHERE MAT_ID=PERIODE_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND PERIODE_MAT_ID=ENS_MAT_ID AND MAT_PERIODE_ID=$periode_id AND ENS_MAT_ANNEE_ID=$annee_courante GROUP BY MAT_ENS_ID";

        $res = self::$conn->query($req);
        $retour =array();
        while ($total = $res->fetch_assoc()) {
            $retour[$total['MAT_ENS_ID']]=$total['TOTAL'];
        }

        return $retour;
    }

    public static function computeChargeEqTDSemestreMultiple(int $SEM_ID, int $annee_courante) : array
    {
        if ($annee_courante >= 9) {
            return self::computeChargeEqTDSemestreMultipleV2($SEM_ID,$annee_courante);
        }
        $retour = array();
        $req = "SELECT 
            SUM(IFNULL(`CHARGE_CM`,0)*IFNULL(`CHARGE_SEMAINES_CM`,0)*IFNULL(`CHARGE_MULT_CM`,1)*IFNULL(`CHARGE_GROUPES_CM`,1)*1.5+
            IFNULL(`CHARGE_TD`,0)*IFNULL(`CHARGE_SEMAINES_TD`,0)*IFNULL(`CHARGE_MULT_TD`,1)*IFNULL(`CHARGE_GROUPES_TD`,1)+
            IFNULL(`CHARGE_TDR`,0)*IFNULL(`CHARGE_SEMAINES_TDR`,0)*IFNULL(`CHARGE_MULT_TDR`,1)*IFNULL(`CHARGE_GROUPES_TDR`,1)+
            IFNULL(`CHARGE_TP`,0)*IFNULL(`CHARGE_SEMAINES_TP`,0)*IFNULL(`CHARGE_MULT_TP`,1)*IFNULL(`CHARGE_GROUPES_TP`,1)+
            IFNULL(`CHARGE_DS`,0)*IFNULL(`CHARGE_SEMAINES_DS`,0)*IFNULL(`CHARGE_MULT_DS`,1)*IFNULL(`CHARGE_GROUPES_DS`,1)+
            IFNULL(`CHARGE_TPR`,0)*IFNULL(`CHARGE_SEMAINES_TPR`,0)*IFNULL(`CHARGE_MULT_TPR`,1)*IFNULL(`CHARGE_GROUPES_TPR`,1)*(0.85)+
            IFNULL(`CHARGE_TPV`,0)*IFNULL(`CHARGE_SEMAINES_TPV`,0)*IFNULL(`CHARGE_MULT_TPV`,1)*IFNULL(`CHARGE_GROUPES_TPV`,1)*(2/3)) AS TOTAL, MAT_ENS_ID,MAT_ID
            FROM (common_enseignants_matieres, common_ue,common_semestre, common_matiere) left join common_charge_enseignant on (ID=CHARGE_AFFECT_ID) WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=$SEM_ID AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND MAT_ID=ENS_MAT_ID AND ENS_MAT_ANNEE_ID=$annee_courante GROUP BY MAT_ENS_ID,MAT_ID";

        $res = self::$conn->query($req);
        while ($total = $res->fetch_assoc()) {
           $retour[]=array(
               "ENS_ID" => $total['MAT_ENS_ID'],
               "MAT_ID" => $total['MAT_ID'],
               "TOTAL" => $total['TOTAL']
           );
        }

        return $retour;
    }

    public static function computeChargeEqTDSemestreMultipleV2(int $SEM_ID, int $annee_courante) : array
    {
        $retour = array();
        $req = "SELECT SUM(CHARGE_VALEUR * (
                    IF(CHARGE_TYPE = 'CM', 1.5,
                       IF(CHARGE_TYPE = 'DS', 0,
                          IF(CHARGE_TYPE = 'TP',
                             IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                           * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR) AS TOTAL, MAT_ENS_ID,MAT_ID, ANNEE_CLOSE
                FROM common_enseignants_matieres
                    LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                    JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                     JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                     JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL))
                     JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL))
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                    JOIN common_enseignants_departement ON (ENS_ID = DEPT_ENS_ID AND ENS_DEPT_ID = FORM_DEPT_ID)
                    JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                WHERE UE_SEM_ID = $SEM_ID
                  AND ENS_MAT_ANNEE_ID = $annee_courante
                  AND MAT_START_ANNEE_ID <= $annee_courante
                  AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)
                GROUP BY MAT_ENS_ID,MAT_ID";

        $res = self::$conn->query($req);
        while ($total = $res->fetch_assoc()) {
            $retour[]=array(
                "ENS_ID" => $total['MAT_ENS_ID'],
                "MAT_ID" => $total['MAT_ID'],
                "TOTAL" => $total['TOTAL']
            );
        }

        return $retour;
    }

    public static function computeChargeEqTDDetail(int $annee_courante, int $dept_id, int $vacataire=1) : array
    {
        $retour = array();
        $req = "SELECT ENS_ID,
                       FORM_ID,
                       SEM_ID,
                       UE_ID,
                       MAT_ID,
                       MAT_CODE_APOGE,
                       MAT_SURMAT_ID,
                       ENS_NOM,
                       FORM_NOM,
                       UE_NOM,
                       MAT_NOM,
                       SEM_NOM,
                       REEL_ID,
                       REEL_CM,
                       REEL_TD,
                       REEL_TP,
                       ENS_ADE,
                       CHARGE_AFFECTATION_ID,
                       ROUND(CHARGE_VALEUR * CHARGE_MULTIPLICATEUR * CHARGE_GROUPE, 2) AS CHARGE_TOTALE,
                       CHARGE_TYPE,
                       DATE_FORMAT(FROM_UNIXTIME(CHARGE_PAYEE), '%d/%m/%Y')            AS DATE_PAYEE,
                       (SELECT ROUND(SUM(CHARGE_VALEUR * (
                           IF(CHARGE_TYPE = 'CM', 1.5,
                              IF(CHARGE_TYPE = 'DS', 0,
                                 IF(CHARGE_TYPE = 'TP',
                                    IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                       IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                           * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR), 2)
                        FROM common_charge_v2
                                 JOIN common_enseignants_matieres ON (ID = CHARGE_AFFECTATION_ID AND ENS_MAT_ANNEE_ID = $annee_courante)
                        WHERE ENS_MAT_ID = MAT_ID
                          AND MAT_ENS_ID = ENS_ID)
                                                                                       AS TOTAL_MATIERE,
                       (SELECT ROUND(SUM(CHARGE_VALEUR * (
                           IF(CHARGE_TYPE = 'CM', 1.5,
                              IF(CHARGE_TYPE = 'DS', 0,
                                 IF(CHARGE_TYPE = 'TP',
                                    IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                       IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                           * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR), 2)
                        FROM common_charge_v2
                                 JOIN common_enseignants_matieres ON (ID = CHARGE_AFFECTATION_ID AND ENS_MAT_ANNEE_ID = $annee_courante)
                                 JOIN common_matiere ON (MAT_ID = ENS_MAT_ID)
                                 JOIN common_ue ON (UE_ID = MAT_UE_ID)
                                 JOIN common_semestre ON (SEM_ID = UE_SEM_ID)
                                 JOIN common_formation ON (FORM_ID = SEM_FORM_ID AND FORM_DEPT_ID = $dept_id)
                        WHERE MAT_ENS_ID = ENS_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                                                                                       AS TOTAL_ANNEE
                FROM common_formation
                         JOIN common_semestre ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_ue ON (SEM_ID = UE_SEM_ID)
                         JOIN common_matiere ON (UE_ID = MAT_UE_ID AND MAT_HAS_NOTE = 1 AND MAT_START_ANNEE_ID <= $annee_courante
                    AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_enseignants_matieres ON (MAT_ID = ENS_MAT_ID AND ENS_MAT_ANNEE_ID = $annee_courante)
                         JOIN common_enseignants_departement
                              ON (MAT_ENS_ID = DEPT_ENS_ID AND ENS_DEPT_ID = FORM_DEPT_ID AND ENS_DEPT_VACATAIRE = $vacataire)
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         LEFT JOIN common_periodes_matieres ON (MAT_ID = PERIODE_MAT_ID)
                         LEFT JOIN common_edt_periode ON (PERIODE_ID = MAT_PERIODE_ID)
                         LEFT JOIN common_charge_v2 on (ID = CHARGE_AFFECTATION_ID)
                         LEFT JOIN common_reel_enseignant on (ID = common_reel_enseignant.REEL_ID)
                WHERE FORM_DEPT_ID = $dept_id
                GROUP BY CHARGE_ID
                ORDER BY ENS_NOM, ENS_ID, FORM_NOM, FORM_ID, SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID, MAT_ORDRE, MAT_ID";

        $res = self::$conn->query($req);
        while ($total = $res->fetch_assoc()) {
            if ($total["MAT_CODE_APOGE"] == "") {
                $total["MAT_CODE_APOGE"] = self::chercherCodeApoge($total["MAT_SURMAT_ID"]);
            }
            $retour[]=$total;
        }

        return $retour;
    }

    public static function computeChargeEqTDDetailParMatiere(int $annee_courante, int $dept_id, int $vacataire=1, ?int $ens_id=null) : array
    {
        $retour = array();
        $where = ($ens_id == null) ? "" : "WHERE ENS_ID=$ens_id";
        $req = "SELECT ENS_NOM, ENS_ID, ENS_NAISSANCE, FORM_NOM_COURT, UE_CODE_APOGEE, MAT_CODE_APOGE, MAT_NOM, PERIODE_PAIEMENT,
                       SUM(IF(CHARGE_TYPE='CM',CHARGE_VALEUR*CHARGE_MULTIPLICATEUR*CHARGE_GROUPE,0)) AS TOTAL_CM,
                       SUM(IF(CHARGE_TYPE='TD',CHARGE_VALEUR*CHARGE_MULTIPLICATEUR*CHARGE_GROUPE,0)) AS TOTAL_TD, 
                       SUM(IF(CHARGE_TYPE='TP',CHARGE_VALEUR*CHARGE_MULTIPLICATEUR*CHARGE_GROUPE,0)) AS TOTAL_TP,
                       REEL_CM, REEL_TP, REEL_TD, MAT_SURMAT_ID 

                FROM common_charge_v2
                    JOIN common_enseignants_matieres ON (ID=CHARGE_AFFECTATION_ID AND ENS_MAT_ANNEE_ID = $annee_courante)
                     JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                     JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL))
                     JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL))
                    JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                    JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                    JOIN common_enseignants_departement ON (MAT_ENS_ID = DEPT_ENS_ID AND ENS_DEPT_ID = $dept_id AND ENS_DEPT_VACATAIRE=$vacataire) 
                    LEFT JOIN common_reel_enseignant on (ID = common_reel_enseignant.REEL_ID)
                    LEFT JOIN common_periodes_matieres ON (MAT_ID = PERIODE_MAT_ID)
                    LEFT JOIN common_edt_periode ON (PERIODE_ID = MAT_PERIODE_ID)
                $where
                GROUP BY MAT_ENS_ID,ENS_MAT_ID
                ORDER BY ENS_NOM, ENS_ID";

        $res = self::$conn->query($req);
        while ($total = $res->fetch_assoc()) {
            if ($total["MAT_CODE_APOGE"] == "") {
                $total["MAT_CODE_APOGE"] = self::chercherCodeApoge($total["MAT_SURMAT_ID"]);
            }
            $retour[$total["ENS_ID"]][]=$total;
        }

        return $retour;
    }

    public static function computeChargeEqTDEnseignantDetailV2(int $annee_courante, int $ens_id, int $dept_id = -1) : array
    {
        $retour = array();
        $departement = "";
        if ($dept_id != -1) {
            $departement = "FORM_DEPT_ID=$dept_id AND";
        }
        $req = "SELECT FORM_ID,
                       FORM_NOM,
                       UE_ID,
                       UE_NOM,
                       SEM_ID,
                       SEM_NOM,
                       MAT_ID,
                       MAT_NOM,
                       MAT_CODE_APOGE,
                       MAT_SURMAT_ID,
                       ROUND(CHARGE_VALEUR*CHARGE_MULTIPLICATEUR*CHARGE_GROUPE,2) AS CHARGE_MULTIPLIEE,
                       CHARGE_TYPE,
                       DATE_FORMAT(FROM_UNIXTIME(CHARGE_PAYEE),'%d/%m/%Y') AS DATE_PAYEE,
                       ROUND(SUM(CHARGE_VALEUR * (
                           IF(CHARGE_TYPE = 'CM', 1.5,
                              IF(CHARGE_TYPE = 'DS', 0,
                                 IF(CHARGE_TYPE = 'TP',
                                    IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                       IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                           * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR),2) AS CHARGE_EQTD, ANNEE_CLOSE
                FROM common_enseignants_matieres
                         LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL))
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL))
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_enseignants_departement ON (ENS_ID = DEPT_ENS_ID AND ENS_DEPT_ID = FORM_DEPT_ID)
                         JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                WHERE $departement ENS_ID = $ens_id
                  AND ENS_MAT_ANNEE_ID = $annee_courante
                GROUP BY CHARGE_ID,MAT_ID
                ORDER BY FORM_ID, FORM_NOM, SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID, MAT_ORDRE, MAT_ID, CHARGE_TYPE";

        $charge = self::getRequete($req);
        $matiere_courante = -1;
        $semestre_courant = -1;
        $calcul_sem = 0;
        $calcul_mat = 0;
        $calcul_annee = 0;
        foreach ($charge as $un_total) {
            if ($semestre_courant != $un_total["SEM_ID"]) {
                $semestre_courant = $un_total["SEM_ID"];
                unset($calcul_sem);
                $calcul_sem = 0;
            }
            if ($matiere_courante != $un_total["MAT_ID"]) {
                $matiere_courante = $un_total["MAT_ID"];
                unset($calcul_mat);
                $calcul_mat = 0;
            }
            if ($un_total["MAT_CODE_APOGE"] == "") {
                $un_total["MAT_CODE_APOGE"] = self::chercherCodeApoge($un_total["MAT_SURMAT_ID"]);
            }
            $calcul_mat += $un_total["CHARGE_EQTD"];
            $calcul_sem += $un_total["CHARGE_EQTD"];
            $calcul_annee += $un_total["CHARGE_EQTD"];
            $un_total["TOTAL"] = &$calcul_mat;
            $un_total["TOTAL_SEMESTRE"] = &$calcul_sem;
            $un_total["TOTAL_ANNEE"] = $calcul_annee;
            $retour[]=$un_total;
        }

        return $retour;
    }

    public static function getChargeEnseignant(int $MAT_ID, int $annee_courante) : array
    {
        $req = "SELECT * FROM (common_enseignants_matieres,common_enseignant) LEFT JOIN common_charge_enseignant ON (ID=CHARGE_AFFECT_ID) WHERE ENS_ID=MAT_ENS_ID AND ENS_MAT_ID=$MAT_ID AND ENS_MAT_ANNEE_ID=$annee_courante ORDER BY ENS_NOM";
        return self::getRequete($req);
    }

    public static function getAffectationEnseignants(int $MAT_ID, int $annee_courante) : array
    {
        $req = "SELECT *
                FROM (common_enseignants_matieres,common_enseignant)
                WHERE ENS_ID = MAT_ENS_ID
                  AND ENS_MAT_ID = $MAT_ID
                  AND ENS_MAT_ANNEE_ID = $annee_courante
                ORDER BY ENS_NOM";
        return self::getRequete($req);
    }

    public static function getChargeEnseignantDeLaFormation(string $formations_autorisees, int $annee_courante, int $DEPT_ID) : mysqli_result
    {
        $req = "select MAT_NOM, MAT_ID,UE_NOM, UE_ID,SEM_NOM,SEM_ID,FORM_NOM,FORM_ID,ENS_NOM,PERIODE_ID,PERIODE_NOM,PERIODE_TYPE,common_charge_enseignant.* from (common_matiere,common_ue,common_semestre,common_formation, common_enseignants_matieres, common_enseignant, common_periodes_matieres, common_edt_periode) left join common_charge_enseignant ON (ID=CHARGE_AFFECT_ID) WHERE FORM_ID IN ($formations_autorisees) AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND UE_ID = MAT_UE_ID AND SEM_ID = UE_SEM_ID AND FORM_ID = SEM_FORM_ID AND MAT_ID = ENS_MAT_ID AND ENS_ID = MAT_ENS_ID AND MAT_ID=PERIODE_MAT_ID AND PERIODE_ID=MAT_PERIODE_ID AND ENS_MAT_ANNEE_ID=$annee_courante AND FORM_DEPT_ID=$DEPT_ID ORDER BY PERIODE_NOM,FORM_NOM,SEM_NOM,UE_NOM,MAT_NOM,ENS_NOM";
        return self::doRequete($req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        if ($tag == "delete_mise_en_paiement") {
            $req = "DELETE FROM common_reel_enseignant WHERE REEL_ID=$wherenum";
            return self::execRequete($req);
        } else {
            $infos = explode("$", $where);
            switch ($tag) {
                case "CHECK" :
                    $req = "UPDATE common_enseignants_matieres SET ENS_MAT_NOTEUR=" . $valeurnum . " WHERE MAT_ENS_ID=" . get_numeric($infos[1]) . " AND ENS_MAT_ID=" . get_numeric($infos[0]) . " AND ENS_MAT_ANNEE_ID=" . get_numeric($infos[2]);
                    return self::execRequete($req);
                    break;
                case "CHARGE_VALEUR" :
                case "CHARGE_GROUPE" :
                case "CHARGE_MULTIPLICATEUR" :
                    $req = "UPDATE common_charge_v2 SET $tag=$valeurnum WHERE CHARGE_ID=".get_numeric($infos[0]);
                    return self::execRequete($req);
                case "CHARGE_TYPE" :
                    $req = "UPDATE common_charge_v2 SET $tag='$valeur' WHERE CHARGE_ID=".get_numeric($infos[0]);
                    return self::execRequete($req);
            }
        }
        return false;
    }

    private static function chercherCodeApoge(?int $mat_id) : ?string
    {
        if ($mat_id == null) {
            return "";
        }
        $req = "SELECT MAT_CODE_APOGE,MAT_SURMAT_ID FROM common_matiere WHERE MAT_ID=$mat_id";
        $matiere = self::getRequete($req);
        foreach ($matiere as $value) {
            if ($value['MAT_CODE_APOGE'] == "") {
                return self::chercherCodeApoge($value["MAT_SURMAT_ID"]);
            } else {
                return $value['MAT_CODE_APOGE'];
            }
        }
        return "";
    }

    public static function getChargeEnseignantV2(int $sem_id, int $annee_id) : array
    {
        $req = "SELECT CHARGE_ID, CHARGE_AFFECTATION_ID, ID, CHARGE_VALEUR, CHARGE_TYPE, CHARGE_MULTIPLICATEUR, CHARGE_GROUPE,MAT_ENS_ID, ENS_MAT_ID, ANNEE_CLOSE
                FROM common_matiere
                         JOIN common_ue cu ON (UE_ID = MAT_UE_ID AND UE_SEM_ID = $sem_id)
                         JOIN common_enseignants_matieres ON (MAT_ID = ENS_MAT_ID AND ENS_MAT_ANNEE_ID = $annee_id)
                         LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                         JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                WHERE CHARGE_ID IS NOT NULL
                ORDER BY CHARGE_AFFECTATION_ID,CHARGE_TYPE";
        return self::getRequete($req);
    }

    public static function ajouterChargeVierge(int $affect_id) : int
    {
        $data = array();
        bfmw_add_secured($data,"*CHARGE_AFFECTATION_ID",$affect_id);
        return createData("common_charge_v2",$data,1);
    }

    public static function getChargeEnseignantAvecAffectation(int $affect_id) : array
    {
        $req = "SELECT CHARGE_ID, CHARGE_AFFECTATION_ID, ID, CHARGE_VALEUR, CHARGE_TYPE, CHARGE_MULTIPLICATEUR, CHARGE_GROUPE, MAT_ENS_ID, ENS_MAT_ID, ANNEE_CLOSE
                FROM common_enseignants_matieres
                     JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                     LEFT JOIN common_charge_v2 ON (ID=CHARGE_AFFECTATION_ID)
                WHERE ID = $affect_id
                ORDER BY CHARGE_AFFECTATION_ID,CHARGE_TYPE";
        return self::getRequete($req);
    }

    public static function supprimerCharge(int $id, int $dept_id) : int
    {
        $req = "DELETE FROM common_charge_v2
                WHERE CHARGE_ID=$id AND 1=(
                    SELECT COUNT(*)
                    FROM common_enseignants_matieres
                    JOIN common_enseignants_departement ON (MAT_ENS_ID=DEPT_ENS_ID)
                    JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                    WHERE CHARGE_ID=$id AND ENS_DEPT_ID=$dept_id
                )";
        return self::execRequeteAvecAffected($req);
    }

    public static function getMatieresAffectees(int $annee_courante, int $ens_id, int $form_id) : array
    {
        $req = "SELECT SEM_ID,UE_ID,MAT_ID,SEM_NOM,UE_NOM,MAT_NOM,MAT_CODE_APOGE, MAT_SURMAT_ID, ID
            FROM common_enseignants_matieres t1
                     JOIN common_matiere ON (MAT_ID = ENS_MAT_ID)
                     JOIN common_ue ON (UE_ID = MAT_UE_ID)
                     JOIN common_semestre ON (SEM_ID = UE_SEM_ID)
            WHERE MAT_ID IN (
                SELECT ENS_MAT_ID
                FROM common_enseignants_matieres t2
                WHERE MAT_ENS_ID = $ens_id
                  AND t2.ENS_MAT_ANNEE_ID = $annee_courante
            )
              AND t1.ENS_MAT_ANNEE_ID = $annee_courante
              AND SEM_FORM_ID = $form_id
              AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)
            GROUP BY MAT_ID
            ORDER BY SEM_ORDRE,SEM_ID,UE_ORDRE,UE_ID, MAT_ORDRE, MAT_ID
        ";

        $retour = self::getRequete($req);
        foreach ($retour as &$une_ligne) {
            if ($une_ligne["MAT_CODE_APOGE"] == "") {
                $une_ligne["MAT_CODE_APOGE"] = self::chercherCodeApoge($une_ligne["MAT_SURMAT_ID"]);
            }
        }

        return $retour;
    }

    public static function computeChargeEqTDPeriodePourEnseignant(int $annee_id, int $periode_id, int $ens_id)
    {
        $req = "SELECT CHARGE_TYPE, CHARGE_AFFECTATION_ID,
                       MAT_ID,
                       MAT_NOM,
                       ID, SEM_ID, UE_ID,
                       SEM_NOM, UE_NOM, MAT_CODE_APOGE,
                       CHARGE_GROUPE,
                       CHARGE_MULTIPLICATEUR,
                       CHARGE_VALEUR,
                       REPLACE(COMMENTAIRE,'\n','<br/>') AS COMMENTAIRE_BR,COMMENTAIRE
                FROM common_enseignants_matieres
                         JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                         JOIN common_periodes_matieres ON (PERIODE_MAT_ID = ENS_MAT_ID)
                         JOIN common_matiere ON (MAT_ID = PERIODE_MAT_ID AND MAT_PERIODE_ID = $periode_id AND ENS_MAT_ID = MAT_ID AND
                                                 MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue
                              ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_id AND (UE_END_ANNEE_ID > $annee_id OR UE_END_ANNEE_ID IS NULL))
                         JOIN common_semestre
                              ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_id AND (SEM_END_ANNEE_ID > $annee_id OR SEM_END_ANNEE_ID IS NULL))
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         left join common_edt_commentaires on (ID = COMMENTAIRE_AFFECT_ID)
                WHERE ENS_MAT_ANNEE_ID = $annee_id
                  AND MAT_ENS_ID = $ens_id
                GROUP BY CHARGE_ID
                ORDER BY SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID, MAT_ORDRE, MAT_ID, CHARGE_TYPE";
        return self::getRequete($req);
    }

    public static function getChargeEquipe(int $form_id, int $annee_id, int $ens_id) : array
    {
        $req = "SELECT MAT_ID, ENS_MAT_ID, ENS_NOM, ENS_ID, ENS_DEPT_VACATAIRE, IF(ENS_ID=$ens_id,1,0) AS SELF, ID, MAT_ENS_ID, ANNEE_CLOSE, common_charge_v2.*
                FROM common_enseignants_matieres t1
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_id AND (UE_END_ANNEE_ID > $annee_id OR UE_END_ANNEE_ID IS NULL))
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_id AND (SEM_END_ANNEE_ID > $annee_id OR SEM_END_ANNEE_ID IS NULL))
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_enseignants_departement ON (DEPT_ENS_ID=ENS_ID AND ENS_DEPT_ID=FORM_DEPT_ID) 
                         JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                         LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                WHERE MAT_ID IN (
                    SELECT ENS_MAT_ID
                    FROM common_enseignants_matieres t2
                    WHERE MAT_ENS_ID = $ens_id
                      AND t2.ENS_MAT_ANNEE_ID = $annee_id
                )
                  AND t1.ENS_MAT_ANNEE_ID = $annee_id
                  AND SEM_FORM_ID = $form_id
                GROUP BY ENS_ID, CHARGE_ID
                ORDER BY SEM_ORDRE,SEM_ID,UE_ORDRE,UE_ID, MAT_ORDRE, MAT_ID, ENS_NOM, ENS_ID, CHARGE_TYPE, CHARGE_ID";
        return self::getRequete($req);
    }

    public static function getChargeEquipePourUneMatiere(int $mat_id, int $ens_id, int $annee_id, int $form_id) : array
    {
        $req = "SELECT MAT_ID, ENS_MAT_ID, ENS_NOM, ENS_ID, ENS_DEPT_VACATAIRE, IF(ENS_ID=$ens_id,1,0) AS SELF, ID, MAT_ENS_ID, ANNEE_CLOSE, common_charge_v2.*
                FROM common_enseignants_matieres t1
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_id AND (UE_END_ANNEE_ID > $annee_id OR UE_END_ANNEE_ID IS NULL))
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_id AND (SEM_END_ANNEE_ID > $annee_id OR SEM_END_ANNEE_ID IS NULL))
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_enseignants_departement ON (DEPT_ENS_ID=ENS_ID AND ENS_DEPT_ID=FORM_DEPT_ID) 
                         JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                         LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                WHERE MAT_ID = $mat_id
                  AND t1.ENS_MAT_ANNEE_ID = $annee_id
                  AND SEM_FORM_ID = $form_id
                GROUP BY ENS_ID, CHARGE_ID
                ORDER BY SEM_ORDRE,SEM_ID,UE_ORDRE,UE_ID, MAT_ORDRE, MAT_ID, ENS_NOM, ENS_ID, CHARGE_TYPE, CHARGE_ID";
        return self::getRequete($req);
    }

    public static function supprimerAffectation(int $id, int $dept_id) : int
    {
        $req = "DELETE FROM common_enseignants_matieres
                WHERE ID=$id AND 1=(
                    SELECT COUNT(*)
                    FROM common_enseignants_matieres
                    JOIN common_enseignants_departement ON (MAT_ENS_ID=DEPT_ENS_ID)
                    WHERE ID=$id AND ENS_DEPT_ID=$dept_id
                )";
        return self::execRequeteAvecAffected($req);
    }

    public static function ajouterEnseignantExistant(int $mat_id, int $annee_id, int $ens_id) : int
    {
         $create = array();
        bfmw_add_secured($create,"*ENS_MAT_ID",$mat_id);
        bfmw_add_secured($create,"*MAT_ENS_ID",$ens_id);
        bfmw_add_secured($create,"*ENS_MAT_ANNEE_ID",$annee_id);
        return createData("common_enseignants_matieres",$create,3);
    }

    public static function getChargeEquipePourToutesMatieres(int $ens_id, int $annee_id, int $form_id)
    {
        $req = "SELECT SUM(CHARGE_VALEUR * (
                    IF(CHARGE_TYPE = 'CM', 1.5,
                       IF(CHARGE_TYPE = 'DS', 0,
                          IF(CHARGE_TYPE = 'TP',
                             IF(ENS_DEPT_VACATAIRE = 1, FORM_RATIO_V,
                                IF(ENS_EC = 1, FORM_RATIO_ES, FORM_RATIO_E)), 1))))
                    * CHARGE_GROUPE * CHARGE_MULTIPLICATEUR) AS TOTAL, MAT_ID
                FROM common_enseignants_matieres t1
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID AND UE_START_ANNEE_ID <= $annee_id AND (UE_END_ANNEE_ID > $annee_id OR UE_END_ANNEE_ID IS NULL))
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_id AND (SEM_END_ANNEE_ID > $annee_id OR SEM_END_ANNEE_ID IS NULL))
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID AND FORM_ID=$form_id)
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         JOIN common_enseignants_departement ON (DEPT_ENS_ID=ENS_ID AND ENS_DEPT_ID=FORM_DEPT_ID)
                         JOIN common_annee ON (ANNEE_ID = ENS_MAT_ANNEE_ID)
                         LEFT JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                WHERE t1.ENS_MAT_ID IN (
                    SELECT ENS_MAT_ID
                    FROM common_enseignants_matieres t2
                    WHERE MAT_ENS_ID = $ens_id
                      AND t2.ENS_MAT_ANNEE_ID = $annee_id
                )
                  AND t1.ENS_MAT_ANNEE_ID = $annee_id
                GROUP BY MAT_ID";
        return self::getRequete($req);
    }

    private static function getAffectationEnseignant(int $affect_id) : array
    {
        $req = "SELECT * FROM common_enseignants_matieres,common_matiere WHERE MAT_ID=ENS_MAT_ID AND ID=$affect_id";
        return self::getRequete($req);
    }

    public static function basculerEnReel(int $ens_ade, int $affect_id, string $code_apogee) : bool
    {
        $events = array();
        $activites = array();
        if (! Edt::collectEDTv2(Edt::$current_project_id,array($ens_ade),$events,1,true,false,false,false,null,null,true,$activites)) {
            return false;
        }

        $total_CM = 0;
        $total_TP = 0;
        $total_TD = 0;

        if (!empty($events)) {
            foreach ($events as $un_event) {
                if (isset($activites[$un_event["ACTIVITE_ID"]])) {
                    $activite_courante = $activites[$un_event["ACTIVITE_ID"]][0];
                    if ($activite_courante["code"] !="" && $activite_courante["code"] == $code_apogee) {
                        $calcul = (($un_event["REAL_HEURE_FIN"]-$un_event["REAL_HEURE_DEBUT"])/3600);
                        switch ($activite_courante["type"]) {
                            case "TD" : $total_TD += $calcul;break;
                            case "TP" : $total_TP += $calcul;break;
                            case "CM" : $total_CM += $calcul;break;
                        }
                    }
                }
            }
        }

        self::startTransaction();
        self::supprimerChargeReelle($affect_id);
        $data = array();
        bfmw_add_secured($data,"*REEL_ID",$affect_id);
        bfmw_add_secured($data,"*REEL_CM",$total_CM);
        bfmw_add_secured($data,"*REEL_TD",$total_TD);
        bfmw_add_secured($data,"*REEL_TP",$total_TP);
        if (createData("common_reel_enseignant",$data,4) != -1) {
            $req = "UPDATE common_charge_v2 SET CHARGE_PAYEE=".time()." WHERE CHARGE_AFFECTATION_ID=".$affect_id;
            if (self::execRequete($req)) {
                mysql_commit();
            }
        }
        mysql_rollback();
        return false;
    }

    private static function supprimerChargeReelle(int $affect_id) : bool
    {
        $req = "DELETE FROM common_reel_enseignant WHERE REEL_ID=$affect_id";
        return self::execRequete($req);
    }

}