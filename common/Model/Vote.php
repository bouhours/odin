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

class Vote extends Connectable
{
    public static function creerVote(array $data) : int {
        $req = "SELECT * FROM common_vote WHERE VOTE_CLOT=0 AND VOTE_CODE='".$data['bfmw_orig_*VOTE_CODE']."' AND VOTE_ET_ID=".$data['bfmw_num_*VOTE_ET_ID'];
        if (self::doRequete($req)->num_rows > 0) {
            return -1;
        }
        return createData("common_vote",$data,3);
    }

    public static function getVote(string $jury_id,int $ens_id) : array {
        $req = "SELECT *
                FROM common_vote
                LEFT JOIN common_vote_enseignant ON VOTE_ID = ENS_VOTE_ID AND VOTE_ENS_ID=$ens_id
                WHERE VOTE_CODE='$jury_id'";
        return self::getRequeteAvecClef("VOTE_ET_ID",$req);
    }

    public static function getVoteAvecResultats(string $jury_id) : array {
        $req = "SELECT *
                FROM common_vote
                LEFT JOIN common_vote_enseignant ON VOTE_ID = ENS_VOTE_ID
                WHERE VOTE_CODE='$jury_id' AND VOTE_CLOT=1
                ORDER BY VOTE_ET_ID,VOTE_ID, VOTE_VALEUR";
        $resultat = self::getRequete($req);

        $identifiant_courant = -1;
        $vote_courant = -1;
        $retour = array();
        foreach ($resultat as $un_vote) {
            if ($identifiant_courant !== $un_vote["VOTE_ET_ID"]) {
                $identifiant_courant = $un_vote["VOTE_ET_ID"];
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
        $req = "SELECT * FROM common_vote_enseignant,common_enseignant WHERE ENS_ID=VOTE_ENS_ID AND ENS_VOTE_ID=$vote_id ORDER BY ENS_NOM";
        return self::getRequete($req);
    }

    public static function cloreVote(int $vote_id) : bool {
        $req = "UPDATE common_vote SET VOTE_CLOT=1 WHERE VOTE_ID=$vote_id";
        return self::execRequete($req);
    }

    public static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool
    {
        $validation = false;
        switch ($tag) {
           case "VOTE" :
                $req = "SELECT * FROM common_vote WHERE VOTE_ID=$wherenum AND VOTE_CLOT=0";
                if (self::doRequete($req)->num_rows != 1) {
                    return false;
                }

                $vote="Abstention";
                switch ($valeur) {
                    case "Pour" : $vote = "Pour";break;
                    case "Contre" : $vote = "Contre";break;
                }
                $req = "INSERT INTO common_vote_enseignant(ENS_VOTE_ID, VOTE_ENS_ID, VOTE_VALEUR) VALUE ($wherenum,".CURRENT_ID.",'$vote') ON DUPLICATE KEY UPDATE VOTE_VALEUR='$vote'";
                return self::execRequete($req);
            case "CLOSE" :
                $tab = explode("$",$where);
                if (isAdmin()) {
                    Vote::cloreVote($tab[0]);
                }
        }
        return $validation;
    }

}