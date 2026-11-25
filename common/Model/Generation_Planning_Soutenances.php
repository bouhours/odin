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

class Generation_Planning_Soutenances extends Connectable
{
    public static function getCreneauxDeSoutenancesPossibles(int $et_id, int $stage_id, int $planning_id, int $annee_id, int $dept_id) : array {
        self::startTransaction();

        $enseignants = self::compilePlanningSoutenance($et_id,$stage_id,$planning_id,$annee_id,$dept_id);

        if (count($enseignants) > 0) {
            $enseignants_selectionnes = array();
            foreach ($enseignants as $ENS_ID=>$_) {
                $enseignants_selectionnes[] = $ENS_ID;
            }

            //Récupération des données à afficher
            $enseignants_selectionnes = implode(",", $enseignants_selectionnes);
            $req = "SELECT DISTINCT CRENEAU_ID,DISPO_DATE,DISPO_ID,
                        DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS CRENEAU_DATE_AFFICHAGE,
                        DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,
                        DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                FROM common_stage,common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau_enseignant,
                     common_soutenances_planning_creneau,common_soutenances_planning_enseignant pe
                WHERE STAGE_ET_ID=$et_id AND STAGE_ID=$stage_id 
                AND PLANNING_ENS_ID=STAGE_ENS_ID AND DISPO_DATE >= ".time()."  
                AND STAGE_ENS_ID=DISPO_ENS_ID AND DISPO_ID=CRENEAU_DISPO_ID AND CRENEAU_ID=DISPO_CRENEAU_ID
                AND STAGE_ANNEE_ID=$annee_id AND DISPO_ANNEE_ID=$annee_id AND DISPO_PLANNING_ID=$planning_id AND DISPO_CRENEAU_STAGE_ID IS NULL
                AND (DISPO_DATE,CRENEAU_ID) IN (
                        SELECT  DISPO_DATE,DISPO_CRENEAU_ID
                        FROM common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau_enseignant,
                             common_soutenances_planning_enseignant
                        WHERE DISPO_ID=CRENEAU_DISPO_ID AND DISPO_ANNEE_ID=$annee_id AND DISPO_CRENEAU_STAGE_ID IS NULL
                          AND (IFNULL(pe.PLANNING_SPE,0) OR IFNULL(PLANNING_SPE,0)) AND PLANNING_ENS_ID=DISPO_ENS_ID
                          AND DISPO_ENS_ID IN ($enseignants_selectionnes) AND DISPO_DATE >= ".time()." 
                          AND DISPO_PLANNING_ID=$planning_id AND DISPO_ENS_ID != STAGE_ENS_ID  
                )
                ORDER BY DISPO_DATE,CRENEAU_DEBUT,CRENEAU_FIN
                ";

            $les_creneaux = self::getRequete($req);
            $retour = array();
            foreach ($les_creneaux as $un_creneau) {
                if (self::resteSallesDisponibles($un_creneau['DISPO_ID'],$un_creneau['CRENEAU_ID'])) {
                    $retour[] = $un_creneau;
                }
            }

            self::rollback();
            return $retour;
        } else {
            self::rollback();
            return array();
        }
    }

    public static function getEnseignantsPossiblesSurUnCreneau(int $et_id, int $stage_id, int $planning_id, int $annee_id, int $dept_id, int $creneau_id, int $dispo_date) : array {
        self::startTransaction();
        $enseignants = self::compilePlanningSoutenance($et_id,$stage_id,$planning_id,$annee_id,$dept_id, $creneau_id,$dispo_date,true);
        self::rollback();
        if (count($enseignants) > 0) {
            if (uasort($enseignants,array('self', 'trierSurX'))) {
                $req = "SELECT * FROM common_enseignant WHERE ENS_ID IN (" . implode(",", array_keys($enseignants)) . ")";
                $les_enseignants = self::getRequeteAvecClef("ENS_ID",$req);
                $retour = array();
                foreach ($enseignants as $ENS_ID=>$data) {
                    $retour[$ENS_ID] = $les_enseignants[$ENS_ID];
                    $retour[$ENS_ID]["X"] = $data["X"];
                }
                return $retour;
            } else {
                return array();
            }
        } else {
            return array();
        }

    }

