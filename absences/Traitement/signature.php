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

if (!isset($_SESSION['ACTIVE_ABSENCES_AUTO']) && !isset($_SESSION['ACTIVE_ABSENCES_PRO'])) {
    $send="?p=accueil";
    require 'refresh.php';
    exit;
}

$annee_courante = Annees::getIdAnneeCourante();


setAttachment($template, "signature", "signature.html");

affichageDesCreneaux($annee_courante, "common_absences_signatures", "0", "FORM_ABSENCES_AUTO=1 AND FORM_PRO=0", $template);

if (isset($_SESSION['ACTIVE_ABSENCES_PRO'])) {
    affichageDesCreneaux($annee_courante, "common_pro_signatures", "EDT_MASQUE", "FORM_PRO=1 AND GROUPE_PRO=1", $template);
}

generateCompleteXHTML($template, "signature");


function affichageDesCreneaux(int $annee_courante, string $table, string $masque,string $condition, Template &$template): void
{
    $les_cours = Signatures::getCreneauxDeCoursNonSignes(CURRENT_ID, $annee_courante, $table, $masque, $condition);

    //Extraction des identifiants des groupes concernés par le créneau
    $uid_precedent = -1;
    $les_groupes = array();
    foreach ($les_cours as $un_cours) {
        $les_groupes[$un_cours['EDT_UID']][] = $un_cours['GROUPE_ID'];
    }

    //Création des sélecteurs en fonction des groupes
    $les_composants = array();
    $deja_fait = array();
    foreach ($les_groupes as $uid => $un_ensemble_de_groupes) {
        $les_identifiants_string = implode(",", $un_ensemble_de_groupes);

        if (isset($deja_fait[$les_identifiants_string])) {
            $les_composants[$uid] = $deja_fait[$les_identifiants_string];
            continue;
        }

        $la_maquette = Formations::getMaquettePourEnseignant(CURRENT_ID, CURRENT_DEPT_ID, $annee_courante, "MAT_LOCK_ANNEE_ID<$annee_courante AND (FORM_ABSENCES_AUTO=1 OR FORM_PRO=1) AND  ", $les_identifiants_string);

        $template_composant = attachXHTML();
        setAttachment($template_composant, "signature", "template_selecteur_matieres.html");
        $nombreDeMatieres = 0;
        MatieresListView::generateListView($la_maquette, $template_composant, $annee_courante, "listview_template_module_open.html", "listview_template_module_close.html",
            function (array $uneMatiere) use (&$nombreDeMatieres) {
                $nombreDeMatieres++;
                $template1 = attachXHTML();
                setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
                affectToXHTML($template1, $uneMatiere);
                return generateCompleteXHTML($template1, "listview_template_matiere", true);
            }, function (array $un_element, int $annee_courante) {
                return Formations::getMatieresAffectees($un_element['UE_ID'], $un_element['MAT_ENS_ID'], $annee_courante);
            }, -1, "", "&nbsp;&nbsp;&nbsp;&nbsp;", true);
        if ($nombreDeMatieres > 0) {
            $les_composants[$uid] = generateCompleteXHTML($template_composant, "signature", true);
            $deja_fait[$les_identifiants_string] = $les_composants[$uid];
        }
    }

    //Construction de l'affichage
    foreach ($les_cours as $un_cours) {
        if ($uid_precedent != $un_cours['EDT_UID']) {
            $uid_precedent = $un_cours['EDT_UID'];
            $un_cours['DATE_DEBUT'] = date("j/m/Y", $un_cours['EDT_DATE_DEBUT']);
            $un_cours['HEURE_DEBUT'] = date("H:i", $un_cours['EDT_HEURE_DEBUT']);
            $un_cours['HEURE_FIN'] = date("H:i", $un_cours['EDT_HEURE_FIN']);
            $un_cours['COMPOSANT'] = $les_composants[$uid_precedent] ?? null;
            $nom = "";
            Groupes::getNomsParents($les_groupes[$uid_precedent], $nom);
            $un_cours['GROUPES'] = $nom;
            affectToBloc($template, "un_cours", $un_cours);
        }
    }
}