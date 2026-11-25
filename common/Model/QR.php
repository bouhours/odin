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

class QR extends Connectable
{

    public static function getQR(int $et_id) : array
    {
        $req = "SELECT * FROM common_etudiant_qr WHERE QR_ET_ID=$et_id AND 
                            QR_ET_QR IS NOT NULL AND
                            QR_ET_QR_TIME IS NOT NULL AND
                            QR_ET_QR_TIME > UNIX_TIMESTAMP(NOW() - INTERVAL 7 DAY)";
        $retour = self::getRequete($req);
        if (count($retour) == 0) {
            if (self::creerQR($et_id)) {
                return self::getQR($et_id);
            } else {
                return [];
            }
        }
        return $retour;
    }

    private static function creerQR(int $et_id) : bool
    {
        ob_start();
        $uniqid = uniqid("ODIN+",true);
        imagepng((new QRCode($uniqid,["s"=>"qr","bc"=>"29363f","fc"=>"ffffff","wq"=>0]))->render_image());
        $base64 = base64_encode(ob_get_clean());
        $req = "INSERT INTO common_etudiant_qr(QR_ET_ID,QR_ET_QR,QR_ET_QR_TIME,QR_DATA) VALUES($et_id,'$base64',UNIX_TIMESTAMP(NOW()),'$uniqid')
                ON DUPLICATE KEY UPDATE QR_ET_QR='$base64', QR_ET_QR_TIME=UNIX_TIMESTAMP(NOW()), QR_DATA='$uniqid'";
        return self::execRequeteAvecAffected($req) > 0;
    }
}