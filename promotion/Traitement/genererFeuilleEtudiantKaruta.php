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

if (isRegistered() && isset($_POST['bfmw_orig_g']) && isset($_POST['bfmw_orig_s']) && isset($_POST['bfmw_orig_annee']) && isset($_POST['bfmw_orig_codePortfolioModele']) && isset($_POST['bfmw_orig_codeProjet']) && isset($_GET['bfmw_orig_generate'])) {

    //Sortie
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="KARUTA_ETUDIANTS_COHORTE_'.$_POST['bfmw_orig_annee'].'.csv"');

    $annee_courante = Annees::getIdAnneeCourante();

    //Récupération des étudiants
    $les_etudiants = Etudiants::getEtudiantsParGroupesEtSemestres( $_POST['bfmw_num_g'],$_POST['bfmw_num_s'],$annee_courante);
    if (count($les_etudiants) == 0) {
        echo "Erreur - Groupe vide";
        exit;
    }

    //Variables globales
    echo "annee,main_project_code,model_code,libelleProjet,codeProjet,codePortfolioModele,nomGroupeEtudiant,nomGroupeEnseignant";
    echo "\n";
    echo $_POST["bfmw_orig_annee"].",";
    echo $_POST['bfmw_orig_codeProjet'].",";
    echo $_POST['bfmw_orig_codeProjet'].".batch-creation-usagers,";
    echo "Cohorte ".CURRENT_DEPT.",";
    echo "cohorte-".CURRENT_DEPT."-,";
    echo $_POST['bfmw_orig_codeProjet'].".".$_POST['bfmw_orig_codePortfolioModele'].",";
    echo "Etudiants-".CURRENT_DEPT."-,";
    echo "Enseignants-".CURRENT_DEPT;
    echo "\n";
    echo "identifiantEtudiant,prenomEtudiant,nomFamilleEtudiant,courrielEtudiant,motDePasseEtudiant,codeEtudiant";
    echo "\n";

    //Initialisation des requêtes
    foreach ($les_etudiants as $un_etudiant) {
        echo $un_etudiant["ET_MAIL"].",";
        if ($un_etudiant["ET_PRENOM"]=="") {
            echo $un_etudiant["ET_NOM"].",";
        } else {
            echo $un_etudiant["ET_PRENOM"].",";
        }
        if ($un_etudiant["ET_NOM_DE_FAMILLE"]=="") {
            echo $un_etudiant["ET_NOM"].",";
        } else {
            echo $un_etudiant["ET_NOM_DE_FAMILLE"].",";
        }
        echo $un_etudiant["ET_MAIL"].",";
        echo $un_etudiant["ET_MAIL"].",";
        echo $un_etudiant["ET_NUMERO"];
        echo "\n";
    }

    exit;
}

exit;
