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

class Notation_Soutenances extends Connectable
{
    public static function creerSession(array $data) : int {
        return createData("common_soutenances_session",$data,3);
    }

    public static function creerDestination(array $data) : int {
        return createData("common_soutenances_destination",$data,4);
    }

    public static function creerSection(array $data) : int {
        return createData("common_soutenances_section",$data,2);
    }

    public static function creerNiveau(array $data) : int {
        return createData("common_soutenances_niveau",$data,4);
    }

    public static function creerCritere(array $data) : int {
        return createData("common_soutenances_critere",$data,2);
    }

    public static function creerExplication(array $data) : int {
        return createData("common_soutenances_explications",$data,3);
    }

    public static function creerGroupe(array $data) : int {
        return createData("common_soutenances_groupes",$data,4);
    }

    public static function ajouterEtudiantDansGroupe(array $data) : int {
        return createData("common_soutenances_groupes_etudiants",$data,2);
    }

    public static function supprimerSession(int $SESSION_ID) : bool {
        $req = "DELETE FROM common_soutenances_session WHERE SESSION_ID=$SESSION_ID";
        return self::execRequete($req);
    }

    public static function supprimerDestination(int $DESTINATION_ID) : bool {
        $req = "DELETE FROM common_soutenances_destination WHERE DEST_ID=$DESTINATION_ID";
        return self::execRequete($req);
    }

    public static function supprimerSection(int $SECTION_ID) : bool {
        $req = "DELETE FROM common_soutenances_section WHERE SECTION_ID=$SECTION_ID";
        return self::execRequete($req);
    }

    public static function supprimerNiveau(int $NIVEAU_ID) : bool {
        $req = "DELETE FROM common_soutenances_niveau WHERE NIVEAU_ID=$NIVEAU_ID";
        return self::execRequete($req);
    }

    public static function supprimerCritere(int $CRITERE) : bool {
        $req = "DELETE FROM common_soutenances_critere WHERE CRITERE_ID=$CRITERE";
        return self::execRequete($req);
    }

    public static function supprimerExplication(int $CRITERE,int $NIVEAU) : bool {
        $req = "DELETE FROM common_soutenances_explications WHERE EXPLICATION_NIVEAU_ID=$NIVEAU AND EXPLICATION_CRITERE_ID=$CRITERE";
        return self::execRequete($req);
    }


    public static function supprimerGroupes(int $GROUPE) : bool {
        $req = "DELETE FROM common_soutenances_groupes WHERE GROUPE_ID=$GROUPE";
        return self::execRequete($req);
    }

    public static function supprimerEtudiantDunGroupe(int $et_id, int $groupe_id) : bool
    {
        $req = "DELETE FROM common_soutenances_groupes_etudiants WHERE GROUPE_ET_ID=$et_id AND ET_GROUPE_ID=$groupe_id";
        return self::execRequete($req);
    }

    public static function supprimerNotesDunEnseignant(int $ET_ID, int $ENS_ID, int $annee_courante, int $session_id) : bool {
        $req = "DELETE FROM common_soutenances_etudiants WHERE SOUT_ENS_ID=$ENS_ID AND SOUT_ET_ID=$ET_ID AND SOUT_ANNEE_ID=$annee_courante AND SOUT_CLOT=0 AND SOUT_SESSION_ID=$session_id";
        return self::execRequete($req);
    }

    public static function supprimerNotesDunEnseignantSurUnGroupe(int $GROUPE_ID, int $ENS_ID, int $annee_courante, int $session_id) : bool {
        $req = "DELETE FROM common_soutenances_etudiants WHERE SOUT_ENS_ID=$ENS_ID AND SOUT_ET_ID IN (SELECT GROUPE_ET_ID FROM common_soutenances_groupes_etudiants WHERE ET_GROUPE_ID=$GROUPE_ID) AND SOUT_ANNEE_ID=$annee_courante AND SOUT_CLOT=0 AND SOUT_SESSION_ID=$session_id";
        return self::execRequete($req);
    }

    public static function getUneSession(int $session_id) : array {
        $req = "SELECT * FROM common_soutenances_session WHERE SESSION_ID=$session_id";
        return self::getRequete($req);
    }

