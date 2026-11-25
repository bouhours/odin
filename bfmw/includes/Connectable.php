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

abstract class Connectable
{
    protected static mysqli $conn;

    public static function static_init(mysqli $conn)
    {
        self::$conn = $conn;
    }

    protected static function getRequete(string $req) : array {
        return self::$conn->query($req)->fetch_all(MYSQLI_ASSOC);
    }

    protected static function getRequeteAvecClef(string $clef,string $req) : array {
        $res = self::$conn->query($req);
        $retour = array();
        if ($res !== false) {
            while ($une_valeur = $res->fetch_assoc()) {
                $retour[$une_valeur[$clef]] = $une_valeur;
            }
        }
        return $retour;
    }

    protected static function doRequete(string $req) : ?mysqli_result {
        $retour = self::$conn->query($req);
        return $retour===false?null:$retour;
    }

    protected static function execRequete(string $req) : bool {
        return self::$conn->query($req);
    }

    protected static function execMultiRequete(string $req) : bool {
        $retour = true;
        $retour &= self::$conn->multi_query($req);
        while (self::$conn->more_results()) {
            $retour &= self::$conn->next_result();
        }
        return $retour;
    }

    protected static function execRequeteAvecAffected(string $req) : int {
        self::$conn->query($req);
        return self::$conn->affected_rows;
    }

    protected static function execRequeteAvecInsertId(string $req) : int {
        self::$conn->query($req);
        return self::$conn->insert_id;
    }

    public static function startTransaction() : void
    {
        self::$conn->query("BEGIN");
    }

    public static function commit() : void
    {
        self::$conn->query("COMMIT");
    }

    public static function rollback() : void
    {
        self::$conn->query("ROLLBACK");
    }

    protected static function doBind(string $tag, $valeur, $where, ?float $valeurnum, ?float $wherenum): bool {
        return false;
    }

}