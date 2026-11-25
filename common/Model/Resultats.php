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

class Resultats extends Connectable
{
    public static function getBilanPourUnGroupe(int $annee_id,int $groupe_id, string $prefixe_departement) : array
    {
        $prefixe = $prefixe_departement."_notes_moyennes_ue_meilleures";

        $req = "SELECT ET_ID,
                       GROUPE_NOM,
                       ET_BAC,
                       ET_RED,
                       ET_TIERS,
                       ET_NUMERO,
                       ANNEE_ID,
                       ANNEE_NOM,
                       ET_ID,
                       NIVEAU_ID,
                       REGROUP_ID,
                       ET_NOM,
                       NIVEAU_NOM,
                       REGROUP_NOM,
                       RESULTAT_UE_ID,
                       RESULTAT_UE_COEF,
                       if(MIN(moyennes_courantes.MOYUE_SPECIAL) IS NULL, MIN(moyennes_anciennes.MOYUE_SPECIAL),
                          MIN(moyennes_courantes.MOYUE_SPECIAL)) AS SPECIAL,
                       if(SUM(moyennes_courantes.MOYUE_VALEUR) IS NULL,
                             ROUND(SUM(moyennes_anciennes.MOYUE_VALEUR * RESULTAT_UE_COEF) / SUM(IF(moyennes_anciennes.MOYUE_VALEUR IS NOT NULL, RESULTAT_UE_COEF,0)), 2),
                             ROUND(SUM(moyennes_courantes.MOYUE_VALEUR * RESULTAT_UE_COEF) / SUM(IF(moyennes_courantes.MOYUE_VALEUR IS NOT NULL, RESULTAT_UE_COEF,0)), 2)) AS VALEUR,
                       if(SUM(moyennes_courantes.MOYUE_BARREE) IS NULL,
                             NULL,
                             ROUND(SUM(
                                 IFNULL (moyennes_courantes.MOYUE_BARREE,moyennes_courantes.MOYUE_VALEUR) * RESULTAT_UE_COEF) / SUM(IF(IFNULL (moyennes_courantes.MOYUE_BARREE,moyennes_courantes.MOYUE_VALEUR) IS NOT NULL, RESULTAT_UE_COEF,0)), 2)) AS BARREE
                FROM common_inscription
                         join common_semestre on (SEM_ID = INSCRIPT_SEM_ID)
                         join common_formation on (FORM_ID = SEM_FORM_ID)
                         join common_etudiant on (ET_ID = INSCRIPT_ET_ID)
                         join common_groupes on (GROUPE_ID = $groupe_id)
                         join common_etudiant_groupes
                              on (ET_ID = GROUPE_ET_ID AND ET_GROUPE_CODE LIKE CONCAT(GROUPE_CODE, '%') AND
                                  ET_GROUPE_ANNEE_ID = $annee_id)
                         join common_resultat_niveau on (NIVEAU_FORM_ID = FORM_ID)
                         join common_resultat_regroupement_ue on (NIVEAU_ID = REGROUP_NIVEAU_ID)
                         join common_annee on (ANNEE_ID = INSCRIPT_ANNEE_ID)
                         LEFT JOIN common_resultat_ue ON (REGROUP_ID = RESULTAT_REGROUP_ID)
                         LEFT JOIN $prefixe as moyennes_courantes
                                   ON moyennes_courantes.MOYUE_ANNEE_ID = INSCRIPT_ANNEE_ID AND
                                      GROUPE_ET_ID = moyennes_courantes.MOYUE_ET_ID AND moyennes_courantes.MOYUE_UE_ID = RESULTAT_UE_ID
                         LEFT JOIN common_clotures_moyennes_ue as moyennes_anciennes
                                   ON moyennes_anciennes.MOYUE_ANNEE_ID = INSCRIPT_ANNEE_ID AND
                                      GROUPE_ET_ID = moyennes_anciennes.MOYUE_ET_ID AND moyennes_anciennes.MOYUE_UE_ID = RESULTAT_UE_ID
                GROUP BY GROUPE_ET_ID, INSCRIPT_ANNEE_ID, NIVEAU_ID, REGROUP_ID
                ORDER BY ET_NOM, NIVEAU_NOM, NIVEAU_ID, ANNEE_NOM, ANNEE_ID, REGROUP_NOM, REGROUP_ID;    
        ";

        return self::getRequete($req);
    }

