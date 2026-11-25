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

class Jury extends Connectable
{
    public static function creerJury(array $data) : int {
        return createData("common_jury",$data,3);
    }

    public static function creerGroupe(array $data) : int {
        return createData("common_jury_groupe",$data,3);
    }

    public static function creerVote(array $data) : int {
        $req = "SELECT * FROM common_jury_vote WHERE VOTE_CLOT=0 AND VOTE_JURY_ID=".$data['bfmw_num_*VOTE_JURY_ID']." AND VOTE_ET_ID=".$data['bfmw_num_*VOTE_ET_ID']." AND VOTE_GROUPE_ID=".$data['bfmw_num_*VOTE_GROUPE_ID'];
        if (self::doRequete($req)->num_rows > 0) {
            return -1;
        }
        return createData("common_jury_vote",$data,4);
    }

    public static function cloreVote(int $vote_id) : bool {
        $req = "UPDATE common_jury_vote SET VOTE_CLOT=1 WHERE VOTE_ID=$vote_id";
        return self::execRequete($req);
    }

    public static function getVote(int $jury_id,int $ens_id) : array {
        $req = "SELECT *
                FROM common_jury_vote
                LEFT JOIN common_jury_vote_enseignant ON VOTE_ID = ENS_VOTE_ID AND VOTE_ENS_ID=$ens_id
                WHERE VOTE_JURY_ID=$jury_id";
        return self::getRequeteAvecClef("VOTE_ET_ID",$req);
    }

    public static function getVoteAvecResultats(int $jury_id) : array {
        $req = "SELECT *
                FROM common_jury_vote
                LEFT JOIN common_jury_vote_enseignant ON VOTE_ID = ENS_VOTE_ID
                WHERE VOTE_JURY_ID=$jury_id AND VOTE_CLOT=1
                ORDER BY VOTE_ET_ID, VOTE_GROUPE_ID,VOTE_ID, VOTE_VALEUR";
        $resultat = self::getRequete($req);

        $identifiant_courant = -1;
        $vote_courant = -1;
        $retour = array();
        foreach ($resultat as $un_vote) {
            if ($identifiant_courant !== $un_vote["VOTE_ET_ID"].$un_vote["VOTE_GROUPE_ID"]) {
                $identifiant_courant = $un_vote["VOTE_ET_ID"].$un_vote["VOTE_GROUPE_ID"];
                $retour[$identifiant_courant] = array();
            }
            if ($vote_courant != $un_vote["VOTE_ID"]) {
                $vote_courant = $un_vote["VOTE_ID"];
                $retour[$identifiant_courant][$vote_courant] = array(
                    "VOTE_POUR" => 0,
                    "VOTE_CONTRE" => 0,
                    "VOTE_ABSTENTION" => 0,
                    "VOTE_NOM" => $un_vote['VOTE_NOM']
                );
            }
            switch ($un_vote['VOTE_VALEUR']) {
                case "Pour" : $retour[$identifiant_courant][$vote_courant]["VOTE_POUR"]++;break;
                case "Contre" : $retour[$identifiant_courant][$vote_courant]["VOTE_CONTRE"]++;break;
                case "Abstention" : $retour[$identifiant_courant][$vote_courant]["VOTE_ABSTENTION"]++;break;
            }
        }
        return $retour;
    }


    public static function getVotantEnCours(int $vote_id) : array {
        $req = "SELECT * FROM common_jury_vote_enseignant,common_enseignant WHERE ENS_ID=VOTE_ENS_ID AND ENS_VOTE_ID=$vote_id ORDER BY ENS_NOM";
        return self::getRequete($req);
    }

