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

class Edt extends Connectable
{
    public static int $current_project_id = 4;

    public static function getReel(int $enseignant,int $annee) : array {
        $req = "SELECT *,ROUND(SUM(EDT_HEURE_FIN-EDT_HEURE_DEBUT)/3600) AS EDT_TOTAL FROM common_backup_ade_enseignant WHERE EDT_ANNEE_ID=$annee AND EDT_ENS_ID=$enseignant GROUP BY EDT_NOM ORDER BY EDT_DATE_DEBUT,EDT_HEURE_DEBUT,EDT_DATE_FIN,EDT_HEURE_FIN";
        return self::getRequete($req);
    }

    public static function getPeriode(int $FORM_1,int $FORM_2) : array {
        $req = "SELECT *,DATE_FORMAT(PERIODE_LIMIT,'%d/%m/%Y') AS PERIODE_LIMITF,DATE_FORMAT(PERIODE_LIMIT_NOTES,'%d/%m/%Y') AS PERIODE_LIMITF_NOTES, DATE_FORMAT(PERIODE_DEBUT_WARNING,'%d/%m/%Y') AS PERIODE_DEBUT_WARNINGF, DATE_FORMAT(PERIODE_DEBUT,'%d/%m/%Y') AS PERIODE_DEBUTF, DATE_FORMAT(PERIODE_FIN,'%d/%m/%Y') AS PERIODE_FINF, DATE_FORMAT(PERIODE_EXAM_DEBUT,'%d/%m/%Y') AS PERIODE_EXAM_DEBUTF, DATE_FORMAT(PERIODE_EXAM_FIN,'%d/%m/%Y') AS PERIODE_EXAM_FINF from common_edt_periode WHERE PERIODE_FORM_ID_1=$FORM_1 OR PERIODE_FORM_ID_2=$FORM_2 ORDER BY PERIODE_DEBUT";
        return self::getRequete($req);
    }

    public static function getPeriodes(string $les_formations) : array {
        $req = "SELECT *,DATE_FORMAT(PERIODE_LIMIT,'%d/%m/%Y') AS PERIODE_LIMITF,DATE_FORMAT(PERIODE_LIMIT_NOTES,'%d/%m/%Y') AS PERIODE_LIMITF_NOTES, DATE_FORMAT(PERIODE_DEBUT_WARNING,'%d/%m/%Y') AS PERIODE_DEBUT_WARNINGF, DATE_FORMAT(PERIODE_DEBUT,'%d/%m/%Y') AS PERIODE_DEBUTF, DATE_FORMAT(PERIODE_FIN,'%d/%m/%Y') AS PERIODE_FINF, DATE_FORMAT(PERIODE_EXAM_DEBUT,'%d/%m/%Y') AS PERIODE_EXAM_DEBUTF, DATE_FORMAT(PERIODE_EXAM_FIN,'%d/%m/%Y') AS PERIODE_EXAM_FINF from common_edt_periode WHERE PERIODE_FORM_ID_1 IN ($les_formations) OR PERIODE_FORM_ID_2 IN ($les_formations) ORDER BY PERIODE_DEBUT";
        return self::getRequete($req);
    }


    public static function getPeriodeMatieres(string $formations_autorisees) : array {
        $req = "SELECT * from common_periodes_matieres,common_edt_periode,common_formation WHERE PERIODE_ID=MAT_PERIODE_ID AND (FORM_ID = PERIODE_FORM_ID_1 OR FORM_ID = PERIODE_FORM_ID_2) AND FORM_ID IN ($formations_autorisees)";
        return self::getRequete($req);
    }

    public static function getPeriodeMatieresParPeriode(int $PERIODE_ID) : array {
        $req = "SELECT * FROM common_periodes_matieres WHERE MAT_PERIODE_ID=$PERIODE_ID";
        return self::getRequete($req);
    }

    public static function getPeriodeMatieresParFormation(?int $FORM_ID,?int $PERIODE_ID) : array {
        if ($FORM_ID == null || $PERIODE_ID == null) {
            return array();
        }
        $req = "SELECT * FROM common_periodes_matieres,common_ue,common_semestre,common_matiere WHERE SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND MAT_ID=PERIODE_MAT_ID AND SEM_FORM_ID=$FORM_ID AND MAT_PERIODE_ID=$PERIODE_ID";
        return self::getRequete($req);
    }

