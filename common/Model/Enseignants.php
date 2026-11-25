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

class Enseignants extends Connectable
{
    public static function getEnseignantsPermanents(int $DEPT_ID,int $vacataire=0) : array {
        $except = "";
        if (!isAdmin()) {
            $except = " AND ENS_ID > 1";
        }
        $req = "SELECT * FROM common_enseignant,common_enseignants_departement WHERE ENS_DEPT_VACATAIRE=$vacataire AND ENS_ID=DEPT_ENS_ID AND ENS_DEPT_ID=$DEPT_ID $except ORDER BY ENS_NOM";
        return self::getRequeteAvecClef("ENS_ID",$req);
    }

    public static function getEnseignantsDuDepartement(int $DEPT_ID, int $ENS_ID) : array {
        $except = "";
        if (!isAdmin() && $DEPT_ID > 1) {
            $except = " AND ENS_ID > 1";
        }
        $req = "SELECT ENS_ID,ENS_NOM,ENS_PRENOM,ENS_NOM_DE_FAMILLE, ENS_LOGIN, ENS_MAIL, ENS_ADE,IF(ENS_PRETEUR=1,'checked','') AS ENS_PRETEUR,IF(ENS_EC=1,'checked','') AS ENS_EC,IF(ENS_DEPT_VACATAIRE=1,'checked','') AS ENS_VACATAIRE,IF(ENS_GESTIONNAIRE_ADE=1,'checked','') AS ENS_GESTIONNAIRE_ADE,IF(ENS_DEPT_STAGE=1,'checked','') AS ENS_DEPT_STAGE,IF(common_departement.DEPT_ENS_ID=ENS_ID AND ENS_ID<>$ENS_ID,'disabled','') AS DISABLED,common_departement.DEPT_ENS_ID AS CHEF FROM common_enseignant,common_enseignants_departement,common_departement WHERE DEPT_ID=ENS_DEPT_ID AND ENS_ID=common_enseignants_departement.DEPT_ENS_ID AND ENS_DEPT_ID=$DEPT_ID $except ORDER BY ENS_NOM";
        return self::getRequeteAvecClef("ENS_ID",$req);
    }

    public static function getEnseignantsDuDepartementAvecInfosSoutenances(int $DEPT_ID, int $annee_id) : array {
        $req = "SELECT ENS_ID,ENS_NOM,ENS_DEPT_VACATAIRE, STAGE_SUGGESTION_ENS_ID,common_soutenances_planning.PLANNING_ID,ET_ID,ET_NOM,IFNULL(PLANNING_CONTENU,'Session non affectée') AS PLANNING_CONTENU,PLANNING_SOUT_MAX ,PLANNING_SOUT_FAITES ,IF(PLANNING_SPE=1,'checked','') AS PLANNING_SPE_AFFICHAGE, IF(ET_PROFESSIONNALISATION=1,'alternant','stagiaire') AS ET_SITUATION
                FROM common_enseignant
                    JOIN common_enseignants_departement ON (ENS_DEPT_ID=$DEPT_ID)
                    LEFT JOIN common_soutenances_planning_enseignant ON (ENS_ID=PLANNING_ENS_ID AND PLANNING_ANNEE_ID=$annee_id AND common_soutenances_planning_enseignant.PLANNING_DEPT_ID=$DEPT_ID)
                    LEFT JOIN common_stage ON (ENS_ID=STAGE_ENS_ID AND STAGE_ANNEE_ID=$annee_id)
                    LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID=PLANNING_STAGE_ID AND STAGE_PLANNING_ANNEE_ID=$annee_id)
                    LEFT JOIN common_etudiant ON (ET_ID=STAGE_ET_ID)
                    LEFT JOIN common_soutenances_planning ON (common_soutenances_planning.PLANNING_ID=STAGE_PLANNING_ID AND common_soutenances_planning.PLANNING_DEPT_ID=$DEPT_ID AND common_soutenances_planning.PLANNING_ANNEE_ID=$annee_id)
                WHERE  ENS_ID=common_enseignants_departement.DEPT_ENS_ID 
                ORDER BY ENS_DEPT_VACATAIRE,ENS_NOM,common_soutenances_planning.PLANNING_ID,STAGE_ID,ET_NOM,ET_ID";

