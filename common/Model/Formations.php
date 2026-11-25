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

class Formations extends Connectable
{
    private static array $_global_secretaire = array(-1=>true);
    private static array $_global_responsable = array(-1=>true);
    private static array $_global_chef = array(-1=>true);
    private static array $_global_admin = array(-1=>true);
    private static array $_global_mediateur = array(-1=>true);

    public static function static_init(mysqli $conn)
    {
        parent::static_init($conn);
        $req = "SELECT * FROM common_logon WHERE LOGON_ENS_ID=".CURRENT_ID." AND DEPT_ID=".CURRENT_DEPT_ID." AND FORM_END_ANNEE_ID IS NULL ORDER BY TYPE";
        $logon = self::doRequete($req);

        while ($un_logon = $logon->fetch_assoc()) {
            if ($un_logon['TYPE']=="Responsable") {
                self::$_global_responsable[$un_logon['FORM_ID']] = true;
            }
            if  ($un_logon['TYPE']=="Secrétaire") {
                self::$_global_secretaire[$un_logon['FORM_ID']] = true;
            }
            if  ($un_logon['TYPE']=="Chef") {
                self::$_global_chef[$un_logon['FORM_ID']] = true;
            }
            if  ($un_logon['TYPE']=="Admin") {
                self::$_global_admin[$un_logon['FORM_ID']] = true;
            }
        }

        $req = "SELECT * FROM etudiants_groupes WHERE GROUPE_ENS_ID=" . CURRENT_ID;
        $res = self::doRequete($req);
        while ($un_mediateur = $res->fetch_assoc()) {
            self::$_global_mediateur[$un_mediateur['GROUPE_FORM_ID']] = true;
        }
    }

    public static function getFormationDuDepartement(int $dept_id, int $annee_courante) : array {
        $req = "SELECT * FROM common_formation WHERE FORM_DEPT_ID=$dept_id AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL) ORDER BY FORM_NOM";
        return self::getRequeteAvecClef("FORM_ID",$req);
    }

    public static function getFormationDuDepartementString(int $dept_id, int $annee_courante) : string {
        return implode(",",array_keys(self::getFormationDuDepartement($dept_id,$annee_courante)));
    }

    public static function getFormationsDuGestionnaireDeStage(int $ens_id,int $dept_id, int $annee_courante, string $complement="") : array  {
        $req = "SELECT * FROM common_enseignants_departement,common_formation WHERE $complement ENS_DEPT_ID=FORM_DEPT_ID AND DEPT_ENS_ID=$ens_id AND ENS_DEPT_ID=$dept_id AND ENS_DEPT_STAGE=1 AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL) ORDER BY FORM_NOM";
        return self::getRequeteAvecClef("FORM_ID",$req);
    }

    public static function getFormationDeLEtudiant(int $etudiant,int $annee,string $complement="") : array  {
        $req = "SELECT common_formation.* FROM etudiants_groupes,common_formation WHERE $complement FORM_ID=GROUPE_FORM_ID AND ET_GROUPE_ANNEE_ID=$annee AND ET_ID=$etudiant AND GROUPE_FEUILLE=1 GROUP BY FORM_ID";
        return self::getRequete($req);
    }

    public static function getLesFormationsDeLEtudiant(int $etudiant,int $annee,string $complement="") : array  {
        $req = "SELECT common_formation.* FROM common_inscription,common_semestre,common_formation WHERE $complement FORM_ID=SEM_FORM_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ANNEE_ID=$annee AND INSCRIPT_ET_ID=$etudiant GROUP BY FORM_ID";
        return self::getRequete($req);
    }

    public static function getToutesLesFormationsDeLEtudiant(int $etudiant,string $complement="") : array  {
        $req = "SELECT common_formation.*, INSCRIPT_ANNEE_ID FROM common_inscription,common_semestre,common_formation WHERE $complement FORM_ID=SEM_FORM_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ET_ID=$etudiant GROUP BY FORM_ID,INSCRIPT_ANNEE_ID ORDER BY INSCRIPT_ANNEE_ID";
        return self::getRequete($req);
    }

    public static function getFormationsDeLEnseignantConnecte(int $ENS_ID, int $ANNEE_ID, int $DEPT_ID, $complement = "") : array {
        $req = "SELECT FORM_ID,FORM_NOM
                FROM common_enseignants_matieres,common_matiere,common_ue,common_semestre,common_formation
                WHERE $complement MAT_ID=ENS_MAT_ID AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND FORM_ID=SEM_FORM_ID
                  AND FORM_START_ANNEE_ID <= $ANNEE_ID AND (FORM_END_ANNEE_ID > $ANNEE_ID OR FORM_END_ANNEE_ID IS NULL)
                  AND SEM_START_ANNEE_ID <= $ANNEE_ID AND (SEM_END_ANNEE_ID > $ANNEE_ID OR SEM_END_ANNEE_ID IS NULL)
                  AND UE_START_ANNEE_ID <= $ANNEE_ID AND (UE_END_ANNEE_ID > $ANNEE_ID OR UE_END_ANNEE_ID IS NULL)
                  AND MAT_START_ANNEE_ID <= $ANNEE_ID AND (MAT_END_ANNEE_ID > $ANNEE_ID OR MAT_END_ANNEE_ID IS NULL) 
                  AND MAT_ENS_ID=$ENS_ID AND ENS_MAT_ANNEE_ID=$ANNEE_ID AND FORM_DEPT_ID=$DEPT_ID
                GROUP BY FORM_ID
                ORDER BY FORM_NOM";

        return self::getRequete($req);
    }

    public static function getFormationsDeLEnseignantConnecteString(int $ENS_ID, int $ANNEE_ID, int $DEPT_ID, $complement = "") : string {
        $formations = self::getFormationsDeLEnseignantConnecte($ENS_ID,$ANNEE_ID,$DEPT_ID,$complement);
        $retour = array();
        $retour[] = -1;
        foreach ($formations as $une_formation) {
            $retour[] = $une_formation['FORM_ID'];
        }
        return implode(",",$retour);
    }

    public static function getFormationsDuConnecte(int $dept_id, int $annee_courante = -1, string $complement = "") : array {
        if ($annee_courante !== -1) {
            $limitateur_annee = "AND DEPT_ID=$dept_id AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL)";
        } else {
            $limitateur_annee = "AND DEPT_ID=$dept_id AND FORM_ID IN (".self::getFormationsDuConnecteString().")";
        }
        $req = "SELECT * FROM common_formation,common_departement WHERE FORM_DEPT_ID=DEPT_ID $limitateur_annee $complement ORDER BY DEPT_NOM,DEPT_ID,FORM_NOM,FORM_ID";
        return self::getRequeteAvecClef("FORM_ID",$req);
    }