    public static function getFeries() : array {
        $req = "SELECT * FROM common_edt_ferie ORDER BY FERIE_SEMAINE";
        return self::getRequete($req);
    }

    public static function getRetardataires(int $periode_id) : array {
        $req = "SELECT ENS_ID, PERIODE_ID, ENS_NOM, GROUP_CONCAT(DISTINCT SUBSTRING(MAT_NOM,1,5) ORDER BY MAT_NOM SEPARATOR ', ') AS MATS_NOM, FICHE_ID
                FROM common_edt_periode
                         JOIN common_periodes_matieres ON (MAT_PERIODE_ID = PERIODE_ID)
                         JOIN common_enseignants_matieres ON (ENS_MAT_ID = PERIODE_MAT_ID AND ENS_MAT_ANNEE_ID = PERIODE_ANNEE_ID)
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= PERIODE_ANNEE_ID AND
                                                 (MAT_END_ANNEE_ID > PERIODE_ANNEE_ID OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID)
                         LEFT JOIN common_edt_fiche
                                   ON (FICHE_PERIODE_ID = PERIODE_ID AND FICHE_ENS_ID = MAT_ENS_ID AND FICHE_ANNEE_ID = PERIODE_ANNEE_ID)
                WHERE periode_id = $periode_id AND FICHE_ID IS NULL
                GROUP BY ENS_ID
                ORDER BY ENS_NOM
        ";

        return self::getRequete($req);
    }

    public static function getFichesEnseignant(int $ens_id, int $dept_id) : array {
        $req = "SELECT ENS_NOM,
                       ENS_ID,
                       PERIODE_NOM,
                       MAT_NOM,
                       ANNEE_NOM,
                       DATE_FORMAT(PERIODE_LIMIT, '%d/%m/%Y') AS PERIODE_LIMIT_AFFICHAGE,
                       PERIODE_ID,
                       ANNEE_ID - 1                           AS ANNEE_PRECEDENTE,
                       UNIX_TIMESTAMP(PERIODE_DEBUT_WARNING)  AS PERIODE_DEBUT_WARNING_UNIX,
                       UNIX_TIMESTAMP(PERIODE_LIMIT)          AS PERIODE_LIMIT_UNIX,
                       IF(FICHE_ID IS NULL, 0, 1)             AS HAS_FICHE,
                       (SELECT COUNT(*)
                        FROM common_edt_fiche
                        WHERE FICHE_PERIODE_ID = PERIODE_ID
                          AND FICHE_ANNEE_ID = PERIODE_ANNEE_ID - 1
                          AND FICHE_ENS_ID = $ens_id)               AS HAS_OLD_FICHE
                FROM common_formation
                         join common_edt_periode on (PERIODE_FORM_ID_1 = FORM_ID OR PERIODE_FORM_ID_2 = FORM_ID)
                         join common_periodes_matieres on (MAT_PERIODE_ID = PERIODE_ID)
                         join common_matiere on (MAT_ID = PERIODE_MAT_ID AND MAT_START_ANNEE_ID <= PERIODE_ANNEE_ID AND
                                                 (MAT_END_ANNEE_ID > PERIODE_ANNEE_ID OR MAT_END_ANNEE_ID IS NULL))
                         join common_enseignants_matieres
                              on (ENS_MAT_ID = PERIODE_MAT_ID AND ENS_MAT_ANNEE_ID = PERIODE_ANNEE_ID AND MAT_ENS_ID = $ens_id)
                         join common_annee on (ANNEE_ID = PERIODE_ANNEE_ID AND ANNEE_CLOSE = 0)
                         join common_enseignant on (ENS_ID = $ens_id)
                         LEFT JOIN common_edt_fiche
                                   ON (PERIODE_ID = FICHE_PERIODE_ID AND FICHE_ANNEE_ID = PERIODE_ANNEE_ID AND FICHE_ENS_ID = $ens_id)
                WHERE FORM_DEPT_ID = $dept_id
                GROUP BY PERIODE_ID
                ORDER BY PERIODE_LIMIT, PERIODE_DEBUT, PERIODE_FIN";
        return self::getRequete($req);
    }

