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

class Groupes extends Connectable
{
    public static function getGroupeParCode(string $GROUPE_CODE) : mysqli_result  {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_CODE='$GROUPE_CODE'";
        return self::doRequete($req);
    }

    public static function getGroupeDeJury(int $dept_id,int $annee_id,int $responsable_id) : array {
        $req = "SELECT * 
                FROM etudiants_groupes,common_formation 
                LEFT JOIN common_responsable_formation ON (FORM_ID=RESPONSABLE_FORM_ID)
                WHERE FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=$dept_id AND  ET_GROUPE_ANNEE_ID=$annee_id 
                AND ((FORM_JURY_DEBUT <= ".time()." AND FORM_JURY_FIN >= ".time().") OR (FORM_ID=RESPONSABLE_FORM_ID AND RESPONSABLE_ENS_ID=$responsable_id))
                GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function getGroupesDesFormations(string $les_formations_autorisees,int $annee_courante, string $complement="") : array  {
        $req = "SELECT *
                    FROM common_groupes
                        JOIN common_formation ON (FORM_ID=GROUPE_FORM_ID)
                    WHERE $complement GROUPE_DELETED=0
                      AND GROUPE_FORM_ID IN (" . $les_formations_autorisees . ")
                      AND (FORM_END_ANNEE_ID<$annee_courante OR FORM_END_ANNEE_ID IS NULL)
                  ORDER BY FORM_NOM, FORM_ID, GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function getGroupesOLD(string $les_formations_autorisees,int $annee_courante, string $complement="") : array  {
        $req = "SELECT * FROM etudiants_groupes,common_formation, common_departement WHERE $complement DEPT_ID=FORM_DEPT_ID AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FORM_ID IN (".$les_formations_autorisees.") GROUP BY GROUPE_ID ORDER BY FORM_NOM, FORM_ID,GROUPE_CODE";
        return self::getRequeteAvecClef("GROUPE_ID",$req);
    }

    public static function getGroupesVides(string $les_formations_autorisees, string $complement="") : array  {
        $req = "SELECT *,IF(GROUPE_PRO=1,'checked','') AS GROUPE_PRO_SELECTED FROM common_groupes,common_formation,common_departement WHERE $complement DEPT_ID=FORM_DEPT_ID AND FORM_ID=GROUPE_FORM_ID AND GROUPE_DELETED = 0 AND GROUPE_FORM_ID IN (".$les_formations_autorisees.") AND FORM_DEPT_ID=".CURRENT_DEPT_ID." GROUP BY GROUPE_ID ORDER BY FORM_NOM, FORM_ID,GROUPE_CODE";
        return self::getRequeteAvecClef("GROUPE_ID",$req);
    }

    public static function getGroupesDuResponsable(string $les_formations_autorisees,int $annee_courante,int $ens_id, string $complement = "") : array  {
        if (Formations::isResponsable() || Formations::isSecretaire() || Formations::isChef()) {
            if ($les_formations_autorisees == 0) {
                $les_formations_autorisees = Formations::getFormationsDuConnecteString();
            }
            return self::getGroupesOLD($les_formations_autorisees,$annee_courante,$complement);
        } else {
            $req = "SELECT * FROM etudiants_groupes,common_formation WHERE $complement GROUPE_ENS_ID=$ens_id AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=" . CURRENT_DEPT_ID . " GROUP BY GROUPE_ID ORDER BY FORM_NOM,FORM_ID,GROUPE_CODE";
        }
        
        return self::getRequeteAvecClef("GROUPE_ID",$req);
    }

    public static function getGroupesPourUnSemestre(string $SEM_ID,int $annee_courante=-1,string $complement = "") : array  {
        $req = "SELECT GROUPE_ID,GROUPE_NOM, GROUPE_CODE, GROUPE_PARENT,GROUPE_FEUILLE FROM common_groupes,semestres_groupes_code WHERE $complement SEM_GROUPE_CODE LIKE CONCAT(GROUPE_CODE,'%') AND GROUPE_SEM_ID=$SEM_ID AND GROUPE_DELETED = 0 GROUP BY GROUPE_ID ORDER BY GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function getGroupesPourUneMatiere(int $mat_id,int $annee_courante) : array  {
        //"SELECT common_groupes.* FROM common_matiere,common_ue,common_semestre,semestres_groupes_code ,common_groupes WHERE GROUPE_DELETED=0 AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND SEM_GROUPE_CODE LIKE CONCAT(GROUPE_CODE,'%') AND GROUPE_SEM_ID=UE_SEM_ID AND MAT_ID=9349 ORDER BY GROUPE_CODE;"
        $req = "SELECT DISTINCT IF(GROUPE_FEUILLE=1,CONCAT('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',GROUPE_NOM),
                                IF(GROUPE_PARENT IS NOT NULL,CONCAT('&nbsp;&nbsp;&nbsp;',GROUPE_NOM),GROUPE_NOM)) AS GROUPE_NOM_FORMAT,GROUPE_NOM,GROUPE_ID,UE_SEM_ID AS SEM_ID, GROUPE_FEUILLE
                FROM common_groupes,common_matiere,common_ue,common_semestre,semestres_groupes_code
                WHERE GROUPE_DELETED=0 AND SEM_GROUPE_CODE LIKE CONCAT(GROUPE_CODE,'%') AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID
                  AND GROUPE_SEM_ID=UE_SEM_ID AND MAT_ID=$mat_id ORDER BY GROUPE_CODE";
        //$req = "SELECT GROUPE_NOM,GROUPE_ID,UE_SEM_ID AS SEM_ID, GROUPE_FEUILLE FROM etudiants_groupes,semestres_groupes_code,common_matiere,common_ue WHERE GROUPE_DELETED=0 AND MAT_ID=$mat_id AND UE_ID=MAT_UE_ID AND SEM_GROUPE_CODE LIKE CONCAT(GROUPE_CODE,'%') AND GROUPE_SEM_ID=UE_SEM_ID AND ET_GROUPE_ANNEE_ID=$annee_courante GROUP BY GROUPE_ID ORDER BY GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function getFormation(string $GROUPE_ID) : array {
        $req = "SELECT common_formation.*, DEPT_NOM
                FROM common_formation
                         JOIN common_groupes ON (FORM_ID = GROUPE_FORM_ID)
                         JOIN common_departement ON (FORM_DEPT_ID = DEPT_ID)
                WHERE GROUPE_ID IN ($GROUPE_ID)
                GROUP BY GROUPE_FORM_ID";

        return self::getRequete($req);
    }

    public static function getGroupe(int $GROUPE_ID) : array {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_ID=$GROUPE_ID";
        return self::getRequete($req);
    }

    public static function getGroupeFeuille(string $groupe_code, int $annee_courante) : array {
        $req = "SELECT * FROM etudiants_groupes,common_formation WHERE FORM_ID=GROUPE_FORM_ID AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FEUILLE='1' AND GROUPE_CODE LIKE '$groupe_code%' GROUP BY ET_ID ORDER BY FORM_NOM,FORM_ID,GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function getGroupeEtudiant(int $ET_ID, int $annee_courante) : array {
        $req = "SELECT * FROM etudiants_groupes WHERE  ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FEUILLE=1 AND GROUPE_ET_ID=$ET_ID";
        return self::getRequete($req);
    }

    public static function getGroupeEtudiantString(int $ET_ID, int $annee_courante) : string {
        $retour = array(-1);
        $les_groupes = self::getGroupeEtudiant($ET_ID,$annee_courante);
        foreach ($les_groupes as $unGroupe) {
            $retour[] = $unGroupe['GROUPE_ID'];
        }
        return implode(",",$retour);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "GROUPE_NOM":
            case "GROUPE_ENS_ID":
            case "GROUPE_ADE":
            case "GROUPE_PRO":
                $req = "UPDATE common_groupes SET $tag=".(($valeur=='NULL' || $valeur=='')?"NULL":"'".$valeur."'")." WHERE GROUPE_ID=$wherenum";
                return self::execRequete($req);
            case "SEMESTRES_GROUPES":
                //Modification d'un semestre pour un groupe
                $tab = explode("$",$where);
                if ($valeurnum != 0) {
                    $req = "INSERT INTO common_semestres_groupes(SEM_GROUPE_ID, GROUPE_SEM_ID) VALUES ($tab[1],$tab[0])";
                } else {
                    $req = "DELETE FROM common_semestres_groupes WHERE SEM_GROUPE_ID=$tab[1] AND GROUPE_SEM_ID=$tab[0]";
                }
                return self::execRequete($req);
            case "EVAL_GROUPE":
                $tab = explode("$",$where);
                if ($valeurnum == 1) {
                    $req = "UPDATE common_enseignants_matieres SET ENS_MAT_EVALUABLE=1 WHERE ID=".$tab[1];
                    self::execRequete($req);
                    $req = "INSERT INTO common_eval_groupe_enseignement(GROUPE_ID_ID, ID_GROUPE_ID) VALUES (" . $tab[1] . "," . $tab[0] . ")";
                    return self::execRequete($req);
                } else {
                    $req = "DELETE FROM common_eval_groupe_enseignement WHERE GROUPE_ID_ID=".$tab[1]." AND ID_GROUPE_ID=".$tab[0];
                    return self::execRequete($req);
                }

        }
        return false;
    }

