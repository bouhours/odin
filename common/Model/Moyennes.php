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

class Moyennes extends Connectable
{
    public static function getMoyennesMatieresUnionSurMatieres(string $DEPT_CODE, int $annee_id) : array {
        $req = "select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,
                        `total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,
                        `total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                        `total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,
                        `odin`.`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,
                        `total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,
                        `total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,
                        `total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,
                        `total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,
                        ROUND(`total`.MOYMAT_VALEUR,2) AS MOYMAT_VALEUR_ROUND,
                        SEM_NOM AS SEM_NOM,
                        MAT_NOM AS MAT_NOM,
                        UE_NOM AS UE_NOM,
                        `total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (
                                ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,
                                         `matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,
                                         `matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                                         `matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,
                                         `matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,
                                         `matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,
                                         `matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,
                                         `matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,
                                         `matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `odin`.`".$DEPT_CODE."_notes_moyennes_matiere` `matieres`
                                         where MOYMAT_ANNEE_ID=$annee_id)
                                union all (
                                    select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,
                                           `surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,
                                           `surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                                           `surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,
                                           `surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,
                                           `surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,
                                           `surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,
                                           `surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,
                                           `surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `odin`.`".$DEPT_CODE."_notes_moyennes_surmatieres` `surmatieres`
                                           where MOYMAT_ANNEE_ID=$annee_id)
                                    ) `total`, common_etudiant, common_semestre,common_ue,common_matiere)
                        where ET_ID = `total`.MOYMAT_ET_ID AND
                              SEM_ID = `total`.MOYMAT_SEM_ID AND
                              UE_ID = `total`.MOYMAT_UE_ID AND
                              MAT_ID = `total`.MOYMAT_MAT_ID AND
                              SEM_START_ANNEE_ID <= $annee_id AND (SEM_END_ANNEE_ID > $annee_id OR SEM_END_ANNEE_ID IS NULL) AND
                              UE_START_ANNEE_ID <= $annee_id AND (UE_END_ANNEE_ID > $annee_id OR UE_END_ANNEE_ID IS NULL) AND
                              MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL) AND
                              MAT_CODE_APOGE<>''
                        group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID`";
        $moyennes = self::getRequete($req);
        $req = "select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,
                        `total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,
                        `total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                        `total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,
                        `odin`.`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,
                        `total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,
                        `total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,
                        `total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,
                        `total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,     
                        ROUND(`total`.MOYMAT_VALEUR,2) AS MOYMAT_VALEUR_ROUND,
                        SEM_NOM AS SEM_NOM,
                        MAT_NOM AS MAT_NOM,
                        UE_NOM AS UE_NOM,          
                        `total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (
                                ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,
                                         `matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,
                                         `matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                                         `matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,
                                         `matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,
                                         `matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,
                                         `matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,
                                         `matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,
                                         `matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `odin`.`common_clotures_moyennes_matiere` `matieres`
                                         where MOYMAT_ANNEE_ID=$annee_id)
                                union all (
                                    select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,
                                           `surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,
                                           `surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                                           `surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,
                                           `surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,
                                           `surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,
                                           `surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,
                                           `surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,
                                           `surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `odin`.`common_clotures_moyennes_surmatieres` `surmatieres`
                                           where MOYMAT_ANNEE_ID=$annee_id)
                                    ) `total`, common_etudiant, common_semestre,common_ue,common_matiere)
                        where ET_ID = `total`.MOYMAT_ET_ID AND
                              SEM_ID = `total`.MOYMAT_SEM_ID AND
                              UE_ID = `total`.MOYMAT_UE_ID AND
                              MAT_ID = `total`.MOYMAT_MAT_ID AND
                              SEM_START_ANNEE_ID <= $annee_id AND (SEM_END_ANNEE_ID > $annee_id OR SEM_END_ANNEE_ID IS NULL) AND
                              UE_START_ANNEE_ID <= $annee_id AND (UE_END_ANNEE_ID > $annee_id OR UE_END_ANNEE_ID IS NULL) AND
                              MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL) AND
                              MAT_CODE_APOGE<>''
                        group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID`";
        return array_merge($moyennes, self::getRequete($req));
    }

