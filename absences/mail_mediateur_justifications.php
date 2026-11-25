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

$req = "SELECT DISTINCT GROUPE_ENS_ID,ENS_MAIL FROM etudiants_groupes,common_enseignant WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND ENS_ID=GROUPE_ENS_ID AND GROUPE_ENS_ID IS NOT NULL UNION SELECT DISTINCT SECRETAIRE_ENS_ID,ENS_MAIL FROM common_enseignant,common_secretaire WHERE ENS_ID=SECRETAIRE_ENS_ID";
$res = $conn->query($req);
while ($un_mediateur = $res->fetch_assoc()) {
    $mail = "Bonjour\n\nDes étudiants de votre groupe ont saisi des excuses qui doivent être validées :\n";
    $req = "SELECT DISTINCT GROUPE_ID,GROUPE_NOM,ET_NOM,ET_MAIL FROM common_absences_justifications, etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND JUSTIF_ATTENTE=1 AND JUSTIF_ET_ID=GROUPE_ET_ID AND GROUPE_ENS_ID = ".$un_mediateur['GROUPE_ENS_ID']." UNION SELECT DISTINCT GROUPE_ID,GROUPE_NOM,ET_NOM,ET_MAIL FROM common_absences_justifications, etudiants_groupes, common_secretaire WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND JUSTIF_ATTENTE=1 AND JUSTIF_ET_ID=GROUPE_ET_ID AND GROUPE_FORM_ID=SECRETAIRE_FORM_ID AND SECRETAIRE_ENS_ID=".$un_mediateur['GROUPE_ENS_ID']." AND GROUPE_FEUILLE=1 ORDER BY GROUPE_NOM,GROUPE_ID,ET_NOM";

    $res2 = $conn->query($req);
    if ($res2->num_rows == 0) {
        continue;
    }

    $groupe_en_cours = -1;
    while ($une_absence = $res2->fetch_assoc()) {
        if ($groupe_en_cours != $une_absence['GROUPE_ID']) {
            $groupe_en_cours = $une_absence['GROUPE_ID'];
            $mail .= "\n---".$une_absence['GROUPE_NOM']."\n";
        }

        $mail .= "- ".$une_absence['ET_NOM']." (".$une_absence['ET_MAIL'].")\n";
    }

    $mail .= "\n\nVous pouvez gérer ces absences sur la plateforme Odin (https://odin.iut.uca.fr), application \"Suivi des étudiants\"\n\nCordialement";

    sendMail($un_mediateur['ENS_MAIL'], "Nouvelles excuses", $mail);
}

$conn->close();
exit;