    public static function getMailLimiteNotes(string $today) : mysqli_result{
        $req = "SELECT ENS_ID,ENS_MAIL,PERIODE_NOM,DATE_FORMAT(PERIODE_LIMIT_NOTES, '%d/%m/%Y') AS PERIODE_LIMIT_AFFICHAGE FROM edt_interventions WHERE ANNEE_ID=PERIODE_ANNEE_ID AND PERIODE_ANNEE_ID=ENS_MAT_ANNEE_ID AND DATE_SUB(PERIODE_LIMIT_NOTES, INTERVAL 15 DAY) <= '$today' AND PERIODE_LIMIT_NOTES >= '$today' GROUP BY PERIODE_ID,ENS_ID  ORDER BY ENS_ID,PERIODE_LIMIT_NOTES";
        return self::doRequete($req);
    }

    /**
     * Méthode permettant de récupérer l'agenda ADE
     * @param int $projectId Identifiant du projet ADE
     * @param array $resourceID Identifiant de la ressource à interroger
     * @param array $events_affiche Tableau modifiable qui contiendra les activités du calendrier
     * @param int $nb_semaines Nombre de semaines à collecter (utile uniquement si les dates de début ET de fin sont null OU si la date de fin est null)
     * @param bool $avec_passe Collecter les activités passées (utile uniquement si les dates de début ET de fin sont null)
     * @param bool $avec_futur Collecter las activités futures (utile uniquement si les dates de début ET de fin sont null)
     * @param bool $compute_groupes Si true, mappe les groupes Odin en fonction des codes ADE
     * @param bool $compute_enseignants Si true, mappe les enseignants Odin en fonction des codes ADE
     * @param DateTime|null $start Date de début
     * @param DateTime|null $end Date de fin
     */
    public static function collectEDTv2(int $projectId, array $resourceID, array &$events_affiche, int $nb_semaines = 8, bool $avec_passe = false, bool $avec_futur = true, bool $compute_groupes = false, bool $compute_enseignants = false, ?DateTime $start=null, ?DateTime $end=null,bool $avecDetailActivite = false, ?array &$activites = null) : bool
    {
        foreach ($resourceID as $une_resource_id) {
            $events = WS_ADE::getEvenements($projectId,$une_resource_id,$nb_semaines,$avec_passe,$avec_futur,$compute_groupes,$compute_enseignants,$start,$end);
            if ($events === null) {
                return false;
            }
            $lesActiviteId = array();
            foreach ($events as $un_evt) {
                $event_en_cours = &$events_affiche[$un_evt->getStart().$un_evt->getUid()];
                $lesActiviteId[] = $un_evt->getActivityId();
                $event_en_cours = array(
                    "ACTIVITE_ID" => $un_evt->getActivityId(),
                    "DATE_DEBUT" => date('d/m/Y', $un_evt->getStart()),
                    "JOUR_DATE_DEBUT" => convertDays(date('l', $un_evt->getStart())),
                    "NUMERO_DATE_DEBUT" => date('d', $un_evt->getStart()),
                    "MOIS_DATE_DEBUT" => convertMonth(date('F', $un_evt->getStart())),
                    "ANNEE_DATE_DEBUT" => date('Y', $un_evt->getStart()),
                    "DATE_FIN" => date('d/m/Y', $un_evt->getEnd()),
                    "HEURE_DEBUT" => date('H:i', $un_evt->getStart()),
                    "HEURE_FIN" => date('H:i', $un_evt->getEnd()),
                    "REAL_DATE_DEBUT" => $un_evt->getStart(),
                    "REAL_DATE_FIN" => $un_evt->getEnd(),
                    "REAL_HEURE_DEBUT" => $un_evt->getStart(),
                    "REAL_HEURE_FIN" => $un_evt->getEnd(),
                    "SALLE" => $un_evt->getSalles(),
                    "SALLE_PROTECTED" => addslashes($un_evt->getSalles()),
                    "NOM" => $un_evt->getName(),
                    "NOM_PROTECTED" => addslashes($un_evt->getName()),
                    "UID" => $un_evt->getUid(),
                    "COULEUR" => $un_evt->getRVB(),
                    "GROUPES" => $un_evt->getGroupes(),
                    "RID" => $une_resource_id,
                    "ENSEIGNANTS" => $un_evt->getEnseignants(),
                    "NB_ENS" => $un_evt->countEnseignants(),
                    "DEPARTEMENTS" => $un_evt->getDepartements(),
                    "*EDT_DATE_DEBUT" => $un_evt->getStart(),
                    "*EDT_DATE_FIN" => $un_evt->getEnd(),
                    "*EDT_HEURE_DEBUT" => $un_evt->getStart(),
                    "*EDT_HEURE_FIN" => $un_evt->getEnd(),
                    "*EDT_SALLE" => addslashes($un_evt->getSalles()),
                    "*EDT_NOM" => addslashes($un_evt->getName()),
                    "*EDT_UID" => $un_evt->getUid()
                );
            }

            if ($avecDetailActivite && $activites !== null){
                $lesActiviteId = array_unique($lesActiviteId);
                foreach ($lesActiviteId as $uneActivite) {
                    $activites[$uneActivite] = WS_ADE::getDetailActivite(EDT::$current_project_id,$uneActivite);
                }
            }
        }
        ksort($events_affiche);

        return true;
    }