    public static function supprimerSoutenance(int $stage_id, int $planning_id) : bool {
        self::startTransaction();
        $annee_id = Annees::getIdAnneeCourante();
        $le_stage = Stages::getStage($stage_id,$annee_id);
        if (count($le_stage) !== 1) {
            self::rollback();
            return false;
        }
        $le_planning = Stages::getPlanning($planning_id,$stage_id,$annee_id);
        if (count($le_planning) !== 1) {
            self::rollback();
            return false;
        }
        $req = "UPDATE common_soutenances_planning_stage SET STAGE_SOUTENANCE_CRENEAU_ID=NULL,STAGE_DATE_SOUTENANCE=NULL,STAGE_JURY_ENS_ID=NULL WHERE PLANNING_STAGE_ID=$stage_id AND STAGE_PLANNING_ID=$planning_id";
        if (self::execRequeteAvecAffected($req) === 1) {
            $req = "UPDATE common_soutenances_planning_creneau_enseignant
                    SET DISPO_CRENEAU_STAGE_ID=NULL
                    WHERE DISPO_CRENEAU_STAGE_ID=$stage_id AND CRENEAU_DISPO_ID IN
                           (SELECT DISPO_ID FROM common_soutenances_planning_dispo_enseignant
                                    WHERE DISPO_PLANNING_ID=$planning_id)";

            if (self::execRequete($req)) {
                $enseignant_tuteur = Enseignants::getEnseigant($le_stage[0]["STAGE_ENS_ID"])[0];
                $enseignant_jury = Enseignants::getEnseigant($le_planning[0]["STAGE_JURY_ENS_ID"])[0];
                $etudiant = Etudiants::getEtudiant($le_stage[0]["STAGE_ET_ID"], $annee_id)[0];
                sendMail($etudiant['ET_MAIL'] . "," . $enseignant_tuteur["ENS_MAIL"] . "," . $enseignant_jury["ENS_MAIL"],
                    "Suppression d'une soutenance",
                    "Bonjour,\n\nLa soutenance de " . $etudiant['ET_NOM'] . " a été supprimée.\n\nCordialement",
                    "cedric.bouhours@uca.fr");

                self::commit();
                return true;
            } else {
                self::rollback();
                return false;
            }
        } else {
            self::rollback();
            return false;
        }
    }

    public static function changeJury(int $enseignant_destinataire, int $et_id, int $stage_id, int $planning_id, int $annee_id, int $dept_id, int $creneau_id, int $dispo_date) : bool {
        self::startTransaction();
        $enseignants = self::compilePlanningSoutenance($et_id,$stage_id,$planning_id,$annee_id,$dept_id, $creneau_id,$dispo_date,true);

        if (count($enseignants) <= 0) {
            self::rollback();
            return false;
        }

        if (!in_array($enseignant_destinataire,array_keys($enseignants))) {
            self::rollback();
            return false;
        }

        $stage = Stages::getStage($stage_id,$annee_id);
        if (count($stage) != 1) {
            self::rollback();
            return false;
        }

        $planning = Stages::getPlanning($planning_id,$stage_id,$annee_id);
        if (count($planning) != 1) {
            self::rollback();
            return false;
        }

        $enseignant_actuel = $planning[0]["STAGE_JURY_ENS_ID"];
        $enseignant_tuteur = $stage[0]["STAGE_ENS_ID"];

        $req = "SELECT DISPO_ID FROM common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau_enseignant
                    WHERE DISPO_ENS_ID = $enseignant_actuel AND DISPO_DATE=$dispo_date
                    AND DISPO_ID=CRENEAU_DISPO_ID AND DISPO_PLANNING_ID=$planning_id AND DISPO_CRENEAU_ID=$creneau_id 
            ";
        $actuel = self::getRequete($req);
        if (count($actuel) !== 1) {
            self::rollback();
            return false;
        }

        $req = "SELECT DISPO_ID, DISPO_DATE,CRENEAU_DEBUT,CRENEAU_FIN,
                        DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS CRENEAU_DATE_AFFICHAGE,
                        DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,
                        DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                    FROM common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau_enseignant,   
                         common_soutenances_planning_creneau
                    WHERE DISPO_ENS_ID = $enseignant_destinataire AND DISPO_DATE=$dispo_date
                    AND DISPO_ID=CRENEAU_DISPO_ID AND DISPO_PLANNING_ID=$planning_id AND DISPO_CRENEAU_ID=$creneau_id AND CRENEAU_ID=DISPO_CRENEAU_ID 
            ";
        $destination = self::getRequete($req);
        if (count($destination) !== 1) {
            self::rollback();
            return false;
        }

        $dispo_enseignant_actuel = $actuel[0]['DISPO_ID'];
        $dispo_enseignant_destinataire = $destination[0]['DISPO_ID'];
        $date_soutenance = $destination[0]['CRENEAU_DATE_AFFICHAGE'];
        $debut_soutenance = $destination[0]['CRENEAU_DEBUT_AFFICHAGE'];
        $fin_soutenance = $destination[0]['CRENEAU_FIN_AFFICHAGE'];
        $creneau_debut = $destination[0]['CRENEAU_DEBUT'];
        $creneau_fin = $destination[0]['CRENEAU_FIN'];

        if (self::fermerCreneau($stage_id,$creneau_debut,$creneau_fin,$planning_id,$dispo_enseignant_destinataire) >= 1) {
            if (self::ouvrirCreneau($stage_id,$creneau_debut,$creneau_fin,$planning_id,$dispo_enseignant_actuel) >= 1) {
                 $req = "UPDATE common_soutenances_planning_stage SET STAGE_JURY_ENS_ID=$enseignant_destinataire WHERE PLANNING_STAGE_ID=$stage_id AND STAGE_PLANNING_ID=$planning_id";
                if (self::execRequeteAvecAffected($req) == 1) {
                    $enseignant_tuteur = Enseignants::getEnseigant($enseignant_tuteur)[0];
                    $enseignant_futur_jury = Enseignants::getEnseigant($enseignant_destinataire)[0];
                    $enseignant_jury = Enseignants::getEnseigant($enseignant_actuel)[0];
                    $etudiant = Etudiants::getEtudiant($et_id, $annee_id)[0];
                    sendMail($etudiant['ET_MAIL'] . "," . $enseignant_tuteur["ENS_MAIL"] . "," . $enseignant_futur_jury["ENS_MAIL"] . "," . $enseignant_jury["ENS_MAIL"],
                        "Modification d'une soutenance",
                        "Bonjour,\n\nLa soutenance de " . $etudiant['ET_NOM'] . " a été modifiée. Elle aura lieu le $date_soutenance de $debut_soutenance à $fin_soutenance avec " . $enseignant_tuteur['ENS_NOM'] . " et " . $enseignant_futur_jury['ENS_NOM'] . ".\n\nCordialement",
                        "cedric.bouhours@uca.fr");
                    self::commit();
                    return true;
                } else {
                    self::rollback();
                    return false;
                }
            } else {
                self::rollback();
                return false;
            }
        } else {
            self::rollback();
            return false;
        }


    }