    public static function getBilanPourUnEtudiant(int $et_id, string $prefixe_departement, bool $meilleure_ue = false) : array
    {
        $prefixe = $prefixe_departement."_notes_moyennes_ue_meilleures";

        $req = "SELECT ANNEE_ID, ANNEE_NOM, NIVEAU_ID, REGROUP_ID, NIVEAU_NOM,REGROUP_NOM,RESULTAT_UE_ID, RESULTAT_UE_COEF,
                    if(MIN(moyennes_courantes.MOYUE_SPECIAL) IS NULL,MIN(moyennes_anciennes.MOYUE_SPECIAL),MIN(moyennes_courantes.MOYUE_SPECIAL)) AS SPECIAL,
                    if(SUM(moyennes_courantes.MOYUE_VALEUR) IS NULL, ROUND(SUM(moyennes_anciennes.MOYUE_VALEUR*RESULTAT_UE_COEF)/SUM(IF(moyennes_anciennes.MOYUE_VALEUR IS NOT NULL, RESULTAT_UE_COEF,0)), 2), ROUND(SUM(moyennes_courantes.MOYUE_VALEUR*RESULTAT_UE_COEF)/SUM(IF(moyennes_courantes.MOYUE_VALEUR IS NOT NULL, RESULTAT_UE_COEF,0)), 2)) AS VALEUR,
                   if(SUM(moyennes_courantes.MOYUE_BARREE) IS NULL,
                         NULL,
                         ROUND(SUM(
                             IFNULL (moyennes_courantes.MOYUE_BARREE,moyennes_courantes.MOYUE_VALEUR) * RESULTAT_UE_COEF) / SUM(IF(IFNULL (moyennes_courantes.MOYUE_BARREE,moyennes_courantes.MOYUE_VALEUR) IS NOT NULL, RESULTAT_UE_COEF,0)), 2)) AS BARREE
                    FROM common_inscription
                             join common_semestre on (SEM_ID = INSCRIPT_SEM_ID)
                             join common_formation on (FORM_ID = SEM_FORM_ID)
                             join common_resultat_niveau on (NIVEAU_FORM_ID = FORM_ID)
                             join common_resultat_regroupement_ue on (NIVEAU_ID = REGROUP_NIVEAU_ID)
                             join common_annee on (ANNEE_ID = INSCRIPT_ANNEE_ID)
                             LEFT JOIN common_resultat_ue ON (REGROUP_ID = RESULTAT_REGROUP_ID)
                             LEFT JOIN $prefixe as moyennes_courantes
                                       ON (moyennes_courantes.MOYUE_ANNEE_ID = INSCRIPT_ANNEE_ID AND
                                           moyennes_courantes.MOYUE_ET_ID = $et_id AND moyennes_courantes.MOYUE_UE_ID = RESULTAT_UE_ID)
                             LEFT JOIN common_clotures_moyennes_ue as moyennes_anciennes
                                       ON (moyennes_anciennes.MOYUE_ANNEE_ID = INSCRIPT_ANNEE_ID AND
                                           moyennes_anciennes.MOYUE_ET_ID = $et_id AND moyennes_anciennes.MOYUE_UE_ID = RESULTAT_UE_ID)
                    WHERE INSCRIPT_ET_ID=$et_id
                GROUP BY INSCRIPT_ANNEE_ID, NIVEAU_ID, REGROUP_ID
                ORDER BY NIVEAU_NOM, NIVEAU_ID, ANNEE_NOM, ANNEE_ID, REGROUP_NOM, REGROUP_ID ;    
        ";

        return self::getRequete($req);
    }

    public static function getDiplomes(int $dept_id) : array
    {
        $req = "SELECT * FROM common_resultats_diplome WHERE DIPLOME_DEPT_ID=$dept_id";
        return self::getRequete($req);
    }