    public static function getFormation(string $FORM_ID) : array {
        $req = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(FORM_JURY_DEBUT),'%d/%m/%Y') AS DDEBUT,DATE_FORMAT(FROM_UNIXTIME(FORM_JURY_FIN),'%d/%m/%Y') AS DFIN,DATE_FORMAT(FROM_UNIXTIME(FORM_JURY_DEBUT),'%Hh%i') AS HDEBUT,DATE_FORMAT(FROM_UNIXTIME(FORM_JURY_FIN),'%Hh%i') AS HFIN FROM common_formation WHERE FORM_ID IN ($FORM_ID)";
        return self::getRequeteAvecClef("FORM_ID",$req);
    }

    public static function getSemestres(string $formations,int $ANNEE_ID) : array {
        $req = "SELECT * FROM common_semestre,common_formation,common_departement WHERE DEPT_ID=FORM_DEPT_ID AND FORM_START_ANNEE_ID <= $ANNEE_ID AND (FORM_END_ANNEE_ID > $ANNEE_ID OR FORM_END_ANNEE_ID IS NULL) AND SEM_START_ANNEE_ID <= $ANNEE_ID AND (SEM_END_ANNEE_ID > $ANNEE_ID OR SEM_END_ANNEE_ID IS NULL) AND  FORM_ID=SEM_FORM_ID AND SEM_FORM_ID IN ($formations) ORDER BY FORM_ID,FORM_NOM,SEM_ORDRE,SEM_NOM";
        return self::getRequete($req);
    }

    public static function getSemestresPourUnGroupe(string $GROUPE_CODE) : array {
        $req = "select GROUPE_ID, SEM_ID, SEM_NOM, GROUPE_SEM_ID
                from common_semestres_groupes
                         join common_groupes ON (GROUPE_ID = SEM_GROUPE_ID)
                         join common_semestre ON (SEM_ID = GROUPE_SEM_ID)
                 WHERE GROUPE_CODE LIKE  CONCAT('$GROUPE_CODE','%')
                 GROUP BY SEM_ID
                 ORDER BY SEM_ORDRE";
        return self::getRequete($req);
    }


    public static function getSemestresSeuls(int $annee_courante) : array {
        $req = "SELECT * FROM common_semestre,common_formation WHERE  FORM_ID=SEM_FORM_ID ORDER BY FORM_ID,FORM_NOM,SEM_ID,SEM_NOM";
        return self::getRequete($req);
    }

    public static function getUEAvecControleDuSemestre(int $SEM_ID, int $annee_courante) : array {
        $req = "SELECT UE_ID FROM common_controle,common_matiere,common_ue WHERE UE_ID=MAT_UE_ID AND MAT_ID=CONTROLE_MAT_ID AND UE_SEM_ID=$SEM_ID AND CONTROLE_ANNEE_ID=$annee_courante GROUP BY UE_ID";
        return self::getRequete($req);
    }

    public static function getMatieresAvecControleDeUE(int $UE_ID,int $annee_courante) : array {
        $req = "SELECT MAT_ID FROM common_controle,common_matiere WHERE MAT_ID=CONTROLE_MAT_ID AND MAT_UE_ID=$UE_ID AND CONTROLE_ANNEE_ID=$annee_courante GROUP BY MAT_ID";
        return self::getRequete($req);
    }

    public static function getControlesDeMatiere(int $MAT_ID,int $annee_courante) : array {
        $req = "SELECT * FROM common_matiere WHERE MAT_ID=$MAT_ID";
        $un_element = self::doRequete($req)->fetch_assoc();
        if ($un_element['MAT_HAS_NOTE']) {
            $req = "SELECT CONTROLE_ID FROM common_controle WHERE CONTROLE_MAT_ID=" . $un_element['MAT_ID'] . " AND CONTROLE_ANNEE_ID=" . $annee_courante . " GROUP BY CONTROLE_ID";
        } else {
            $req = "SELECT MAT_ID FROM common_matiere,common_controle WHERE CONTROLE_MAT_ID=MAT_ID AND CONTROLE_ANNEE_ID=" . $annee_courante . " AND MAT_SURMAT_ID = " . $un_element['MAT_ID'] . " GROUP BY MAT_ID";
        }
        return self::getRequete($req);
    }

    public static function getMatieresAvecRacine(int $UE_ID,int $annee_courante,string $completement="") : array {
        $req = "SELECT *,IF(MAT_START_ANNEE_ID=$annee_courante,1,0) AS NEW_MAT FROM common_matiere WHERE $completement MAT_UE_ID=$UE_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) ORDER BY MAT_ORDRE,MAT_NOM";
        $retour = array();
        $res = self::doRequete($req);
        while ($une_matiere = $res->fetch_assoc()) {
            $une_matiere['VIDE'] = count(self::getControlesDeMatiere($une_matiere['MAT_ID'],$annee_courante))==0;
            if ($une_matiere['MAT_SURMAT_ID'] == "") {
                $retour['ROOT'][] = $une_matiere;
            } else {
                $retour[$une_matiere['MAT_SURMAT_ID']][] = $une_matiere;
            }
        }
        return $retour;
    }

    public static function getMatieresAvecRacineEtSemestre(int $UE_ID,int $annee_courante,string $completement="") : array {
        $req = "SELECT *,IF(MAT_START_ANNEE_ID=$annee_courante,1,0) AS NEW_MAT FROM common_matiere,common_ue,common_semestre WHERE $completement MAT_UE_ID=$UE_ID AND UE_ID=$UE_ID AND SEM_ID=UE_SEM_ID AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) ORDER BY MAT_ORDRE,MAT_NOM";
        $retour = array();
        $res = self::doRequete($req);
        while ($une_matiere = $res->fetch_assoc()) {
            $une_matiere['VIDE'] = count(self::getControlesDeMatiere($une_matiere['MAT_ID'],$annee_courante))==0;
            if ($une_matiere['MAT_SURMAT_ID'] == "") {
                $retour['ROOT'][] = $une_matiere;
            } else {
                $retour[$une_matiere['MAT_SURMAT_ID']][] = $une_matiere;
            }
        }
        return $retour;
    }

    public static function getMatieresAffectees(int $UE_ID, int $ENS_ID,int $annee_courante) : array {
        $enseignant = "";
        if ($ENS_ID !== -1) {
            $enseignant = "AND MAT_ENS_ID=$ENS_ID";
        }
        $req = "SELECT * FROM common_matiere,common_enseignants_matieres WHERE MAT_COPIE_MAT_ID IS NULL AND MAT_ID=ENS_MAT_ID $enseignant AND ENS_MAT_ANNEE_ID=$annee_courante AND MAT_UE_ID=$UE_ID AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)";
        $retour = array();
        $les_id = array(-1);
        do {
            $res = self::doRequete($req);
            $taille_depart = count($les_id);
            while ($une_matiere = $res->fetch_assoc()) {
                $les_id[] = $une_matiere['MAT_ID'];
                if ($une_matiere['MAT_SURMAT_ID'] != "") {
                    $les_id[] = $une_matiere['MAT_SURMAT_ID'];
                }
            }
            $les_id = array_unique($les_id);
            $req = "SELECT * FROM common_matiere WHERE MAT_ID IN (" . implode(",", $les_id) . ") ORDER BY MAT_NOM";
        } while ($taille_depart != count($les_id));

        $req = "SELECT * FROM common_matiere WHERE MAT_ID IN (".implode(",",$les_id).") ORDER BY MAT_NOM";
        $res = self::doRequete($req);
        while ($une_matiere = $res->fetch_assoc()) {
            $une_matiere['VIDE'] = count(self::getControlesDeMatiere($une_matiere['MAT_ID'],$annee_courante))==0;
            if ($une_matiere['MAT_SURMAT_ID'] == "") {
                $retour['ROOT'][] = $une_matiere;
            } else {
                $retour[$une_matiere['MAT_SURMAT_ID']][] = $une_matiere;
            }
        }
        return $retour;
    }

    public static function insertStageFormations($formation_id,$stage_id) : bool {
        return self::execRequete("INSERT INTO common_stage_formations(STAGE_FORM_ID, FORM_STAGE_ID) VALUES ($formation_id,$stage_id)");
    }

    public static function getMaquette(int $DEPT_ID, int $ANNEE_ID, string $complement = "") : array {
        $req = "SELECT *,IF(SEM_START_ANNEE_ID=$ANNEE_ID,1,0) AS NEW_SEM,IF(UE_START_ANNEE_ID=$ANNEE_ID,1,0) AS NEW_UE,IF(MAT_START_ANNEE_ID=$ANNEE_ID,1,0) AS NEW_MAT
                FROM common_departement
                LEFT JOIN common_formation ON (DEPT_ID=FORM_DEPT_ID AND FORM_START_ANNEE_ID <= $ANNEE_ID AND (FORM_END_ANNEE_ID > $ANNEE_ID OR FORM_END_ANNEE_ID IS NULL))
                LEFT JOIN common_semestre ON (FORM_ID = SEM_FORM_ID  AND SEM_START_ANNEE_ID <= $ANNEE_ID AND (SEM_END_ANNEE_ID > $ANNEE_ID OR SEM_END_ANNEE_ID IS NULL))
                LEFT JOIN common_ue ON (SEM_ID = UE_SEM_ID AND UE_START_ANNEE_ID <= $ANNEE_ID AND (UE_END_ANNEE_ID > $ANNEE_ID OR UE_END_ANNEE_ID IS NULL))
                LEFT JOIN common_matiere ON (UE_ID = MAT_UE_ID AND MAT_START_ANNEE_ID <= $ANNEE_ID AND (MAT_END_ANNEE_ID > $ANNEE_ID OR MAT_END_ANNEE_ID IS NULL))
                WHERE $complement  FORM_DEPT_ID=$DEPT_ID
                ORDER BY FORM_NOM,FORM_ID,SEM_ORDRE,SEM_NOM,SEM_ID,UE_ORDRE,UE_NOM,UE_ID,MAT_ORDRE,MAT_NOM,MAT_ID";
        return self::getRequete($req);
    }

    public static function getMaquetteSansMatiere(int $DEPT_ID, int $ANNEE_ID, string $complement = "") : array {
        $req = "SELECT *,IF(SEM_START_ANNEE_ID=$ANNEE_ID,1,0) AS NEW_SEM,IF(UE_START_ANNEE_ID=$ANNEE_ID,1,0) AS NEW_UE
                FROM common_departement, common_formation, common_semestre
                LEFT JOIN common_ue ON (SEM_ID = UE_SEM_ID AND UE_START_ANNEE_ID <= $ANNEE_ID AND (UE_END_ANNEE_ID > $ANNEE_ID OR UE_END_ANNEE_ID IS NULL))
                WHERE $complement  FORM_DEPT_ID=$DEPT_ID AND DEPT_ID=FORM_DEPT_ID AND FORM_ID = SEM_FORM_ID AND FORM_START_ANNEE_ID <= $ANNEE_ID AND (FORM_END_ANNEE_ID > $ANNEE_ID OR FORM_END_ANNEE_ID IS NULL) AND SEM_START_ANNEE_ID <= $ANNEE_ID AND (SEM_END_ANNEE_ID > $ANNEE_ID OR SEM_END_ANNEE_ID IS NULL)
                ORDER BY FORM_NOM,FORM_ID,SEM_ORDRE,SEM_NOM,SEM_ID,UE_ORDRE,UE_NOM,UE_ID";

        return self::getRequete($req);
    }

    public static function getMaquettePourEnseignant(int $ENS_ID, int $DEPT_ID, int $annee_courante, string $complement = "", ?string $groupe_id = null, string $group_by = "UE_ID") : array {
        if ($ENS_ID != -1) {
            $enseignant = "AND MAT_ENS_ID=$ENS_ID";
        } else {
            $enseignant = "";
        }
        if ($groupe_id != null) {
            $groupe = "AND INSCRIPT_ET_ID IN (SELECT DISTINCT ET_ID FROM etudiants_groupes WHERE GROUPE_ID IN ($groupe_id) AND ET_GROUPE_ANNEE_ID=$annee_courante)";
        } else {
            $groupe = "";
        }
        $req = "SELECT *,FROM_UNIXTIME(ENS_MAT_EVAL_DATE_DEBUT) AS EVAL_DEBUT,FROM_UNIXTIME(ENS_MAT_EVAL_DATE_FIN) AS EVAL_FIN FROM common_departement,common_formation,common_semestre, common_ue, common_matiere, common_enseignants_matieres,common_inscription
                WHERE $complement SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL)
                AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL)
                AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL)
                AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)
                AND INSCRIPT_ANNEE_ID = $annee_courante AND SEM_ID = INSCRIPT_SEM_ID
                $groupe
                AND DEPT_ID=FORM_DEPT_ID AND FORM_ID=SEM_FORM_ID AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID
                AND MAT_ID=ENS_MAT_ID AND ENS_MAT_ANNEE_ID=$annee_courante
                $enseignant AND DEPT_ID=$DEPT_ID
                GROUP BY $group_by
                ORDER BY FORM_NOM,FORM_ID,SEM_NOM,SEM_ID,UE_NOM, UE_ID,MAT_ID,MAT_NOM";
        return self::getRequete($req);
    }

    public static function getMatiere(int $MAT_ID) : array {
        $req = "SELECT * FROM common_matiere WHERE MAT_ID=$MAT_ID";
        return self::getRequete($req)[0] ?? array();
    }

    public static function getFormationDuSemestre(int $SEM_ID) : ?array {
        $req = "SELECT * FROM common_formation,common_semestre WHERE FORM_ID=SEM_FORM_ID AND SEM_ID=$SEM_ID";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            return null;
        }
        return self::getRequete($req)[0];
    }

    public static function getFormationDeUE(int $ue_id) : ?array {
        $req = "SELECT * FROM common_formation,common_semestre,common_ue WHERE FORM_ID=SEM_FORM_ID AND SEM_ID=UE_SEM_ID AND UE_ID=$ue_id";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            return null;
        }
        return self::getRequete($req)[0];
    }

    public static function getFormationDeLaMatiere(int $mat_id) : ?array {
        $req = "SELECT * FROM common_formation,common_semestre,common_ue,common_matiere WHERE FORM_ID=SEM_FORM_ID AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND MAT_ID=$mat_id";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            return null;
        }
        return self::getRequete($req)[0];
    }

    public static function getFormationsDuConnecteString() : string {
        $formations_autorisees = "0";
        if (isAdmin()){
            $formations_autorisees = self::getFormationsAdmin();
        }
        if (self::isChef()) {
            $formations_autorisees = self::getFormationsDuChef();
        }
        if (self::isResponsable()) {
            $formations_autorisees = self::getFormationsDuResponsable();
        }
        if (self::isSecretaire()){
            $formations_autorisees = self::getFormationsDuSecretaire();
        }
        if (self::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
            $formations_autorisees = implode(",",array_keys(self::getFormationsDuGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID, Annees::getIdAnneeCourante())));
        }

        return $formations_autorisees;
    }

    public static function getFormationsAyantDesExplications(int $DEPT_ID, int $annee_courante, ?int $SESSION_ID = null, string $formation_id = "") : array {
        $req = "SELECT * FROM common_soutenances_explications,common_soutenances_niveau,common_formation,common_soutenances_destination
                WHERE DEST_ID=NIVEAU_DEST_ID AND NIVEAU_ID=EXPLICATION_NIVEAU_ID AND FORM_ID=NIVEAU_FORM_ID AND FORM_DEPT_ID=$DEPT_ID
                    AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL)
                ".($SESSION_ID==null?"":"AND DEST_SESSION_ID=$SESSION_ID ")
                .($formation_id == ""?"":"AND FORM_ID IN ($formation_id) ")."
                GROUP BY FORM_ID
                ORDER BY FORM_NOM";
        return self::getRequete($req);
    }

    public static function supprimerAffectationEnseignantMatiere(int $MAT_ID,int $ANNEE_ID, int $ENS_ID) : int {
        $req = "DELETE FROM common_enseignants_matieres WHERE ENS_MAT_ID=$MAT_ID AND ENS_MAT_ANNEE_ID=$ANNEE_ID AND MAT_ENS_ID=$ENS_ID";
        return self::execRequeteAvecAffected($req);
    }

    public static function recopierVersAnneeSuivante(int $ANNEE_ID) : bool {
        self::startTransaction();
        $req = "DELETE FROM common_enseignants_matieres WHERE ENS_MAT_ANNEE_ID=".($ANNEE_ID+1);
        if (!self::execRequete($req)) {
            self::rollback();
            return false;
        }

        $req = "SELECT * FROM common_enseignants_matieres WHERE ENS_MAT_ANNEE_ID=$ANNEE_ID FOR UPDATE";
        $res = self::doRequete($req);
        while ($un_enseignant = $res->fetch_assoc()) {
            $req = "INSERT INTO common_enseignants_matieres(
                    ENS_MAT_ID,MAT_ENS_ID,ENS_MAT_ANNEE_ID,ENS_MAT_NOTEUR,
                    ENS_MAT_EVALUABLE,ENS_MAT_EVAL_DATE_DEBUT,ENS_MAT_EVAL_DATE_FIN,ENS_MAT_POURSUITE) VALUES (".
                        $un_enseignant["ENS_MAT_ID"].",".$un_enseignant["MAT_ENS_ID"].",".($un_enseignant["ENS_MAT_ANNEE_ID"]+1).",".
                        (int)$un_enseignant["ENS_MAT_NOTEUR"].",".(int)$un_enseignant["ENS_MAT_EVALUABLE"].",".
                        ($un_enseignant["ENS_MAT_EVAL_DATE_DEBUT"]==""?"NULL":$un_enseignant["ENS_MAT_EVAL_DATE_DEBUT"]).",".
                        ($un_enseignant["ENS_MAT_EVAL_DATE_FIN"]==""?"NULL":$un_enseignant["ENS_MAT_EVAL_DATE_FIN"]).",".(int)$un_enseignant["ENS_MAT_POURSUITE"].")";
            $id = self::execRequeteAvecInsertId($req);
            if ($id > 0) {
                $req = "SELECT * FROM common_charge_v2 WHERE CHARGE_AFFECTATION_ID=".$un_enseignant["ID"];
                $les_charges = self::getRequete($req);
                foreach ($les_charges as $une_charge) {
                    $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                                VALUES ($id," . $une_charge['CHARGE_GROUPE'] . "," . $une_charge['CHARGE_MULTIPLICATEUR'] . ",'" . $une_charge['CHARGE_TYPE'] . "'," . $une_charge['CHARGE_VALEUR'] . "," . ($une_charge['CHARGE_SEMAINE']??1) .")";
                    if (self::execRequeteAvecAffected($req) != 1) {
                        self::rollback();
                        return false;
                    }
                }
            } else {
                self::rollback();
                return false;
            }
        }

        self::commit();
        return true;
    }

    public static function isSecretaire() : bool {
        return count(self::$_global_secretaire) > 1;
    }

    public static function isSecretaireFormation(string $formation) : bool {
        return isset(self::$_global_secretaire[$formation]);
    }

    public static function isResponsable() : bool {
        return count(self::$_global_responsable) > 1;
    }

    public static function isResponsableFormation(string $formation) : bool {
        return isset(self::$_global_responsable[$formation]);
    }

    public static function isChef() : bool {
        return count(self::$_global_chef) > 1;
    }

    public static function isChefFormation(string $formation) : bool {
        return isset(self::$_global_chef[$formation]);
    }

    public static function isMediateur() : bool {
        return count(self::$_global_mediateur) > 1;
    }

    public static function getFormationsDuResponsable() : string {
        return implode(",",array_keys(self::$_global_responsable));
    }

    public static function getFormationsDuSecretaire() : string {
        return implode(",",array_keys(self::$_global_secretaire));
    }

    public static function getFormationsDuChef() : string {
        return implode(",",array_keys(self::$_global_chef));
    }

    public static function getFormationsAdmin() : string {
        return implode(",",array_keys(self::$_global_admin));
    }

    public static function isRetourActif(int $ET_ID,int $today, int $annee_courante) : bool {
        $req = "SELECT ET_ID FROM common_etudiant,common_inscription,common_annee,common_semestre,common_formation WHERE ANNEE_COURANTE = 1 AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL) AND ANNEE_ID=INSCRIPT_ANNEE_ID AND ET_ID=INSCRIPT_ET_ID AND SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=SEM_FORM_ID AND FORM_EVALUABLE = 1 AND ET_ID=$ET_ID AND FORM_EVAL_DEBUT <= $today AND FORM_EVAL_FIN >= $today GROUP BY ET_ID";
        $retour = self::doRequete($req)->num_rows === 1;
        $req = "SELECT * FROM affectations_enseignants,common_inscription,common_eval_groupe_enseignement WHERE ID=GROUPE_ID_ID AND ID_GROUPE_ID IN (".Groupes::getGroupeEtudiantString($ET_ID,$annee_courante).") AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ANNEE_ID=$annee_courante AND INSCRIPT_ET_ID=$ET_ID AND ENS_MAT_EVAL_DATE_DEBUT<=$today AND ENS_MAT_EVAL_DATE_FIN>=$today";
        $res = self::doRequete($req);
        if ($res !== false) {
            $retour |= $res->num_rows >= 1;
        }
        return $retour;
    }

    public static function isSelectionPoursuite(int $ET_ID, int $DEPT_ID,int $today) : bool {
        $req = "SELECT * FROM etudiants_groupes,common_departement WHERE DEPT_POURSUITE_DDEB <= $today AND DEPT_POURSUITE_DFIN > $today AND GROUPE_POURSUITE=1 AND ET_ID=$ET_ID AND DEPT_ID=$DEPT_ID GROUP BY ET_ID";
        return self::doRequete($req)->num_rows > 0;
    }

    public static function deplacerElement(string $table, string $prefixe, string $identifier,int $identifier_id,int $element_id,int $offset,int $ancienne_position, int $annee_courante) : bool
    {
        if ($ancienne_position+$offset < 0) {
            return false;
        }
        self::startTransaction();
        $req = "UPDATE $table SET ".$prefixe."_ORDRE=".$prefixe."_ORDRE+($offset*-1) WHERE $identifier=$identifier_id AND ".$prefixe."_ORDRE=$ancienne_position+$offset AND ".$prefixe."_START_ANNEE_ID <= $annee_courante AND (".$prefixe."_END_ANNEE_ID > $annee_courante OR ".$prefixe."_END_ANNEE_ID IS NULL) LIMIT 1";
        if (self::execRequete($req)) {
            $req = "UPDATE $table SET ".$prefixe."_ORDRE=".$prefixe."_ORDRE+$offset WHERE ".$prefixe."_ID=$element_id";
            if (self::execRequete($req)) {
                self::commit();
            }
            return true;
        }
        self::rollback();
        return false;
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "DEPT_NOM" :
            case "DEPT_ENS_ID" :
                $req = "UPDATE common_departement SET " . $tag . "='" . $valeur . "' WHERE DEPT_ID=" . $wherenum . (isAdmin() ? "" : " AND DEPT_ENS_ID=" . CURRENT_ID);
                return self::execRequete($req);
                break;
            case "FORM_NOM" :
            case "FORM_NOM_COURT" :
            case "FORM_REGIME" :
            case "FORM_PRO" :
            case "FORM_EVALUABLE" :
            case "FORM_ABSENCES_AUTO" :
            case "FORM_SIGNATURE_SUR_TABLETTES" :
            case "FORM_AUTORISE_SIGNATURES_ANTICIPEES" :
            case "FORM_MINUTES_SIGNATURES" :
            case "FORM_RATIO_ES" :
            case "FORM_RATIO_E" :
            case "FORM_RATIO_V" :
                if (Formations::isResponsableFormation($wherenum) || isAdmin() || Formations::isSecretaireFormation($wherenum)) {
                    $req = "UPDATE common_formation SET " . $tag . "='" . $valeur . "' WHERE FORM_ID=" . $wherenum;
                    return self::execRequete($req);
                }
                break;
            case "SEM_NOM" :
            case "SEM_COEF" :
                $form_id = Formations::getFormationDuSemestre($wherenum)["FORM_ID"];
                if (Formations::isResponsableFormation($form_id) || isAdmin() || Formations::isSecretaireFormation($form_id)) {
                    $req = "UPDATE common_semestre SET " . $tag . "='" . $valeur . "' WHERE SEM_ID=$wherenum";
                    return self::execRequete($req);
                }
                break;
            case "UE_NOM" :
            case "UE_COEF" :
            case "UE_CODE_APOGEE" :
                $form_id = Formations::getFormationDeUE($wherenum)["FORM_ID"];
                if (Formations::isResponsableFormation($form_id) || isAdmin() || Formations::isSecretaireFormation($form_id)) {
                    $req = "UPDATE common_ue SET " . $tag . "='" . $valeur . "' WHERE UE_ID=$wherenum";
                    return self::execRequete($req);
                }
                break;
            case "MAT_NOM" :
            case "MAT_COEF" :
            case "MAT_CODE_APOGE" :
            case "MAT_HAS_NOTE" :
            case "MAT_SURMAT_ID" :
            case "MAT_COPIE_MAT_ID" :
                $form_id = Formations::getFormationDeLaMatiere($wherenum)["FORM_ID"];
                if (Formations::isResponsableFormation($form_id) || isAdmin() || Formations::isSecretaireFormation($form_id)) {
                    if ($tag == "MAT_COPIE_MAT_ID" && $valeurnum == $wherenum) {
                        return false;
                    }
                    $req = "UPDATE common_matiere SET " . $tag . "=" . ($valeur === "NULL" ? "NULL" : "'" . $valeur . "'") . " WHERE MAT_ID=" . $wherenum;
                    return self::execRequete($req);
                }
                break;
            case "MAT_PERIODE_ID" :
                $tab = explode("$",$where);
                if (Formations::isResponsableFormation($tab[0]) || isAdmin() || Formations::isSecretaireFormation($tab[0])) {
                    if ($valeurnum != 0) {
                       $req = "INSERT INTO common_periodes_matieres(PERIODE_MAT_ID, MAT_PERIODE_ID) VALUES ($tab[1],$tab[2])";
                    } else {
                        $req = "DELETE FROM common_periodes_matieres WHERE PERIODE_MAT_ID=$tab[1] AND MAT_PERIODE_ID=$tab[2]";
                    }
                    return self::execRequete($req);
                } else {
                    return false;
                }
            case "ENS_MAT_EVAL_DATE_FIN":
            case "ENS_MAT_EVAL_DATE_DEBUT":
                try {
                    $date = transformDateHeure($valeur);
                    $req = "UPDATE common_enseignants_matieres SET $tag=$date WHERE ID=$wherenum";
                    return self::execRequete($req);
                } catch (Exception $e) {
                }
                break;
        }
        return false;
    }

    public static function getFormations(int $annee_courante) : array
    {
        $req = "SELECT * FROM common_formation,common_departement WHERE DEPT_ID=FORM_DEPT_ID AND FORM_START_ANNEE_ID <= $annee_courante AND (FORM_END_ANNEE_ID > $annee_courante OR FORM_END_ANNEE_ID IS NULL) ORDER BY DEPT_NOM, DEPT_ID, FORM_NOM, FORM_ID";
        return self::getRequete($req);
    }

    public static function isGestionnaireDeStage(int $ens_id, int $dept_id) : bool
    {
        $req = "SELECT * FROM common_enseignants_departement WHERE DEPT_ENS_ID=$ens_id AND ENS_DEPT_ID=$dept_id AND ENS_DEPT_STAGE=1";
        return self::doRequete($req)->num_rows == 1;
    }

    public static function importMaquette(array $tableau_de_lignes,int $FORM_ID, int $annee_courante) : bool
    {
        self::startTransaction();
        $numero_semestre = 1;
        $numero_ue = 1;
        $numero_matue = 1;
        $numero_matmod = 1;
        $semestre_precedent = -1;
        $ue_precedente = -1;
        $module_precedent = -1;

        foreach ($tableau_de_lignes as $une_ligne) {
            if (trim($une_ligne) === "") {
                continue;
            }
            $premier_caractere = $une_ligne[0];
            switch ($premier_caractere) {
                case "#" : break;
                case "1" :
                    $to_save = array();
                    bfmw_add_secured($to_save,"*SEM_NOM",htmlspecialchars(addslashes(trim(substr($une_ligne,1,strlen($une_ligne)))),ENT_SUBSTITUTE));
                    bfmw_add_secured($to_save,"*SEM_FORM_ID",$FORM_ID);
                    bfmw_add_secured($to_save,"*SEM_START_ANNEE_ID",$annee_courante);
                    bfmw_add_secured($to_save,"*SEM_ORDRE",$numero_semestre++);
                    $semestre_precedent = createData("common_semestre", $to_save, 4);
                    if ($semestre_precedent < 1) {
                        self::rollback();
                        return false;
                    }
                    $numero_ue = 1;
                    $ue_precedente = -1;
                    $module_precedent = -1;
                    break;
                case "2" :
                    $to_save = array();
                    bfmw_add_secured($to_save,"*UE_NOM",htmlspecialchars(addslashes(trim(substr($une_ligne,1,strlen($une_ligne)))),ENT_SUBSTITUTE));
                    bfmw_add_secured($to_save,"*UE_SEM_ID",$semestre_precedent);
                    bfmw_add_secured($to_save,"*UE_START_ANNEE_ID",$annee_courante);
                    bfmw_add_secured($to_save,"*UE_ORDRE",$numero_ue++);
                    $ue_precedente = createData("common_ue", $to_save, 4);
                    if ($ue_precedente < 1) {
                        self::rollback();
                        return false;
                    }
                    $module_precedent = -1;
                    $numero_matue = 1;
                    $numero_matmod = 1;
                    break;
                case "3" :
                    $to_save = array();
                    bfmw_add_secured($to_save,"*MAT_NOM",htmlspecialchars(addslashes(trim(substr($une_ligne,1,strlen($une_ligne)))),ENT_SUBSTITUTE));
                    bfmw_add_secured($to_save,"*MAT_UE_ID",$ue_precedente);
                    bfmw_add_secured($to_save,"*MAT_START_ANNEE_ID",$annee_courante);
                    bfmw_add_secured($to_save,"*MAT_HAS_NOTE",0);
                    bfmw_add_secured($to_save,"*MAT_CODE_APOGE","");
                    bfmw_add_secured($to_save,"*MAT_SURMAT_ID","NULL");
                    bfmw_add_secured($to_save,"*MAT_ORDRE",$numero_matue++);
                    $module_precedent = createData("common_matiere", $to_save, 7);
                    if ($module_precedent < 1) {
                        self::rollback();
                        return false;
                    }
                    break;
                case "4" :
                    $to_save = array();
                    bfmw_add_secured($to_save,"*MAT_NOM",htmlspecialchars(addslashes(trim(substr($une_ligne,1,strlen($une_ligne)))),ENT_SUBSTITUTE));
                    bfmw_add_secured($to_save,"*MAT_UE_ID",$ue_precedente);
                    bfmw_add_secured($to_save,"*MAT_START_ANNEE_ID",$annee_courante);
                    bfmw_add_secured($to_save,"*MAT_HAS_NOTE",0);
                    bfmw_add_secured($to_save,"*MAT_CODE_APOGE","");
                    bfmw_add_secured($to_save,"*MAT_SURMAT_ID",$module_precedent);
                    bfmw_add_secured($to_save,"*MAT_ORDRE",$numero_matmod++);
                    $module_precedent = createData("common_matiere", $to_save, 7);
                    if ($module_precedent < 1) {
                        self::rollback();
                        return false;
                    }
                    $numero_matmod = 1;
                    break;
                case "5" :
                    $to_save = array();
                    bfmw_add_secured($to_save,"*MAT_NOM",htmlspecialchars(addslashes(trim(substr($une_ligne,1,strlen($une_ligne)))),ENT_SUBSTITUTE));
                    bfmw_add_secured($to_save,"*MAT_UE_ID",$ue_precedente);
                    bfmw_add_secured($to_save,"*MAT_START_ANNEE_ID",$annee_courante);
                    bfmw_add_secured($to_save,"*MAT_LOCK_ANNEE_ID",$annee_courante-1);
                    bfmw_add_secured($to_save,"*MAT_HAS_NOTE",1);
                    bfmw_add_secured($to_save,"*MAT_CODE_APOGE","");
                    bfmw_add_secured($to_save,"*MAT_SURMAT_ID",$module_precedent);
                    bfmw_add_secured($to_save,"*MAT_ORDRE",$numero_matmod++);
                    if (createData("common_matiere", $to_save, 8) < 1) {
                        self::rollback();
                        return false;
                    }
                    break;
                case "6" :
                    $to_save = array();
                    bfmw_add_secured($to_save,"*MAT_NOM",htmlspecialchars(addslashes(trim(substr($une_ligne,1,strlen($une_ligne)))),ENT_SUBSTITUTE));
                    bfmw_add_secured($to_save,"*MAT_UE_ID",$ue_precedente);
                    bfmw_add_secured($to_save,"*MAT_START_ANNEE_ID",$annee_courante);
                    bfmw_add_secured($to_save,"*MAT_LOCK_ANNEE_ID",$annee_courante-1);
                    bfmw_add_secured($to_save,"*MAT_HAS_NOTE",1);
                    bfmw_add_secured($to_save,"*MAT_CODE_APOGE","");
                    bfmw_add_secured($to_save,"*MAT_SURMAT_ID","NULL");
                    bfmw_add_secured($to_save,"*MAT_ORDRE",$numero_matue++);
                    if (createData("common_matiere", $to_save, 8) < 1) {
                        self::rollback();
                        return false;
                    }
                    break;
            }
        }

        self::commit();
        return true;

    }

    public static function getOrdreMaxSemestre(int $form_id,int $annee_courante) : int
    {
        $req = "SELECT MAX(SEM_ORDRE) AS TOTAL FROM common_semestre WHERE SEM_FORM_ID=$form_id AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL)";
        $tableau = self::getRequete($req);
        foreach ($tableau as $un_element) {
            return $un_element["TOTAL"]==null?0:$un_element["TOTAL"];
        }
        return 0;
    }

    public static function getOrdreMaxUe(int $sem_id,int $annee_courante)
    {
        $req = "SELECT MAX(UE_ORDRE) AS TOTAL FROM common_ue WHERE UE_SEM_ID=$sem_id AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL)";
        $tableau = self::getRequete($req);
        foreach ($tableau as $un_element) {
            return $un_element["TOTAL"]==null?0:$un_element["TOTAL"];
        }
        return 0;
    }

    public static function getOrdreMaxMatSurMat(int $surmat_id, $annee_courante)
    {
        $req = "SELECT MAX(MAT_ORDRE) AS TOTAL FROM common_matiere WHERE MAT_SURMAT_ID=$surmat_id AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)";
        $tableau = self::getRequete($req);
        foreach ($tableau as $un_element) {
            return $un_element["TOTAL"]==null?0:$un_element["TOTAL"];
        }
        return 0;
    }

    public static function getOrdreMaxMat(int $ue_id, $annee_courante)
    {
        $req = "SELECT MAX(MAT_ORDRE) AS TOTAL FROM common_matiere WHERE MAT_UE_ID=$ue_id AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL)";
        $tableau = self::getRequete($req);
        foreach ($tableau as $un_element) {
            return $un_element["TOTAL"]==null?0:$un_element["TOTAL"];
        }
        return 0;
    }

    public static function SwitchMatieres(int $MAT_ID, int $annee_id, ?int $ue_id = null, ?int $surmat_id = null, ?int $copie_id = null): bool
    {
        $req = "SELECT * FROM common_matiere WHERE MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=" . $MAT_ID;
        $les_matieres = self::getRequete($req);
        foreach ($les_matieres as $une_matiere) {
            $copie = array();
            bfmw_add_secured($copie,"*MAT_NOM",htmlspecialchars(addslashes($une_matiere["MAT_NOM"])));
            bfmw_add_secured($copie,"*MAT_UE_ID",$ue_id??$une_matiere["MAT_UE_ID"]);
            bfmw_add_secured($copie,"*MAT_CODE_APOGE",$une_matiere["MAT_CODE_APOGE"]);
            bfmw_add_secured($copie,"*MAT_COEF", $une_matiere["MAT_COEF"]);
            bfmw_add_secured($copie,"*MAT_SURMAT_ID",$surmat_id??($une_matiere["MAT_SURMAT_ID"]??"NULL"));
            bfmw_add_secured($copie,"*MAT_HAS_NOTE",$une_matiere["MAT_HAS_NOTE"]);
            bfmw_add_secured($copie,"*MAT_LOCK_ANNEE_ID",$une_matiere["MAT_LOCK_ANNEE_ID"]);
            bfmw_add_secured($copie,"*MAT_START_ANNEE_ID", $annee_id);
            bfmw_add_secured($copie,"*MAT_END_ANNEE_ID", "NULL");
            bfmw_add_secured($copie,"*MAT_ORDRE", $une_matiere["MAT_ORDRE"]);
            bfmw_add_secured($copie,"*MAT_COPIE_MAT_ID", $copie_id??($une_matiere["MAT_COPIE_MAT_ID"]??"NULL"));
            $nouvelle_matiere = createData("common_matiere",$copie,11);

            if ($nouvelle_matiere <= 0) {
                return false;
            }

            $req = "SELECT * FROM common_periodes_matieres WHERE PERIODE_MAT_ID=$MAT_ID";
            $les_periodes = self::getRequete($req);
            foreach ($les_periodes as $une_periode) {
                $copie = array();
                bfmw_add_secured($copie,"*PERIODE_MAT_ID",$nouvelle_matiere);
                bfmw_add_secured($copie,"*MAT_PERIODE_ID",$une_periode["MAT_PERIODE_ID"]);
                createData("common_periodes_matieres",$copie,2);
            }

            $req = "UPDATE common_controle SET CONTROLE_MAT_ID=$nouvelle_matiere WHERE CONTROLE_MAT_ID=$MAT_ID AND CONTROLE_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_absences_v2 SET ABS_MAT_ID=$nouvelle_matiere WHERE ABS_MAT_ID=$MAT_ID AND ABS_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_clotures_moyennes_matiere SET MOYMAT_MAT_ID=$nouvelle_matiere WHERE MOYMAT_MAT_ID=$MAT_ID AND MOYMAT_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_clotures_moyennes_matiere_sans_bonus SET MOYMAT_MAT_ID=$nouvelle_matiere WHERE MOYMAT_MAT_ID=$MAT_ID AND MOYMAT_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_clotures_moyennes_matiere_somme_bonus SET MOYMAT_MAT_ID=$nouvelle_matiere WHERE MOYMAT_MAT_ID=$MAT_ID AND MOYMAT_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_clotures_moyennes_surmatieres SET MOYMAT_MAT_ID=$nouvelle_matiere WHERE MOYMAT_MAT_ID=$MAT_ID AND MOYMAT_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_dispense_matieres SET DISP_MAT_ID=$nouvelle_matiere WHERE DISP_MAT_ID=$MAT_ID AND DISP_ANNEE_ID =$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_edt_contraintes SET CONTRAINTE_MAT_ID=$nouvelle_matiere WHERE CONTRAINTE_MAT_ID=$MAT_ID";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_edt_exams SET EXAM_MAT_ID=$nouvelle_matiere WHERE EXAM_MAT_ID =$MAT_ID";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_enseignants_matieres SET ENS_MAT_ID=$nouvelle_matiere WHERE ENS_MAT_ID=$MAT_ID AND ENS_MAT_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_matiere SET MAT_END_ANNEE_ID=$annee_id WHERE MAT_ID=" . $MAT_ID;
            $affected_rows = self::execRequeteAvecAffected($req);
            if ($affected_rows === 1) {
                $retour = true;
                $req = "SELECT MAT_ID FROM common_matiere WHERE (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_SURMAT_ID=$MAT_ID";
                $les_sous_matieres = self::getRequete($req);
                foreach ($les_sous_matieres as $une_sous_matiere) {
                    $retour &= self::SwitchMatieres($une_sous_matiere['MAT_ID'],$annee_id,$ue_id,$nouvelle_matiere);
                }
                $req = "SELECT MAT_ID FROM common_matiere WHERE (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_COPIE_MAT_ID=$MAT_ID";
                $les_copies = self::getRequete($req);
                foreach ($les_copies as $une_copie) {
                    $retour &= self::SwitchMatieres($une_copie['MAT_ID'],$annee_id,null,null,$nouvelle_matiere);
                }
                return $retour;
            } else {
                return false;
            }
        }
        return true;
    }

    public static function HideMatieres(int $MAT_ID, int $annee_id): bool
    {
        $req = "SELECT * FROM common_matiere WHERE MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=" . $MAT_ID;
        $les_matieres = self::getRequete($req);
        foreach ($les_matieres as $une_matiere) {
            if ($une_matiere['MAT_HAS_NOTE']) {
                $req = "SELECT CONTROLE_ID FROM common_controle WHERE CONTROLE_MAT_ID=" . $une_matiere['MAT_ID'] . " AND CONTROLE_ANNEE_ID=$annee_id GROUP BY CONTROLE_ID";
                $une_matiere['VIDE'] = (self::doRequete($req)->num_rows == 0);
            } else {
                $req = "SELECT MAT_ID FROM common_matiere,common_controle WHERE CONTROLE_MAT_ID=MAT_ID AND CONTROLE_ANNEE_ID=$annee_id AND MAT_SURMAT_ID = " . $une_matiere['MAT_ID'] . " GROUP BY MAT_ID";
                $une_matiere['VIDE'] = (self::doRequete($req)->num_rows == 0);
            }
            if ($une_matiere['VIDE']) {
                $req = "UPDATE common_matiere SET MAT_END_ANNEE_ID=$annee_id WHERE MAT_ID=" . $MAT_ID;
                $affected_rows = self::execRequeteAvecAffected($req);
                if ($affected_rows === 1) {
                    $retour = true;
                    $req = "SELECT MAT_ID FROM common_matiere WHERE MAT_SURMAT_ID=$MAT_ID";
                    $les_sous_matieres = self::getRequete($req);
                    foreach ($les_sous_matieres as $une_sous_matiere) {
                        $retour &= self::HideMatieres($une_sous_matiere['MAT_ID'],$annee_id);
                    }
                    $req = "SELECT MAT_ID FROM common_matiere WHERE MAT_COPIE_MAT_ID=$MAT_ID";
                    $les_copies = self::getRequete($req);
                    foreach ($les_copies as $une_copie) {
                        $retour &= self::HideMatieres($une_copie['MAT_ID'],$annee_id);
                    }
                    return $retour;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public static function SwitchUEs(int $UE_ID, int $annee_id, ?int $sem_id = null): bool
    {
        $req = "SELECT * FROM common_ue WHERE UE_ID=$UE_ID";
        $les_ue = self::getRequete($req);
        foreach ($les_ue as $une_ue) {
            $copie = array();
            bfmw_add_secured($copie,"*UE_NOM",htmlspecialchars(addslashes($une_ue["UE_NOM"])));
            bfmw_add_secured($copie,"*UE_SEM_ID",$sem_id??$une_ue["UE_SEM_ID"]);
            bfmw_add_secured($copie,"*UE_COEF",$une_ue["UE_COEF"]);
            bfmw_add_secured($copie,"*UE_START_ANNEE_ID", $annee_id);
            bfmw_add_secured($copie,"*UE_END_ANNEE_ID","NULL");
            bfmw_add_secured($copie,"*UE_ORDRE",$une_ue["UE_ORDRE"]);
            bfmw_add_secured($copie,"*UE_CODE_APOGEE",$une_ue["UE_CODE_APOGEE"]);
            $nouvelle_ue = createData("common_ue",$copie,7);
            if ($nouvelle_ue <= 0) {
                return false;
            }

            $req = "SELECT * FROM common_matiere WHERE MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_SURMAT_ID IS NULL AND MAT_UE_ID=$UE_ID";
            $les_matieres = self::getRequete($req);
            foreach ($les_matieres as $une_matiere) {
                if (! self::SwitchMatieres($une_matiere['MAT_ID'],$annee_id,$nouvelle_ue)) {
                    return false;
                }
            }

            $req = "UPDATE common_ue SET UE_END_ANNEE_ID=$annee_id WHERE UE_ID=" . $UE_ID;
            $effected = self::execRequeteAvecAffected($req);
            if ($effected === 1) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function HideUEs(int $UE_ID, int $annee_id): bool
    {
        $req = "SELECT MAT_ID FROM common_controle,common_matiere WHERE MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=CONTROLE_MAT_ID AND MAT_UE_ID=$UE_ID AND CONTROLE_ANNEE_ID=$annee_id GROUP BY MAT_ID";
        if (self::doRequete($req)->num_rows==0) {
            $req = "SELECT * FROM common_matiere WHERE MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_UE_ID=$UE_ID";
            $les_matieres = self::getRequete($req);
            foreach ($les_matieres as $une_matiere) {
                if (! self::HideMatieres($une_matiere['MAT_ID'],$annee_id)) {
                    return false;
                }
            }

            $req = "UPDATE common_ue SET UE_END_ANNEE_ID=$annee_id WHERE UE_ID=" . $UE_ID;
            $effected = self::execRequeteAvecAffected($req);
            if ($effected === 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function SwitchSemestres(int $SEM_ID, int $annee_id): bool
    {
        $req = "SELECT * FROM common_semestre WHERE SEM_ID=$SEM_ID";
        $les_sem = self::getRequete($req);
        foreach ($les_sem as $une_sem) {

            $copie = array();
            bfmw_add_secured($copie,"*SEM_NOM",htmlspecialchars(addslashes($une_sem["SEM_NOM"])));
            bfmw_add_secured($copie,"*SEM_FORM_ID",$une_sem["SEM_FORM_ID"]);
            bfmw_add_secured($copie,"*SEM_COEF",$une_sem["SEM_COEF"]);
            bfmw_add_secured($copie,"*SEM_START_ANNEE_ID", $annee_id);
            bfmw_add_secured($copie,"*SEM_END_ANNEE_ID","NULL");
            bfmw_add_secured($copie,"*SEM_ORDRE",$une_sem["SEM_ORDRE"]);
            $nouveau_sem = createData("common_semestre",$copie,6);
            if ($nouveau_sem <= 0) {
                return false;
            }

            $req = "SELECT * FROM common_ue WHERE UE_START_ANNEE_ID<=$annee_id AND (UE_END_ANNEE_ID>$annee_id OR UE_END_ANNEE_ID IS NULL) AND UE_SEM_ID=$SEM_ID";
            $les_ues = self::getRequete($req);
            foreach ($les_ues as $une_ue) {
                if (! self::SwitchUEs($une_ue['UE_ID'],$annee_id,$nouveau_sem)) {
                    return false;
                }
            }

            $req = "INSERT INTO common_semestres_groupes(GROUPE_SEM_ID, SEM_GROUPE_ID) (SELECT $nouveau_sem,SEM_GROUPE_ID FROM common_semestres_groupes WHERE GROUPE_SEM_ID = $SEM_ID)";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_inscription SET INSCRIPT_SEM_ID=$nouveau_sem WHERE INSCRIPT_SEM_ID=$SEM_ID AND INSCRIPT_ANNEE_ID=$annee_id";
            if (!self::execRequete($req)) {
                return false;
            }

            $req = "UPDATE common_semestre SET SEM_END_ANNEE_ID=$annee_id WHERE SEM_ID=$SEM_ID";
            $effected = self::execRequeteAvecAffected($req);
            if ($effected === 1) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function HideSemestres(int $SEM_ID, int $annee_id): bool
    {
        $req = "SELECT UE_ID FROM common_controle,common_matiere,common_ue WHERE  UE_START_ANNEE_ID<=$annee_id AND (UE_END_ANNEE_ID>$annee_id OR UE_END_ANNEE_ID IS NULL)  AND  MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND UE_ID=MAT_UE_ID AND MAT_ID=CONTROLE_MAT_ID AND UE_SEM_ID=$SEM_ID AND CONTROLE_ANNEE_ID=$annee_id GROUP BY UE_ID";
        if (self::doRequete($req)->num_rows==0) {
            $req = "SELECT * FROM common_ue WHERE UE_START_ANNEE_ID<=$annee_id AND (UE_END_ANNEE_ID>$annee_id OR UE_END_ANNEE_ID IS NULL) AND UE_SEM_ID=$SEM_ID";
            $les_ues = self::getRequete($req);
            foreach ($les_ues as $une_ue) {
                if (! self::HideUEs($une_ue['UE_ID'],$annee_id)) {
                    return false;
                }
            }

            $req = "UPDATE common_semestre SET SEM_END_ANNEE_ID=$annee_id WHERE SEM_ID=$SEM_ID";
            $effected = self::execRequeteAvecAffected($req);
            if ($effected === 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function HideFormations(int $form_id, int $annee_id): bool
    {
        $req = "SELECT SEM_ID FROM common_controle,common_matiere,common_ue,common_semestre WHERE SEM_START_ANNEE_ID<=$annee_id AND (SEM_END_ANNEE_ID>$annee_id OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID<=$annee_id AND (UE_END_ANNEE_ID>$annee_id OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID<=$annee_id AND (MAT_END_ANNEE_ID>$annee_id OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND MAT_ID=CONTROLE_MAT_ID AND SEM_FORM_ID=$form_id AND CONTROLE_ANNEE_ID=$annee_id GROUP BY SEM_ID";
        if (self::doRequete($req)->num_rows==0) {
            $req = "SELECT * FROM common_semestre WHERE SEM_START_ANNEE_ID<=$annee_id AND (SEM_END_ANNEE_ID>$annee_id OR SEM_END_ANNEE_ID IS NULL) AND SEM_FORM_ID=$form_id";
            $les_sem = self::getRequete($req);
            foreach ($les_sem as $un_sem) {
                if (! self::HideSemestres($un_sem['SEM_ID'],$annee_id)) {
                    return false;
                }
            }

            $req = "UPDATE common_formation SET FORM_END_ANNEE_ID=$annee_id WHERE FORM_ID=$form_id";
            $effected = self::execRequeteAvecAffected($req);
            if ($effected === 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function verrouillerMatiere(int $mat_id, int $annee_courante, bool $unlock = false) : bool
    {
        if (!$unlock) {
            $req = "UPDATE common_matiere SET MAT_LOCK_ANNEE_ID=$annee_courante WHERE MAT_ID=$mat_id AND MAT_LOCK_ANNEE_ID<$annee_courante";
        } else {
            $req = "UPDATE common_matiere SET MAT_LOCK_ANNEE_ID=$annee_courante-1 WHERE MAT_ID=$mat_id";
        }

        return self::execRequeteAvecAffected($req) === 1;
    }

    public static function getMatiereCopiee(int $mat_id) : array
    {
        $req = "SELECT * FROM common_matiere WHERE MAT_ID=$mat_id AND MAT_COPIE_MAT_ID IS NOT NULL";
        return self::getRequeteAvecClef("MAT_COPIE_MAT_ID",$req);
    }

    public static function getQuestionsEvaluation(int $affectation_id) : array
    {
        $req = "SELECT common_eval_questions.* FROM common_eval_questions,common_enseignants_matieres,common_matiere,common_ue,common_semestre WHERE ID=$affectation_id AND MAT_ID=ENS_MAT_ID AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND EVALQ_FORM_ID=SEM_FORM_ID";
        return self::getRequete($req);
    }

    public static function repondreQuestion(int $et_id, int $affectation_id, string $reponse, string $question, int $ordre) : void
    {
        $req = "INSERT INTO common_evaluation(EVAL_ET_ID, EVAL_AFFECT_ID, EVAL_REPONSE, EVAL_QUESTION, EVAL_Q_ORDRE) VALUES ($et_id,$affectation_id,'$reponse','$question',$ordre)";
        self::execRequete($req);
    }

    public static function getUEDeLaFormation(int $form_id, int $annee_courante) : array
    {
        $req = "SELECT * FROM common_ue
                INNER JOIN common_semestre ON (SEM_ID=UE_SEM_ID)
                WHERE SEM_FORM_ID=$form_id
                AND SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL)
                AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL)
                ORDER BY SEM_ORDRE,SEM_ID,UE_ORDRE,UE_ID
                ";
        return self::getRequete($req);
    }

    public static function getFormationDuDepartementCode(string $dept_code) : array
    {
        $req = "SELECT * FROM common_formation
                JOIN common_departement ON (DEPT_ID=FORM_DEPT_ID)
                WHERE DEPT_CODE='$dept_code'";
        return self::getRequete($req);
    }

    public static function getFormationsDuConnecteV2String(int $dept_id, int $annee_courante=-1, $complement = "" )
    {
        $retour = self::getFormationsDuConnecte($dept_id,$annee_courante,$complement);
        $retour = implode(",",array_keys($retour));
        return $retour;
    }

    public static function getExportDispense(int $annee_id, string $les_matieres) : array
    {
        $req = "select MOYMAT_SPECIAL AS MOYMAT_REMONTEE,MOYMAT_VALEUR,ET_NUMERO, MOYMAT_MAT_ID, ROUND(VALEUR_TO_EXPORT,2) AS VALEUR_TO_EXPORT, MOYMAT_ET_ID from all_notes_moyennes_export_dispense WHERE MOYMAT_MAT_ID IN ($les_matieres) AND MOYMAT_ANNEE_ID = $annee_id ";
        $requete = self::getRequete($req);
        $retour = array();
        foreach ($requete as $une_ligne) {
            if (! isset($retour[$une_ligne['MOYMAT_ET_ID']])) {
                $retour[$une_ligne['MOYMAT_ET_ID']] = array();
            }
            $retour[$une_ligne['MOYMAT_ET_ID']][$une_ligne['MOYMAT_MAT_ID']] = $une_ligne;
        }
        return $retour;
    }

    public static function isAbsenceAutomatique(string $groupe_courant) : bool
    {
        $req = "SELECT *
                FROM common_groupes
                         JOIN common_formation ON (FORM_ID = GROUPE_FORM_ID)
                WHERE GROUPE_ID IN ($groupe_courant)
                  AND FORM_ABSENCES_AUTO = 1
        ";
        return count(self::getRequete($req)) > 0;
    }
}