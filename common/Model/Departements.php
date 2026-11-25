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

class Departements extends Connectable
{
    public static function getDepartement(int $DEPT_ID) : array  {
        $req = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(DEPT_POURSUITE_DDEB),'%d/%m/%Y %Hh%i') AS DDEBUT,DATE_FORMAT(FROM_UNIXTIME(DEPT_POURSUITE_DFIN),'%d/%m/%Y %Hh%i') AS DFIN FROM common_departement WHERE DEPT_ID=$DEPT_ID";
        return self::getRequete($req);
    }

    public static function getDepartementDuGroupe(int $groupe_id) : array
    {
        $req = "SELECT common_departement.*
                    FROM common_groupes, common_formation, common_departement
                    WHERE GROUPE_ID = $groupe_id AND FORM_ID = GROUPE_FORM_ID AND DEPT_ID=FORM_DEPT_ID";
        return self::getRequete($req);
    }

    public static function creerDepartement(array $data) : bool
    {
        self::startTransaction();
        $id = createData("common_departement", $data, 2);
        if ($id > 0) {
            $req = "INSERT INTO common_enseignants_departement (DEPT_ENS_ID, ENS_DEPT_ID) VALUES(".CURRENT_ID.",$id)";
            if (self::execRequete($req) > 0) {
                $req = "UPDATE common_departement SET DEPT_ENS_ID=".CURRENT_ID." WHERE DEPT_ID=$id";
                if (self::execRequete($req) > 0) {
                    self::commit();
                    $dept_code = $data["bfmw_orig_*DEPT_CODE"];
                    $dept_id = $id;
                    $req = "
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_matiere_sans_bonus  AS SELECT sum(if(common_notes.NOTES_SPECIAL = 'ABJ',0,common_notes.NOTES_VALEUR * 20 / common_controle.CONTROLE_BAREME * common_controle.CONTROLE_COEFF)) / sum(if(common_notes.NOTES_SPECIAL = 'ABJ',0,common_controle.CONTROLE_COEFF)) AS MOYMAT_VALEUR, common_matiere.MAT_COEF AS MOYMAT_COEF, common_matiere.MAT_ID AS MOYMAT_MAT_ID, common_notes.NOTES_ET_ID AS MOYMAT_ET_ID, common_controle.CONTROLE_ANNEE_ID AS MOYMAT_ANNEE_ID, common_ue.UE_ID AS MOYMAT_UE_ID, common_ue.UE_COEF AS MOYMAT_UE_COEF, common_semestre.SEM_COEF AS MOYMAT_SEM_COEF, common_semestre.SEM_ID AS MOYMAT_SEM_ID, common_semestre.SEM_FORM_ID AS MOYMAT_FORM_ID, common_matiere.MAT_SURMAT_ID AS MOYMAT_SURMAT_ID, min(common_notes.NOTES_SPECIAL) AS MOYMAT_SPECIAL FROM ((((((common_controle join common_notes) join common_matiere) join common_ue) join common_semestre) join common_annee) join common_formation) WHERE common_formation.FORM_DEPT_ID = ".$dept_id." AND common_formation.FORM_ID = common_semestre.SEM_FORM_ID AND ifnull(`odin`.`common_matiere`.`MAT_COPIE_MAT_ID`,`odin`.`common_matiere`.`MAT_ID`) = `odin`.`common_controle`.`CONTROLE_MAT_ID` AND common_ue.UE_ID = common_matiere.MAT_UE_ID AND common_semestre.SEM_ID = common_ue.UE_SEM_ID AND common_controle.CONTROLE_ID = common_notes.NOTES_CONTROLE_ID AND common_controle.CONTROLE_MOYENNE = '1' AND common_controle.CONTROLE_VALIDE = '1' AND common_matiere.MAT_HAS_NOTE = 1 AND (common_notes.NOTES_VALEUR is not null OR common_notes.NOTES_SPECIAL is not null) AND common_annee.ANNEE_ID = common_controle.CONTROLE_ANNEE_ID AND common_annee.ANNEE_CLOSE = 0 GROUP BY common_matiere.MAT_ID, common_notes.NOTES_ET_ID, common_controle.CONTROLE_ANNEE_ID ;
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_matiere_somme_bonus  AS SELECT ifnull(sum(common_notes.NOTES_VALEUR),0) AS MOYMAT_BONUS_VALEUR, common_matiere.MAT_ID AS MOYMAT_MAT_ID, common_notes.NOTES_ET_ID AS MOYMAT_ET_ID, common_controle.CONTROLE_ANNEE_ID AS MOYMAT_ANNEE_ID, common_ue.UE_ID AS MOYMAT_UE_ID, common_ue.UE_COEF AS MOYMAT_UE_COEF, common_semestre.SEM_COEF AS MOYMAT_SEM_COEF, common_semestre.SEM_ID AS MOYMAT_SEM_ID, common_semestre.SEM_FORM_ID AS MOYMAT_FORM_ID, common_matiere.MAT_SURMAT_ID AS MOYMAT_SURMAT_ID, min(common_notes.NOTES_SPECIAL) AS MOYMAT_BONUS_SPECIAL FROM ((((((common_controle join common_notes) join common_matiere) join common_ue) join common_semestre) join common_annee) join common_formation) WHERE common_formation.FORM_DEPT_ID = ".$dept_id." AND common_formation.FORM_ID = common_semestre.SEM_FORM_ID AND ifnull(`odin`.`common_matiere`.`MAT_COPIE_MAT_ID`,`odin`.`common_matiere`.`MAT_ID`) = `odin`.`common_controle`.`CONTROLE_MAT_ID` AND common_ue.UE_ID = common_matiere.MAT_UE_ID AND common_semestre.SEM_ID = common_ue.UE_SEM_ID AND common_controle.CONTROLE_ID = common_notes.NOTES_CONTROLE_ID AND common_controle.CONTROLE_MOYENNE = '2' AND common_controle.CONTROLE_VALIDE = '1' AND common_matiere.MAT_HAS_NOTE = 1 AND common_annee.ANNEE_ID = common_controle.CONTROLE_ANNEE_ID AND common_annee.ANNEE_CLOSE = 0 GROUP BY common_matiere.MAT_ID, common_notes.NOTES_ET_ID, common_controle.CONTROLE_ANNEE_ID ;
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_matiere  AS SELECT ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_COEF AS MOYMAT_COEF, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_MAT_ID AS MOYMAT_MAT_ID, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_ET_ID AS MOYMAT_ET_ID, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_UE_ID AS MOYMAT_UE_ID, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_UE_COEF AS MOYMAT_UE_COEF, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_SEM_COEF AS MOYMAT_SEM_COEF, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_SEM_ID AS MOYMAT_SEM_ID, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_FORM_ID AS MOYMAT_FORM_ID, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_SURMAT_ID AS MOYMAT_SURMAT_ID, if(".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_SPECIAL = 'ABI',NULL,if(ifnull(".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_BONUS_VALEUR,0) + ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_VALEUR > 20,20,ifnull(".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_BONUS_VALEUR,0) + ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_VALEUR)) AS MOYMAT_VALEUR, ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_SPECIAL AS MOYMAT_SPECIAL, ".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_BONUS_SPECIAL AS MOYMAT_BONUS_SPECIAL FROM (".$dept_code."_notes_moyennes_matiere_sans_bonus left join ".$dept_code."_notes_moyennes_matiere_somme_bonus on(".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_MAT_ID = ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_MAT_ID and ".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_ET_ID = ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_ET_ID and ".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_ANNEE_ID = ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_ANNEE_ID and ".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_UE_ID = ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_UE_ID and ".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_SEM_ID = ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_SEM_ID and ".$dept_code."_notes_moyennes_matiere_somme_bonus.MOYMAT_FORM_ID = ".$dept_code."_notes_moyennes_matiere_sans_bonus.MOYMAT_FORM_ID)) ;
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_surmatieres  AS select sum(if(".$dept_code."_notes_moyennes_matiere.MOYMAT_VALEUR is null, 0, ".$dept_code."_notes_moyennes_matiere.MOYMAT_VALEUR * ".$dept_code."_notes_moyennes_matiere.MOYMAT_COEF)) / sum(if(".$dept_code."_notes_moyennes_matiere.MOYMAT_VALEUR is null, 0, ".$dept_code."_notes_moyennes_matiere.MOYMAT_COEF)) AS MOYMAT_VALEUR, ifnull(arborescence_matiere.MAT_SURMAT_ID, arborescence_matiere.MAT_ID) AS MOYMAT_MAT_ID, (select odin.common_matiere.MAT_COEF from odin.common_matiere where odin.common_matiere.MAT_ID = arborescence_matiere.MAT_SURMAT_ID) AS MOYMAT_COEF, ".$dept_code."_notes_moyennes_matiere.MOYMAT_ET_ID AS MOYMAT_ET_ID, ".$dept_code."_notes_moyennes_matiere.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID, ".$dept_code."_notes_moyennes_matiere.MOYMAT_UE_ID AS MOYMAT_UE_ID, ".$dept_code."_notes_moyennes_matiere.MOYMAT_UE_COEF AS MOYMAT_UE_COEF, ".$dept_code."_notes_moyennes_matiere.MOYMAT_SEM_COEF AS MOYMAT_SEM_COEF, ".$dept_code."_notes_moyennes_matiere.MOYMAT_SEM_ID AS MOYMAT_SEM_ID, ".$dept_code."_notes_moyennes_matiere.MOYMAT_FORM_ID AS MOYMAT_FORM_ID, min(".$dept_code."_notes_moyennes_matiere.MOYMAT_SPECIAL) AS MOYMAT_SPECIAL from (odin.".$dept_code."_notes_moyennes_matiere join odin.arborescence_matiere on (arborescence_matiere.MAT_SOURCE = ".$dept_code."_notes_moyennes_matiere.MOYMAT_MAT_ID)) where ".$dept_code."_notes_moyennes_matiere.MOYMAT_SURMAT_ID is not null group by arborescence_matiere.MAT_SURMAT_ID, ".$dept_code."_notes_moyennes_matiere.MOYMAT_ET_ID, ".$dept_code."_notes_moyennes_matiere.MOYMAT_ANNEE_ID;
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_ue_meilleures  AS select sum(if(total.MOYMAT_SPECIAL = 'ABJ' and total.MOYMAT_VALEUR is null, 0, total.MOYMAT_VALEUR * total.MOYMAT_COEF)) / sum(if(total.MOYMAT_SPECIAL = 'ABJ' and total.MOYMAT_VALEUR is null, 0,               total.MOYMAT_COEF)) AS MOYUE_VALEUR,        total.MOYMAT_ET_ID         AS MOYUE_ET_ID,        total.MOYMAT_ANNEE_ID      AS MOYUE_ANNEE_ID,        total.MOYMAT_UE_ID         AS MOYUE_UE_ID,        total.MOYMAT_UE_COEF       AS MOYUE_COEF,        total.MOYMAT_SEM_COEF      AS MOYUE_SEM_COEF,        total.MOYMAT_SEM_ID        AS MOYUE_SEM_ID,        total.MOYMAT_FORM_ID       AS MOYUE_FORM_ID,        sum(total.MOYMAT_COEF)     AS MOYUE_COEF_CALC,        min(total.MOYMAT_SPECIAL)  AS MOYUE_SPECIAL from ((select matieres.MOYMAT_VALEUR   AS MOYMAT_VALEUR,               matieres.MOYMAT_COEF     AS MOYMAT_COEF,               matieres.MOYMAT_ET_ID    AS MOYMAT_ET_ID,               matieres.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID,               matieres.MOYMAT_UE_ID    AS MOYMAT_UE_ID,               matieres.MOYMAT_SEM_COEF AS MOYMAT_SEM_COEF,               matieres.MOYMAT_SEM_ID   AS MOYMAT_SEM_ID,               matieres.MOYMAT_FORM_ID  AS MOYMAT_FORM_ID,               matieres.MOYMAT_UE_COEF  AS MOYMAT_UE_COEF,               matieres.MOYMAT_SPECIAL  AS MOYMAT_SPECIAL        from odin.".$dept_code."_notes_moyennes_matiere matieres        where matieres.MOYMAT_SURMAT_ID is null)       union all       (select surmatieres.MOYMAT_VALEUR   AS MOYMAT_VALEUR,               surmatieres.MOYMAT_COEF     AS MOYMAT_COEF,               surmatieres.MOYMAT_ET_ID    AS MOYMAT_ET_ID,               surmatieres.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID,               surmatieres.MOYMAT_UE_ID    AS MOYMAT_UE_ID,               surmatieres.MOYMAT_SEM_COEF AS MOYMAT_SEM_COEF,               surmatieres.MOYMAT_SEM_ID   AS MOYMAT_SEM_ID,               surmatieres.MOYMAT_FORM_ID  AS MOYMAT_FORM_ID,               surmatieres.MOYMAT_UE_COEF  AS MOYMAT_UE_COEF,               surmatieres.MOYMAT_SPECIAL  AS MOYMAT_SPECIAL        from (odin.".$dept_code."_notes_moyennes_surmatieres surmatieres                 join odin.arborescence_matiere                      on (surmatieres.MOYMAT_MAT_ID = arborescence_matiere.MAT_ID and                          arborescence_matiere.MAT_ID = arborescence_matiere.MAT_SOURCE))        where arborescence_matiere.MAT_SURMAT_ID is null)) total group by total.MOYMAT_ET_ID, total.MOYMAT_ANNEE_ID, total.MOYMAT_UE_ID; 
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_semestre  AS SELECT sum(".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_VALEUR * ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_COEF_CALC) / sum(".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_COEF_CALC) AS MOYSEM_VALEUR, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_ET_ID AS MOYSEM_ET_ID, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_FORM_ID AS MOYSEM_FORM_ID, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_ANNEE_ID AS MOYSEM_ANNEE_ID, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_SEM_COEF AS MOYSEM_COEF, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_SEM_ID AS MOYSEM_ID, min(".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_SPECIAL) AS MOYSEM_SPECIAL FROM ".$dept_code."_notes_moyennes_ue_meilleures GROUP BY ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_SEM_ID, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_ET_ID, ".$dept_code."_notes_moyennes_ue_meilleures.MOYUE_ANNEE_ID ;
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_annee  AS SELECT sum(".$dept_code."_notes_moyennes_semestre.MOYSEM_VALEUR * ".$dept_code."_notes_moyennes_semestre.MOYSEM_COEF) / sum(".$dept_code."_notes_moyennes_semestre.MOYSEM_COEF) AS MOYAN_VALEUR, ".$dept_code."_notes_moyennes_semestre.MOYSEM_ET_ID AS MOYAN_ET_ID, ".$dept_code."_notes_moyennes_semestre.MOYSEM_FORM_ID AS MOYAN_FORM_ID, ".$dept_code."_notes_moyennes_semestre.MOYSEM_ANNEE_ID AS MOYAN_ANNEE_ID, min(".$dept_code."_notes_moyennes_semestre.MOYSEM_SPECIAL) AS MOYAN_SPECIAL FROM ".$dept_code."_notes_moyennes_semestre GROUP BY ".$dept_code."_notes_moyennes_semestre.MOYSEM_ET_ID, ".$dept_code."_notes_moyennes_semestre.MOYSEM_ANNEE_ID ;
                        CREATE ALGORITHM=UNDEFINED DEFINER=`odin`@`%` SQL SECURITY DEFINER VIEW ".$dept_code."_notes_moyennes_export  AS SELECT total.MOYMAT_VALEUR AS MOYMAT_VALEUR, total.MOYMAT_ET_ID AS MOYMAT_ET_ID, total.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID, total.MOYMAT_MAT_ID AS MOYMAT_MAT_ID, common_etudiant.ET_NUMERO AS ET_NUMERO, total.MOYMAT_SPECIAL AS MOYMAT_SPECIAL, total.MOYMAT_SEM_ID AS MOYMAT_SEM_ID, total.MOYMAT_UE_ID AS MOYMAT_UE_ID, total.MOYMAT_FORM_ID AS MOYMAT_FORM_ID, total.MOYMAT_COEF AS MOYMAT_COEF FROM (((select matieres.MOYMAT_VALEUR AS MOYMAT_VALEUR,matieres.MOYMAT_ET_ID AS MOYMAT_ET_ID,matieres.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID,matieres.MOYMAT_MAT_ID AS MOYMAT_MAT_ID,matieres.MOYMAT_SPECIAL AS MOYMAT_SPECIAL,matieres.MOYMAT_SEM_ID AS MOYMAT_SEM_ID,matieres.MOYMAT_UE_ID AS MOYMAT_UE_ID,matieres.MOYMAT_FORM_ID AS MOYMAT_FORM_ID,matieres.MOYMAT_COEF AS MOYMAT_COEF from ".$dept_code."_notes_moyennes_matiere matieres) union all (select surmatieres.MOYMAT_VALEUR AS MOYMAT_VALEUR,surmatieres.MOYMAT_ET_ID AS MOYMAT_ET_ID,surmatieres.MOYMAT_ANNEE_ID AS MOYMAT_ANNEE_ID,surmatieres.MOYMAT_MAT_ID AS MOYMAT_MAT_ID,surmatieres.MOYMAT_SPECIAL AS MOYMAT_SPECIAL,surmatieres.MOYMAT_SEM_ID AS MOYMAT_SEM_ID,surmatieres.MOYMAT_UE_ID AS MOYMAT_UE_ID,surmatieres.MOYMAT_FORM_ID AS MOYMAT_FORM_ID,surmatieres.MOYMAT_COEF AS MOYMAT_COEF from ".$dept_code."_notes_moyennes_surmatieres surmatieres)) total join common_etudiant) WHERE common_etudiant.ET_ID = total.MOYMAT_ET_ID GROUP BY total.MOYMAT_ET_ID, total.MOYMAT_ANNEE_ID, total.MOYMAT_MAT_ID ;
                        INSERT INTO `common_absences_creneau` (`CRENEAU_NOM`, `CRENEAU_DEMI`, `CRENEAU_REAL_START`, `CRENEAU_REAL_END`, `CRENEAU_DEPT_ID`, `CRENEAU_CLASSIQUE`) VALUES ('10h00 - 12h00', 'matin', 943952400, 943959600, $dept_id, 1), ('08h00 - 10h00', 'matin', 943945200, 943952400, $dept_id, 1), ('13h30 - 15h30', 'après-midi', 943965000, 943972200, $dept_id, 1), ('15h30 - 17h30', 'après-midi', 943972200, 943979400, $dept_id, 1)";

                    if (self::execMultiRequete($req)) {
                        return true;
                    } else {
                        self::supprimerDepartement($id,$dept_code);
                    }
                }
            }
        }

        self::rollback();
        return false;
    }

    public static function supprimerDepartement(int $id, string $dept_code) : bool
    {
        $req = "DELETE FROM common_departement WHERE DEPT_ID=$id;
                DROP VIEW ".$dept_code."_notes_moyennes_matiere_sans_bonus;
                DROP VIEW ".$dept_code."_notes_moyennes_matiere_somme_bonus;
                DROP VIEW ".$dept_code."_notes_moyennes_matiere;
                DROP VIEW ".$dept_code."_notes_moyennes_surmatieres;
                DROP VIEW ".$dept_code."_notes_moyennes_ue_meilleures;
                DROP VIEW ".$dept_code."_notes_moyennes_semestre;
                DROP VIEW ".$dept_code."_notes_moyennes_annee;
                DROP VIEW ".$dept_code."_notes_moyennes_export;
               ";
        return self::execMultiRequete($req);
    }

    public static function getDepartementCourantDeLEnseignant(int $ens_id) : array
    {
        $req = "SELECT * FROM common_enseignants_departement WHERE DEPT_ENS_ID=$ens_id AND ENS_DEPT_CURRENT=1";
        return self::getRequete($req);
    }

    public static function isInDepartement(int $ens_id,int $dept_id) : bool
    {
        $tab = self::getDepartementCourantDeLEnseignant($ens_id);
        foreach ($tab as $un_dept) {
            return $un_dept["ENS_DEPT_ID"] == $dept_id;
        }
        return false;
    }

    public static function getDepartementDeLEtudiant(int $annee_courante,int $et_id) : array
    {
        $req = "SELECT common_departement.*
                FROM common_inscription
                     JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID)
                     JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                     JOIN common_departement ON (DEPT_ID = FORM_DEPT_ID)
                WHERE INSCRIPT_ANNEE_ID = $annee_courante
                  AND INSCRIPT_ET_ID = $et_id
                GROUP BY DEPT_ID";

        return self::getRequete($req);
    }
}