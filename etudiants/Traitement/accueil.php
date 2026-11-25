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

verifSession();

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "accueil", "accueil.html");

$annee_courante = $force_annee_courante;

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

affectToXHTML($template,Etudiants::getEtudiantSimple(CURRENT_ID)[0]);
affectToXHTML($template,QR::getQR(CURRENT_ID)[0]);

$les_formations = Formations::getLesFormationsDeLEtudiant(CURRENT_ID,$annee_courante);
$formation_courante = affectToBlocAndRepeat($template,"une_formation",$les_formations,new Comparateur("FORM_ID",$formation_courante));

affectToXHTML($template, array(
    "FORM_PRO" => false,
    "ANNEE_COURANTE" => $annee_courante
));

foreach ($les_formations as $formation_etudiant) {
    if ($formation_etudiant['FORM_ID'] != $formation_courante) {
        continue;
    }

    if ($formation_etudiant == null) {
        $champs_formations = array();
    } else {
        $champs_formations = Fiches_Renseignements::getChampsDeLaFormationValorises($formation_etudiant["FORM_ID"], CURRENT_ID);
    }

    affectToBlocAndRepeat($template, "un_champ", $champs_formations);


    if ($formation_etudiant != null) {
        if ($formation_etudiant['FORM_PRO'] == 1) {
            $etudiant = Etudiants::getEtudiantPro(CURRENT_ID)[0];

            affectToXHTML($template, array(
                "FORM_PRO" => $etudiant["ET_PROFESSIONNALISATION"]==1
            ));
            affectToXHTML($template, $etudiant);
        }
    }
}

generateCompleteXHTML($template, "accueil");