    public static function getSession(int $annee_courante,?int $FORM_ID, string $FORM_ID_STRING = "",string $complement = "") : array {
        $req = "SELECT *,
                DATE_FORMAT(FROM_UNIXTIME(SESSION_START),'%d/%m/%Y %Hh%i') AS SESSION_START_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(SESSION_END),'%d/%m/%Y %Hh%i') AS SESSION_END_AFFICHAGE,
                DATE_FORMAT(FROM_UNIXTIME(SESSION_HARMONISATION_START),'%d/%m/%Y %Hh%i') AS SESSION_HARMONISATION_START_AFFICHAGE,DATE_FORMAT(FROM_UNIXTIME(SESSION_HARMONISATION_END),'%d/%m/%Y %Hh%i') AS SESSION_HARMONISATION_END_AFFICHAGE
                FROM common_soutenances_session
                WHERE $complement SESSION_ANNEE_ID=$annee_courante AND ".($FORM_ID_STRING===""?"SESSION_FORM_ID=$FORM_ID":"SESSION_FORM_ID IN ($FORM_ID_STRING)").
                " ORDER BY SESSION_CONTENU";
        return self::getRequeteAvecClef("SESSION_ID",$req);
    }

    public static function getSessionVide(int $FORM_ID,int $annee_courante) : array {
        $req = "SELECT * FROM common_soutenances_session WHERE SESSION_ANNEE_ID=$annee_courante AND SESSION_FORM_ID=$FORM_ID AND SESSION_ID NOT IN (SELECT DEST_SESSION_ID FROM common_soutenances_destination WHERE DEST_FORM_ID=$FORM_ID) ORDER BY SESSION_CONTENU";
        return self::getRequeteAvecClef("SESSION_ID",$req);
    }

    public static function getSessionPasVideDuDepartement(int $DEPT_ID, int $annee_courante) : array {
        $req = "SELECT * FROM common_soutenances_session,common_formation,common_annee WHERE ANNEE_ID=SESSION_ANNEE_ID AND (SESSION_ANNEE_ID=$annee_courante OR SESSION_ANNEE_ID=$annee_courante-1) AND FORM_DEPT_ID=$DEPT_ID AND FORM_ID=SESSION_FORM_ID AND SESSION_ID IN (SELECT DEST_SESSION_ID FROM common_soutenances_destination WHERE DEST_FORM_ID=FORM_ID) ORDER BY FORM_NOM,FORM_ID,ANNEE_ID,SESSION_CONTENU";
        return self::getRequeteAvecClef("SESSION_ID",$req);
    }

    public static function getDestination(int $FORM_ID, int $annee_courante, string $complement = "") : array {
        $req = "SELECT * FROM common_soutenances_destination,common_soutenances_session WHERE $complement SESSION_ANNEE_ID=$annee_courante AND SESSION_ID=DEST_SESSION_ID AND DEST_FORM_ID=$FORM_ID ORDER BY SESSION_CONTENU,SESSION_ID,DEST_CONTENU,DEST_ID";
        return self::getRequeteAvecClef("DEST_ID",$req);
    }

    public static function getSection(int $FORM_ID, int $annee_courante) : array {
        $req = "SELECT * FROM common_soutenances_section,common_soutenances_destination,common_soutenances_session WHERE SESSION_ANNEE_ID=$annee_courante AND SESSION_ID=DEST_SESSION_ID AND DEST_ID=SECTION_DEST_ID AND DEST_FORM_ID=$FORM_ID ORDER BY SESSION_CONTENU,SESSION_ID,DEST_CONTENU,DEST_ID,SECTION_CONTENU,SECTION_ID";
        return self::getRequete($req);
    }

    public static function getNiveau(int $FORM_ID, int $annee_courante) : array {
        $req = "SELECT * FROM common_soutenances_niveau,common_soutenances_destination,common_soutenances_session WHERE SESSION_ANNEE_ID=$annee_courante AND SESSION_ID=DEST_SESSION_ID AND DEST_ID=NIVEAU_DEST_ID AND NIVEAU_FORM_ID=DEST_FORM_ID AND NIVEAU_FORM_ID=$FORM_ID ORDER BY SESSION_CONTENU,SESSION_ID,DEST_CONTENU,DEST_ID,NIVEAU_POIDS,NIVEAU_ID";
        return self::getRequete($req);
    }

    public static function getCriteres(int $FORM_ID,int $annee_courante) : array {
        $req = "SELECT * FROM common_soutenances_critere,common_soutenances_section,common_soutenances_destination,common_soutenances_session WHERE SESSION_ANNEE_ID=$annee_courante AND SESSION_ID=DEST_SESSION_ID AND DEST_ID=SECTION_DEST_ID AND SECTION_ID=CRITERE_SECTION_ID AND DEST_FORM_ID=$FORM_ID ORDER BY SESSION_CONTENU,SESSION_ID,DEST_CONTENU,DEST_ID,SECTION_CONTENU,SECTION_ID,CRITERE_CONTENU,CRITERE_ID";
        return self::getRequete($req);
    }

    public static function getExplications(int $FORM_ID, int $annee_courante) : array {
        $req = "SELECT * FROM common_soutenances_explications,common_soutenances_critere,common_soutenances_niveau,common_soutenances_destination,common_soutenances_session WHERE SESSION_ANNEE_ID=$annee_courante AND SESSION_ID=DEST_SESSION_ID AND DEST_ID=NIVEAU_DEST_ID AND NIVEAU_FORM_ID=DEST_FORM_ID AND CRITERE_ID=EXPLICATION_CRITERE_ID AND NIVEAU_ID=EXPLICATION_NIVEAU_ID AND NIVEAU_FORM_ID=$FORM_ID ORDER BY SESSION_CONTENU,SESSION_ID,DEST_CONTENU,DEST_ID,CRITERE_CONTENU,CRITERE_ID,NIVEAU_POIDS,NIVEAU_ID,EXPLICATION_CONTENU";
        return self::getRequete($req);
    }

    public static function getGroupes(int $annee_courante,int $session_id) : array {
        $req = "SELECT *
                FROM common_soutenances_groupes
                         LEFT JOIN common_soutenances_groupes_etudiants ON (GROUPE_ID = ET_GROUPE_ID)
                         LEFT JOIN common_etudiant ON (ET_ID = GROUPE_ET_ID)
                WHERE GROUPE_SESSION_ID = $session_id
                  AND GROUPE_ANNEE_ID = $annee_courante
                ORDER BY GROUPE_NOM, GROUPE_ID, ET_NOM, ET_ID";

        return self::getRequete($req);
    }

    public static function getEtudiantsDeLaFormationAvecInformationGroupeSoutenance(int $annee_courante,int $groupe_id, int $formation_id, int $session_id) : array {
        $req = "SELECT ET_ID, ET_NOM, IF(t1.COUPLE_ID IS NULL, '', 'checked') AS ET_SELECTED
                FROM common_etudiant
                         JOIN common_inscription ON (INSCRIPT_ANNEE_ID = $annee_courante AND INSCRIPT_ET_ID = ET_ID)
                         JOIN common_semestre ON (SEM_FORM_ID = $formation_id AND INSCRIPT_SEM_ID = SEM_ID)
                         LEFT JOIN common_soutenances_groupes_etudiants t1
                                   ON (ET_GROUPE_ID = $groupe_id AND ET_ID = t1.GROUPE_ET_ID)
                WHERE ET_DEM = 0
                  AND ET_ID NOT IN
                      (SELECT t3.GROUPE_ET_ID
                       FROM common_soutenances_groupes t2
                                JOIN common_soutenances_groupes_etudiants t3 ON (t3.ET_GROUPE_ID = t2.GROUPE_ID)
                       WHERE t2.GROUPE_FORM_ID = $formation_id
                         AND t2.GROUPE_ANNEE_ID = $annee_courante
                         AND t2.GROUPE_SESSION_ID=$session_id
                         AND t2.GROUPE_ID != $groupe_id)
                GROUP BY ET_ID
                ORDER BY ET_NOM";
        return self::getRequete($req);
    }

    public static function getGroupesAvecNote(int $annee_courante,int $session_id) : array {
        $req = "SELECT * FROM common_soutenances_groupes LEFT JOIN common_soutenances_groupes_etudiants ON (GROUPE_ID=ET_GROUPE_ID) LEFT JOIN common_etudiant ON (ET_ID=GROUPE_ET_ID AND ET_DEM=0) LEFT JOIN common_soutenances_etudiants ON (ET_ID = SOUT_ET_ID AND SOUT_CLOT=0 AND SOUT_SESSION_ID=$session_id AND SOUT_ANNEE_ID=$annee_courante) WHERE GROUPE_SESSION_ID=$session_id AND GROUPE_ANNEE_ID=$annee_courante AND SOUT_ET_ID IS NOT NULL GROUP BY ET_ID ORDER BY GROUPE_NOM,GROUPE_ID,ET_NOM,ET_ID";
        return self::getRequete($req);
    }

    public static function getEnseignantAyantMisUneNote(int $ET_ID, int $annee_courante, int $session_id) : array {
        $req = "SELECT * FROM common_enseignant,common_soutenances_etudiants WHERE SOUT_SESSION_ID=$session_id AND ENS_ID=SOUT_ENS_ID AND SOUT_ANNEE_ID=$annee_courante AND SOUT_ET_ID=$ET_ID AND SOUT_CLOT=0 GROUP BY ENS_ID ORDER BY ENS_NOM";
        return self::getRequete($req);
    }

    public static function isEnseignantAMisUneNote(int $ens_id, int $dept_id,string $annee_courante="SOUT_ANNEE_ID") : bool {
        $req = "
                SELECT *
                FROM common_soutenances_etudiants
                         JOIN common_soutenances_session ON (SESSION_ID = SOUT_SESSION_ID)
                         JOIN common_formation ON (FORM_ID = SESSION_FORM_ID)
                WHERE FORM_DEPT_ID = $dept_id
                  AND SOUT_ENS_ID = $ens_id
                  AND SOUT_ANNEE_ID = $annee_courante
                  AND SOUT_CLOT = 1";

        return self::doRequete($req)->num_rows > 0;
    }

    public static function getEtudiantsAyantUneNote(int $annee_courante, int $session_id, int $formation_id) : array {
        $req = "SELECT * FROM common_etudiant,common_inscription,common_semestre,common_soutenances_etudiants WHERE ET_ID=SOUT_ET_ID AND SOUT_ANNEE_ID=$annee_courante AND SOUT_SESSION_ID=$session_id AND SEM_FORM_ID=$formation_id AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID AND ET_DEM=0 AND SOUT_CLOT=0 AND INSCRIPT_ANNEE_ID=$annee_courante GROUP BY ET_ID ORDER BY ET_NOM";
        return self::getRequete($req);
    }

    public static function getEtudiantsAyantEuUneNote(int $annee_courante, int $session_id, int $formation_id, int $ens_id) : array {
        $req = "SELECT * FROM common_etudiant,common_inscription,common_semestre,common_soutenances_etudiants WHERE ET_ID=SOUT_ET_ID AND SOUT_ANNEE_ID=$annee_courante AND SOUT_SESSION_ID=$session_id AND SEM_FORM_ID=$formation_id AND SEM_ID=INSCRIPT_SEM_ID AND ET_ID=INSCRIPT_ET_ID AND ET_DEM=0 AND SOUT_CLOT=1 AND SOUT_ENS_ID=$ens_id AND INSCRIPT_ANNEE_ID=$annee_courante GROUP BY ET_ID ORDER BY ET_NOM";
        return self::getRequeteAvecClef("ET_ID",$req);
    }

    public static function getEtudiantValorise(int $ET_ID, int $FORM_ID, int $annee_courante, string $les_enseignants_id, int $session_id) : array {
        $req = "SELECT DEST_ID,DEST_CONTENU,SECTION_ID, SECTION_CONTENU, CRITERE_ID, CRITERE_CONTENU, ENS_ID, ENS_NOM, NIVEAU_ID, NIVEAU_CONTENU, SOUT_NIVEAU_NUMERIQUE, NIVEAU_NUMERIQUE
                    FROM (common_soutenances_destination,common_soutenances_section,common_soutenances_critere,common_enseignant)
                    LEFT JOIN common_soutenances_etudiants ON (SOUT_ET_ID=$ET_ID AND CRITERE_ID=SOUT_CRITERE_ID AND SOUT_CLOT=0 AND SOUT_SESSION_ID=$session_id AND SOUT_ANNEE_ID=$annee_courante AND ENS_ID=SOUT_ENS_ID)
                    LEFT JOIN common_soutenances_niveau ON (NIVEAU_ID=SOUT_NIVEAU_ID AND DEST_ID=NIVEAU_DEST_ID)
                    WHERE DEST_ID=SECTION_DEST_ID AND
                          SECTION_ID=CRITERE_SECTION_ID AND
                          DEST_FORM_ID = $FORM_ID AND
                          ENS_ID IN ($les_enseignants_id) AND
                          DEST_SESSION_ID = $session_id
                    ORDER BY DEST_CONTENU,DEST_ID,SECTION_CONTENU, SECTION_ID, CRITERE_CONTENU,CRITERE_ID,ENS_NOM,ENS_ID                
        ";
        return self::getRequete($req);
    }

    public static function getEtudiantsValorises(int $FORM_ID,int $annee_courante, bool $with_groupe, int $session_id, ?array &$les_destination) : array {
        $les_id = array_keys(Etudiants::getEtudiantsInscrits($FORM_ID,$annee_courante));
        $les_id_string = implode(",",$les_id);
        $req = "SELECT ET_ID, ET_NOM, ET_DEM, ET_NUMERO, DEST_COEF,  DEST_ID, SOUT_ENS_ID, 
                SUM(IF(NIVEAU_MAX IS NOT NULL AND NIVEAU_NUMERIQUE = 0,NIVEAU_POIDS,IF (NIVEAU_NUMERIQUE = 1,SOUT_NIVEAU_NUMERIQUE,0))) AS NOTE_AFFICHAGE,
                SUM(NIVEAU_MAX) AS QUOTIENT_AFFICHAGE, 
                SUM(IF((NIVEAU_MAX IS NULL AND NIVEAU_NUMERIQUE != 1 AND NIVEAU_POIDS != 0),NIVEAU_POIDS,NULL)) AS MALUS,
                 DEST_CONTENU".
                ($with_groupe?", GROUPE_ID, GROUPE_NOM ":" ")
                ."FROM
                (common_etudiant,common_soutenances_destination,common_soutenances_section,common_soutenances_critere)
                LEFT JOIN common_soutenances_etudiants ON (ET_ID=SOUT_ET_ID AND CRITERE_ID=SOUT_CRITERE_ID AND SOUT_CLOT=0 AND SOUT_ANNEE_ID=$annee_courante AND SOUT_SESSION_ID=$session_id)
                LEFT JOIN common_soutenances_niveau ON (NIVEAU_ID=SOUT_NIVEAU_ID AND DEST_ID=NIVEAU_DEST_ID)
                ".($with_groupe?"
                LEFT JOIN common_soutenances_groupes_etudiants ON (ET_ID = GROUPE_ET_ID)
                LEFT JOIN common_soutenances_groupes ON (GROUPE_ID = ET_GROUPE_ID AND GROUPE_SESSION_ID=$session_id) ":" ")
                ."WHERE
                      ET_ID IN ($les_id_string) AND
                      ET_DEM = 0 AND
                      DEST_ID=SECTION_DEST_ID AND
                      DEST_FORM_ID = $FORM_ID AND
                      DEST_SESSION_ID = $session_id AND 
                      SECTION_ID=CRITERE_SECTION_ID".
                      ($with_groupe?" AND GROUPE_ID IS NOT NULL ":" ")
                      ."
                GROUP BY ET_ID,DEST_ID, SOUT_ENS_ID
                ORDER BY ".
                ($with_groupe?"GROUPE_NOM,GROUPE_ID,":"")
                ."ET_NOM,ET_ID,DEST_CONTENU,DEST_ID";

        $premier_retour = self::getRequete($req);
        $retour = array();

        //Agrégation des notes pas enseignant (impossible de le faire dans la requête, car l'agrégation des malus dépend du nombre d'enseignants qui ont noté
        $destination_courante = -1;
        $enseignant_courant = -1;
        $etudiant_courant = -1;
        $indexeur = 0;
        foreach ($premier_retour as $une_ligne) {

            if ($etudiant_courant != $une_ligne["ET_ID"] || $destination_courante != $une_ligne['DEST_ID']) {
                $etudiant_courant = $une_ligne['ET_ID'];
                $destination_courante = $une_ligne['DEST_ID'];
                $retour[$indexeur++] = $une_ligne;
                $enseignant_courant = $une_ligne['SOUT_ENS_ID'];
                $retour[$indexeur-1]["TOUS_LES_MALUS"][] = $une_ligne['MALUS'];
            }

            if ( $une_ligne['SOUT_ENS_ID'] != "" && $enseignant_courant != $une_ligne['SOUT_ENS_ID']) {
                $enseignant_courant = $une_ligne['SOUT_ENS_ID'];
                $retour[$indexeur-1]["NOTE_AFFICHAGE"] += $une_ligne['NOTE_AFFICHAGE'];
                $retour[$indexeur-1]["QUOTIENT_AFFICHAGE"] += $une_ligne['QUOTIENT_AFFICHAGE'];
                $retour[$indexeur-1]["TOUS_LES_MALUS"][] = $une_ligne['MALUS'];
            }
        }

        //Finalisation des calculs
        $etudiant_courant = -1;
        $note_finale = array();
        $coef_final = array();
        $moyenne_destination = array();
        $nombre_note_destination = array();
        foreach ($retour as &$une_ligne) {
            $une_ligne['MALUS'] = round((array_sum($une_ligne["TOUS_LES_MALUS"]) / count($une_ligne["TOUS_LES_MALUS"])) ,2);
            $note_bornee = max(min(($une_ligne['NOTE_AFFICHAGE']*20/($une_ligne['QUOTIENT_AFFICHAGE']==0?1:$une_ligne['QUOTIENT_AFFICHAGE']))+$une_ligne['MALUS'],20),0);

            if ($etudiant_courant != $une_ligne['ET_ID']) {
                $note_finale[$une_ligne['ET_ID']] = 0;
                $coef_final[$une_ligne['ET_ID']] = 0;
                $etudiant_courant = $une_ligne['ET_ID'];
            }

            if ($une_ligne['QUOTIENT_AFFICHAGE']>0) {
                if (isset($moyenne_destination[$une_ligne['DEST_ID']])) {
                    $nombre_note_destination[$une_ligne['DEST_ID']]++;
                } else {
                    $nombre_note_destination[$une_ligne['DEST_ID']] = 1;
                };
                $moyenne_destination[$une_ligne['DEST_ID']][] = $note_bornee;
            }

            $note_finale[$une_ligne['ET_ID']] += $note_bornee*$une_ligne['DEST_COEF'];
            $coef_final[$une_ligne['ET_ID']] += (($une_ligne['QUOTIENT_AFFICHAGE']>0)?$une_ligne['DEST_COEF']:0);
            $une_ligne['NOTE_AFFICHAGE'] = round($une_ligne['NOTE_AFFICHAGE'],2);
            $une_ligne['QUOTIENT_AFFICHAGE'] = round($une_ligne['QUOTIENT_AFFICHAGE'],2);
            $une_ligne['NOTE'] = round($note_bornee,2);
        }

        //Moyennage
        $moyenne_generale = 0;
        $nombre_notes = 0;
        $les_moyennes = array();
        foreach ($retour as &$un_final) {
            $un_final['NOTE_FINALE'] = round($note_finale[$un_final['ET_ID']]/($coef_final[$un_final['ET_ID']]==0?1:$coef_final[$un_final['ET_ID']]),2);
            $un_final['COEF_FINAL'] = $coef_final[$un_final['ET_ID']];
            $moyenne_generale += $un_final['NOTE_FINALE'];
            if ($un_final['COEF_FINAL'] > 0) {
                $les_moyennes[] = $un_final['NOTE_FINALE'];
                $nombre_notes++;
            }
        }

        //Calcul des moyennes
        foreach ($retour as &$un_final) {
            $un_final['MOYENNE_GENERALE'] = ($nombre_notes>0?round($moyenne_generale / $nombre_notes, 2):"");
            $un_final['MOYENNE_MAXIMUM'] = ($nombre_notes>0?round(max($les_moyennes),2):"");
            $un_final['MOYENNE_MINIMUM'] = ($nombre_notes>0?round(min($les_moyennes),2):"");
            if (isset($moyenne_destination[$un_final['DEST_ID']])) {
                if ($les_destination != null) {
                    $les_destination[$un_final['DEST_ID']]['MOYENNE_GENERALE'] = round(array_sum($moyenne_destination[$un_final['DEST_ID']]) / $nombre_note_destination[$un_final['DEST_ID']], 2);
                    $les_destination[$un_final['DEST_ID']]['MOYENNE_MAXIMUM'] = round(max($moyenne_destination[$un_final['DEST_ID']]), 2);
                    $les_destination[$un_final['DEST_ID']]['MOYENNE_MINIMUM'] = round(min($moyenne_destination[$un_final['DEST_ID']]), 2);
                }
            } else {
                $les_destination[$un_final['DEST_ID']]['MOYENNE_GENERALE'] = "";
                $les_destination[$un_final['DEST_ID']]['MOYENNE_MAXIMUM'] = "";
                $les_destination[$un_final['DEST_ID']]['MOYENNE_MINIMUM'] = "";
            }
        }

        return $retour;
    }

    public static function getGroupe(int $GROUPE_ID) : array {
        $req = "SELECT * FROM common_soutenances_groupes WHERE GROUPE_ID = $GROUPE_ID";
        return self::doRequete($req)->fetch_assoc();
    }

    public static function getEtudiantsDuGroupe(int $GROUPE_ID) : array {
        $req = "SELECT * FROM common_soutenances_groupes_etudiants,common_etudiant WHERE ET_ID=GROUPE_ET_ID AND ET_GROUPE_ID = $GROUPE_ID";
        return self::getRequete($req);
    }

    public static function getGrille(int $FORM_ID, int $session_id) : array {
        $req = "SELECT *,ABS(NIVEAU_POIDS) AS NIVEAU_POIDS_ABS
                    FROM (common_soutenances_explications,common_soutenances_section,common_soutenances_niveau,common_soutenances_critere,common_soutenances_destination)
                    WHERE
                    NIVEAU_ID=EXPLICATION_NIVEAU_ID AND
                    CRITERE_ID=EXPLICATION_CRITERE_ID AND
                    DEST_ID=SECTION_DEST_ID AND
                    DEST_ID=NIVEAU_DEST_ID AND
                    DEST_FORM_ID=NIVEAU_FORM_ID AND
                    SECTION_ID=CRITERE_SECTION_ID AND
                    DEST_FORM_ID=$FORM_ID AND
                    DEST_SESSION_ID=$session_id
                    GROUP BY DEST_ID,SECTION_ID,CRITERE_ID, NIVEAU_ID
                    ORDER BY
                    DEST_CONTENU,DEST_ID,SECTION_CONTENU,SECTION_ID,CRITERE_CONTENU,
                    CRITERE_ID,NIVEAU_POIDS_ABS, NIVEAU_CONTENU,NIVEAU_ID,EXPLICATION_CONTENU,EXPLICATION_ID";

        return self::getRequete($req);
    }

    public static function getGrilles(int $FORM_ID,int $ENS_ID, int $annee_id, int $session_id, string $et_id, int $clot=0) : array {
        $req = "SELECT *,IF(SOUT_ET_ID IN ($et_id) AND SOUT_ENS_ID = $ENS_ID,'checked','') AS CHECKED,ABS(NIVEAU_POIDS) AS NIVEAU_POIDS_ABS
                    FROM (common_soutenances_explications,common_soutenances_section,common_soutenances_niveau,common_soutenances_critere,common_soutenances_destination)
                        LEFT JOIN common_soutenances_etudiants ON (CRITERE_ID=SOUT_CRITERE_ID AND NIVEAU_ID=SOUT_NIVEAU_ID AND SOUT_ENS_ID=$ENS_ID AND SOUT_ANNEE_ID=$annee_id AND SOUT_CLOT=$clot AND SOUT_ET_ID IN ($et_id) AND SOUT_SESSION_ID=$session_id)
                    WHERE
                    NIVEAU_ID=EXPLICATION_NIVEAU_ID AND
                    CRITERE_ID=EXPLICATION_CRITERE_ID AND
                    DEST_ID=SECTION_DEST_ID AND
                    DEST_ID=NIVEAU_DEST_ID AND
                    DEST_FORM_ID=NIVEAU_FORM_ID AND
                    SECTION_ID=CRITERE_SECTION_ID AND
                    DEST_FORM_ID=$FORM_ID AND
                    DEST_SESSION_ID=$session_id
                    GROUP BY DEST_ID,SECTION_ID,CRITERE_ID, NIVEAU_ID
                    ORDER BY
                    DEST_CONTENU,DEST_ID,SECTION_CONTENU,SECTION_ID,CRITERE_CONTENU,
                    CRITERE_ID,NIVEAU_POIDS_ABS, NIVEAU_CONTENU,NIVEAU_ID,EXPLICATION_CONTENU,EXPLICATION_ID";

        return self::getRequete($req);
    }

    public static function getMatierePourUnEtudiantEtUneSession(int $et_id, int $session_id, int $annee_id) : ?int {
        $req = "SELECT SOUT_MAT_ID FROM common_soutenances_etudiants WHERE SOUT_ET_ID=$et_id AND SOUT_CLOT=1 AND SOUT_ANNEE_ID=$annee_id AND SOUT_SESSION_ID=$session_id";
        if ($ligne = self::doRequete($req)->fetch_assoc()) {
            return $ligne['SOUT_MAT_ID'];
        }
        return null;
    }

    public static function copierSession(int $source,int $dest,int $formation_courante) : bool {
        if ($source == $dest) {
            return false;
        }

        self::startTransaction();
        $req = "SELECT DEST_ID FROM common_soutenances_destination WHERE DEST_SESSION_ID=$source";
        $destinations = self::getRequeteAvecClef("DEST_ID",$req);
        foreach ($destinations as $destination_source => $_) {
            $req = "INSERT INTO common_soutenances_destination(DEST_SESSION_ID, DEST_CONTENU, DEST_FORM_ID, DEST_COEF)
                    (SELECT $dest, DEST_CONTENU, $formation_courante, DEST_COEF FROM common_soutenances_destination WHERE DEST_ID=$destination_source)";

            if (! self::execRequete($req)) {
                self::rollback();
                return false;
            }
            $destination_dest = self::$conn->insert_id;

            $map_niveau = array();
            $req = "SELECT NIVEAU_ID FROM common_soutenances_niveau WHERE NIVEAU_DEST_ID=$destination_source";
            $niveaux = self::getRequeteAvecClef("NIVEAU_ID",$req);
            foreach ($niveaux as $niveau_source => $____) {
                $req = "INSERT INTO common_soutenances_niveau(NIVEAU_FORM_ID, NIVEAU_DEST_ID, NIVEAU_CONTENU, NIVEAU_POIDS, NIVEAU_MAX, NIVEAU_NUMERIQUE)
                        (SELECT $formation_courante, $destination_dest, NIVEAU_CONTENU, NIVEAU_POIDS, NIVEAU_MAX, NIVEAU_NUMERIQUE FROM common_soutenances_niveau WHERE NIVEAU_ID = $niveau_source)";

                if (!self::execRequete($req)) {
                    self::rollback();
                    return false;
                }
                $niveau_dest = self::$conn->insert_id;
                $map_niveau[$niveau_source] = $niveau_dest;
            }

            $req = "SELECT SECTION_ID FROM common_soutenances_section WHERE SECTION_DEST_ID=$destination_source";
            $sections = self::getRequeteAvecClef("SECTION_ID",$req);
            foreach ($sections as $section_source => $__) {
                $req = "INSERT INTO common_soutenances_section(SECTION_CONTENU, SECTION_DEST_ID)
                        (SELECT SECTION_CONTENU, $destination_dest FROM common_soutenances_section WHERE SECTION_ID = $section_source)";

                if (! self::execRequete($req)) {
                    self::rollback();
                    return false;
                }
                $section_dest = self::$conn->insert_id;

                $req = "SELECT CRITERE_ID FROM common_soutenances_critere WHERE CRITERE_SECTION_ID=$section_source";
                $criteres = self::getRequeteAvecClef("CRITERE_ID",$req);
                foreach ($criteres as $critere_source => $___) {
                    $req = "INSERT INTO common_soutenances_critere(CRITERE_SECTION_ID, CRITERE_CONTENU)
                            (SELECT $section_dest,CRITERE_CONTENU FROM common_soutenances_critere WHERE CRITERE_ID = $critere_source)";

                    if (! self::execRequete($req)) {
                        self::rollback();
                        return false;
                    }
                    $critere_dest = self::$conn->insert_id;

                    $req = "SELECT * FROM common_soutenances_explications WHERE EXPLICATION_CRITERE_ID=$critere_source";
                    $explications = self::getRequeteAvecClef("EXPLICATION_ID",$req);
                    foreach ($explications as $explication_source => $explication) {
                        $req = "INSERT INTO common_soutenances_explications(EXPLICATION_NIVEAU_ID, EXPLICATION_CRITERE_ID, EXPLICATION_CONTENU)
                                (SELECT ".$map_niveau[$explication['EXPLICATION_NIVEAU_ID']].",$critere_dest,EXPLICATION_CONTENU FROM common_soutenances_explications WHERE EXPLICATION_ID = $explication_source)";

                        if (! self::execRequete($req)) {
                            self::rollback();
                            return false;
                        }
                    }
                }
            }
        }

        self::commit();
        return true;
    }

    public static function publierNotes(int $mat_id,int $session_id,int $formation_id,int $annee_id, bool $detail) : bool {
        self::startTransaction();

        $destination = null;
        $la_grille = Notation_Soutenances::getEtudiantsValorises($formation_id,$annee_id,false,$session_id,$destination);

        if (!$detail) {
            $etudiant_courant = -1;
            $les_notes = array();
            foreach ($la_grille as $une_grille) {
                if ($une_grille['ET_ID'] != $etudiant_courant) {
                    $etudiant_courant = $une_grille['ET_ID'];
                    if ($une_grille['COEF_FINAL'] > 0) {
                        $les_notes[$etudiant_courant] = $une_grille['NOTE_FINALE'];
                    }
                }
            }

            $donnees = array(array(
                "*CONTROLE_NOM" => "Note finale",
                "*CONTROLE_MAT_ID" => $mat_id,
                "*CONTROLE_ANNEE_ID" => $annee_id,
                "*CONTROLE_ENS_ID" => CURRENT_ID,
                "*CONTROLE_VALIDE" => 1,
                "*CONTROLE_VISIBLE" => 1,
                "*CONTROLE_MOYENNE" => 2,
                "*CONTROLE_COEFF" => 1
            ));
            manual_bfmw_secure($donnees);
            $controle_id = Controles::creerControle($donnees[0]);
            if ($controle_id <= 0) {
                self::rollback();
                return false;
            }

            $to_lock = array(-1);
            if (! Notes::insertNotes($controle_id,$mat_id,$annee_id,$les_notes,$to_lock,true)) {
                self::rollback();
                return false;
            }
            if (! Notation_Soutenances::lockNotes($session_id,$annee_id,$to_lock,$mat_id)) {
                self::rollback();
                return false;
            }
        } else {
            $les_destinations = array();
            $les_contenus = array();
            foreach ($la_grille as $une_grille) {
                $destination_courante = $une_grille['DEST_ID'];
                $etudiant_courant = $une_grille['ET_ID'];
                if ($une_grille['COEF_FINAL'] > 0) {
                    $les_destinations[$destination_courante][$etudiant_courant] = $une_grille['NOTE'];
                }
                $les_contenus[$une_grille['DEST_ID']] = $une_grille;
            }

            foreach ($les_destinations as $DEST_ID=>$un_tableau_de_note) {
                $donnees = array(array(
                    "*CONTROLE_NOM" => $les_contenus[$DEST_ID]['DEST_CONTENU'],
                    "*CONTROLE_MAT_ID" => $mat_id,
                    "*CONTROLE_ANNEE_ID" => $annee_id,
                    "*CONTROLE_ENS_ID" => CURRENT_ID,
                    "*CONTROLE_VALIDE" => 1,
                    "*CONTROLE_VISIBLE" => 1,
                    "*CONTROLE_MOYENNE" => 2,
                    "*CONTROLE_COEFF" => $les_contenus[$DEST_ID]['DEST_COEF']
                ));
                manual_bfmw_secure($donnees);
                $controle_id = Controles::creerControle($donnees[0]);

                if ($controle_id <= 0) {
                    self::rollback();
                    return false;
                }

                $to_lock = array(-1);
                if (! Notes::insertNotes($controle_id,$mat_id,$annee_id,$un_tableau_de_note,$to_lock,true)) {
                    self::rollback();
                    return false;
                }

                if (! Notation_Soutenances::lockNotes($session_id,$annee_id,$to_lock,$mat_id)) {
                    self::rollback();
                    return false;
                }
            }
        }
        self::commit();
        return true;
    }

    private static function lockNotes(int $session_id, int $annee_id, array $les_notes, int $mat_id) : bool {
        $req = "UPDATE common_soutenances_etudiants SET SOUT_CLOT = 1, SOUT_MAT_ID=$mat_id WHERE SOUT_SESSION_ID=$session_id AND SOUT_ANNEE_ID=$annee_id AND SOUT_ET_ID IN (".implode(",",array_keys($les_notes)).")";
        return self::execRequete($req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        $annee_courante = Annees::getIdAnneeCourante();
        if (isset($_SESSION['ANNEE_COURANTE'])) {
            $annee_courante = $_SESSION['ANNEE_COURANTE'];
        }
        if (strpos($tag,"$") !== false) {
            $tab = explode("$",$tag);
            $critere = $tab[0];
            $session = $tab[1];
            $tab = explode("$",$where);
            $numerique = false;
            $niveau_numerique = -1;
            if ($tab[0] == "flhgljkh") {
                $numerique = true;
                $niveau_numerique = $tab[1];
                $tab = array_slice($tab,2);
            }
            $retour = true;
            self::startTransaction();
            foreach ($tab as $un_element) {
                if (is_numeric($un_element)) {
                    if ($numerique) {
                        $req = "INSERT INTO common_soutenances_etudiants(SOUT_ET_ID, SOUT_CRITERE_ID, SOUT_SESSION_ID, SOUT_NIVEAU_ID, SOUT_ENS_ID, SOUT_ANNEE_ID, SOUT_NIVEAU_NUMERIQUE) VALUES ($un_element,$critere,$session,$niveau_numerique," . CURRENT_ID . ",$annee_courante,$valeurnum) ON DUPLICATE KEY UPDATE SOUT_NIVEAU_ID=$niveau_numerique, SOUT_NIVEAU_NUMERIQUE=$valeurnum";
                    } else {
                        $req = "INSERT INTO common_soutenances_etudiants(SOUT_ET_ID, SOUT_CRITERE_ID, SOUT_SESSION_ID, SOUT_NIVEAU_ID, SOUT_ENS_ID, SOUT_ANNEE_ID) VALUES ($un_element,$critere,$session,$valeurnum," . CURRENT_ID . ",$annee_courante) ON DUPLICATE KEY UPDATE SOUT_NIVEAU_ID=$valeurnum";
                    }
                    $retour &= self::execRequete($req);
                }
                if (!$retour) {
                    break;
                }
            }
            if ($retour) {
                self::commit();
            } else {
                self::rollback();
            }
            return $retour;
        }

        switch ($tag) {
            case "DEST_COEF" :
            case "DEST_CONTENU" :
                $req = "UPDATE common_soutenances_destination SET $tag='$valeur' WHERE DEST_ID=$wherenum";
                return self::execRequete($req);
            case "SESSION_CONTENU" :
                $req = "UPDATE common_soutenances_session SET $tag='$valeur' WHERE SESSION_ID=$wherenum";
                return self::execRequete($req);
            case "SESSION_START" :
            case "SESSION_END" :
            case "SESSION_HARMONISATION_START" :
            case "SESSION_HARMONISATION_END" :
                try {
                    $date_convertie = transformDateHeure($valeur);
                } catch (Exception $e) {
                    return false;
                }
                $req = "UPDATE common_soutenances_session SET $tag=$date_convertie WHERE SESSION_ID=$wherenum";
                return self::execRequete($req);
            case "EXPLICATION_CONTENU" :
                $req = "UPDATE common_soutenances_explications SET $tag='$valeur' WHERE EXPLICATION_ID=$wherenum";
                return self::execRequete($req);
            case "CRITERE_CONTENU" :
                $req = "UPDATE common_soutenances_critere SET $tag='$valeur' WHERE CRITERE_ID=$wherenum";
                return self::execRequete($req);
            case "NIVEAU_CONTENU" :
            case "NIVEAU_POIDS" :
            case "NIVEAU_MAX" :
                $req = "UPDATE common_soutenances_niveau SET $tag='$valeur' WHERE NIVEAU_ID=$wherenum";
                return self::execRequete($req);
            case "SECTION_CONTENU" :
                $req = "UPDATE common_soutenances_section SET $tag='$valeur' WHERE SECTION_ID=$wherenum";
                return self::execRequete($req);
            case "AJOUTER_ETUDIANT_DANS_GROUPE" :
                $tab = explode("$",$where);
                $data = array();
                bfmw_add_secured($data, "*GROUPE_ET_ID", $tab[0]);
                bfmw_add_secured($data, "*ET_GROUPE_ID", $tab[1]);
                return ($valeurnum == 1)?(Notation_Soutenances::ajouterEtudiantDansGroupe($data) > 0):(Notation_Soutenances::supprimerEtudiantDunGroupe($tab[0],$tab[1]) > 0);
        }
        return false;
    }

}