    public static function affecterCreneauDeSoutenance(int $et_id, int $stage_id, int $planning_id, int $annee_id, int $dept_id, int $creneau_id, int $dispo_date, int $dispo_id, int $tuteur_id) : bool {
        self::startTransaction();

        if (!self::resteSallesDisponibles($dispo_id,$creneau_id)) {
            self::rollback();
            return false;
        }

        $enseignants = self::compilePlanningSoutenance($et_id,$stage_id,$planning_id,$annee_id,$dept_id,$creneau_id,$dispo_date);

        if (count($enseignants) <= 0) {
            self::rollback();
            return false;
        }

        if (uasort($enseignants,array('self', 'trierSurX'))) {
            $enseignant_choisi = -1;

            $enseignant_suggere = Stages::getStage($stage_id,$annee_id)[0]['STAGE_SUGGESTION_ENS_ID'];
            if ($enseignant_suggere != null) {
                if (in_array($enseignant_suggere,array_keys($enseignants))) {
                    $enseignant_choisi = $enseignant_suggere;
                }
            }

            if ($enseignant_choisi == -1) {
                foreach ($enseignants as $ENS_ID => $_) {
                    $enseignant_choisi = $ENS_ID;
                    break;
                }
            }
            if ($enseignant_choisi == -1) {
                self::rollback();
                return false;
            }
            $req = "SELECT DISPO_ID,CRENEAU_DEBUT,CRENEAU_FIN,
                        DATE_FORMAT(FROM_UNIXTIME(DISPO_DATE),'%d/%m/%Y') AS CRENEAU_DATE_AFFICHAGE,
                        DATE_FORMAT(FROM_UNIXTIME(CRENEAU_DEBUT),'%Hh%i') AS CRENEAU_DEBUT_AFFICHAGE,
                        DATE_FORMAT(FROM_UNIXTIME(CRENEAU_FIN),'%Hh%i') AS CRENEAU_FIN_AFFICHAGE
                    FROM common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau_enseignant,   
                         common_soutenances_planning_creneau
                    WHERE DISPO_ENS_ID = $enseignant_choisi AND DISPO_DATE=$dispo_date
                    AND DISPO_ID=CRENEAU_DISPO_ID AND DISPO_PLANNING_ID=$planning_id AND DISPO_CRENEAU_ID=$creneau_id AND CRENEAU_ID=DISPO_CRENEAU_ID 
            ";
            $destination = self::getRequete($req);
            if (count($destination) !== 1) {
                self::rollback();
                return false;
            }
            $dispo_enseignant_destinataire = $destination[0]['DISPO_ID'];
            $date_soutenance = $destination[0]['CRENEAU_DATE_AFFICHAGE'];
            $debut_soutenance = $destination[0]['CRENEAU_DEBUT_AFFICHAGE'];
            $fin_soutenance = $destination[0]['CRENEAU_FIN_AFFICHAGE'];
            $creneau_debut = $destination[0]['CRENEAU_DEBUT'];
            $creneau_fin = $destination[0]['CRENEAU_FIN'];
            //Enseignant tuteur
            if (self::fermerCreneau($stage_id,$creneau_debut,$creneau_fin,$planning_id,$dispo_id) >= 1) {
                //Enseignant destinataire
                if (self::fermerCreneau($stage_id,$creneau_debut,$creneau_fin,$planning_id,$dispo_enseignant_destinataire) >= 1) {
                    //Mise à jour du stage
                    $req = "UPDATE common_soutenances_planning_stage SET STAGE_DATE_SOUTENANCE=$dispo_date,STAGE_SOUTENANCE_CRENEAU_ID=$creneau_id,STAGE_JURY_ENS_ID=$enseignant_choisi WHERE PLANNING_STAGE_ID=$stage_id AND STAGE_PLANNING_ID=$planning_id";
                    if (self::execRequeteAvecAffected($req) == 1) {
                        self::commit();
                        $enseignant_destinataire = Enseignants::getEnseigant($enseignant_choisi)[0];
                        $enseignant_tuteur = Enseignants::getEnseigant($tuteur_id)[0];
                        $etudiant_nom = Etudiants::getEtudiant($et_id,$annee_id)[0]["ET_NOM"];
                        sendMail($enseignant_tuteur["ENS_MAIL"],
                        "Création d'une soutenance",
                        "Bonjour,\n\nLa soutenance de $etudiant_nom aura lieu le $date_soutenance de $debut_soutenance à $fin_soutenance. Vous serez accompagné de ".$enseignant_destinataire['ENS_NOM'].".\n\nCordialement",
                        "cedric.bouhours@uca.fr");
                        sendMail($enseignant_destinataire["ENS_MAIL"],
                            "Création d'une soutenance",
                            "Bonjour,\n\nLa soutenance de $etudiant_nom aura lieu le $date_soutenance de $debut_soutenance à $fin_soutenance. Vous serez accompagné de ".$enseignant_tuteur['ENS_NOM'].".\n\nCordialement",
                            "cedric.bouhours@uca.fr");
                        return true;
                    } else {
                        self::rollback();
                        return false;
                    }
                }
                self::rollback();
                return false;
            } else {
                self::rollback();
                return false;
            }
        } else {
            self::rollback();
            return false;
        }
    }

