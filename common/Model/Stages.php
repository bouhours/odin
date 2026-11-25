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

class Stages extends Connectable
{
    /**
     * Retourne tous les stages d'un groupe d'étudiants
     * @param $groupe
     * @param $annee
     * @return array
     */
    public static function getStagesDUnGroupe(int $groupe,int $annee) : array {
        $req = "SELECT common_stage.* FROM common_stage,common_stage_formations,etudiants_groupes WHERE STAGE_ID=FORM_STAGE_ID AND GROUPE_ID=$groupe AND GROUPE_FORM_ID=STAGE_FORM_ID AND STAGE_FORM_ID=GROUPE_FORM_ID AND STAGE_ANNEE_ID=ET_GROUPE_ANNEE_ID AND STAGE_ANNEE_ID=$annee GROUP BY STAGE_ID";
        return self::getRequeteAvecClef("STAGE_ID",$req);
    }

    /**
     * Retourne un stage
     * @param int $stage
     * @param int $annee
     * @return array
     */
    public static function getStage(int $stage,int $annee) : array {
        $req = "SELECT * FROM common_stage WHERE STAGE_ID=$stage AND STAGE_ANNEE_ID=$annee";
        return self::getRequete($req);
    }

    /**
     * Enregistre la candidature à un stage
     * @param int $etudiant
     * @param int $stage
     * @return bool
     */
    public static function candidater(int $etudiant,int $stage) : bool {
        $req = "INSERT INTO common_stage_etudiants(STAGE_ET_ID, ET_STAGE_ID, ET_STAGE_DATE) VALUES ($etudiant,$stage,".time().")";
        return self::execRequete($req);
    }

    /**
     * Retourne tous les stages d'une formation donnée avec le nombre de candidats et les formations
     * @param int $formation
     * @param int $annee
     * @param int|null $etudiant Indiquez ici l'ID de l'étudiant si vous souhaitez savoir s'il a candidaté à ce stage
     * @return array
     */
    public static function getStages(int $formation,int $annee,?int $etudiant = null) : array {
        $req = "SELECT ET_ID,ET_NOM,common_stage.*,
                       FROM_UNIXTIME(STAGE_DATE,'%d/%m/%Y à %H:%i') AS DATE_STAGE,
                       FROM_UNIXTIME(STAGE_DATE_AFFECTATION,'%d/%m/%Y à %H:%i') AS DATE_AFFECTATION,
                       0 AS NB_CANDIDATS,0 AS ETUDIANT_A_CANDIDATE
                       FROM (common_stage,common_stage_formations)
                       LEFT JOIN common_etudiant ON (ET_ID = common_stage.STAGE_ET_ID) 
                       WHERE STAGE_ID=FORM_STAGE_ID AND STAGE_FORM_ID=$formation AND STAGE_ANNEE_ID=$annee
                       ORDER BY STAGE_DATE DESC";

        $les_stages = self::getRequeteAvecClef("STAGE_ID",$req);
        $req = "SELECT STAGE_ID,ET_ID,ET_NOM,common_stage_etudiants.*,FROM_UNIXTIME(ET_STAGE_DATE,'%d/%m/%Y à %H:%i') AS DATE_CANDIDATURE FROM (common_stage,common_stage_formations) LEFT JOIN common_stage_etudiants ON (STAGE_ID = ET_STAGE_ID) LEFT JOIN common_etudiant ON (ET_ID = common_stage_etudiants.STAGE_ET_ID) WHERE STAGE_ID=FORM_STAGE_ID AND STAGE_FORM_ID=$formation AND STAGE_ANNEE_ID=$annee ORDER BY ET_NOM";
        $les_candidats = self::getRequete($req);
        foreach ($les_candidats as $un_candidat) {
            if ($un_candidat['ET_ID'] !== null) {
                $les_stages[$un_candidat["STAGE_ID"]]["CANDIDATS"][] = $un_candidat;
                $les_stages[$un_candidat["STAGE_ID"]]['NB_CANDIDATS'] = $les_stages[$un_candidat["STAGE_ID"]]['NB_CANDIDATS']+1;;
                if ($etudiant != null) {
                    if ($un_candidat['ET_ID'] == $etudiant) {
                        $les_stages[$un_candidat["STAGE_ID"]]['ETUDIANT_A_CANDIDATE'] = 1;
                    }
                }
            }
        }
        foreach ($les_stages as &$un_stage) {
            $req = "SELECT * FROM common_stage_formations WHERE FORM_STAGE_ID = ".$un_stage['STAGE_ID'];
            $les_formations = self::getRequete($req);
            foreach ($les_formations as $une_formation) {
                $un_stage["FORMATIONS"][$une_formation['STAGE_FORM_ID']] = $une_formation;
            }
        }

        return $les_stages;
    }