    public static function collectEDT(string $adresse, array &$events_affiche)
    {
        require_once __DIR__.'/../../vendor/johngrogg/ics-parser/src/ICal/ICal.php';
        require_once __DIR__.'/../../vendor/johngrogg/ics-parser/src/ICal/Event.php';

        try {
            $ical = new \ICal\ICal($adresse);
            $events = $ical->events();
            
            foreach ($events as $un_evt) {
                $event_en_cours = &$events_affiche[$ical->iCalDateToUnixTimestamp($un_evt->dtstart) . $un_evt->uid];
                $event_en_cours = array(
                    "DATE_DEBUT" => date('d/m/Y', $ical->iCalDateToUnixTimestamp($un_evt->dtstart)),
                    "JOUR_DATE_DEBUT" => convertDays(date('l', $ical->iCalDateToUnixTimestamp($un_evt->dtstart))),
                    "NUMERO_DATE_DEBUT" => date('d', $ical->iCalDateToUnixTimestamp($un_evt->dtstart)),
                    "MOIS_DATE_DEBUT" => convertMonth(date('F', $ical->iCalDateToUnixTimestamp($un_evt->dtstart))),
                    "ANNEE_DATE_DEBUT" => date('Y', $ical->iCalDateToUnixTimestamp($un_evt->dtstart)),
                    "DATE_FIN" => date('d/m/Y', $ical->iCalDateToUnixTimestamp($un_evt->dtend)),
                    "HEURE_DEBUT" => date('H:i', $ical->iCalDateToUnixTimestamp($un_evt->dtstart)),
                    "HEURE_FIN" => date('H:i', $ical->iCalDateToUnixTimestamp($un_evt->dtend)),
                    "REAL_DATE_DEBUT" => $ical->iCalDateToUnixTimestamp($un_evt->dtstart),
                    "REAL_DATE_FIN" => $ical->iCalDateToUnixTimestamp($un_evt->dtend),
                    "REAL_HEURE_DEBUT" => $ical->iCalDateToUnixTimestamp($un_evt->dtstart),
                    "REAL_HEURE_FIN" => $ical->iCalDateToUnixTimestamp($un_evt->dtend),
                    "SALLE" => str_ireplace("\\", "", $un_evt->location),
                    "NOM" => $un_evt->summary,
                    "UID" => $un_evt->uid,
                    "*EDT_DATE_DEBUT" => $ical->iCalDateToUnixTimestamp($un_evt->dtstart),
                    "*EDT_DATE_FIN" => $ical->iCalDateToUnixTimestamp($un_evt->dtend),
                    "*EDT_HEURE_DEBUT" => $ical->iCalDateToUnixTimestamp($un_evt->dtstart),
                    "*EDT_HEURE_FIN" => $ical->iCalDateToUnixTimestamp($un_evt->dtend),
                    "*EDT_SALLE" => str_ireplace("\\", "", $un_evt->location),
                    "*EDT_NOM" => addslashes($un_evt->summary),
                    "*EDT_UID" => $un_evt->uid
                );
            }

            ksort($events_affiche);
        } catch (Exception $e)
        {}
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        $annee_courante = Annees::getIdAnneeCourante();

        switch ($tag) {
            case "PERIODE_LIMIT" :
            case "PERIODE_LIMIT_NOTES" :
            case "PERIODE_DEBUT_WARNING" :
            case "PERIODE_DEBUT" :
            case "PERIODE_FIN" :
            case "PERIODE_EXAM_DEBUT" :
            case "PERIODE_EXAM_FIN" :
                if ($valeur == "") {
                    $req = "UPDATE common_edt_periode SET $tag=NULL WHERE PERIODE_ID=$wherenum";
                    return self::execRequete($req);
                } else {
                    try {
                        list($jour, $mois, $annee) = explode('/', $valeur);
                        $today = $annee;
                        $today .= "-" . $mois;
                        $today .= "-" . $jour;
                        $req = "UPDATE common_edt_periode SET $tag='" . $today . "' WHERE PERIODE_ID=$wherenum";
                        return self::execRequete($req);
                    } catch (Exception $e) {
                    }
                }
                break;
            case "PERIODE_ANNEE_ID" :
            case "PERIODE_FORM_ID_1" :
            case "PERIODE_FORM_ID_2" :
            case "PERIODE_TYPE" :
            case "PERIODE_SEMAINES" :
            case "PERIODE_PAIEMENT" :
                if ($valeur == "NULL" || $valeur == "") {
                    $req = "UPDATE common_edt_periode SET $tag=NULL WHERE PERIODE_ID=$wherenum";
                } else {
                    $req = "UPDATE common_edt_periode SET $tag='$valeur' WHERE PERIODE_ID=$wherenum";
                }
                return self::execRequete($req);
                break;
        }
        return false;
    }