    public static function getNombreSoutenancesDejaPlacees(int $annee_id,string $les_enseignants, int $planning_id=-1) : array {
        $complement = "";
        if ($planning_id != -1) {
            $complement = "AND STAGE_PLANNING_ID=$planning_id";
        }
        $req = "SELECT STAGE_ENS_ID,COUNT(*) AS TOTAL
                FROM common_stage,common_soutenances_planning_stage
                WHERE STAGE_ID=PLANNING_STAGE_ID AND STAGE_ENS_ID IN ($les_enseignants) AND STAGE_JURY_ENS_ID IS NOT NULL 
                AND STAGE_ANNEE_ID = $annee_id AND STAGE_PLANNING_ANNEE_ID = $annee_id
                $complement
                GROUP BY STAGE_ENS_ID
            ";
        $total1 = self::getRequeteAvecClef("STAGE_ENS_ID",$req);
        $req = "SELECT STAGE_JURY_ENS_ID,COUNT(*) AS TOTAL
                FROM common_stage,common_soutenances_planning_stage
                WHERE STAGE_ID=PLANNING_STAGE_ID AND STAGE_JURY_ENS_ID IN ($les_enseignants)  
                AND STAGE_ANNEE_ID = $annee_id AND STAGE_PLANNING_ANNEE_ID = $annee_id
                $complement
                GROUP BY STAGE_JURY_ENS_ID
            ";
        $total2 = self::getRequeteAvecClef("STAGE_JURY_ENS_ID",$req);
        foreach ($total2 as $ENS_ID=>$complement) {
            if (! isset($total1[$ENS_ID])) {
                $total1[$ENS_ID]["TOTAL"] = $complement["TOTAL"];
            } else {
                $total1[$ENS_ID]["TOTAL"] += $complement["TOTAL"];
            }
        }

        return $total1;
    }

