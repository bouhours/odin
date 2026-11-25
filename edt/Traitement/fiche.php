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

//$fiche_courante = 0;
//
//$gestionnaire = false;
//if (isAdmin() && (isset($_GET['bfmw_orig_fi']) || isset($_GET['bfmw_orig_new'])) && isset($_GET['bfmw_num_ens'])) {
//    $current_id = $_GET['bfmw_num_ens'];
//    if (isset($_GET['bfmw_orig_fi'])) {
//        $fiche_courante = $_GET['bfmw_orig_fi'];
//    }
//    affectToXHTML($template,array(
//        "FICHE_ENSEIGNANT_ID" => "$".$current_id,
//        "ENSEIGNANT_ID" => $current_id,
//        "GESTIONNAIRE" => true
//    ));
//    $gestionnaire = true;
//} else {
//    $current_id = CURRENT_ID;
//    affectToXHTML($template,array(
//        "FICHE_ENSEIGNANT_ID" => "",
//        "GESTIONNAIRE" => false
//    ));
//    $gestionnaire = false;
//}

$gestionnaire = false;
$enseignant_courant = CURRENT_ID;
$fiche_courante = 0;
if (isGestionnaire() && (isset($_GET['bfmw_orig_fi']) || isset($_GET['bfmw_orig_new'])) && isset($_GET['bfmw_num_ens'])) {
    $gestionnaire = true;
    $enseignant_courant = $_GET['bfmw_num_ens'];
    $fiche_courante = $_GET['bfmw_num_fi']??0;
}

$periode_courante = -1;
if (isset($_GET['bfmw_num_pe'])) {
    $periode_courante = $_GET['bfmw_num_pe'];
}

if ($periode_courante != -1) {
    $les_periodes = Edt::getPeriodeID($periode_courante);
    if (count($les_periodes) !== 1) {
        $send = "p=voeux";
        require "refresh.php";
        exit;
    }
    $une_periode = $les_periodes["0"];
    $annee_a_afficher = $une_periode['PERIODE_ANNEE_ID'];
    
    $date_maxi = new DateTime($une_periode['PERIODE_LIMIT'] . " 23:59:59", new DateTimeZone("Europe/Paris"));
    $saisie_terminee = (time() > $date_maxi->getTimestamp()) && !$gestionnaire;

    $une_periode['READONLY'] = ($saisie_terminee) ? "disabled" : "";

    if (isset($_GET['bfmw_orig_read'])) {
        $une_periode['READONLY'] = "disabled";
        $annee_a_afficher = $_GET['bfmw_num_read'];
    }

    if ($gestionnaire) {
        $une_periode['FICHE_ENSEIGNANT_ID'] = "$".$enseignant_courant;
    }

    if ($une_periode['READONLY'] != "disabled" && $fiche_courante == 0) {
        $fiche_courante = Edt::updateFiche($enseignant_courant,$periode_courante,$annee_a_afficher,date("Y-m-d H:i:s"));
        if ((isset($_GET['bfmw_orig_copy']) && $_GET['bfmw_orig_copy']=="copy") || (isset($_GET['bfmw_orig_new']))) {
            Edt::CopyFiche($fiche_courante,$enseignant_courant,$annee_a_afficher, $periode_courante);
        }
    }

    if ($fiche_courante != 0) {
        $la_fiche = Edt::getFiche($fiche_courante);
    }
    if (isset($_GET['bfmw_orig_read']) || $fiche_courante == 0) {
        $la_fiche = Edt::getFicheEnseignant($enseignant_courant,$periode_courante,$annee_a_afficher);

    }

    setAttachment($template, "fiche", "fiche.html");
    if (count($la_fiche) != 0) {
        $fiche_courante = $la_fiche[0]['FICHE_ID'];
        affectToXHTML($template,array(
            "FICHE_A" => $une_periode['PERIODE_TYPE'] == "A"
        ));

        $une_periode = array_merge($une_periode, $la_fiche[0]);

        for ($i = 0; $i < 55; $i++) {
            $une_periode["DISPO_" . $i] = "<span class='vert'>disponible</span>";
        }

        $les_indisponibilites = Edt::getIndisponibilites($fiche_courante);
        foreach ($les_indisponibilites as $indispo_id => $une_indispo) {
            $une_periode["DISPO_" . $indispo_id] = "<span class='rouge'>indisponible</span>";
        }

        affectToXHTML($template, $une_periode);

        $les_matieres = ChargeEnseignements::computeChargeEqTDPeriodePourEnseignant($annee_a_afficher,$periode_courante,$enseignant_courant);
        affectToBlocAndRepeat($template,"un_semestre.une_ue.une_matiere.une_charge",$les_matieres,null,
        array(
            "un_semestre" => array(-1,"SEM_ID"),
            "un_semestre.une_ue" => array(-1,"UE_ID"),
            "un_semestre.une_ue.une_matiere" => array(-1,"MAT_ID")
        ));

        generateCompleteXHTML($template, "fiche");
    } else {
        echo "Le délai de saisie est dépassé. Vous n'avez saisi aucune fiche pour cette période.";
    }

}