    /**
     * Retourne l'identifiant du stage sur lequel l'étudiant a été affecté
     * @param $etudiant_courant
     * @param $annee
     * @return int
     */
    public static function getIdStageDUnEtudiant(int $etudiant_courant, int $annee) : int {
        $stage = self::getStageDUnEtudiant($etudiant_courant, $annee);
        if ($stage != null) {
            return $stage['STAGE_ID'];
        } else {
            return -1;
        }
    }

    /**
     * Retourne le stage sur lequel l'étudiant a été affecté
     * @param $etudiant_courant
     * @param $annee
     * @return array ou null si trage pas trouvé
     */
    public static function getStageDUnEtudiant(int $etudiant_courant, int $annee) : ?array {
        $req = "SELECT *,
                       FROM_UNIXTIME(STAGE_DATE,'%d/%m/%Y à %H:%i') AS DATE_STAGE
                FROM common_stage
                WHERE STAGE_ET_ID=$etudiant_courant AND STAGE_ANNEE_ID=$annee";
        $res = self::doRequete($req);
        if ($res->num_rows === 1) {
            return $res->fetch_assoc();
        } else {
            return null;
        }
    }

    /**
     * Retourne toutes les candidatures d'un étudiant
     * @param $etudiant
     * @param $annee
     * @return array
     */
    public static function getCandidatures(int $etudiant,int $annee) : array {
        $req = "SELECT *,common_stage.STAGE_ET_ID AS ETUDIANT_AFFECTE,FROM_UNIXTIME(STAGE_DATE_AFFECTATION,'%d/%m/%Y à %H:%i') AS STAGE_DATE_AFFECTATIONF,FROM_UNIXTIME(ET_STAGE_DATE,'%d/%m/%Y à %H:%i') AS ET_STAGE_DATEF FROM common_stage,common_stage_etudiants WHERE STAGE_ID=ET_STAGE_ID AND common_stage_etudiants.STAGE_ET_ID=$etudiant AND STAGE_ANNEE_ID=$annee ORDER BY ET_STAGE_DATE DESC, STAGE_DATE_AFFECTATION DESC, STAGE_DATE DESC";
        return self::getRequeteAvecClef("STAGE_ID",$req);
    }

    /**
     * Retourne toutes les candidatures à un stage donné
     * @param int $stage
     * @param int $annee
     * @return array
     */
    public static function getCandidaturesAUnStage(int $stage,int $annee) : array {
        $req = "SELECT *,FROM_UNIXTIME(ET_STAGE_DATE,'%d/%m/%Y à %H:%i') AS DATE_CANDIDATURE FROM common_stage LEFT JOIN common_stage_etudiants ON (STAGE_ID = ET_STAGE_ID) LEFT JOIN common_etudiant ON (ET_ID = common_stage_etudiants.STAGE_ET_ID) WHERE STAGE_ID=$stage AND STAGE_ANNEE_ID=$annee ORDER BY ET_NOM";
        return self::getRequete($req);
    }

    /**
     * Retourne toutes les candidatures d'un étudiant où il n'est pas éliminé
     * @param $etudiant
     * @param $annee
     * @return array
     */
    public static function getCandidaturesNonElimine(int $etudiant,int $annee) : array {
        $req = "SELECT *,common_stage.STAGE_ET_ID AS ETUDIANT_AFFECTE,FROM_UNIXTIME(STAGE_DATE_AFFECTATION,'%d/%m/%Y à %H:%i') AS STAGE_DATE_AFFECTATIONF,FROM_UNIXTIME(ET_STAGE_DATE,'%d/%m/%Y à %H:%i') AS ET_STAGE_DATEF FROM common_stage,common_stage_etudiants WHERE common_stage.STAGE_ET_ID IS NULL AND STAGE_ID=ET_STAGE_ID AND common_stage_etudiants.STAGE_ET_ID=$etudiant AND STAGE_ANNEE_ID=$annee ORDER BY ET_STAGE_DATE DESC, STAGE_DATE_AFFECTATION DESC, STAGE_DATE DESC";
        return self::getRequete($req);
    }

