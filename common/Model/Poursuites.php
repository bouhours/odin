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

class Poursuites extends Connectable
{
    private static string $selon = "MOYAN_VALEUR";
    private static int $desc = 1;

    public static function getMatieresDePoursuite(int $DEPT_ID, int $ANNEE_ID) : array  {
        $req = "SELECT * 
                    FROM common_poursuite_matiere
                        LEFT JOIN common_poursuite_matiere_composition ON (PMAT_ID=MAT_PMAT_ID)
                        LEFT JOIN common_matiere ON (MAT_ID=PMAT_MAT_ID)
                        LEFT JOIN common_enseignants_matieres ON (MAT_ID=ENS_MAT_ID)
                        LEFT JOIN common_enseignant ON (ENS_ID=MAT_ENS_ID)
                    WHERE PMAT_DEPT_ID=$DEPT_ID AND (ENS_MAT_ANNEE_ID=$ANNEE_ID OR ENS_MAT_ANNEE_ID IS NULL)
                    ORDER BY PMAT_NOM,PMAT_ID,MAT_NOM,MAT_ID,ENS_NOM,ENS_ID";
        $retour = array();
        $les_pmatieres = self::doRequete($req);
        while($une_pmatiere = $les_pmatieres->fetch_assoc()) {
            $req = "SELECT * from common_poursuite_avis WHERE AVIS_PMAT_ID=" . $une_pmatiere['PMAT_ID'];
            $supprimable = self::doRequete($req)->num_rows === 0;
            $req = "SELECT * from common_poursuite_niveau_matiere WHERE NIVEAU_PMAT_ID=" . $une_pmatiere['PMAT_ID'];
            $supprimable &= self::doRequete($req)->num_rows === 0;
            $une_pmatiere['NO_SUPPR'] = $supprimable;
            $retour[] = $une_pmatiere;
        }
        return $retour;
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        switch ($tag) {
            case "DEPT_POURSUITE_DFIN" :
            case "DEPT_POURSUITE_DDEB" :
                if (!(preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9]) ([01]\d|2[0-3])h([0-5]\d)$/", $valeur) === false && $valeur !== "")) {
                    if ($_POST['bfmw_orig_valeur'] === "") {
                        $req = "UPDATE common_departement SET " . $tag . "=NULL WHERE DEPT_ID=" . CURRENT_DEPT_ID;
                    } else {
                        $req = "UPDATE common_departement SET " . $tag . "=" . transformDateHeure($valeur) . " WHERE DEPT_ID=" . CURRENT_DEPT_ID;
                    }
                    return self::execRequete($req);
                }
                break;
            case "POURSUITE_PEUT_SAISIR" :
                $req = "UPDATE common_enseignants_matieres SET ENS_MAT_POURSUITE=$valeurnum WHERE ID=$wherenum";
                return self::execRequete($req);
            case "MODELE_AVIS" :
                $req = "UPDATE common_poursuite_avis_modele SET MODELE_AVIS='$valeur' WHERE MODELE_ID=$wherenum";
                return self::execRequete($req);
            case "MODELE_ORDRE" :
                $req = "UPDATE common_poursuite_avis_modele SET MODELE_ORDRE=$valeurnum WHERE MODELE_ID=$wherenum";
                return self::execRequete($req);
            case "CATEGORIE_NOM" :
                $req = "UPDATE common_poursuite_avis_categorie SET CATEGORIE_NOM='$valeur' WHERE CATEGORIE_ID=$wherenum";
                return self::execRequete($req);
            case "CATEGORIE_ORDRE" :
                $req = "UPDATE common_poursuite_avis_categorie SET CATEGORIE_ORDRE=$valeurnum WHERE CATEGORIE_ID=$wherenum";
                return self::execRequete($req);
            default :
                $req = "SELECT * FROM common_groupes,common_formation WHERE GROUPE_DELETED=0 AND FORM_ID=GROUPE_FORM_ID AND GROUPE_CODE LIKE '".$tag."%' AND GROUPE_ID=".$wherenum." AND FORM_DEPT_ID=".CURRENT_DEPT_ID;
                if (self::doRequete($req)->num_rows > 0) {
                    $req = "UPDATE common_groupes SET GROUPE_POURSUITE=" . $_POST['bfmw_num_valeur'] . " WHERE GROUPE_CODE LIKE '".$_POST['bfmw_orig_tag']."%'";
                    return self::execRequete($req);
                }
        }
        return false;
    }

    public static function getAvisModele(int $dept_id) : array
    {
        $req = "SELECT * FROM common_poursuite_avis_modele WHERE MODELE_DEPT_ID=$dept_id ORDER BY MODELE_ORDRE";
        return self::getRequete($req);
    }

    public static function supprimerAvis(int $modele_id, int $dept_id) : bool
    {
        $req = "DELETE FROM common_poursuite_avis_modele WHERE MODELE_ID=$modele_id AND MODELE_DEPT_ID=$dept_id";
        return self::execRequete($req);
    }

    public static function getCategorie(int $dept_id,?int $selecteur = null) : array
    {
        $req = "SELECT *,IF(CATEGORIE_ID='$selecteur','class=\'active\'','') AS ACTIVE_JURY FROM common_poursuite_avis_categorie WHERE CATEGORIE_DEPT_ID=$dept_id ORDER BY CATEGORIE_ORDRE";
        return self::getRequete($req);
    }

    public static function supprimerCategorie(int $categorie_id, int $dept_id) : bool
    {
        $req = "DELETE FROM common_poursuite_avis_categorie WHERE CATEGORIE_ID=$categorie_id AND CATEGORIE_DEPT_ID=$dept_id";
        return self::execRequete($req);
    }

    public static function getEtudiantsDuGroupe(int $annee_courante, string $groupe_code, string $categorie) : array
    {
        $req = "SELECT ET_ID, ET_NOM, ET_NOM_DE_FAMILLE, ET_PRENOM, ET_NUMERO, ET_TIERS, ET_RED, ET_BAC,GROUPE_ID, GROUPE_NOM, ET_PROFESSIONNALISATION, POURSUITE_APPRECIATION_G, POURSUITE_AVIS, POURSUITE_CATEGORIE
                    FROM common_etudiant
                        JOIN common_etudiant_groupes ON (ET_ID = GROUPE_ET_ID)
                        JOIN common_groupes ON (GROUPE_CODE = ET_GROUPE_CODE)
                        LEFT JOIN common_poursuite_etudiants ON (ET_ID=POURSUITE_ET_ID AND POURSUITE_CATEGORIE='$categorie')
                    WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND ET_GROUPE_CODE LIKE '$groupe_code%'
                    ORDER BY ET_NOM
                    ";
        return self::getRequeteAvecClef("ET_ID",$req);
    }

    public static function deposerAvis(int $et_id, int $annee_courante, string $avis, int $categ_id, int $dept_id) : bool
    {
        $categorie = self::getCategorieById($categ_id,$dept_id)[0]["CATEGORIE_NOM"];
        $req = "INSERT INTO common_poursuite_etudiants (POURSUITE_ET_ID,POURSUITE_AVIS, POURSUITE_ANNEE_ID, POURSUITE_CATEGORIE) VALUES ($et_id,'$avis',$annee_courante,'$categorie') ON DUPLICATE KEY UPDATE POURSUITE_AVIS='$avis',POURSUITE_CATEGORIE='$categorie'";
        return self::execRequete($req);
    }

    public static function getAvisEtudiant(int $et_id, int $annee_courante) : array
    {
        $req = "SELECT * FROM common_poursuite_etudiants WHERE POURSUITE_ET_ID=$et_id AND POURSUITE_ANNEE_ID=$annee_courante";
        return self::getRequete($req);
    }

    public static function getLesAvisDesEtudiants(int $annee_courante,string $les_etudiants, string $categorie, int $dept_id)
    {
        $req = "SELECT CONCAT(POURSUITE_ET_ID,'¤',POURSUITE_AVIS,'¤',IFNULL(POURSUITE_APPRECIATION_G,''),'¤**¤') AS AVIS_COMPLET,
                    POURSUITE_ET_ID,POURSUITE_AVIS,POURSUITE_APPRECIATION_G
                 FROM common_poursuite_avis_modele
                    LEFT JOIN common_poursuite_etudiants ON (POURSUITE_ET_ID IN ($les_etudiants) AND MODELE_AVIS=POURSUITE_AVIS AND POURSUITE_ANNEE_ID=$annee_courante AND POURSUITE_CATEGORIE='$categorie')               
                WHERE  MODELE_DEPT_ID=$dept_id";

        return self::getRequete($req);
    }

    public static function getNombreAvisDesEtudiants(int $annee_courante,string $les_etudiants, string $categorie, int $dept_id)
    {
        $req = "SELECT CONCAT('<span class=\'vert\'>',SUM(IF(POURSUITE_AVIS IS NOT NULL,1,0)),'</span>&nbsp;<span>',MODELE_AVIS,'</span><br/>') AS NOMBRE_TOTAL,
                    SUM(IF(POURSUITE_AVIS IS NOT NULL,1,0)) AS TOTAL_AVIS,MODELE_AVIS
                FROM common_poursuite_avis_modele
                    LEFT JOIN common_poursuite_etudiants ON (POURSUITE_ET_ID IN ($les_etudiants) AND MODELE_AVIS=POURSUITE_AVIS AND POURSUITE_ANNEE_ID=$annee_courante AND POURSUITE_CATEGORIE='$categorie')               
                WHERE  MODELE_DEPT_ID=$dept_id
                GROUP BY MODELE_AVIS
                ORDER BY MODELE_ORDRE";
        return self::getRequete($req);
    }

    public static function getFiche(int $annee_courante, int $etudiant_courant, int $CURRENT_DEPT_ID, int $annee_en_arriere = 2) : array
    {
        $req ="SELECT PMAT_ID,PMAT_NOM, PMAT_MODE, PMAT_ENS_ID, PMAT_PERSO,NIVEAU,AVIS_NIVEAU,AVIS_APPRECIATION, AVIS_ENS_ID,ENS_NOM
            FROM common_poursuite_matiere
            LEFT JOIN common_poursuite_niveau_matiere ON (PMAT_ID=NIVEAU_PMAT_ID AND NIVEAU_ANNEE_ID=$annee_courante)
            JOIN common_poursuite_matiere_composition ON (PMAT_ID=MAT_PMAT_ID)
            JOIN common_enseignants_matieres ON (ENS_MAT_ID=PMAT_MAT_ID AND ENS_MAT_ANNEE_ID BETWEEN NIVEAU_ANNEE_ID-$annee_en_arriere AND NIVEAU_ANNEE_ID)
            JOIN common_enseignant ON (ENS_ID=MAT_ENS_ID)
            LEFT JOIN common_poursuite_avis ON (PMAT_ID=AVIS_PMAT_ID AND AVIS_ET_ID=$etudiant_courant AND AVIS_ANNEE_ID=NIVEAU_ANNEE_ID)
            WHERE PMAT_DEPT_ID=$CURRENT_DEPT_ID
            GROUP BY ENS_ID
            ORDER BY PMAT_NOM, PMAT_ID, ENS_NOM, ENS_ID
        ";
        return self::getRequete($req);
    }

    public static function getCategorieById(mixed $categorie, mixed $dept_id) : array
    {
        $req = "SELECT * from common_poursuite_avis_categorie WHERE CATEGORIE_ID=$categorie AND CATEGORIE_DEPT_ID=$dept_id";
        return self::getRequete("$req");

    }

    public static function extractEtudiants(int $annee_courante, int $groupe_id = -1) : array
    {
        if ($groupe_id == -1) {
            $les_groupes = Groupes::getGroupesDePoursuite(CURRENT_DEPT_ID);
        } else {
            $les_groupes = Groupes::getGroupe($groupe_id);
        }
        $lesEtudiantsConcernes = [];
        foreach ($les_groupes as $un_groupe) {
            $les_categories = Poursuites::getCategorie(CURRENT_DEPT_ID);
            foreach ($les_categories as $une_categorie) {
                $les_etudiants = Poursuites::getEtudiantsDuGroupe($annee_courante, $un_groupe['GROUPE_CODE'], $une_categorie['CATEGORIE_NOM']);
                if (count($les_etudiants) == 0) {
                    continue;
                }
                $les_moyennes = Moyennes::getMoyennesDesSemestresTouteAnnee(implode(",", array_keys($les_etudiants)), CURRENT_DEPT);
                foreach ($les_moyennes as $une_moyenne) {
                    $les_etudiants[$une_moyenne['ET_ID']]["MOYAN_VALEUR"] = $une_moyenne['MOYAN_VALEUR'];
                }
                if (isset($_POST['bfmw_orig_moyenne'])) {
                    uasort($les_etudiants, self::trierSelon(...));
                }

                $lesEtudiantsConcernes[$un_groupe['GROUPE_NOM']][$une_categorie['CATEGORIE_NOM']] = $les_etudiants;
                $totaux = Poursuites::getNombreAvisDesEtudiants($annee_courante, implode(",",array_keys($les_etudiants)), $une_categorie['CATEGORIE_NOM'], CURRENT_DEPT_ID);
                $lesEtudiantsConcernes[$un_groupe['GROUPE_NOM']][$une_categorie['CATEGORIE_NOM']][-1] = [];
                foreach ($totaux as $un_total) {
                    $lesEtudiantsConcernes[$un_groupe['GROUPE_NOM']][$une_categorie['CATEGORIE_NOM']][-1][$un_total['MODELE_AVIS']] = $un_total['TOTAL_AVIS'];

                }
            }
        }

        return $lesEtudiantsConcernes;
    }

    private static function trierSelon($elem1,$elem2) : int
    {

        if (!isset($elem1[self::$selon]) && isset($elem2[self::$selon])) {
            return 1*self::$desc;
        }

        if (isset($elem1[self::$selon]) && !isset($elem2[self::$selon])) {
            return -1*self::$desc;
        }

        if (!isset($elem1[self::$selon]) && !isset($elem2[self::$selon])) {
            return 0;
        }

        if (is_float($elem1[self::$selon])) {
            if (floatval($elem1[self::$selon]) == floatval($elem2[self::$selon])) {
                return 0;
            }

            return ((floatval($elem1[self::$selon]) > floatval($elem2[self::$selon])) ? -1 : 1)*self::$desc;
        } else {
            if (($elem1[self::$selon]) == ($elem2[self::$selon])) {
                return 0;
            }

            return ((($elem1[self::$selon]) > ($elem2[self::$selon])) ? -1 : 1)*self::$desc;
        }
    }

}