    public static function getPeriodeID(int $periode_id) : array
    {
        $req = "SELECT *,DATE_FORMAT(PERIODE_LIMIT, '%d/%m/%Y') AS PERIODE_LIMIT_AFFICHAGE,DATE_FORMAT(PERIODE_FIN, '%d/%m/%Y') AS PERIODE_FIN_AFFICHAGE,DATE_FORMAT(PERIODE_DEBUT, '%d/%m/%Y') AS PERIODE_DEBUT_AFFICHAGE FROM common_edt_periode WHERE PERIODE_ID = $periode_id ORDER BY PERIODE_LIMIT";
        return self::getRequete($req);
    }

    public static function updateFiche(int $ens_id, int $periode_id, int $annee_id, string $date) : int
    {
        $req = "INSERT INTO common_edt_fiche(FICHE_ENS_ID, FICHE_PERIODE_ID, FICHE_ANNEE_ID, FICHE_DATE_MODIFICATION) VALUES ($ens_id,$periode_id,$annee_id,'$date') ON DUPLICATE KEY UPDATE FICHE_DATE_MODIFICATION='" . date("Y-m-d H:i:s") . "'";
        return self::execRequeteAvecInsertId($req);
    }

    public static function getPeriodeMatieresParPeriodeAvecEnseignant(int $periode_id, int $ens_id, int $annee_id) : array
    {
        $req = "SELECT *
                FROM common_enseignants_matieres
                    JOIN common_periodes_matieres ON (PERIODE_MAT_ID=ENS_MAT_ID AND MAT_PERIODE_ID=$periode_id)
                    JOIN common_matiere ON (MAT_START_ANNEE_ID <= $annee_id AND (MAT_END_ANNEE_ID > $annee_id OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=PERIODE_MAT_ID AND MAT_ID=ENS_MAT_ID)
                    WHERE ENS_MAT_ANNEE_ID=$annee_id AND MAT_ENS_ID = $ens_id  ORDER BY MAT_NOM";
        return self::getRequete($req);
    }

    public static function getPeriodesDuDepartement(int $annee_id,int $dept_id) : array
    {
        $req = "SELECT DISTINCT common_edt_periode.*
                FROM common_edt_periode
                         join common_formation on ((FORM_END_ANNEE_ID > $annee_id OR FORM_END_ANNEE_ID IS NULL)
                    AND (PERIODE_FORM_ID_1 = FORM_ID OR PERIODE_FORM_ID_2 = FORM_ID)
                    AND FORM_DEPT_ID = $dept_id)
                ORDER BY PERIODE_LIMIT";
        return self::getRequete($req);
    }

    public static function getCreneaux(int $ens_id, int $datedebut) : array
    {
        $req = "SELECT * FROM common_backup_ade_enseignant WHERE EDT_ENS_ID=$ens_id AND EDT_DATE_DEBUT>=$datedebut";
        return self::getRequeteAvecClef("EDT_UID",$req);
    }

    public static function deleteCreneaux(int $ens_id, int $datedebut) : bool
    {
        $req = "DELETE FROM common_backup_ade_enseignant WHERE EDT_ENS_ID=$ens_id AND EDT_DATE_DEBUT>=$datedebut";
        return self::execRequete($req);
    }

    public static function getCreneauxEtudiant(int $groupe_id, int $datedebut) : array
    {
        $req = "SELECT * FROM common_backup_ade_etudiant WHERE EDT_GROUPE_ID=$groupe_id AND EDT_DATE_DEBUT>=$datedebut";
        return self::getRequeteAvecClef("EDT_UID",$req);
    }

    public static function deleteCreneauxEtudiant(int $groupe_id, int $datedebut) : bool
    {
        $req = "DELETE FROM common_backup_ade_etudiant WHERE EDT_GROUPE_ID=$groupe_id AND EDT_DATE_DEBUT>=$datedebut";
        return self::execRequete($req);
    }

    public static function getFiches(int $periode_id) : array
    {
        $req = "SELECT ENS_NOM, ENS_ID, FICHE_ID, PERIODE_ID, IFNULL((54 - (COUNT(DISPO_ENS_ID) + 6)) * PERIODE_SEMAINES, 0) AS TOTAL
                FROM common_edt_fiche
                         join common_edt_periode on (PERIODE_ANNEE_ID = FICHE_ANNEE_ID AND PERIODE_ID = FICHE_PERIODE_ID)
                         join common_enseignant on (ENS_ID = FICHE_ENS_ID)
                         LEFT JOIN common_edt_indisponibilite ON (FICHE_ID = DISPO_FICHE_ID)
                WHERE  FICHE_PERIODE_ID = $periode_id
                GROUP BY ENS_ID
                ORDER BY TOTAL";
        return self::getRequete($req);
    }

    public static function getMatieres(int $periode_id, ?int $ens_id = null) : array
    {
        $complement = "";
        if ($ens_id != null) {
            $complement = "AND ENS_ID = $ens_id";
        }
        $req = "SELECT MAT_NOM,
                       ENS_NOM,
                       MAT_ID,ENS_ID,FORM_NOM,
                       REPLACE(COMMENTAIRE,'\n','<br/>') AS COMMENTAIRE,
                       COMMENTAIRE_GESTIONNAIRE,
                       ID,
                       FICHE_ID,
                       IF(COMMENTAIRE_DONE IS NOT NULL AND COMMENTAIRE_DONE = 1, 'checked', '') AS COMMENTAIRE_CHECKED,
                       COUNT(CHARGE_ID) OVER (PARTITION BY CHARGE_AFFECTATION_ID) AS NB_CHARGES,
                       ROW_NUMBER() over (PARTITION BY CHARGE_AFFECTATION_ID ORDER BY CHARGE_TYPE) AS NUMERO_CHARGES,       
                       common_charge_v2.*
                FROM common_periodes_matieres
                         JOIN common_edt_periode ON (MAT_PERIODE_ID = PERIODE_ID AND PERIODE_ID = $periode_id)
                         JOIN common_matiere ON (MAT_ID = PERIODE_MAT_ID AND MAT_START_ANNEE_ID <= PERIODE_ANNEE_ID AND
                                                 (MAT_END_ANNEE_ID > PERIODE_ANNEE_ID OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID)
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID)
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID)
                         JOIN common_enseignants_matieres ON (MAT_ID = ENS_MAT_ID AND ENS_MAT_ANNEE_ID = PERIODE_ANNEE_ID)
                         JOIN common_charge_v2 ON (ID = CHARGE_AFFECTATION_ID)
                         JOIN common_enseignant ON (ENS_ID = MAT_ENS_ID $complement)
                         LEFT JOIN common_edt_commentaires ON (ID = COMMENTAIRE_AFFECT_ID)
                         LEFT JOIN common_edt_fiche ON (FICHE_ENS_ID = ENS_ID AND PERIODE_ID=FICHE_PERIODE_ID AND FICHE_ANNEE_ID = PERIODE_ANNEE_ID)
                ORDER BY SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID, MAT_ORDRE, MAT_ID, ENS_NOM
        ";
        return self::getRequete($req);
    }