    public static function getDiplome(int $diplome_en_cours) : array
    {
        $req = "SELECT DIPLOME_ID, DIPLOME_NOM, DIPLOME_ELIM, DIPLOME_VAL, NIVEAU_ID, NIVEAU_NOM, NIVEAU_FORM_ID, FORM_NOM,
                        r1.REGROUP_ID AS REGROUP_ID_1, r1.REGROUP_NOM AS REGROUP_NOM_1,
                        r2.REGROUP_ID AS REGROUP_ID_2, r2.REGROUP_NOM AS REGROUP_NOM_2,
                        RESULTAT_UE_ID, RESULTAT_UE_COEF, UE_NOM
                FROM common_resultats_diplome
                     LEFT JOIN common_resultat_niveau ON (DIPLOME_ID = NIVEAU_DIPLOME_ID)
                     LEFT JOIN common_formation ON (FORM_ID = NIVEAU_FORM_ID)
                     LEFT JOIN common_resultat_regroupement_ue AS r1 ON (NIVEAU_ID = r1.REGROUP_NIVEAU_ID)
                     LEFT JOIN common_resultat_regroupement_ue AS r2 ON (r2.REGROUP_ID = r1.REGROUP_PREC_REGROUP_ID)                    
                     LEFT JOIN common_resultat_ue ON (r1.REGROUP_ID = RESULTAT_REGROUP_ID)
                     LEFT JOIN common_ue ON (UE_ID = RESULTAT_UE_ID)
                WHERE DIPLOME_ID = $diplome_en_cours           
                ORDER BY DIPLOME_NOM,DIPLOME_ID,NIVEAU_NOM,NIVEAU_ID,r1.REGROUP_NOM,r1.REGROUP_ID
                      ";

        return self::getRequete($req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "DIPLOME_NOM" :
                $req = "UPDATE common_resultats_diplome SET $tag='$valeur' WHERE DIPLOME_ID=$wherenum";
                return self::execRequete($req);
            case "DIPLOME_ELIM" :
            case "DIPLOME_VAL" :
                $req = "UPDATE common_resultats_diplome SET $tag=$valeurnum WHERE DIPLOME_ID=$wherenum";
                return self::execRequete($req);
            case "NIVEAU_NOM" :
                $req = "UPDATE common_resultat_niveau SET $tag='$valeur' WHERE NIVEAU_ID=$wherenum";
                return self::execRequete($req);
            case "REGROUP_NOM" :
                $req = "UPDATE common_resultat_regroupement_ue SET $tag='$valeur' WHERE REGROUP_ID=$wherenum";
                return self::execRequete($req);
            case "RESULTAT_UE_COEF" :
                $tab = explode("$",$where);
                $req = "UPDATE common_resultat_ue SET $tag=$valeurnum WHERE RESULTAT_UE_ID=$tab[0] AND RESULTAT_REGROUP_ID=$tab[1]";
                return self::execRequete($req);
        }
        return false;
    }

    public static function getRegroupements(int $diplome_id) : array
    {
        $req = "SELECT * FROM common_resultat_regroupement_ue,common_resultat_niveau WHERE NIVEAU_ID=REGROUP_NIVEAU_ID AND NIVEAU_DIPLOME_ID=$diplome_id";
        return self::getRequete($req);
    }

    public static function supprimerDiplome(int $diplome_id, int $dept_id) : bool
    {
        $req = "DELETE FROM common_resultats_diplome WHERE DIPLOME_ID=$diplome_id AND DIPLOME_DEPT_ID=$dept_id";
        return self::execRequete($req);

    }

    public static function supprimerNiveau(int $niveau_id, int $dept_id) : bool
    {
        $req = "DELETE FROM common_resultat_niveau WHERE NIVEAU_ID=$niveau_id AND NIVEAU_DIPLOME_ID IN (SELECT DIPLOME_ID FROM common_resultats_diplome WHERE DIPLOME_DEPT_ID=$dept_id)";
        return self::execRequete($req);
    }

    public static function supprimerRegroupement(int $regroupement_id, int $dept_id) : bool
    {
        $req = "DELETE FROM common_resultat_regroupement_ue WHERE REGROUP_ID=$regroupement_id AND REGROUP_NIVEAU_ID IN
                   (SELECT NIVEAU_ID FROM common_resultat_niveau,common_resultats_diplome WHERE DIPLOME_ID=NIVEAU_DIPLOME_ID AND DIPLOME_DEPT_ID=$dept_id)";
        return self::execRequete($req);
    }

    public static function supprimerUE(int $ue_id,int $regroupement_id, int $dept_id) : bool
    {
        $req = "DELETE FROM common_resultat_ue WHERE RESULTAT_UE_ID=$ue_id AND RESULTAT_REGROUP_ID=$regroupement_id AND RESULTAT_REGROUP_ID IN
                   (SELECT REGROUP_ID FROM common_resultat_regroupement_ue,common_resultat_niveau,common_resultats_diplome
                   WHERE DIPLOME_ID=NIVEAU_DIPLOME_ID AND DIPLOME_DEPT_ID=$dept_id AND NIVEAU_ID=REGROUP_NIVEAU_ID)";
        return self::execRequete($req);
    }

    public static function hasResultats(int $groupe_courant, int $dept_id) : bool
    {
        $req = "SELECT *
                FROM common_resultats_diplome
                JOIN common_resultat_niveau ON (DIPLOME_ID=NIVEAU_DIPLOME_ID)
                JOIN common_resultat_regroupement_ue ON (NIVEAU_ID=REGROUP_NIVEAU_ID)
                JOIN common_resultat_ue ON (REGROUP_ID=RESULTAT_REGROUP_ID)
                JOIN common_groupes ON (NIVEAU_FORM_ID=GROUPE_FORM_ID)
                WHERE DIPLOME_DEPT_ID=$dept_id AND GROUPE_ID=$groupe_courant";
        return self::doRequete($req)->num_rows > 0;
    }


}