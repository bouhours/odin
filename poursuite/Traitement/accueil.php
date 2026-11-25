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
exit;
setAttachment($template, "accueil", "accueil.html");

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Libération de la saisir en cours
 */
$req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=NULL WHERE PMAT_ENS_ID=".CURRENT_ID;
$conn->query($req);

/**
 * Affichage des groupes
 */
$groupe_courant = -1;
if (isset($_GET['bfmw_orig_g'])) {
    $groupe_courant = $_GET['bfmw_num_g'];
}
$etudiant_courant = -1;
if (isset($_GET['bfmw_orig_e'])) {
    $etudiant_courant = $_GET['bfmw_num_e'];
}

$groupe_courant = affectToBlocAndRepeat($template,"une_formation.un_groupe",Groupes::getGroupesDePoursuite(CURRENT_DEPT_ID),new Comparateur("GROUPE_ID",$groupe_courant),array(
    "une_formation" => array(-1,"FORM_ID")
));

affectToBlocAndRepeat($template,"un_etudiant",Etudiants::getEtudiantsGroupes($annee_courante,$groupe_courant));

$table = array(
    "GROUPE" => $groupe_courant,
    "ETUDIANT_ID" => $etudiant_courant,
    "SHOW" => $etudiant_courant != -1
);

affectToXHTML($template, $table);

    /**
     * Detail
     */
    if ($etudiant_courant != -1) {

        affectToXHTML($template,Etudiants::getEtudiantSimple($etudiant_courant)[0]);

        $les_fiches = Poursuites::getFiche($annee_courante,$etudiant_courant,CURRENT_DEPT_ID);
        foreach ($les_fiches as &$une_fiche) {
            if ($une_fiche['PMAT_MODE'] == "ENS" && $une_fiche["AVIS_ENS_ID"] != "") {
                $une_fiche["ENS_SAISISSEUR"] = Enseignants::getEnseigant($une_fiche["AVIS_ENS_ID"])[0]["ENS_NOM"];
            } else {
                $une_fiche["ENS_SAISISSEUR"] = "";
            }
            $une_fiche["AVIS_APPRECIATION"] = nl2br($une_fiche["AVIS_APPRECIATION"]);
        }
        affectToBlocAndRepeat($template,"une_ligne.un_enseignant",$les_fiches,null,array(
            "une_ligne" => array(-1,"PMAT_ID")
        ));
    }

    generateCompleteXHTML($template, "accueil");