    public static function getMoyenneUnEtudiantUneMatiere(string $dept_code,int $et_id,int $mat_id, int $annee_id) : array {
        $req = "SELECT * from ".$dept_code."_notes_moyennes_matiere WHERE MOYMAT_ANNEE_ID=$annee_id AND MOYMAT_ET_ID=$et_id AND MOYMAT_MAT_ID=$mat_id";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            $req = "SELECT * FROM common_clotures_moyennes_matiere WHERE MOYMAT_ANNEE_ID=$annee_id AND MOYMAT_ET_ID=$et_id AND MOYMAT_MAT_ID=$mat_id";
            return self::getRequete($req);
        }
        return $retour;
    }

    public static function getMoyennesDesSemestresTouteAnnee(string $les_etudiants, string $dept_code) : array
    {
        if ($les_etudiants=="") {
            $les_etudiants = -1;
        }
        $req = "SELECT MOYAN_ET_ID, MOYAN_VALEUR FROM ".$dept_code."_notes_moyennes_annee WHERE MOYAN_ET_ID IN ($les_etudiants)";
        $current = self::getRequete($req);
        $req = "SELECT MOYAN_ET_ID, MOYAN_VALEUR FROM common_clotures_moyennes_annee WHERE MOYAN_ET_ID IN ($les_etudiants)";
        $past = self::getRequete($req);

        $retour = array();
        foreach ($current as $un_current) {
            $retour[$un_current["MOYAN_ET_ID"]]["ET_ID"] = $un_current["MOYAN_ET_ID"];
            $retour[$un_current["MOYAN_ET_ID"]]["MOYENNE"] = $un_current["MOYAN_VALEUR"];
            $retour[$un_current["MOYAN_ET_ID"]]["DIVISEUR"] = 1;
        }
        foreach ($past as $un_past) {
            $retour[$un_past["MOYAN_ET_ID"]]["ET_ID"] = $un_past["MOYAN_ET_ID"];
            if (isset($retour[$un_past["MOYAN_ET_ID"]]["MOYENNE"])) {
                $retour[$un_past["MOYAN_ET_ID"]]["MOYENNE"] += $un_past["MOYAN_VALEUR"];
            } else {
                $retour[$un_past["MOYAN_ET_ID"]]["MOYENNE"] = $un_past["MOYAN_VALEUR"];
            }
            if (isset($retour[$un_past["MOYAN_ET_ID"]]["DIVISEUR"])) {
                $retour[$un_past["MOYAN_ET_ID"]]["DIVISEUR"] += 1;
            } else {
                $retour[$un_past["MOYAN_ET_ID"]]["DIVISEUR"] = 1;
            }
        }

        foreach ($retour as &$un_retour) {
            $un_retour["MOYAN_VALEUR"] = round($un_retour["MOYENNE"] / $un_retour["DIVISEUR"],2);
        }

        return $retour;

    }

    public static function getValeurAPartirDeCodeApogee(string $les_codes, string $les_etudiants, int $annee_courante, string $dept_code) : array
    {
        $collecte = [];
        $req = "SELECT MAT_ID FROM common_matiere WHERE MAT_CODE_APOGE IN (".($les_codes??-1).")";
        $les_matieres = self::getRequeteAvecClef("MAT_ID",$req);
        if (! empty($les_matieres)) {
            $les_matieres_string = implode(",", array_keys($les_matieres));
            $req = "SELECT MOYMAT_ET_ID AS ET_ID, MOYMAT_VALEUR AS VALEUR,MOYMAT_SPECIAL AS SPECIAL, MOYMAT_COEF AS COEF, MOYMAT_ANNEE_ID AS ANNEE
                    FROM ".$dept_code."_notes_moyennes_matiere
                    WHERE MOYMAT_MAT_ID IN ($les_matieres_string) AND MOYMAT_ET_ID IN ($les_etudiants) AND MOYMAT_ANNEE_ID BETWEEN $annee_courante-8 AND $annee_courante ORDER BY MOYMAT_ANNEE_ID DESC";
            $collecte ["db1"] = self::getRequete($req);
            $req = "SELECT MOYMAT_ET_ID AS ET_ID,MOYMAT_VALEUR AS VALEUR,MOYMAT_SPECIAL AS SPECIAL, MOYMAT_COEF AS COEF, MOYMAT_ANNEE_ID AS ANNEE
                    FROM common_clotures_moyennes_matiere
                    WHERE MOYMAT_MAT_ID IN ($les_matieres_string) AND MOYMAT_ET_ID IN ($les_etudiants) AND MOYMAT_ANNEE_ID BETWEEN $annee_courante-8 AND $annee_courante ORDER BY MOYMAT_ANNEE_ID DESC";
            $collecte ["db2"] = self::getRequete($req);
            $req = "SELECT MOYMAT_ET_ID AS ET_ID,MOYMAT_VALEUR AS VALEUR,MOYMAT_SPECIAL AS SPECIAL, MOYMAT_COEF AS COEF, MOYMAT_ANNEE_ID AS ANNEE
                    FROM ".$dept_code."_notes_moyennes_surmatieres
                    WHERE MOYMAT_MAT_ID IN ($les_matieres_string) AND MOYMAT_ET_ID IN ($les_etudiants) AND MOYMAT_ANNEE_ID BETWEEN $annee_courante-8 AND $annee_courante ORDER BY MOYMAT_ANNEE_ID DESC";
            $collecte ["db3"] = self::getRequete($req);
            $req = "SELECT MOYMAT_ET_ID AS ET_ID,MOYMAT_VALEUR AS VALEUR,MOYMAT_SPECIAL AS SPECIAL, MOYMAT_COEF AS COEF, MOYMAT_ANNEE_ID AS ANNEE
                    FROM common_clotures_moyennes_surmatieres
                    WHERE MOYMAT_MAT_ID IN ($les_matieres_string) AND MOYMAT_ET_ID IN ($les_etudiants) AND MOYMAT_ANNEE_ID BETWEEN $annee_courante-8 AND $annee_courante ORDER BY MOYMAT_ANNEE_ID DESC";
            $collecte ["db4"] = self::getRequete($req);
        }

        $req = "SELECT UE_ID FROM common_ue  WHERE UE_CODE_APOGEE IN (".($les_codes??-1).")";
        $les_ues = self::getRequeteAvecClef("UE_ID",$req);
        if (! empty($les_ues)) {
            $les_ues_string = implode(",",array_keys($les_ues));
            $req = "SELECT MOYUE_ET_ID AS ET_ID,MOYUE_VALEUR AS VALEUR,MOYUE_SPECIAL AS SPECIAL, MOYUE_COEF AS COEF, MOYUE_ANNEE_ID AS ANNEE
                    FROM ".$dept_code."_notes_moyennes_ue_meilleures
                    WHERE MOYUE_UE_ID IN ($les_ues_string) AND MOYUE_ET_ID IN ($les_etudiants) AND MOYUE_ANNEE_ID BETWEEN $annee_courante-8 AND $annee_courante ORDER BY MOYUE_ANNEE_ID DESC";
            $collecte ["db5"] = self::getRequete($req);
            $req = "SELECT MOYUE_ET_ID AS ET_ID,MOYUE_VALEUR AS VALEUR,MOYUE_SPECIAL AS SPECIAL, MOYUE_COEF AS COEF, MOYUE_ANNEE_ID AS ANNEE
                    FROM common_clotures_moyennes_ue
                    WHERE MOYUE_UE_ID IN ($les_ues_string) AND MOYUE_ET_ID IN ($les_etudiants) AND MOYUE_ANNEE_ID BETWEEN $annee_courante-8 AND $annee_courante ORDER BY MOYUE_ANNEE_ID DESC";
            $collecte ["db6"] = self::getRequete($req);
        }

        $retour = [];

        foreach ($collecte as $une_db) {
            foreach ($une_db as $une_moyenne) {
                $retour[$une_moyenne['ET_ID']][] = $une_moyenne;
            }
        }


        return $retour;
    }

    public static function computeMoyenne(array $les_moyennes,bool $ponderation = false) : ?float
    {
        $les_moyennes_sans_redoublants = array();
        $etudiant_courant = -1;
        $annee_courante = -1;
        foreach ($les_moyennes as $une_moyenne) {
            if ($etudiant_courant != $une_moyenne['ET_ID']) {
                $etudiant_courant = $une_moyenne['ET_ID'];
                $annee_courante = $une_moyenne['ANNEE'];
            } else if ($annee_courante != $une_moyenne['ANNEE']) {
                continue;
            }
            $les_moyennes_sans_redoublants[] = $une_moyenne;
        }

        $somme = 0;
        $diviseur = 0;
        foreach ($les_moyennes_sans_redoublants as $une_moyenne) {
            if ($une_moyenne['SPECIAL'] != '') {
                return null;
            }
            $somme += ($ponderation?($une_moyenne['VALEUR']*$une_moyenne['COEF']):$une_moyenne['VALEUR']);
            $diviseur += ($ponderation?$une_moyenne['COEF']:1);
        }
        if ($diviseur==0) {
            return null;
        } else {
            return $somme/$diviseur;
        }
    }
}