        $retour = self::getRequete($req);
        $enseignant_courant = -1;
        $compteur = 0;
        $backup = null;
        foreach ($retour as &$une_ligne) {
            if ($une_ligne["ET_ID"] != "") {
                $une_ligne["INSCRIPT_FORMATION"] = Formations::getFormationDeLEtudiant($une_ligne["ET_ID"], $annee_id)[0]["FORM_NOM"];
            } else {
                $une_ligne["INSCRIPT_FORMATION"] = "";
            }

            $une_ligne['HAS_SESSION'] = $compteur;

            if ($enseignant_courant != $une_ligne['ENS_ID']) {
                $enseignant_courant = $une_ligne['ENS_ID'];
                $backup = &$une_ligne;
                $compteur = 0;
            }

            ($une_ligne['ET_ID'] != null)?++$compteur:null;
            if ($backup != null) {
                $backup['HAS_SESSION'] = $compteur;
            }

            if ($une_ligne['STAGE_SUGGESTION_ENS_ID'] != null) {
                $une_ligne['ENS_NOM_SUGGERE'] = self::getEnseigant($une_ligne['STAGE_SUGGESTION_ENS_ID'])[0]['ENS_NOM'];
            } else {
                $une_ligne['ENS_NOM_SUGGERE'] = "";
            }
        }
        return $retour;
    }

    public static function getResponsablesDeStages() : array {
        $req = "SELECT * FROM common_enseignant,common_enseignants_departement WHERE ENS_ID=DEPT_ENS_ID AND ENS_DEPT_STAGE=1 AND ENS_DEPT_ID=".CURRENT_DEPT_ID;
        return self::getRequete($req);
    }

    public static function getEnseigant(int $ENS_ID) : array {
        $req = "SELECT * FROM common_enseignant WHERE ENS_ID=$ENS_ID";
        return self::getRequete($req);
    }

    public static function getResponsableFormation(int $FORM_ID) : array {
        $req = "SELECT *, RESPONSABLE_ENS_ID AS ENS_ID FROM common_responsable_formation WHERE RESPONSABLE_FORM_ID=$FORM_ID";
        return self::getRequete($req);
    }

    public static function getSecretaireFormation(int $FORM_ID) : array {
        $req = "SELECT *, SECRETAIRE_ENS_ID AS ENS_ID FROM common_secretaire WHERE SECRETAIRE_FORM_ID=$FORM_ID";
        return self::getRequete($req);
    }

    public static function getStagiairesEtAlternants(int $ens_id,int $annee_courante,int $dept_id) : array {
        $req =  "SELECT PLANNING_ID,
                           FORM_ID,
                           FORM_NOM,
                           ET_NOM,
                           ENS_NOM,
                           ET_NUMERO,
                           ET_MAIL,
                           ET_ENTREPRISE,
                           ET_LIEU,
                           ET_INFO_LIEU,
                           ET_TUTEUR,
                           ET_MAIL_TUTEUR,
                           ET_TEL_TUTEUR,
                           ET_PROFESSIONNALISATION,
                           IF(PLANNING_CONTENU IS NULL, 'inconnue', PLANNING_CONTENU) AS PLANNING_CONTENU_AFFICHAGE,
                           FROM_UNIXTIME(STAGE_DATE_SOUTENANCE, '%d/%m/%Y')           AS STAGE_DATE_SOUTENANCE_AFFICHAGE,
                           FROM_UNIXTIME(CRENEAU_DEBUT, '%H:%i')                      AS CRENEAU_DEBUT_AFFICHAGE,
                           FROM_UNIXTIME(CRENEAU_FIN, '%H:%i')                        AS CRENEAU_FIN_AFFICHAGE
                    FROM common_stage
                             JOIN common_stage_formations ON (STAGE_ID = FORM_STAGE_ID)
                             JOIN common_formation ON (STAGE_FORM_ID = FORM_ID AND FORM_DEPT_ID = $dept_id)
                             JOIN common_etudiant ON (ET_ID = STAGE_ET_ID)
                             JOIN common_inscription ON (ET_ID = INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID = $annee_courante)
                             JOIN common_semestre ON (SEM_ID = INSCRIPT_SEM_ID AND FORM_ID = SEM_FORM_ID)
                             LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID = PLANNING_STAGE_ID)
                             LEFT JOIN common_soutenances_planning ON (PLANNING_ID = STAGE_PLANNING_ID)
                             LEFT JOIN common_soutenances_planning_creneau ON (CRENEAU_ID = STAGE_SOUTENANCE_CRENEAU_ID)
                             LEFT JOIN common_enseignant ON (ENS_ID = STAGE_JURY_ENS_ID)
                    WHERE STAGE_ENS_ID = $ens_id
                      AND STAGE_ANNEE_ID = $annee_courante
                    GROUP BY ET_ID, PLANNING_ID
                    ORDER BY PLANNING_SOUTENANCES_START, PLANNING_SOUTENANCES_END, PLANNING_ID, FORM_NOM, FORM_ID, ET_NOM,
                             STAGE_DATE_SOUTENANCE, CRENEAU_DEBUT, CRENEAU_FIN";
        return self::getRequete($req);
    }

    public static function getSoutenances(int $ens_id,int $annee_courante,int $dept_id) : array {
        $req =  "SELECT *,PLANNING_CONTENU AS PLANNING_CONTENU_AFFICHAGE,
                    FROM_UNIXTIME(STAGE_DATE_SOUTENANCE ,'%d/%m/%Y') AS STAGE_DATE_SOUTENANCE_AFFICHAGE,
                    FROM_UNIXTIME(CRENEAU_DEBUT,'%H:%i') AS CRENEAU_DEBUT_AFFICHAGE,
                    FROM_UNIXTIME(CRENEAU_FIN,'%H:%i') AS CRENEAU_FIN_AFFICHAGE
                FROM (common_stage,common_stage_formations, common_formation,common_etudiant, common_inscription,common_semestre)
                LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID=PLANNING_STAGE_ID)
                LEFT JOIN common_soutenances_planning ON (PLANNING_ID=STAGE_PLANNING_ID)
                LEFT JOIN common_soutenances_planning_creneau ON (CRENEAU_ID=STAGE_SOUTENANCE_CRENEAU_ID)
                LEFT JOIN common_enseignant ON (IF(STAGE_JURY_ENS_ID=$ens_id,ENS_ID=STAGE_ENS_ID,ENS_ID=STAGE_JURY_ENS_ID))
                WHERE ET_ID=INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID=$annee_courante AND SEM_ID=INSCRIPT_SEM_ID AND FORM_ID=SEM_FORM_ID  
                AND ET_ID=STAGE_ET_ID AND FORM_DEPT_ID=$dept_id AND STAGE_FORM_ID=FORM_ID AND STAGE_ID=FORM_STAGE_ID
                AND (STAGE_ENS_ID=$ens_id OR STAGE_JURY_ENS_ID=$ens_id) AND STAGE_ANNEE_ID=$annee_courante
                AND STAGE_DATE_SOUTENANCE IS NOT NULL
                AND PLANNING_CONTENU IS NOT NULL
                GROUP BY ET_ID,PLANNING_ID
                ORDER BY PLANNING_SOUTENANCES_START,PLANNING_ID,STAGE_DATE_SOUTENANCE,CRENEAU_DEBUT, CRENEAU_FIN, CRENEAU_ID,ET_NOM, ET_ID";
        return self::getRequete($req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "responsable" :
                $tab = explode("$",$where);
                if (Formations::isResponsableFormation($tab[1]) || isAdmin() || Formations::isSecretaireFormation($tab[1])) {
                    if ($valeurnum != 0) {
                        $req = "INSERT INTO common_responsable_formation(RESPONSABLE_FORM_ID, RESPONSABLE_ENS_ID) VALUES ($tab[1],$tab[0])";
                    } else {
                        $req = "DELETE FROM common_responsable_formation WHERE RESPONSABLE_ENS_ID=$tab[0] AND RESPONSABLE_FORM_ID=$tab[1]";
                    }
                    return self::execRequete($req);
                } else {
                    return false;
                }
            case "secretaires" :
                $tab = explode("$",$where);
                if (Formations::isResponsableFormation($tab[1]) || isAdmin() || Formations::isSecretaireFormation($tab[1])) {
                    if ($valeurnum != 0) {
                        $req = "INSERT INTO common_secretaire(SECRETAIRE_ENS_ID, SECRETAIRE_FORM_ID) VALUES ($tab[0],$tab[1])";
                    } else {
                        $req = "DELETE FROM common_secretaire WHERE SECRETAIRE_ENS_ID=$tab[0] AND SECRETAIRE_FORM_ID=$tab[1]";
                    }
                    return self::execRequete($req);
                } else {
                    return false;
                }
        }
        $req = "SELECT * FROM common_responsable_formation,common_formation,common_departement, common_enseignants_departement WHERE DEPT_ID=ENS_DEPT_ID AND DEPT_ID=FORM_DEPT_ID AND FORM_ID=RESPONSABLE_FORM_ID AND (RESPONSABLE_ENS_ID=".CURRENT_ID." OR common_departement.DEPT_ENS_ID=".CURRENT_ID.")  AND common_enseignants_departement.DEPT_ENS_ID=$wherenum";
        if (self::doRequete($req)->num_rows > 0 || isAdmin() || Formations::isSecretaire()) {
            $req = "SELECT * FROM common_departement WHERE DEPT_ENS_ID=$wherenum";
            if (self::doRequete($req)->num_rows == 0 || $wherenum == CURRENT_ID) {
                switch ($tag) {
                    case "ENS_MAIL":
                        if (preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(,([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?))*$/", $valeur) == 1) {
                            $req = "UPDATE common_enseignant SET " . $tag . "='" . $valeur . "' WHERE ENS_ID=" . $wherenum;
                            return self::execRequete($req);
                        }

                        break;
                    case "ENS_PRETEUR":
                    case "ENS_EC":
                    case "ENS_ADE":
                    case "ENS_GESTIONNAIRE_ADE":
                        $req = "UPDATE common_enseignant SET " . $tag . "='" . $valeur . "' WHERE ENS_ID=" . $wherenum;
                        return self::execRequete($req);
                        break;
                    case "ENS_DEPT_VACATAIRE":
                    case "ENS_DEPT_STAGE":
                        $req = "UPDATE common_enseignants_departement SET " . $tag . "='" . $valeur . "' WHERE DEPT_ENS_ID=" . $wherenum . " AND ENS_DEPT_ID=" . CURRENT_DEPT_ID;
                        return self::execRequete($req);
                        break;
                    case "ENS_NOM":
                    case "ENS_LOGIN":
                        $req = "UPDATE common_enseignant SET " . $tag . "='" . $valeur . "' WHERE ENS_ID=" . $wherenum;
                        if (isAdmin()) {
                            return self::execRequete($req);
                        }
                        break;
                }
            }
        }
        return false;
    }

    public static function getEnseigantAPartirDuCodeADE($codeADE) : array
    {
        $req = "SELECT * FROM common_enseignant WHERE ENS_ADE=$codeADE";
        return self::getRequete($req);
    }

    public static function getLoginEnseignant(string $ens_nom) : array
    {
        $req = "SELECT ENS_LOGIN AS LOGIN, ENS_NOM AS NOM FROM common_enseignant WHERE ENS_NOM LIKE '%$ens_nom%' ORDER BY ENS_NOM";
        return self::getRequete($req);
    }

    public static function getEnseignantsSansCodeEmploye() : array
    {
        $req = "SELECT * FROM common_enseignant WHERE ENS_CODE_EMPLOYE IS NULL AND ENS_LOGIN IS NULL";
        return self::getRequete($req);
    }

    public static function supprimerEnseignantsSansCodeEmploye() : void
    {
        $req = "DELETE IGNORE FROM common_enseignant WHERE ENS_CODE_EMPLOYE IS NULL";
        self::execRequete($req);
    }

    public static function updateEnseignant(int $ens_id,string $ens_login,string $ens_nom, string $ens_prenom, string $employeeid, string $naissance, string $mail) : void
    {
        $req = "UPDATE common_enseignant SET ENS_LOGIN='$ens_login', ENS_NOM='$ens_nom $ens_prenom', ENS_NOM_DE_FAMILLE='$ens_nom', ENS_PRENOM='$ens_prenom', ENS_CODE_EMPLOYE='$employeeid', ENS_NAISSANCE='$naissance', ENS_MAIL='$mail' WHERE ENS_ID=$ens_id";
        self::execRequete($req);
    }

    public static function synchroADE()
    {
        $req = "UPDATE common_enseignant SET ENS_ADE = null WHERE ENS_CODE_EMPLOYE != '--special--' AND ENS_CODE_EMPLOYE NOT IN
                    (SELECT EXTRACT_CODE FROM extraction_res_ade)";
        self::execRequete($req);
        $req = "UPDATE common_enseignant SET ENS_ADE = null WHERE ENS_CODE_EMPLOYE IS NULL";
        self::execRequete($req);
        $req = "UPDATE common_enseignant,extraction_res_ade SET ENS_ADE = EXTRACT_NUMERO WHERE ENS_CODE_EMPLOYE != '--special--' AND EXTRACT_CODE != '' AND ENS_CODE_EMPLOYE = EXTRACT_CODE";
        self::execRequete($req);
    }

    public static function getEnseignantsDeLaMatiere(int $mat_id, int $annee_courante) : array
    {
        $req = "SELECT ENS_ID,ENS_NOM FROM common_enseignants_matieres,common_enseignant WHERE ENS_ID=MAT_ENS_ID AND ENS_MAT_ID=$mat_id AND ENS_MAT_ANNEE_ID=$annee_courante ORDER BY ENS_NOM";
        return self::getRequete($req);

    }

    public static function supprimerEnseignantDuDepartement(int $ens_id, int $dept_id, int $annee_courante) : bool
    {
        $req = "DELETE FROM common_enseignants_departement WHERE DEPT_ENS_ID=$ens_id AND ENS_DEPT_ID=$dept_id";
        if (self::execRequeteAvecAffected($req) === 1) {
            $req = "DELETE
                    FROM common_enseignants_matieres
                    WHERE MAT_ENS_ID = $ens_id
                      AND ENS_MAT_ANNEE_ID = $annee_courante
                      AND ENS_MAT_ID IN (SELECT MAT_ID
                                         FROM common_matiere
                                                  JOIN common_ue ON (UE_ID = MAT_UE_ID)
                                                  JOIN common_semestre ON (SEM_ID = UE_SEM_ID)
                                                  JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                                         WHERE FORM_DEPT_ID = $dept_id)";
            return self::execRequete($req);
        }
        return false;
    }


}