    private static function fermerCreneau(int $stage_id, int $creneau_debut, int $creneau_fin, int $planning_id, int $dispo_id) : int {
        $req = "UPDATE common_soutenances_planning_creneau_enseignant SET DISPO_CRENEAU_STAGE_ID=$stage_id
                    WHERE CRENEAU_DISPO_ID=$dispo_id AND DISPO_CRENEAU_ID IN (
                        SELECT CRENEAU_ID FROM common_soutenances_planning_creneau WHERE CRENEAU_PLANNING_ID=$planning_id
                            AND ((CRENEAU_DEBUT < $creneau_fin AND CRENEAU_DEBUT > $creneau_debut) OR
                                 (CRENEAU_FIN < $creneau_fin AND CRENEAU_FIN > $creneau_debut) OR
                                 (CRENEAU_FIN = $creneau_fin AND CRENEAU_DEBUT = $creneau_debut))
                    )";
        return self::execRequeteAvecAffected($req);
    }

    private static function ouvrirCreneau(int $stage_id, int $creneau_debut, int $creneau_fin, int $planning_id, int $dispo_id) : int {
        $req = "UPDATE common_soutenances_planning_creneau_enseignant SET DISPO_CRENEAU_STAGE_ID=NULL
                    WHERE CRENEAU_DISPO_ID=$dispo_id AND DISPO_CRENEAU_ID IN (
                        SELECT CRENEAU_ID FROM common_soutenances_planning_creneau
                            WHERE CRENEAU_PLANNING_ID=$planning_id
                            AND DISPO_CRENEAU_STAGE_ID=$stage_id
                            AND ((CRENEAU_DEBUT < $creneau_fin AND CRENEAU_DEBUT > $creneau_debut) OR
                                 (CRENEAU_FIN < $creneau_fin AND CRENEAU_FIN > $creneau_debut) OR
                                 (CRENEAU_FIN = $creneau_fin AND CRENEAU_DEBUT = $creneau_debut))
                    )";
        return self::execRequeteAvecAffected($req);
    }

    public static function getNombreCreneauxReels(string $ens_id, int $annee_id, int $planning_id) : array {
        $req = "SELECT * FROM
                common_soutenances_planning_creneau_enseignant,
                common_soutenances_planning_dispo_enseignant,
                common_soutenances_planning_creneau cr
                WHERE CRENEAU_ID=DISPO_CRENEAU_ID AND DISPO_ENS_ID IN ($ens_id)  AND CRENEAU_PLANNING_ID=$planning_id
                      AND DISPO_ID=CRENEAU_DISPO_ID AND DISPO_ANNEE_ID=$annee_id AND DISPO_PLANNING_ID=$planning_id
                ORDER BY DISPO_ENS_ID";

        $creneaux = self::getRequete($req);
        $a_supprimer = array();
        $travail = array();
        foreach ($creneaux as $un_creneau) {
            $travail[$un_creneau['DISPO_ENS_ID']][] = $un_creneau['CRENEAU_ID'].$un_creneau['DISPO_DATE'];
            if (!isset($a_supprimer[$un_creneau['DISPO_ENS_ID']])) {
                $a_supprimer[$un_creneau['DISPO_ENS_ID']] = array();
            }

            if (in_array($un_creneau['CRENEAU_ID'].$un_creneau['DISPO_DATE'],$a_supprimer[$un_creneau['DISPO_ENS_ID']])) {
                continue;
            }
            foreach ($creneaux as $deuxieme) {
                if (!isset($a_supprimer[$deuxieme['DISPO_ENS_ID']])) {
                    $a_supprimer[$deuxieme['DISPO_ENS_ID']] = array();
                }
                if (in_array($deuxieme['CRENEAU_ID'].$deuxieme['DISPO_DATE'],$a_supprimer[$deuxieme['DISPO_ENS_ID']])) {
                    continue;
                }
                if ($deuxieme['DISPO_DATE'] == $un_creneau['DISPO_DATE'] && $deuxieme['DISPO_ENS_ID'] == $un_creneau['DISPO_ENS_ID'] &&
                    (($deuxieme['CRENEAU_DEBUT'] < $un_creneau['CRENEAU_FIN'] && $deuxieme['CRENEAU_DEBUT'] > $un_creneau['CRENEAU_DEBUT'])
                    ||
                    ($deuxieme['CRENEAU_FIN'] < $un_creneau['CRENEAU_FIN'] && $deuxieme['CRENEAU_FIN'] > $un_creneau['CRENEAU_DEBUT']))) {
                        $a_supprimer[$deuxieme['DISPO_ENS_ID']][] = $deuxieme['CRENEAU_ID'].$deuxieme['DISPO_DATE'];
                }
            }
        }

        $retour = array();
        foreach ($travail as $ENS_ID=>$_) {
            $retour[$ENS_ID] = count($travail[$ENS_ID]) - count($a_supprimer[$ENS_ID]);
        }

       return $retour;
    }