    public static function getIndisponibilites(int $fiche_id) : array
    {
        $req = "SELECT DISPO_INDISPO, DISPO_FICHE_ID
                FROM common_edt_indisponibilite
                         JOIN common_enseignant on (DISPO_ENS_ID = ENS_ID)
                WHERE DISPO_FICHE_ID = $fiche_id
                ORDER BY DISPO_INDISPO
        ";
        return self::getRequeteAvecClef("DISPO_INDISPO",$req);
    }

    public static function getFiche(int $fiche_id) : array
    {
        $req = "SELECT * FROM common_edt_fiche WHERE FICHE_ID=$fiche_id";
        return self::getRequete($req);


    }

    public static function CopyFiche(int $fiche_id, int $ens_id, int $annee_id, int $periode_id) : bool
    {
        $req = "INSERT INTO common_edt_indisponibilite(DISPO_FICHE_ID, DISPO_INDISPO, DISPO_ENS_ID)
                    (SELECT $fiche_id, DISPO_INDISPO, DISPO_ENS_ID
                     FROM common_edt_fiche,
                          common_edt_indisponibilite
                     WHERE FICHE_PERIODE_ID = $periode_id
                       AND FICHE_ID = DISPO_FICHE_ID
                       AND FICHE_ANNEE_ID = $annee_id - 1
                       AND DISPO_ENS_ID = $ens_id)";
        return self::execRequete($req);
    }