    /**
     * Retourne si des stages sont disponibles pour l'étudiant étudiant donné
     * @param $etudiant
     * @param $annee
     * @return bool
     */
    public static function isStagesDisponibles(int $etudiant,int $annee) : bool {
        $req = "SELECT GROUPE_FORM_ID FROM etudiants_groupes,common_stage_formations,common_inscription WHERE ET_GROUPE_ANNEE_ID=$annee AND ET_ID=$etudiant AND GROUPE_FORM_ID=STAGE_FORM_ID AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$annee AND INSCRIPT_DISP=0 GROUP BY ET_ID,FORM_STAGE_ID";
        return self::doRequete($req)->num_rows > 0;
    }

    /**
     * Supprimer un stage
     * @param $stage
     * @param $annee
     * @return bool
     */
    public static function supprimerStage(int $stage,int $annee) : bool {
        $les_formation = Formations::getFormationsDuGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID,$annee);
        if (count($les_formation) > 0) {
            $req = "SELECT * FROM common_stage,common_stage_formations WHERE STAGE_ID=$stage AND STAGE_ID=FORM_STAGE_ID AND STAGE_FORM_ID IN (".implode(",",array_keys($les_formation)).") AND STAGE_ANNEE_ID=$annee";
            if (self::doRequete($req)->num_rows > 0) {
                $req = "DELETE FROM common_stage WHERE STAGE_ID=$stage";
                return self::execRequete($req);
            }
        }
        return false;
    }

    /**
     * Supprimer candidature un stage
     * @param $stage
     * @param $annee
     * @param $etudiant
     * @return bool
     */
    public static function supprimerCandidateStage(int $stage, int $etudiant,int $annee) : bool {
        $les_formation = Formations::getFormationsDuGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID,$annee);
        if (count($les_formation) > 0) {
            $req = "SELECT * FROM common_stage,common_stage_formations WHERE STAGE_ID=$stage AND STAGE_ID=FORM_STAGE_ID AND STAGE_FORM_ID IN (".implode(",",array_keys($les_formation)).") AND STAGE_ANNEE_ID=$annee";
            if (self::doRequete($req)->num_rows > 0) {
                $req = "DELETE FROM common_stage_etudiants WHERE ET_STAGE_ID=$stage AND STAGE_ET_ID=$etudiant";
                return self::execRequete($req);
            }
        }
        return false;
    }

    /**
     * Vérifier que l'étudiant peut candidater à un stage
     * @param int $etudiant
     * @param int $stage
     * @param int $annee
     * @return bool
     */
    public static function peutCandidater(int $etudiant,int $stage,int $annee) : bool {
        $formations = Formations::getFormationDeLEtudiant($etudiant,$annee);
        $retour = false;
        foreach ($formations as $formation_courante) {
            if ($formation_courante != null) {
                $nb_candidatures = count(Stages::getCandidaturesNonElimine(CURRENT_ID, $annee));
                $nb_stage_max = $formation_courante["FORM_CANDIDATURES_STAGE_MAX"];
                $nb_stage_et_max = $formation_courante["FORM_CANDIDATURES_STAGE_ET_MAX"];
                $retour |= !(count(self::getCandidaturesAUnStage($stage, $annee)) >= $nb_stage_max || $nb_candidatures >= $nb_stage_et_max);
            }
        }
        return $retour;
    }

    /**
     * Retourn le nombre de stage d'un enseignant pour une session donnée
     * @param int $ens_id
     * @param int $annee_id
     * @param int $planning_id
     * @return int
     */
    public static function getNombreEncadrementPourUnEnseignant(int $ens_id, int $annee_id, int $planning_id) : int {
        $retour = 0;

        $req = "SELECT COUNT(*) AS TOTAL FROM common_stage WHERE STAGE_ENS_ID=$ens_id AND STAGE_ANNEE_ID=$annee_id AND STAGE_PLANNING_ID=$planning_id";
        if ($un_enseignant = self::doRequete($req)->fetch_assoc()) {
            return $un_enseignant['TOTAL'];
        }

        return $retour;
    }

    /**
     * Retourne le nombre de stage par enseignants pour un planning donné
     * @param string $ens_id
     * @param int $annee_id
     * @param int $planning_id
     * @return int
     */
    public static function getNombreEncadrementPourEnseignants(string $ens_id, int $annee_id, int $planning_id) : array {
        $req = "SELECT STAGE_ENS_ID,COUNT(*) AS TOTAL 
                FROM common_stage,common_soutenances_planning_stage 
                WHERE STAGE_ID=PLANNING_STAGE_ID AND STAGE_ENS_ID IN ($ens_id) AND STAGE_ANNEE_ID=$annee_id AND STAGE_PLANNING_ID=$planning_id
                GROUP BY STAGE_ENS_ID
                ";
            return self::getRequeteAvecClef("STAGE_ENS_ID",$req);
    }

    /**
     * Retourne le nombre de stage non planifiés par enseignants pour un planning donné
     * @param string $ens_id
     * @param int $annee_id
     * @param int $planning_id
     * @return int
     */
    public static function getNombreEncadrementRestantsPourEnseignants(string $ens_id, int $annee_id, int $planning_id) : array {
        $req = "SELECT STAGE_ENS_ID,COUNT(*) AS TOTAL 
                FROM common_stage,common_soutenances_planning_stage 
                WHERE STAGE_ID=PLANNING_STAGE_ID AND STAGE_ENS_ID IN ($ens_id) AND STAGE_ANNEE_ID=$annee_id AND STAGE_PLANNING_ID=$planning_id AND STAGE_DATE_SOUTENANCE IS NULL
                GROUP BY STAGE_ENS_ID
                ";
        return self::getRequeteAvecClef("STAGE_ENS_ID",$req);
    }

    /**
     * @param string $tag
     * @param $valeur
     * @param $where
     * @param float|null $valeurnum
     * @param float|null $wherenum
     * @return bool
     */
    public static function doBind(string $tag, $valeur, $where,?float $valeurnum, ?float $wherenum) : bool {
        switch ($tag) {
            case "STAGE_SUJET" :
            case "STAGE_REF" :
            case "STAGE_MAIL" :
            case "STAGE_CONTACT" :
                return self::execRequete("UPDATE common_stage SET $tag='$valeur' WHERE STAGE_ID=$wherenum");
            case "STAGE_ENS_ID" :
                if ($valeur == "NULL") {
                    if (self::execRequete("UPDATE common_stage SET $tag=null WHERE STAGE_ID=$wherenum")) {
                        self::execRequete("DELETE FROM common_soutenances_planning_stage WHERE PLANNING_STAGE_ID=$wherenum");
                        return true;
                    }
                } else {
                    return self::execRequete("UPDATE common_stage SET $tag=$valeurnum WHERE STAGE_ID=$wherenum");
                }
            case 'STAGE_SUGGESTION_ENS_ID' :
                if ($valeur == "NULL") {
                    return self::execRequete("UPDATE common_stage SET $tag=null WHERE STAGE_ID=$wherenum");
                } else {
                    return self::execRequete("UPDATE common_stage SET $tag=$valeurnum WHERE STAGE_ID=$wherenum");
                }
            case 'STAGE_PLANNING_ID' :
                $annee_courante = Annees::getIdAnneeCourante();
                $tab = explode("$",$where);
                if ($valeurnum > 0) {
                    return self::execRequete("INSERT INTO common_soutenances_planning_stage(PLANNING_STAGE_ID, STAGE_PLANNING_ID, STAGE_PLANNING_ANNEE_ID) VALUES (".$tab[0].",$valeurnum,$annee_courante)");
                } else {
                    return self::execRequete("DELETE FROM common_soutenances_planning_stage WHERE PLANNING_STAGE_ID=".$tab[0]." AND STAGE_PLANNING_ID=".$tab[1]." AND STAGE_PLANNING_ANNEE_ID=$annee_courante");
                }
            case "STAGE_ET_ID" :
                $tab = explode("$",$where);
                if ($valeur == "NULL") {
                    return self::execRequete("UPDATE common_stage SET STAGE_ET_ID=NULL, STAGE_DATE_AFFECTATION=NULL, STAGE_ENS_ID=NULL WHERE STAGE_ET_ID=".$tab[0]." AND STAGE_ANNEE_ID=".$tab[1]);
                }
                if ($valeur == "CSPON") {
                    $data = array("1"=>"1");
                    bfmw_add_secured($data,"*STAGE_SUJET", "Candidature spontanée");
                    bfmw_add_secured($data,"*STAGE_MAIL", "Candidature spontanée");
                    bfmw_add_secured($data,"*STAGE_CONTACT", "Candidature spontanée");
                    bfmw_add_secured($data,"*STAGE_ET_ID", $tab[0]);
                    bfmw_add_secured($data,"*STAGE_DATE", time());
                    bfmw_add_secured($data,"*STAGE_DATE_AFFECTATION", time());
                    bfmw_add_secured($data,"*STAGE_ANNEE_ID", $tab[1]);
                    bfmw_add_secured($data,"*STAGE_REF", "CSP");
                    $id = createData("common_stage",$data,8);
                    if ($id > 0) {
                        return Formations::insertStageFormations($tab[2],$id);
                    }
                    return false;
                }
                $res = self::doRequete("SELECT * FROM common_stage WHERE STAGE_ET_ID=".$tab[0]." AND STAGE_ANNEE_ID=".$tab[1]);
                if ($res->num_rows > 0) {
                    return false;
                }
                return self::execRequete("UPDATE common_stage SET STAGE_ET_ID=".$tab[0].", STAGE_DATE_AFFECTATION=".time()." WHERE STAGE_ID=$valeurnum");
            case "FORM_CANDIDATURES_STAGE_MAX" :
            case "FORM_CANDIDATURES_STAGE_ET_MAX" :
                return self::execRequete("UPDATE common_formation SET $tag=$valeurnum WHERE FORM_ID=$wherenum");
            case "STAGE_FORM_ID":
                $tab = explode("$",$where);
                mysql_start_transaction();
                if ($valeur == 0) {
                    self::execRequete("DELETE FROM common_stage_formations WHERE FORM_STAGE_ID=".$tab[0]." AND STAGE_FORM_ID=".$tab[1]);
                } else {
                    self::execRequete("INSERT INTO common_stage_formations (STAGE_FORM_ID, FORM_STAGE_ID) VALUES (".$tab[1].",".$tab[0].")");
                }
                $req = "SELECT * FROM common_stage_formations WHERE FORM_STAGE_ID=".$tab[0];
                if (self::$conn->query($req)->num_rows == 0) {
                    mysql_rollback();
                    return false;
                } else {
                    mysql_commit();
                }
                return true;
            case "PLANNING_SOUT_MAX":
            case "PLANNING_SOUT_FAITES":
            case "PLANNING_SPE":
                $annee_courante = Annees::getIdAnneeCourante();
                if (isset($_SESSION["ANNEE_COURANTE"])) {
                    $annee_courante = $_SESSION["ANNEE_COURANTE"];
                }
                return self::execRequete("INSERT INTO common_soutenances_planning_enseignant(PLANNING_ENS_ID, PLANNING_ANNEE_ID, PLANNING_DEPT_ID, $tag) VALUES($wherenum,$annee_courante,".CURRENT_DEPT_ID.",$valeurnum) ON DUPLICATE KEY UPDATE $tag=$valeurnum");
            case "CHANGE_JURY" :
                $tab = explode("$",$where);
                if (count($tab) != 7) {
                    return false;
                }
                $et_id = $tab[0];
                $stage_id = $tab[1];
                $session_id = $tab[2];
                $annee_id = $tab[3];
                $dept_id = $tab[4];
                $creneau_id = $tab[5];
                $dispo_date = $tab[6];
                return Generation_Planning_Soutenances::changeJury($valeurnum,$et_id, $stage_id, $session_id, $annee_id, $dept_id,$creneau_id,  $dispo_date);
        }
        return false;
    }

    public static function getPlannings(int $stage_id, int $annee_courante) : array
    {
        $req = "SELECT *,FROM_UNIXTIME(STAGE_DATE_SOUTENANCE ,'%d/%m/%Y') AS STAGE_DATE_SOUTENANCE_AFFICHAGE,
                       FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                       FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE
                    FROM (common_soutenances_planning_stage,common_soutenances_planning)
                    LEFT JOIN common_soutenances_planning_creneau ON (PLANNING_ID=CRENEAU_PLANNING_ID AND CRENEAU_ID=STAGE_SOUTENANCE_CRENEAU_ID)
                    WHERE PLANNING_ID=STAGE_PLANNING_ID AND PLANNING_STAGE_ID = $stage_id AND STAGE_PLANNING_ANNEE_ID=$annee_courante";
        return self::getRequete($req);
    }

    public static function getPlanning(int $planning_id, int $stage_id, int $annee_courante) : array
    {
        $req = "SELECT * FROM common_soutenances_planning,common_soutenances_planning_stage
                WHERE PLANNING_ID=STAGE_PLANNING_ID AND PLANNING_ID=$planning_id AND PLANNING_ANNEE_ID=$annee_courante
                  AND PLANNING_STAGE_ID=$stage_id
                ";
        return self::getRequete($req);
    }

    public static function inPlanning(int $stage_id, string $planning_id, int $annee_courante) : bool
    {
        $req = "SELECT * FROM common_soutenances_planning_stage WHERE STAGE_PLANNING_ID=$planning_id AND PLANNING_STAGE_ID=$stage_id AND STAGE_PLANNING_ANNEE_ID=$annee_courante";
        return self::doRequete($req)->num_rows == 1;
    }

    public static function affecterStageEnAlternance(int $et_id, int $annee_courante, int $form_id, int $ens_id) : bool
    {
        if (! self::desaffecterStageEnAlternance($et_id,$annee_courante)) {
            return false;
        }

        $data = array("1"=>"1");
        bfmw_add_secured($data,"*STAGE_SUJET", "Stage en alternance");
        bfmw_add_secured($data,"*STAGE_MAIL", "Stage en alternance");
        bfmw_add_secured($data,"*STAGE_CONTACT", "Stage en alternance");
        bfmw_add_secured($data,"*STAGE_ET_ID", $et_id);
        bfmw_add_secured($data,"*STAGE_DATE", time());
        bfmw_add_secured($data,"*STAGE_DATE_AFFECTATION", time());
        bfmw_add_secured($data,"*STAGE_ANNEE_ID", $annee_courante);
        bfmw_add_secured($data,"*STAGE_REF", "CSP");
        bfmw_add_secured($data,"*STAGE_ENS_ID", $ens_id);
        $id = createData("common_stage",$data,9);
        if ($id > 0) {
            return Formations::insertStageFormations($form_id,$id);
        }
        return false;
    }

    public static function desaffecterStageEnAlternance(int $et_id, int $annee_courante) : bool
    {
        $req = "SELECT *
                    FROM common_stage, common_soutenances_planning_stage
                    WHERE STAGE_ET_ID=$et_id AND STAGE_ANNEE_ID=$annee_courante AND STAGE_ID=PLANNING_STAGE_ID
                      AND STAGE_ANNEE_ID=STAGE_PLANNING_ANNEE_ID AND STAGE_DATE_SOUTENANCE IS NOT NULL";
        if (self::doRequete($req)->num_rows == 0) {
            $req = "DELETE FROM common_stage WHERE STAGE_ET_ID=$et_id AND STAGE_ANNEE_ID=$annee_courante";
            return self::execRequete($req);
        }

        return false;
    }

    public static function dispenserEtudiant(int $et_id, int $annee_id) : bool
    {
        $req = "UPDATE common_inscription SET INSCRIPT_DISP=1 WHERE INSCRIPT_ET_ID=$et_id AND INSCRIPT_ANNEE_ID=$annee_id";
        return self::execRequete($req);
    }


}