    public static function getJury(int $form_id, int $annee_id) : array {
        $req = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(JURY_START),'%d/%m/%Y %Hh%i') AS JURY_START_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(JURY_END),'%d/%m/%Y %Hh%i') AS JURY_END_AFFICHAGE
                FROM common_jury WHERE JURY_FORM_ID = $form_id AND JURY_ANNEE_ID=$annee_id";
        return self::getRequete($req);
    }

    public static function getFormationsAyantDesJurys(string $form_id, int $annee_id, string $complement = "") : array {
        $req = "SELECT * FROM common_jury,common_formation WHERE $complement FORM_ID=JURY_FORM_ID AND JURY_FORM_ID IN ($form_id) GROUP BY FORM_ID";
        return self::getRequete($req);
    }

    public static function getGroupe(int $jury_id, int $form_id) : array {
        $req = "SELECT * FROM common_jury_groupe WHERE GROUPE_FORM_ID=$form_id AND GROUPE_JURY_ID=$jury_id ORDER BY GROUPE_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsGroupe(int $jury_id,int $groupe_id, int $form_id, int $annee_id) : array {
        $req = "SELECT GROUPE_ET_ID FROM common_jury_groupe,common_jury_groupe_etudiant WHERE GROUPE_ID=ET_GROUPE_ID AND GROUPE_ID<>$groupe_id AND GROUPE_JURY_ID=$jury_id";
        $les_id_deja_selectionnes = self::getRequeteAvecClef("GROUPE_ET_ID",$req);
        $les_id_deja_selectionnes[-1] = null;

        $les_etudiants = Etudiants::getEtudiantsInscrits($form_id,$annee_id,"ET_ID NOT IN (".implode(",",array_keys($les_id_deja_selectionnes)).") AND");

        if (count(array_keys($les_etudiants)) == 0 ) {
            return array();
        }
        $les_id_etudiants = implode(",",array_keys($les_etudiants));
        $req = "SELECT * FROM common_jury_groupe_etudiant WHERE GROUPE_ET_ID IN ($les_id_etudiants) AND ET_GROUPE_ID=$groupe_id";
        $les_selectionnes = self::getRequeteAvecClef("GROUPE_ET_ID",$req);
        foreach ($les_selectionnes as $et_id=>$_) {
            $les_etudiants[$et_id]["CHECKED"] = "checked";
        }
        return $les_etudiants;
    }

    public static function getGroupeAvecEtudiants(int $jury_id, string $dept_code) : array {
        $req = "(SELECT GROUPE_ID,
                       GROUPE_NOM,
                       ET_ID,
                       ET_NOM,
                       ET_NUMERO,
                       ROUND(MOYUE_VALEUR, 2)  AS MOYUE_VALEUR,
                       ROUND(MOYSEM_VALEUR, 2) AS MOYSEM_VALEUR,
                       ROUND(MOYUE_BARREE, 2) AS MOYUE_BARREE,
                       ANNEE_NOM,
                       SEM_NOM,
                       UE_NOM,
                       ANNEE_ID,
                       SEM_ID,
                       UE_ID,
                       SEM_ORDRE,
                       UE_ORDRE
                FROM common_jury_groupe
                         JOIN common_jury_groupe_etudiant ON (ET_GROUPE_ID = GROUPE_ID)
                         JOIN common_etudiant ON (ET_ID = GROUPE_ET_ID)
                         JOIN ".$dept_code."_notes_moyennes_semestre ON (MOYSEM_ET_ID = ET_ID)
                         JOIN ".$dept_code."_notes_moyennes_ue_meilleures
                              ON (MOYUE_SEM_ID = MOYSEM_ID AND MOYUE_ET_ID = MOYSEM_ET_ID AND MOYUE_ANNEE_ID = MOYSEM_ANNEE_ID)
                         JOIN common_semestre ON (SEM_ID = MOYSEM_ID)
                         JOIN common_ue ON (UE_ID = MOYUE_UE_ID)
                         JOIN common_annee ON (ANNEE_ID = MOYSEM_ANNEE_ID)
                WHERE GROUPE_JURY_ID = $jury_id
                UNION
                SELECT GROUPE_ID,
                       GROUPE_NOM,
                       ET_ID,
                       ET_NOM,
                       ET_NUMERO,
                       ROUND(MOYUE_VALEUR, 2)  AS MOYUE_VALEUR,
                       ROUND(MOYSEM_VALEUR, 2) AS MOYSEM_VALEUR,
                       ROUND(MOYUE_BARREE, 2) AS MOYUE_BARREE,
                       ANNEE_NOM,
                       SEM_NOM,
                       UE_NOM,
                       ANNEE_ID,
                       SEM_ID,
                       UE_ID,
                       SEM_ORDRE,
                       UE_ORDRE
                FROM common_jury_groupe
                         JOIN common_jury_groupe_etudiant ON (ET_GROUPE_ID = GROUPE_ID)
                         JOIN common_etudiant ON (ET_ID = GROUPE_ET_ID)
                         JOIN common_clotures_moyennes_semestre ON (MOYSEM_ET_ID = ET_ID)
                         JOIN common_clotures_moyennes_ue
                              ON (MOYUE_SEM_ID = MOYSEM_ID AND MOYUE_ET_ID = MOYSEM_ET_ID AND MOYUE_ANNEE_ID = MOYSEM_ANNEE_ID)
                         JOIN common_semestre ON (SEM_ID = MOYSEM_ID)
                         JOIN common_ue ON (UE_ID = MOYUE_UE_ID)
                         JOIN common_annee ON (ANNEE_ID = MOYSEM_ANNEE_ID)
                WHERE GROUPE_JURY_ID = $jury_id)
                ORDER BY GROUPE_NOM, GROUPE_ID, ET_NOM, ANNEE_ID, SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID";
        return self::getRequete($req);
    }

    public static function supprimerJury(int $form_id, int $jury_id, int $annee_id) : int {
        $req = "DELETE FROM common_jury WHERE JURY_FORM_ID=$form_id AND JURY_ID=$jury_id AND JURY_ANNEE_ID=$annee_id";
        return self::execRequeteAvecAffected($req);
    }

    public static function supprimerGroupe(int $groupe_id,int $form_id) : int {
        $req = "DELETE FROM common_jury_groupe WHERE GROUPE_FORM_ID=$form_id AND GROUPE_ID=$groupe_id";
        return self::execRequeteAvecAffected($req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        $validation = false;
        switch ($tag) {
            case "SELECT_GROUPE" :
                $tab = explode("$",$where);
                if ($valeurnum != 0) {
                    $req = "INSERT INTO common_jury_groupe_etudiant(GROUPE_ET_ID, ET_GROUPE_ID) VALUES ($tab[0],$tab[1])";
                } else {
                    $req = "DELETE FROM common_jury_groupe_etudiant WHERE GROUPE_ET_ID=$tab[0] AND ET_GROUPE_ID=$tab[1]";
                }
                return self::execRequete($req);
            case "JURY_START" :
            case "JURY_END" :
                try {
                    $ladate = transformDateHeure($valeur);
                } catch (Exception $e) {
                    return false;
                }
                $req = "UPDATE common_jury SET $tag=$ladate WHERE JURY_ID=$wherenum";
                return self::execRequete($req);
            case "VOTE" :
                $req = "SELECT * FROM common_jury_vote WHERE VOTE_ID=$wherenum AND VOTE_CLOT=0";
                if (self::doRequete($req)->num_rows != 1) {
                    return false;
                }

                $vote="Abstention";
                switch ($valeur) {
                    case "Pour" : $vote = "Pour";break;
                    case "Contre" : $vote = "Contre";break;
                }
                $req = "INSERT INTO common_jury_vote_enseignant(ENS_VOTE_ID, VOTE_ENS_ID, VOTE_VALEUR) VALUE ($wherenum,".CURRENT_ID.",'$vote') ON DUPLICATE KEY UPDATE VOTE_VALEUR='$vote'";
                return self::execRequete($req);
            case "CLOSE" :
                $tab = explode("$",$where);
                if (Formations::isResponsableFormation($tab[1])) {
                    Jury::cloreVote($tab[0]);
                }
            case "GROUPE_NOM" :
                $req = "UPDATE common_jury_groupe SET $tag = '$valeur' WHERE GROUPE_ID=$wherenum";
                return self::execRequete($req);
        }
        return $validation;
    }

    public static function getAnneeDuJury(int $jury_id) : int {
        $req = "SELECT * FROM common_jury WHERE JURY_ID=$jury_id";
        $le_jury = self::getRequete($req);
        foreach ($le_jury as $un_jury) {
            return $un_jury['JURY_ANNEE_ID'];
        }
        return Annees::getIdAnneeCourante();
    }

    public static function getMatieresValorisees(int $et_id, string $dept_code) : array
    {
        $req = "SELECT MAT_NOM,
                       ANNEE_NOM,
                       ANNEE_ID,
                       SEM_ID,
                       UE_NOM,
                       UE_ID,
                       SEM_NOM,
                       IF(nouvelle.MOYMAT_VALEUR IS NULL, round(ancienne.MOYMAT_VALEUR, 2),
                          round(nouvelle.MOYMAT_VALEUR, 2)) AS MOYMAT_VALEUR
                
                from common_inscription
                         join common_semestre on (sem_id = INSCRIPT_SEM_ID AND
                                                  SEM_START_ANNEE_ID <= INSCRIPT_ANNEE_ID AND
                                                  (SEM_END_ANNEE_ID > INSCRIPT_ANNEE_ID OR SEM_END_ANNEE_ID IS NULL))
                         join common_ue on (UE_SEM_ID = sem_id AND
                                            UE_START_ANNEE_ID <= INSCRIPT_ANNEE_ID AND
                                            (UE_END_ANNEE_ID > INSCRIPT_ANNEE_ID OR UE_END_ANNEE_ID IS NULL))
                         join common_matiere on (mat_ue_id = UE_ID AND MAT_HAS_NOTE = 1 AND MAT_COPIE_MAT_ID IS NULL AND
                                                 MAT_START_ANNEE_ID <= INSCRIPT_ANNEE_ID AND
                                                 (MAT_END_ANNEE_ID > INSCRIPT_ANNEE_ID OR MAT_END_ANNEE_ID IS NULL))
                         join common_annee on (ANNEE_ID = INSCRIPT_ANNEE_ID)
                         left join ".$dept_code."_notes_moyennes_matiere as nouvelle
                                   on (nouvelle.MOYMAT_ET_ID = INSCRIPT_ET_ID AND nouvelle.MOYMAT_ANNEE_ID = ANNEE_ID AND
                                       nouvelle.MOYMAT_MAT_ID = MAT_ID)
                         left join common_clotures_moyennes_matiere as ancienne
                                   on (ancienne.MOYMAT_ET_ID = INSCRIPT_ET_ID AND ancienne.MOYMAT_ANNEE_ID = ANNEE_ID AND
                                       ancienne.MOYMAT_MAT_ID = MAT_ID)
                where INSCRIPT_ET_ID = $et_id
                order by ANNEE_NOM, SEM_ORDRE, SEM_ID, UE_ORDRE, UE_ID, MAT_ORDRE, MAT_NOM";

        return self::getRequete($req);
    }


}