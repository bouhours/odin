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

ini_set('max_execution_time', '0');
$annee_courante = Annees::getIdAnneeCourante();

//sendMail("cedric.bouhours@uca.fr", "BACKUP EDT", "Backup étudiant démarré");
mysql_start_transaction();
$req = "SELECT * FROM common_groupes WHERE GROUPE_DELETED=0 AND GROUPE_ADE IS NOT NULL AND GROUPE_ADE <> ''";
$res = $conn->query($req);
$les_groupes = $res->fetch_all(MYSQLI_ASSOC);
$today = new DateTime();
$cinquantedeuxsemainespast = new DateTime();
$cinquantedeuxsemainespast->sub(new DateInterval("P52W"));
$tomorrow = new DateTime();
$tomorrow->add(new DateInterval("P1D"));

$nb = 0;

foreach($les_groupes as $un_groupe) {
    try {
        $les_creneaux = Edt::getCreneauxEtudiant($un_groupe['GROUPE_ID'],$cinquantedeuxsemainespast->getTimestamp());

        Edt::deleteCreneauxEtudiant($un_groupe['GROUPE_ID'],$cinquantedeuxsemainespast->getTimestamp());

        $events_affiche = array();
        echo "<br/>".$un_groupe['GROUPE_ADE']."<br/>";
        if (!Edt::collectEDTv2(Edt::$current_project_id,array($un_groupe['GROUPE_ADE']),$events_affiche,0,false,false,false,false,$cinquantedeuxsemainespast, $tomorrow)) {
            echo "Exception : ".$un_groupe['GROUPE_NOM'];
        }
        if (!empty($events_affiche)) {
            foreach ($events_affiche as $un_evt) {
                echo  "*";
                $un_evt['*EDT_GROUPE_ID']=$un_groupe['GROUPE_ID'];
                $un_evt['*EDT_ANNEE_ID']=$annee_courante;
                $params = array();
                $params[] = $un_evt;
                manual_bfmw_secure($params);
                createData("common_backup_ade_etudiant",$params[0],9);
                if (isset($les_creneaux[$un_evt['*EDT_UID']]) && ($les_creneaux[$un_evt['*EDT_UID']]["EDT_ARCHIVE"]!=null || $les_creneaux[$un_evt['*EDT_UID']]["EDT_MASQUE"]=="1")) {
                    $req = "UPDATE common_backup_ade_etudiant SET EDT_ARCHIVE=".(($les_creneaux[$un_evt['*EDT_UID']]["EDT_ARCHIVE"]==null)?"NULL":$les_creneaux[$un_evt['*EDT_UID']]["EDT_ARCHIVE"]).",EDT_MASQUE=".$les_creneaux[$un_evt['*EDT_UID']]["EDT_MASQUE"]." WHERE EDT_UID = '".$un_evt['*EDT_UID']."'";
                    $conn->query($req);
                }
                $nb++;
                ob_flush();
                flush();
                ob_flush();
                flush();
                ob_flush();
                flush();
                ob_flush();
                flush();
            }
        }
    } catch (Exception $e) {
        echo "<br/>Exception : ".$un_groupe['GROUPE_NOM']."<br/>".$e->getTraceAsString();
    }
}

echo "FIN";

mysql_commit();
//sendMail("cedric.bouhours@uca.fr", "BACKUP EDT", "$trace\nBackup étudiant fini ($nb)");
$conn->close();
exit;