    private static function compilePlanningSoutenance(int $et_id, int $stage_id, int $planning_id, int $annee_id, int $dept_id, ?int $creneau_id = null, ?int $dispo_date = null, bool $post_attribution = false) : array {
        $les_enseignants_du_departement = implode(",",array_keys(Enseignants::getEnseignantsDuDepartement($dept_id,-1)));

        $req = "SELECT PLANNING_SPE FROM common_soutenances_planning_enseignant,common_stage WHERE STAGE_ENS_ID=PLANNING_ENS_ID AND STAGE_ID=$stage_id";
        $planning = self::getRequete($req);
        foreach ($planning as $un_planning) {

            $specialiste = $un_planning["PLANNING_SPE"];
            if ($specialiste == null) {
                $specialiste = 0;
            }

            //Récupération des enseignants ayant les mêmes créneaux que le tuteur
            $complement = "";
            if ($creneau_id != null && $dispo_date != null) {
                $complement = " AND DISPO_DATE = $dispo_date AND DISPO_CRENEAU_ID = $creneau_id ";
            }
            $req = "SELECT  DISPO_ENS_ID
                FROM common_soutenances_planning_dispo_enseignant de,common_soutenances_planning_creneau_enseignant,
                     common_soutenances_planning_enseignant
                WHERE PLANNING_ENS_ID=DISPO_ENS_ID AND DISPO_DATE >= " . time() . " 
                  AND DISPO_PLANNING_ID=$planning_id AND DISPO_ID=CRENEAU_DISPO_ID AND DISPO_ANNEE_ID=$annee_id AND DISPO_CRENEAU_STAGE_ID IS NULL
                  AND DISPO_ENS_ID IN ($les_enseignants_du_departement)
                  AND ($specialiste OR IFNULL(PLANNING_SPE,0)) 
                  $complement
                  AND (DISPO_DATE,DISPO_CRENEAU_ID) IN (
                        SELECT DISPO_DATE,DISPO_CRENEAU_ID
                        FROM common_stage,common_soutenances_planning_dispo_enseignant,common_soutenances_planning_creneau_enseignant
                        WHERE STAGE_ET_ID=$et_id AND STAGE_ID=$stage_id                                        
                        AND STAGE_ENS_ID=DISPO_ENS_ID AND DISPO_ID=CRENEAU_DISPO_ID AND STAGE_ANNEE_ID=$annee_id
                        AND de.DISPO_ENS_ID != STAGE_ENS_ID AND DISPO_DATE >= " . time() . " 
                        AND DISPO_ANNEE_ID=$annee_id AND DISPO_PLANNING_ID=$planning_id " .
                ($post_attribution ? "" : "AND DISPO_CRENEAU_STAGE_ID IS NULL") .
                ")";

            $travail = self::getRequeteAvecClef("DISPO_ENS_ID", $req);
            if (count($travail) > 0) {

                //Suppression des incompatibilités
                $tuteur = Stages::getStage($stage_id, $annee_id)[0]['STAGE_ENS_ID'];
                if ($tuteur == null) {
                    return array();
                }
                $req = "SELECT * FROM common_soutenances_planning_incompatibilite WHERE INCOMPATIBILITE_ENS_ID_1=$tuteur OR INCOMPATIBILITE_ENS_ID_2=$tuteur";
                $incompatibles = self::getRequete($req);
                $les_id_des_enseignants_possibles = array_keys($travail);
                foreach ($les_id_des_enseignants_possibles as &$un_possible) {
                    foreach ($incompatibles as $couple) {
                        if ($un_possible == $couple['INCOMPATIBILITE_ENS_ID_1'] || $un_possible == $couple['INCOMPATIBILITE_ENS_ID_2']) {
                            $un_possible = -1;
                        }
                    }
                }

                $les_enseignants_possibles = implode(",", $les_id_des_enseignants_possibles);

                //Collecte du nombre d'encadrement par enseignants restant à placer
                $req = "SELECT STAGE_ENS_ID,COUNT(*) AS TOTAL
                FROM common_stage
                LEFT JOIN common_soutenances_planning_stage ON (STAGE_ID=PLANNING_STAGE_ID)
                WHERE STAGE_ANNEE_ID=$annee_id AND STAGE_ENS_ID IN ($les_enseignants_possibles)
                AND STAGE_DATE_SOUTENANCE IS NULL
                GROUP BY STAGE_ENS_ID
                ";
                $enseignants = array();
                $res = self::doRequete($req);
                while ($une_ligne = $res->fetch_assoc()) {
                    $enseignants[$une_ligne['STAGE_ENS_ID']]["OBLIGATOIRE"] = $une_ligne['TOTAL'];
                    $enseignants[$une_ligne['STAGE_ENS_ID']]["DEJA_PLACEES"] = 0;
                    $enseignants[$une_ligne['STAGE_ENS_ID']]["MAX"] = 0;
                    $enseignants[$une_ligne['STAGE_ENS_ID']]["FAITES"] = 0;
                    $enseignants[$une_ligne['STAGE_ENS_ID']]["SPE"] = 0;
                }

                //Collecte des informations de contraintes par enseignants
                $req = "SELECT *
                FROM common_soutenances_planning_enseignant
                WHERE PLANNING_ENS_ID IN ($les_enseignants_possibles)
                AND PLANNING_ANNEE_ID = $annee_id
            ";
                $res = self::doRequete($req);
                while ($une_ligne = $res->fetch_assoc()) {
                    $enseignants[$une_ligne['PLANNING_ENS_ID']]["MAX"] = $une_ligne["PLANNING_SOUT_MAX"];
                    $enseignants[$une_ligne['PLANNING_ENS_ID']]["FAITES"] = $une_ligne["PLANNING_SOUT_FAITES"];
                    $enseignants[$une_ligne['PLANNING_ENS_ID']]["SPE"] = $une_ligne["PLANNING_SPE"];
                }

                //Collecte soutenances déjà placées
                $deja_placees = self::getNombreSoutenancesDejaPlacees($annee_id, $les_enseignants_possibles, $planning_id);
                foreach ($deja_placees as $ENS_ID => $une_ligne) {
                    $enseignants[$ENS_ID]["DEJA_PLACEES"] = $une_ligne['TOTAL'];
                }
                $deja_placees = self::getNombreSoutenancesDejaPlacees($annee_id, $les_enseignants_possibles);
                foreach ($deja_placees as $ENS_ID => $une_ligne) {
                    $enseignants[$ENS_ID]["DEJA_PLACEES_TOTAL"] = $une_ligne['TOTAL'];
                }

                //Calcul de l'éliminateur
                $les_creneaux_reels = self::getNombreCreneauxReels($les_enseignants_possibles, $annee_id, $planning_id);
                $les_encadrements = Stages::getNombreEncadrementRestantsPourEnseignants($les_enseignants_possibles, $annee_id, $planning_id);

                //Calcul du poids de chaque enseignant
                foreach ($enseignants as $ENS_ID => &$un_enseignant) {
                    if (!isset($un_enseignant["DEJA_PLACEES"])) {
                        $un_enseignant["DEJA_PLACEES"] = 0;
                    }
                    if (!isset($un_enseignant["DEJA_PLACEES_TOTAL"])) {
                        $un_enseignant["DEJA_PLACEES_TOTAL"] = 0;
                    }
                    if (isset($les_encadrements[$ENS_ID]) && isset($les_creneaux_reels[$ENS_ID]) && ($les_creneaux_reels[$ENS_ID] - $un_enseignant["DEJA_PLACEES"] - $les_encadrements[$ENS_ID]["TOTAL"]) <= 0) {
                        $un_enseignant["X"] = 0;
                    } else {
                        $un_enseignant["X"] = $un_enseignant["MAX"] - $un_enseignant["FAITES"] - $un_enseignant["DEJA_PLACEES_TOTAL"] - ($un_enseignant["OBLIGATOIRE"] ?? 0);
                    }
                    if ($un_enseignant["X"] < 1) {
                        unset($enseignants[$ENS_ID]);
                    }
                }

                return $enseignants;
            } else {
                return array();
            }
        }
        return array();
    }

    private static function trierSurX(array $elem1, array $elem2) : int {
        if ($elem1['X'] == $elem2['X']) {
            return 0;
        }

        return ($elem1['X'] > $elem2['X']) ? -1 : 1;
    }


    public static function checkCreneauxAFermer(int $dispo_id, int $creneau_id) : bool
    {
        $req = "SELECT CRENEAU_DEBUT, CRENEAU_FIN, CRENEAU_PLANNING_ID
                    FROM common_soutenances_planning_creneau
                    WHERE CRENEAU_ID=$creneau_id  
                    ";
        $le_creneau_coche = self::getRequete($req);
        if (count($le_creneau_coche) != 1) {
            return false;
        }
        foreach ($le_creneau_coche as $un_creneau) {
            $req = "SELECT DISTINCT DISPO_CRENEAU_STAGE_ID
                        FROM common_soutenances_planning_creneau_enseignant
                        WHERE CRENEAU_DISPO_ID=$dispo_id AND DISPO_CRENEAU_STAGE_ID IS NOT NULL AND DISPO_CRENEAU_ID IN (
                            SELECT CRENEAU_ID FROM common_soutenances_planning_creneau WHERE CRENEAU_PLANNING_ID=" . $un_creneau["CRENEAU_PLANNING_ID"] . "
                                AND ((CRENEAU_DEBUT < " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_DEBUT > " . $un_creneau["CRENEAU_DEBUT"] . ") OR
                                     (CRENEAU_FIN < " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_FIN > " . $un_creneau["CRENEAU_DEBUT"] . ") OR
                                     (CRENEAU_FIN = " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_DEBUT = " . $un_creneau["CRENEAU_DEBUT"] . "))
                            )
                            ";

            $les_stages_en_contact = self::getRequete($req);
            foreach ($les_stages_en_contact as $un_stage) {
                $req = "SELECT *
                        FROM common_soutenances_planning_stage
                        WHERE PLANNING_STAGE_ID=".$un_stage['DISPO_CRENEAU_STAGE_ID']." AND STAGE_PLANNING_ID=".$un_creneau['CRENEAU_PLANNING_ID']." 
                        AND 1 = ( SELECT COUNT(*) FROM common_soutenances_planning_creneau WHERE CRENEAU_PLANNING_ID=" . $un_creneau['CRENEAU_PLANNING_ID'] . "
                                AND CRENEAU_ID=STAGE_SOUTENANCE_CRENEAU_ID
                                AND ((CRENEAU_DEBUT < " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_DEBUT > " . $un_creneau["CRENEAU_DEBUT"] . ") OR
                                     (CRENEAU_FIN < " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_FIN > " . $un_creneau["CRENEAU_DEBUT"] . ") OR
                                     (CRENEAU_FIN = " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_DEBUT = " . $un_creneau["CRENEAU_DEBUT"] . "))
                            )
                            ";

                if (self::doRequete($req)->num_rows === 1) {
                    $req = "UPDATE common_soutenances_planning_creneau_enseignant
                               SET DISPO_CRENEAU_STAGE_ID=".$un_stage["DISPO_CRENEAU_STAGE_ID"]."
                               WHERE CRENEAU_DISPO_ID=$dispo_id AND DISPO_CRENEAU_ID=$creneau_id";
                    self::execRequete($req);
                }
            }

        }

        return true;
    }

    private static function resteSallesDisponibles(int $dispo_id, int $creneau_id) : bool
    {
        $req = "SELECT CRENEAU_DEBUT, CRENEAU_FIN, CRENEAU_PLANNING_ID
                    FROM common_soutenances_planning_creneau
                    WHERE CRENEAU_ID=$creneau_id  
                    ";
        $le_creneau_a_comparer = self::getRequete($req);
        if (count($le_creneau_a_comparer) != 1) {
            return false;
        }
        $req = "SELECT DISPO_DATE
                    FROM common_soutenances_planning_dispo_enseignant
                    WHERE DISPO_ID=$dispo_id  
                    ";
        $la_dispo_a_comparer = self::getRequete($req);
        if (count($la_dispo_a_comparer) != 1) {
            return false;
        }
        foreach ($le_creneau_a_comparer as $un_creneau) {
            foreach ($la_dispo_a_comparer as $une_dispo) {
                $nb_max = 0;
                $le_planning = Soutenances::getUnPlanning($un_creneau['CRENEAU_PLANNING_ID']);
                foreach ($le_planning as $un_planning) {
                    $nb_max = $un_planning["PLANNING_SOUTENANCES_NB_SALLES"];
                    if ($nb_max == 0) {
                        return true;
                    }
                }
                $req = "SELECT DISTINCT DISPO_CRENEAU_STAGE_ID
                        FROM common_soutenances_planning_creneau_enseignant,common_soutenances_planning_dispo_enseignant
                        WHERE DISPO_DATE = ".$une_dispo['DISPO_DATE']." AND DISPO_ID=CRENEAU_DISPO_ID
                          AND DISPO_CRENEAU_STAGE_ID IS NOT NULL AND DISPO_CRENEAU_ID IN (
                            SELECT CRENEAU_ID FROM common_soutenances_planning_creneau WHERE CRENEAU_PLANNING_ID=" . $un_creneau["CRENEAU_PLANNING_ID"] . "
                                AND ((CRENEAU_DEBUT < " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_DEBUT > " . $un_creneau["CRENEAU_DEBUT"] . ") OR
                                     (CRENEAU_FIN < " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_FIN > " . $un_creneau["CRENEAU_DEBUT"] . ") OR
                                     (CRENEAU_FIN = " . $un_creneau["CRENEAU_FIN"] . " AND CRENEAU_DEBUT = " . $un_creneau["CRENEAU_DEBUT"] . "))
                            )
                            ";

                return $nb_max > self::doRequete($req)->num_rows;
            }
        }

        return false;
    }
}