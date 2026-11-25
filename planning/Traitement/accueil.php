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

Plannings::cleanDisponibilitesNonAffecteesEtPassees();

setAttachment($template, "accueil", "accueil.html");

if (!isset($_GET["bfmw_orig_planning"])) {
    affectToXHTML($template,array("GENERIQUE" => true));
} else {
    $planning_courant = $_GET["bfmw_num_planning"];

    $les_rdv = Plannings::getRendezVousDeLEnseignant($planning_courant,CURRENT_ID);
    affectToBlocAndRepeat($template,"une_date.un_rdv",$les_rdv,null,array(
        "une_date" => array(-1,"DISPO_DATE")
    ));

    affectToXHTML($template,array(
        "GENERIQUE" => false,
        "NOMBRE_RDV" => count($les_rdv),
        "PLANNING_ID" => $planning_courant
    ));
    foreach ($les_plannings as $planning_id=>$un_planning) {
        if ($planning_id != $planning_courant) {
            continue;
        }
        $date_debut = $un_planning["PLANNING_START"];
        $date_fin = $un_planning["PLANNING_END"];
        $date_courante = new DateTime();
        $date_courante->setTimestamp($date_debut);
        while ($date_courante->getTimestamp() <= $date_fin) {
            if (time() > $date_courante->getTimestamp()) {
                $date_courante->add(new DateInterval("P1D"));
                continue;
            }

            affectToBloc($template,"une_dispo",array(
                "DISPO_DATE_AFFICHAGE"=>$date_courante->format('d/m/Y'),
                "DISPO_DATE" => $date_courante->getTimestamp()
            ));

            affectToBlocAndRepeat($template,"une_dispo.un_creneau",$les_creneaux = Plannings::getCreneauxAvecRendezVous($planning_id, CURRENT_ID,$date_courante->getTimestamp()));

            $date_courante->add(new DateInterval("P1D"));
        }
    }


}

generateCompleteXHTML($template, "accueil");