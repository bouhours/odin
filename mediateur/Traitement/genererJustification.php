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

$les_formations_autorisees = Formations::getFormationsDuConnecteString();

$annee_courante = $_GET['bfmw_num_a']??Annees::getIdAnneeCourante();

$req = "SELECT * FROM etudiants_groupes,common_absences_justifications WHERE ET_ID=JUSTIF_ET_ID AND JUSTIF_ID=".$_GET['bfmw_num_code']." AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ENS_ID='" . CURRENT_ID . "'";
if (Formations::isSecretaire() || Formations::isResponsable()) {
    $req = "SELECT * FROM etudiants_groupes,common_formation,common_absences_justifications WHERE ET_ID=JUSTIF_ET_ID AND JUSTIF_ID=".$_GET['bfmw_num_code']." AND ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND GROUPE_FORM_ID IN (".$les_formations_autorisees.") AND FORM_DEPT_ID=".CURRENT_DEPT_ID;
}

if ($conn->query($req)->num_rows > 0) {

    $req = "SELECT * FROM common_absences_justifications WHERE JUSTIF_ID=".$_GET['bfmw_num_code'];
    $res = $conn->query($req);
    $result = "";
    $filename="";
    if ($une_justif = $res->fetch_assoc()) {
        $filename = "../etudiants/".$une_justif['JUSTIF_CHEMIN'];
        $result = file_get_contents($filename);
    } else {
        exit;
    }

        //Sortie
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        header('Content-Type: '.mime_content_type($filename));
        header('Content-Disposition: attachment;filename="' . pathinfo($filename, PATHINFO_FILENAME).".". pathinfo($filename, PATHINFO_EXTENSION));
        print_r($result);
}
exit;