    public static function getNomsParents(array $les_id,string &$les_noms) : void
    {
        $req = "SELECT DISTINCT * FROM common_groupes WHERE GROUPE_ID IN (SELECT GROUPE_PARENT FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_ID IN (".implode(",",$les_id)."))";
        $les_groupes_parents = self::getRequete($req);
        $retour = array();
        $id_suivants = array();
        foreach ($les_groupes_parents as $un_groupe) {
            $retour[] = $un_groupe['GROUPE_NOM'];
            $id_suivants[] = $un_groupe['GROUPE_ID'];
        }

        if (count($id_suivants) > 0) {
            self::getNomsParents($id_suivants, $les_noms);
        }

        if ($les_noms == "") {
            $les_noms = implode(", ",$retour);
        }
    }

    public static function getGroupesAPartirDuCodeADE($code_ade) : array
    {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_ADE=$code_ade";
        return self::getRequete($req);
    }

    public static function isEtudiantDansGroupe(string $les_groupes, int $et_id, int $annee_courante)
    {
        $req = "SELECT * FROM common_etudiant_groupes,common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_CODE=ET_GROUPE_CODE AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ET_ID=$et_id";
        $groupes = self::getRequeteAvecClef("GROUPE_ID",$req);
        $groupes_param = explode("$",$les_groupes);
        if (count($groupes_param) == 0) {
            return false;
        }
        foreach ($groupes_param as $un_groupe) {
            if (!in_array($un_groupe,array_keys($groupes))) {
                return false;
            }
        }
        return true;
    }

