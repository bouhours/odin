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

class Controles extends Connectable
{
    /**
     * @param array $data 8 champs : CONTROLE_NOM,CONTROLE_MAT_ID,CONTROLE_ANNEE_ID,CONTROLE_ENS_ID,CONTROLE_VALIDE,CONTROLE_VISIBLE,CONTROLE_MOYENNE,CONTROLE_COEFF
     * @return int id du contrôle
     */
    public static function creerControle(array $data) : int {
        return createData("common_controle",$data,8);
    }

    public static function getControlesDansMatierePourUnEtudiant(int $et_id,int $mat_id, int $annee_id) : array {
        $req = "SELECT * FROM common_controle,common_notes WHERE CONTROLE_ID=NOTES_CONTROLE_ID AND NOTES_ET_ID=$et_id AND CONTROLE_MAT_ID=$mat_id AND CONTROLE_ANNEE_ID=$annee_id ORDER BY CONTROLE_NOM";
        return self::getRequete($req);
    }

    public static function getControlesAuBrouillon(int $matiere_courante, int $annee_courante, int $ens_id) : array {
        $req = "SELECT * FROM common_controle WHERE CONTROLE_MAT_ID=$matiere_courante AND CONTROLE_VALIDE=0 AND CONTROLE_ANNEE_ID=$annee_courante AND CONTROLE_ENS_ID=$ens_id ORDER BY CONTROLE_NOM";
        return self::getRequete($req);
    }

    public static function getControlesAValider(int $ens_id) : array {
        $req = "SELECT CONTROLE_NOM,CONTROLE_ID,MAT_NOM,FORM_NOM,FORM_ID,MAT_ID,COUNT(NOTES_ID) AS NB_NOTES
                 FROM common_notes,common_controle,common_annee,common_matiere,common_ue,common_semestre,common_formation
                WHERE CONTROLE_VALIDE=0 AND CONTROLE_ENS_ID=$ens_id
                  AND ANNEE_ID=CONTROLE_ANNEE_ID AND ANNEE_CLOSE=0 
                  AND MAT_ID=CONTROLE_MAT_ID AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND FORM_ID=SEM_FORM_ID
                  AND CONTROLE_ID=NOTES_CONTROLE_ID
                GROUP BY CONTROLE_ID
                ORDER BY CONTROLE_NOM,FORM_NOM,FORM_ID,MAT_NOM,MAT_ID";
        return self::getRequete($req);
    }

    public static function getControlesDeChaqueEnseignantDeLaMatiere(int $matiere_courante, int $annee_courante, bool $acces_chef) : array {
        $req = "SELECT * FROM (common_enseignants_matieres,common_enseignant)
                LEFT JOIN common_controle ON (CONTROLE_MAT_ID=$matiere_courante AND CONTROLE_ANNEE_ID=$annee_courante AND CONTROLE_ENS_ID=ENS_ID AND CONTROLE_VALIDE=1)
                WHERE ENS_MAT_ID = $matiere_courante 
                  AND ENS_MAT_ANNEE_ID = $annee_courante
                  AND ENS_ID=MAT_ENS_ID
                ORDER BY ENS_NOM,ENS_ID,CONTROLE_ID
                ";

        $les_controles = self::getRequete($req);
        
        if (!$acces_chef) {
            return $les_controles;
        }

        $les_enseignants[] = -1;
        foreach ($les_controles as $un_controle) {
            if ($un_controle['CONTROLE_ENS_ID'] != "") {
                $les_enseignants[] = $un_controle['CONTROLE_ENS_ID'];
            }
        }
        if (count($les_enseignants) > 0) {
            $les_id_enseignants = implode(",",$les_enseignants);
        }

        $req = "SELECT * FROM common_controle,common_enseignant
                WHERE CONTROLE_MAT_ID=$matiere_courante AND CONTROLE_ANNEE_ID=$annee_courante AND CONTROLE_VALIDE = 1
                  AND CONTROLE_ENS_ID NOT IN ($les_id_enseignants)
                  AND ENS_ID=CONTROLE_ENS_ID";

        return array_merge($les_controles,self::getRequete($req));
    }

