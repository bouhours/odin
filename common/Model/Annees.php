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

class Annees extends Connectable
{
    private static int $annee_courante = -1;

    public static function getAnnee() : array {
        $req = "SELECT * FROM common_annee ORDER BY ANNEE_NOM";
        return self::getRequete($req);
    }

    public static function getAnneeWithId(int $annee_id) : array {
        $req = "SELECT * FROM common_annee WHERE ANNEE_ID=$annee_id ORDER BY ANNEE_NOM";
        return self::getRequete($req);
    }

    public static function getAnneeCourante() : array {
        $req = "SELECT * FROM common_annee WHERE ANNEE_COURANTE = 1 ORDER BY ANNEE_NOM";
        return self::getRequete($req);
    }

    public static function getIdAnneeCourante() : int {
        if (self::$annee_courante == -1) {
            $req = "SELECT * FROM common_annee WHERE ANNEE_COURANTE = 1 ORDER BY ANNEE_NOM";
            self::$annee_courante = self::doRequete($req)->fetch_assoc()['ANNEE_ID'];
        }
        return self::$annee_courante;
    }

    public static function getLastIdAnneeCourante() : int {
        $req = "SELECT * FROM common_annee ORDER BY ANNEE_ID DESC";
        return self::doRequete($req)->fetch_assoc()['ANNEE_ID'];
    }

    public static function getAnneeNonClose(int $close = 0) : array {
        $req = "SELECT * FROM common_annee WHERE ANNEE_CLOSE=$close ORDER BY ANNEE_NOM";
        return self::getRequete($req);
    }

    public static function getAnneeDuDepartement(int $DEPT_ID) : array {
        $req = "SELECT * FROM common_annee, common_formation WHERE FORM_DEPT_ID=$DEPT_ID AND FORM_START_ANNEE_ID<=ANNEE_ID GROUP BY ANNEE_ID ORDER BY ANNEE_NOM";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            return self::getAnneeCourante();
        }
        return $retour;
    }
}