    public static function getFicheEnseignant(int $ens_id, int $periode_id, int $annee_id) : array
    {
        $req = "SELECT *
                    FROM common_edt_fiche
                    WHERE FICHE_ENS_ID=$ens_id AND FICHE_PERIODE_ID=$periode_id AND FICHE_ANNEE_ID=$annee_id";
        return self::getRequete($req);
    }

    public static function getFichesDuGestionnaire(int $dept_id) : array
    {
        $req = "SELECT ENS_NOM, PERIODE_NOM, MAT_NOM, PERIODE_ID, FICHE_ID, ENS_ID, DATE_FORMAT(PERIODE_DEBUT,'%d/%m/%Y') AS PERIODE_DEBUT
                FROM common_enseignants_departement
                         JOIN common_annee ON (ANNEE_CLOSE = 0)
                         JOIN common_enseignant ON (ENS_ID = DEPT_ENS_ID)
                         JOIN common_enseignants_matieres ON (MAT_ENS_ID = ENS_ID AND ENS_MAT_ANNEE_ID = ANNEE_ID)
                         JOIN common_matiere ON (MAT_ID = ENS_MAT_ID AND MAT_START_ANNEE_ID <= ANNEE_ID AND
                                                 (MAT_END_ANNEE_ID > ANNEE_ID OR MAT_END_ANNEE_ID IS NULL))
                         JOIN common_ue ON (UE_ID = MAT_UE_ID)
                         JOIN common_semestre ON (SEM_ID = UE_SEM_ID)
                         JOIN common_formation ON (FORM_ID = SEM_FORM_ID AND FORM_DEPT_ID = ENS_DEPT_ID)
                         JOIN common_periodes_matieres ON (PERIODE_MAT_ID = MAT_ID)
                         JOIN common_edt_periode ON (PERIODE_ID = MAT_PERIODE_ID AND PERIODE_ANNEE_ID = ANNEE_ID)
                         LEFT JOIN common_edt_fiche
                                   ON (FICHE_ENS_ID = DEPT_ENS_ID AND FICHE_ANNEE_ID = ANNEE_ID AND FICHE_PERIODE_ID = PERIODE_ID)
                WHERE ENS_DEPT_ID = 1
                ORDER BY ENS_NOM, PERIODE_LIMIT
        ";
        return self::getRequete($req);
    }

}