    public static function getNombresControlesValidesDansMatiere(int $matiere_courante, int $annee_courante) : int {
        $req = "SELECT * FROM common_controle WHERE CONTROLE_ANNEE_ID=$annee_courante AND CONTROLE_MAT_ID=$matiere_courante AND CONTROLE_VALIDE=1";
        return self::doRequete($req)->num_rows;
    }

    public static function getControle(int $controle_id, int $ens_id, int $mat_id) : array
    {
        $req = "SELECT *,
                       CASE CONTROLE_MOYENNE WHEN '1' THEN 'oui' WHEN '0' THEN 'non' ELSE 'sous forme de bonus' END AS COMPTE_MOYENNE,
                       IF(CONTROLE_VISIBLE='1','oui','non') AS VISIBLE,
                       ROUND(AVG(NOTES_VALEUR),2) AS MOYENNE
                FROM common_controle,common_notes
                WHERE CONTROLE_ID=$controle_id AND CONTROLE_ENS_ID=$ens_id AND CONTROLE_MAT_ID=$mat_id
                  AND CONTROLE_ID=NOTES_CONTROLE_ID";
        return self::getRequete($req);
    }

    public static function getGroupesEtNotesDuControle(int $controle_id, int $mat_id, int $ue_id, int $annee_id, int $form_id) : array
    {

        $req = "SELECT ET_NOM, ET_NUMERO,DISP_UE_ID,DISP_MAT_ID,NOTES_VALEUR, NOTES_ID, NOTES_CONTROLE_ID, GROUPE_ID, GROUPE_NOM
                    FROM etudiants_groupes 
                    LEFT JOIN common_dispense_matieres ON (DISP_MAT_ID=$mat_id AND ET_ID=common_dispense_matieres.DISP_ET_ID AND common_dispense_matieres.DISP_ANNEE_ID=$annee_id)
                    LEFT JOIN common_dispense_ue ON (DISP_UE_ID=$ue_id AND ET_ID=common_dispense_ue.DISP_ET_ID AND common_dispense_ue.DISP_ANNEE_ID=$annee_id)
                    LEFT JOIN common_notes ON (ET_ID=NOTES_ET_ID AND NOTES_CONTROLE_ID=$controle_id)            
                WHERE ET_GROUPE_ANNEE_ID=$annee_id AND GROUPE_FORM_ID=$form_id AND GROUPE_FEUILLE=1
                ORDER BY GROUPE_NOM, GROUPE_ID, ET_NOM
            ";

        return self::getRequete($req);
    }

    public static function validerControle(?int $controle_id, int $ens_id, ?int $annee_courante, bool $isVisible = true) : bool
    {
        if ($controle_id == null || $annee_courante == null) {
            return false;
        }
        $req = "UPDATE common_controle SET CONTROLE_VALIDE=1 WHERE CONTROLE_ID=$controle_id AND CONTROLE_ENS_ID=$ens_id";
        if (self::execRequeteAvecAffected($req) == 1) {
            if ($isVisible) {
                Notes::envoyerMail($annee_courante, $controle_id);
            }

            $req = "DELETE FROM common_notes WHERE NOTES_SPECIAL='ABJ'";
            self::execRequete($req);

            return true;
        }
        return false;
    }

    public static function supprimerControle(int $controle_id, int $mat_id, int $ens_id) : bool
    {
        $req = "DELETE FROM common_controle WHERE CONTROLE_ID=$controle_id AND CONTROLE_MAT_ID=$mat_id AND CONTROLE_ENS_ID=$ens_id";
        return self::execRequeteAvecAffected($req) === 1;
    }

    public static function setControleToBrouillon(int $mat_id, int $controle_id) : bool
    {
        $req = "UPDATE common_controle SET CONTROLE_VALIDE=0 WHERE CONTROLE_MAT_ID=$mat_id AND CONTROLE_ID=$controle_id";
        return self::execRequeteAvecAffected($req) === 1;
    }
}