    public static function supprimerUnGroupe(int $groupe_id, int $annee_id) : bool
    {
        $req = "SELECT GROUPE_ID FROM common_groupes WHERE GROUPE_PARENT=$groupe_id";
        $les_groupes = self::getRequeteAvecClef("GROUPE_ID",$req);
        foreach ($les_groupes as $ssgroupe_id=>$groupe) {
            if (!self::supprimerUnGroupe($ssgroupe_id,$annee_id)) {
                return false;
            }
        }
        $req = "DELETE FROM common_semestres_groupes WHERE SEM_GROUPE_ID=$groupe_id";
        if (!self::execRequete($req)) {
            return false;
        }
        $req = "DELETE FROM common_etudiant_groupes WHERE ET_GROUPE_CODE=(SELECT GROUPE_CODE FROM common_groupes WHERE GROUPE_ID=$groupe_id) AND ET_GROUPE_ANNEE_ID=$annee_id";
        if (!self::execRequete($req)) {
            return false;
        }
        $req = "UPDATE common_groupes SET GROUPE_DELETED=1,GROUPE_ENS_ID=NULL,GROUPE_ADE=NULL,GROUPE_POURSUITE=0 WHERE GROUPE_ID=$groupe_id";
        if (!self::execRequete($req)) {
            return false;
        }
        return true;
    }

    public static function hasGroupeNonPro(array $groupe) : bool
    {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_PARENT=".$groupe["GROUPE_ID"];
        $les_groupes_filles = self::getRequeteAvecClef("GROUPE_ID",$req);
        foreach ($les_groupes_filles as $ssgroupe_id=>$ssgroupe) {
            if (self::hasGroupeNonPro($ssgroupe)) {
                return true;
            }
        }

        return ($groupe["GROUPE_FEUILLE"] == 1 && $groupe["GROUPE_PRO"] == 0);
    }

    public static function getGroupesEvaluablesPourEnseignant(int $affectation_id, string $les_formations_autorisees, int $annee_courante, string $complement) : array
    {
        $req = "SELECT *,IF(ID_GROUPE_ID IS NULL,'','checked') AS CHECKED FROM (etudiants_groupes,common_formation, common_departement) left join common_eval_groupe_enseignement ON (GROUPE_ID=ID_GROUPE_ID AND GROUPE_ID_ID=$affectation_id) WHERE $complement DEPT_ID=FORM_DEPT_ID AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FORM_ID IN (".$les_formations_autorisees.") GROUP BY GROUPE_ID ORDER BY FORM_NOM, FORM_ID,GROUPE_CODE";
        return self::getRequeteAvecClef("GROUPE_ID",$req);
    }

    public static function getGroupesDePoursuite(int $dept_id) : array
    {
        $req = "SELECT * FROM common_groupes
                         JOIN common_formation  ON (FORM_ID = GROUPE_FORM_ID)
                         WHERE GROUPE_POURSUITE=1 AND FORM_DEPT_ID=$dept_id
                         GROUP BY FORM_ID ORDER BY FORM_NOM,FORM_ID, GROUPE_CODE";
        return self::getRequete($req);
    }

    public static function isPro(int $groupe_id) : bool
    {
        $req = "SELECT * FROM common_groupes WHERE GROUPE_ID=$groupe_id AND GROUPE_PRO=1";
        return count(self::getRequete($req))  == 1;
    }

    public static function getGroupesDuDepartement(int $dept_id, string $space = "&nbsp;&nbsp;&nbsp;&nbsp;") : array
    {
        $req = "SELECT GROUPE_ID,
                       GROUPE_NOM,
                       FORM_ID,
                       FORM_NOM,
                       GROUPE_CODE,
                       IF(GROUPE_FEUILLE = 1, CONCAT('$space', GROUPE_NOM), GROUPE_NOM) AS GROUPE_AFFICHAGE
                FROM common_groupes
                         JOIN common_formation ON (FORM_ID = GROUPE_FORM_ID)
                WHERE FORM_DEPT_ID = $dept_id
                  AND GROUPE_DELETED = 0
                ORDER BY FORM_NOM, FORM_ID, GROUPE_CODE";
        return self::getRequete($req);
    }
}