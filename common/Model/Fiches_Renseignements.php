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

class Fiches_Renseignements extends Connectable
{
    public static function creerChamp(array $data) : int {
        return createData("common_etudiant_champs_renseignement",$data,4);
    }

    public static function supprimerChamp(int $champ_id) : bool {
        $req = "DELETE FROM common_etudiant_champs_renseignement WHERE CHAMPS_ID=$champ_id";
        return self::execRequete($req);
    }

    public static function getChampsDeLaFormation(int $form_id) : array {
        $req = "SELECT *,IF(CHAMPS_OBLIGATOIRE=1,'CHECKED','') AS CHAMPS_OBLIGATOIRE_CHECKED
                , CASE CHAMPS_TYPE
                           WHEN 'text' THEN 'Texte'
                           WHEN 'checkbox' THEN 'Case à cocher'
                           ELSE 'erreur'
                  END  AS CHAMPS_TYPE_AFF
                FROM common_etudiant_champs_renseignement
                WHERE CHAMPS_FORM_ID=$form_id
                ORDER BY CHAMPS_ORDRE";

        return self::getRequete($req);
    }

    public static function getChampsDeLaFormationValorises(int $form_id, int $et_id) : array {
        $req = "SELECT *,IF(CHAMPS_TYPE='checkbox',IF(CHAMPS_ET_VALEUR=1,'oui','non'),CHAMPS_ET_VALEUR) AS CHAMPS_ET_VALEUR_AFF
                FROM common_etudiant_champs_renseignement
                LEFT JOIN common_etudiant_renseignement ON (CHAMPS_ID=ET_CHAMPS_ID AND CHAMPS_ET_ID=$et_id) 
                WHERE CHAMPS_FORM_ID=$form_id
                ORDER BY CHAMPS_ORDRE";

        return self::getRequete($req);
    }

    public static function getEtudiantsAyantDesFichesNonRemplies(int $annee_id) : array {
        $req = "SELECT common_etudiant.*
                FROM (common_inscription,common_semestre,common_etudiant,common_etudiant_champs_renseignement)
                LEFT JOIN common_etudiant_renseignement ON (ET_ID=CHAMPS_ET_ID AND CHAMPS_ID=ET_CHAMPS_ID)
                WHERE INSCRIPT_ANNEE_ID=$annee_id AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID
                  AND CHAMPS_FORM_ID=SEM_FORM_ID AND CHAMPS_OBLIGATOIRE=1 AND (CHAMPS_ET_VALEUR IS NULL OR CHAMPS_ET_VALEUR='')
                  AND ET_DEM=0     
                GROUP BY ET_ID      
                ";
        return self::getRequete($req);
    }

    public static function hasDesFichesNonRemplies(int $et_id,int $annee_id) : bool {
        $req = "SELECT common_etudiant.*
                FROM (common_inscription,common_semestre,common_etudiant,common_etudiant_champs_renseignement)
                LEFT JOIN common_etudiant_renseignement ON (ET_ID=CHAMPS_ET_ID AND CHAMPS_ID=ET_CHAMPS_ID)
                WHERE INSCRIPT_ANNEE_ID=$annee_id AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID
                  AND CHAMPS_FORM_ID=SEM_FORM_ID AND CHAMPS_OBLIGATOIRE=1 AND (CHAMPS_ET_VALEUR IS NULL OR CHAMPS_ET_VALEUR='')
                  AND ET_DEM=0 AND ET_ID=$et_id    
                GROUP BY ET_ID      
                ";
        return self::doRequete($req)->num_rows > 0;
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool {
        switch ($tag) {
            case "ET_BAC" :
            case "ET_TEL" :
            case "ET_ADRESSE" :
            case "ET_ADRESSE_2" :
            case "ET_ENTREPRISE" :
            case "ET_ADRESSE_ENTREPRISE" :
            case "ET_DEBUT" :
            case "ET_LIEU" :
            case "ET_INFO_LIEU" :
            case "ET_TUTEUR" :
            case "ET_MAIL_TUTEUR" :
            case "ET_TEL_TUTEUR" :
                $req = "UPDATE common_etudiant SET " . $tag . "='" . $valeur . "' WHERE ET_ID=" . CURRENT_ID;
                return self::execRequete($req);
            case "CHAMPS_ET_VALEUR" :
                $req = "INSERT INTO common_etudiant_renseignement(CHAMPS_ET_ID, ET_CHAMPS_ID, CHAMPS_ET_VALEUR) VALUES (".CURRENT_ID.",$wherenum,'$valeur') ON DUPLICATE KEY UPDATE CHAMPS_ET_VALEUR='$valeur'";
                return self::execRequete($req);
            case "CHAMPS_LABEL" :
            case "CHAMPS_ORDRE" :
            case "CHAMPS_OBLIGATOIRE" :
                $req = "UPDATE common_etudiant_champs_renseignement SET $tag='$valeur' WHERE CHAMPS_ID=$wherenum";
                return self::execRequete($req);
        }
        return false;
    }

}