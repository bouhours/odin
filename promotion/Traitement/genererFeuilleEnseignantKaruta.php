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

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {

    //Sortie
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="KARUTA_ENSEIGNANTS.csv"');


    //Récupération des enseignants
    $les_enseignants = Enseignants::getEnseignantsDuDepartement(CURRENT_DEPT_ID,CURRENT_ID);
    if (count($les_enseignants) == 0) {
        echo "Erreur - Pas d'enseignant";
        exit;
    }

    //Variables globales
    echo "model_code,NomDuGroupe";
    echo "\n";
    echo "projet_".CURRENT_DEPT.".batch-creation-enseignant,";
    echo "Enseignants-".CURRENT_DEPT;
    echo "\n";
    echo "identifiantEnseignant,prenomEnseignant,nomFamilleEnseignant,courrielEnseignant,motDePasseEnseignant";
    echo "\n";

    //Initialisation des requêtes
    foreach ($les_enseignants as $un_enseignant) {
        if ($un_enseignant["ENS_MAIL"] == "") {
            continue;
        }
        echo $un_enseignant["ENS_MAIL"].",";
        if ($un_enseignant["ENS_PRENOM"]=="") {
            echo $un_enseignant["ENS_NOM"].",";
        } else {
            echo $un_enseignant["ENS_PRENOM"].",";
        }
        if ($un_enseignant["ENS_NOM_DE_FAMILLE"]=="") {
            echo $un_enseignant["ENS_NOM"].",";
        } else {
            echo $un_enseignant["ENS_NOM_DE_FAMILLE"].",";
        }
        echo $un_enseignant["ENS_MAIL"].",";
        echo $un_enseignant["ENS_MAIL"];
        echo "\n";
    }

    exit;
}

exit;
