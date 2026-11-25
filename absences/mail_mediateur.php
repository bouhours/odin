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

require_once('self_server_concrete.php');
require_once __DIR__.'/../bfmw/includes/functions.php';
date_default_timezone_set("Europe/Paris");
$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

require_once __DIR__.'/../common/Model/Absences.php';
require_once __DIR__.'/../common/Model/Annees.php';
Absences::static_init($conn);
Annees::static_init($conn);

$annee_courante = Annees::getIdAnneeCourante();
$lesAbsences = Absences::getAbsencesToMailNewGen($annee_courante);

$req = "SELECT DISTINCT GROUPE_ENS_ID,ENS_MAIL FROM etudiants_groupes,common_enseignant WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND ENS_ID=GROUPE_ENS_ID AND GROUPE_ENS_ID IS NOT NULL";
$res = $conn->query($req);
$les_id = array();
while ($un_mediateur = $res->fetch_assoc()) {
    $mail = "Bonjour\n\nDes étudiants de votre groupe ont été déclarés absents :\n";

    if (!isset($lesAbsences[$un_mediateur['GROUPE_ENS_ID']]) ) {
        continue;
    }

    $groupe_en_cours = -1;
    foreach ($lesAbsences[$un_mediateur['GROUPE_ENS_ID']] as $une_absence ) {
        if ($groupe_en_cours != $une_absence['GROUPE_ID']) {
            $groupe_en_cours = $une_absence['GROUPE_ID'];
            $mail .= "\n---".$une_absence['GROUPE_NOM']."\n";
        }

        $mail .= "- ".$une_absence['ET_NOM']." (".$une_absence['ET_MAIL'].") : ".date("d/m/Y",$une_absence['ABS_REAL_DATE'])." : ".$une_absence['ABST_NOM']." ".$une_absence['MAT_NOM']." (avec ".$une_absence['ENS_NOM'].") : ".$une_absence['CRENEAU_NOM']."\n";
        $les_id[] = $une_absence['ABS_ID'];
    }

    $mail .= "\n\nVous pouvez gérer ces absences sur https://odin.iut.uca.fr\n\nCordialement";

    sendMail($un_mediateur['ENS_MAIL'], "Nouvelles absences", $mail);
}

foreach ($les_id as $id) {
    $req = "UPDATE common_absences_v2 SET ABS_MAIL = 1 WHERE ABS_ID=$id";
    $conn->query($req);
}

$conn->close();
exit;

