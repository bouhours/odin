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

class Tablettes extends Connectable
{
    public static function getTablette(string $identifiant) : array {
        $req = "SELECT common_tablettes.*,common_formation.FORM_DEPT_ID FROM common_tablettes,common_formation WHERE FORM_ID=TABLETTE_FORM_ID AND TABLETTE_UID='$identifiant'";
        return self::getRequete($req);
    }

    public static function createTabletteAsk(string $identifiant)
    {
        $req = "INSERT INTO common_tablette_ask(ASK_TABLETTE, ASK_DATE) VALUES('$identifiant',".time().") ";
        self::execRequete($req);
    }
}