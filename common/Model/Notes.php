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

class Notes extends Connectable
{
    public static function getNombreControlesPourUnEnseignantParEtudiant(int $ENS_ID) : array {
        $req = "SELECT NOTES_ET_ID,COUNT(*) AS TOTAL FROM common_notes,common_controle WHERE CONTROLE_ID = NOTES_CONTROLE_ID AND (NOTES_VALEUR IS NOT NULL OR NOTES_SPECIAL IS NOT NULL) AND CONTROLE_ENS_ID=$ENS_ID GROUP BY NOTES_ET_ID";
        $retour = self::getRequeteAvecClef("NOTES_ET_ID",$req);
        $req = "SELECT NOTES_ET_ID,COUNT(*) AS TOTAL FROM common_clotures_notes,common_controle WHERE CONTROLE_ID = NOTES_CONTROLE_ID AND (NOTES_VALEUR IS NOT NULL OR NOTES_SPECIAL IS NOT NULL) AND CONTROLE_ENS_ID=$ENS_ID GROUP BY NOTES_ET_ID";
        $retour2 = self::getRequeteAvecClef("NOTES_ET_ID",$req);
        foreach ($retour2 as $ET_ID=>$controles) {
            if (isset($retour[$ET_ID])) {
                $retour[$ET_ID]["TOTAL"] += $controles["TOTAL"];
            } else {
                $retour[$ET_ID] = $controles;
            }
        }
        return $retour;
    }

    public static function insertNotes(int $controle_id, int $mat_id, int $annee_id, array $les_notes,?array &$etudiants_reels, bool $with_mail = false) : bool
    {
        $les_etudiants = Etudiants::getEtudiantsDeLaMatiere($mat_id,$annee_id,CURRENT_DEPT_ID);
        $donnees = array();
        foreach ($les_etudiants as $et_id => $un_etudiant) {
            if (in_array($et_id,array_keys($les_notes))) {
                if ($etudiants_reels != null) {
                    $etudiants_reels[$et_id] = $un_etudiant;
                }
                $donnees[] = array(
                    "*NOTES_CONTROLE_ID" => $controle_id,
                    "*NOTES_ET_ID" => $et_id,
                    "*NOTES_VALEUR" => $les_notes[$et_id]
                );
            }
        }
        manual_bfmw_secure($donnees);
        foreach ($donnees as $une_note) {
            if (createData("common_notes",$une_note,3) <= 0) {
                return false;
            }
        }

        if ($with_mail) {
            self::envoyerMail($annee_id,$controle_id);
        }

        return true;
    }

    public static function envoyerMail(int $annee_courante, int $controle) : void
    {

        $req = "SELECT DISTINCT ENS_MAIL FROM common_notes, etudiants_groupes, common_enseignant WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND ENS_ID=GROUPE_ENS_ID AND ET_ID=NOTES_ET_ID AND NOTES_SPECIAL='ABI' AND NOTES_CONTROLE_ID=$controle GROUP BY ENS_ID";
        $res = self::doRequete($req);
        $fail = $res->num_rows > 0;
        $les_mediateurs = array();
        while ($un_mediateur = $res->fetch_assoc()) {
            $les_mediateurs[] = $un_mediateur['ENS_MAIL'];
        }

        $req = "SELECT DISTINCT ET_MAIL,ET_NOM, MAT_NOM FROM etudiants_groupes,common_notes,common_controle,common_matiere WHERE MAT_START_ANNEE_ID <= CONTROLE_ANNEE_ID AND (MAT_END_ANNEE_ID > CONTROLE_ANNEE_ID OR MAT_END_ANNEE_ID IS NULL) AND CONTROLE_ID=NOTES_CONTROLE_ID AND MAT_ID=CONTROLE_MAT_ID AND ET_GROUPE_ANNEE_ID=CONTROLE_ANNEE_ID AND ET_ID = NOTES_ET_ID AND (NOTES_VALEUR IS NOT NULL OR NOTES_SPECIAL IS NOT NULL) AND NOTES_CONTROLE_ID=$controle";
        $res = self::doRequete($req);
        $les_destinataires = "";
        $matiere = "";
        while ($mail = $res->fetch_assoc()) {
            $les_destinataires .= $mail['ET_MAIL'] . ",";
            $matiere = $mail['MAT_NOM'];
        }
        $les_destinataires .= "noreply+odin@uca.fr";
        sendMail("Plateforme ODIN <noreply+odin@uca.fr>", "Une nouvelle note est disponible", "Bonjour\n\nUne note d'un de vos contrôles de '" . $matiere . "' a été saisie. Vous pouvez la consulter sur https://odin.iut.uca.fr\n\nCordialement\n\nL'équipe enseignante", $les_destinataires);
        if ($fail) {
            foreach ($les_mediateurs as $un_mediateur) {
                sendMail($un_mediateur, "Une note ABI a été saisie", "Bonjour\n\nUne note ABI a été saisie dans un des contrôles de '" . $matiere . "'. Vous trouverez plus d'informations dans la zone de médiation d'Odin sur https://odin.iut.uca.fr\n\nCordialement");
            }
        }
    }

    public static function supprimerNote(int $note_id, int $controle_id) : bool
    {
        $req = "DELETE FROM common_notes WHERE NOTES_ID=$note_id AND NOTES_CONTROLE_ID=$controle_id";
        return self::execRequeteAvecAffected($req) === 1;
    }

    public static function modifierNote(string $note_valeur, int $note_id) : int
    {
        if (is_numeric($note_valeur)) {
            $req = "UPDATE common_notes SET NOTES_VALEUR=$note_valeur,NOTES_SPECIAL = NULL WHERE NOTES_ID=$note_id";
        } else if ($note_valeur == "ABI") {
            $req = "UPDATE common_notes SET NOTES_VALEUR=NULL,NOTES_SPECIAL = 'ABI' WHERE NOTES_ID=$note_id";
        } else if ($note_valeur == "ABJ") {
            $req = "UPDATE common_notes SET NOTES_VALEUR=NULL,NOTES_SPECIAL=NULL WHERE NOTES_ID=$note_id";
        } else {
            return 0;
        }
        return self::execRequeteAvecAffected($req);
    }
}