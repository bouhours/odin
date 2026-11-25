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

if (!isRegistered()) {
    echo "Non autorisé";
    exit;
}

if (isset($_GET['bfmw_orig_itt'])) {
    unset($_SESSION['notes_chef']);
}

if (!Formations::isChef() && !Formations::isResponsable() && !Formations::isSecretaire()) {
    if (isset($_GET['bfmw_orig_chef']) || isset($_SESSION['notes_chef'])) {
        $send="p=accueil&amp;itt=sdmuj";
        require "refresh.php";
        exit;
    }
}

$acces_chef = false;
if ((isset($_GET['bfmw_orig_chef']) || isset($_SESSION['notes_chef']))) {
    $_SESSION['notes_chef'] = "toto";
    $acces_chef = true;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "accueil", "accueil.html");

$annee_courante = Annees::getIdAnneeCourante();
$les_annnes_non_closes = Annees::getAnneeNonClose();
$annee_multiples = count($les_annnes_non_closes) > 1;
if (isset($_GET['bfmw_num_a']) && ($acces_chef || $annee_multiples )) {
    $annee_courante = $_GET['bfmw_num_a'];
}

$formation_courante = -1;
if (isset($_GET['bfmw_num_f'])) {
    $formation_courante = $_GET['bfmw_num_f'];
}

$matiere_courante = -1;
if (isset($_GET['bfmw_num_m'])) {
    $matiere_courante = $_GET['bfmw_num_m'];
}

$controle_courante = -1;
if (isset($_GET['bfmw_num_c'])) {
    $controle_courante = $_GET['bfmw_num_c'];
}

if ($annee_multiples) {
    $annee_courante = affectToBlocAndRepeat($template,"une_annee",$les_annnes_non_closes,new Comparateur("ANNEE_ID",$annee_courante));
}

/**
 * Matières
 */
if ($acces_chef) {
    $formation_courante = affectToBlocAndRepeat($template, "une_formation", Formations::getFormationsDuConnecte(CURRENT_DEPT_ID,$annee_courante), new Comparateur("FORM_ID", $formation_courante));
} else {
    $formation_courante = affectToBlocAndRepeat($template, "une_formation", Formations::getFormationsDeLEnseignantConnecte(CURRENT_ID, $annee_courante, CURRENT_DEPT_ID, "ENS_MAT_NOTEUR=1 AND"), new Comparateur("FORM_ID", $formation_courante));
}

if ($acces_chef) {
    $la_maquette=Formations::getMaquetteSansMatiere(CURRENT_DEPT_ID,$annee_courante,"FORM_ID = $formation_courante AND");
} else {
    $la_maquette=Formations::getMaquettePourEnseignant(CURRENT_ID,CURRENT_DEPT_ID,$annee_courante,"FORM_ID=$formation_courante AND ENS_MAT_NOTEUR=1 AND");
}

affectToXHTML($template,array(
    "FORMATION_COURANTE" => $formation_courante,
    "ANNEE_COURANTE" => $annee_courante,
    "CHEF" => $acces_chef,
    "ANNEES_MULTIPLES" =>$annee_multiples,
    "CONTROLE_VALIDE" => 0,
    "HAS_MATIERE" => count($la_maquette) > 0
));

if (count($la_maquette) > 0) {

    $matiere_courante = MatieresListView::generateListView($la_maquette,$template,$annee_courante,"listview_template_module_open.html","listview_template_module_close.html",
        function(array $uneMatiere){
            $template1 = attachXHTML();
            setAttachment($template1, "listview_template_matiere", "listview_template_matiere.html");
            affectToXHTML($template1, $uneMatiere);
            return generateCompleteXHTML($template1,"listview_template_matiere",true);
        },function(array $un_element,int $annee_courante) {
            global $acces_chef;
            if ($acces_chef) {
                return Formations::getMatieresAvecRacine($un_element['UE_ID'], $annee_courante, "MAT_COPIE_MAT_ID IS NULL AND ");
            } else {
                return Formations::getMatieresAffectees($un_element['UE_ID'], CURRENT_ID, $annee_courante);
            }
        },$matiere_courante,"","&nbsp;&nbsp;",true);


    /**
     * Affichage des contrôles au brouillons
     */
    if (! $acces_chef) {
        $les_controles_au_brouillon = Controles::getControlesAuBrouillon($matiere_courante, $annee_courante, CURRENT_ID);
        if (count($les_controles_au_brouillon) > 0) {
            affectToBlocAndRepeat($template, "un_controle_brouillon", $les_controles_au_brouillon);
        } else {
            openBloc($template, "no_controle_brouillon");
        }
    }

    /**
     * Affichage des contrôles
     */

    $les_controles = Controles::getControlesDeChaqueEnseignantDeLaMatiere($matiere_courante,$annee_courante,$acces_chef);
    affectToBlocAndRepeat($template,"un_enseignant.un_controle",$les_controles,null,
        array("un_enseignant" => array("-1","ENS_ID"))
    );

    /**
     * Affichage du Detail
     */
    $laMatiere = Formations::getMatiere($matiere_courante);
    affectToXHTML($template,array(
            "SHOW" => -1,
            'MAT_LOCK' => ($laMatiere['MAT_LOCK_ANNEE_ID']??1000) >= $annee_courante ? "disabled" : "",
            'HAS_ONE' => Controles::getNombresControlesValidesDansMatiere($matiere_courante,$annee_courante) > 0,
            'MATIERE' => $matiere_courante
        )
    );


    if (isset($_GET['bfmw_orig_c']) && isset($_GET['bfmw_orig_m'])) {

        /**
         * Controles
         */
        $req = "SELECT * FROM common_controle,notes_access_enseignants, common_matiere WHERE MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND  MAT_ID=CONTROLE_MAT_ID AND ENS_ID = CONTROLE_ENS_ID AND (CONTROLE_VALIDE = 1 OR CONTROLE_ENS_ID=".CURRENT_ID.") AND CONTROLE_MAT_ID=$matiere_courante AND CONTROLE_ID=" . $_GET['bfmw_num_c'];
        $res = $conn->query($req);
        if ($res !== false) {
            if ($controle = $res->fetch_assoc()) {
                $ue_id = $controle['MAT_UE_ID'];
                $controle['OUI'] = ($controle['CONTROLE_MOYENNE'] == "1") ? "checked=\"checked\"" : "";
                $controle['NON'] = ($controle['CONTROLE_MOYENNE'] == "0") ? "checked=\"checked\"" : "";
                $controle['BONUS'] = ($controle['CONTROLE_MOYENNE'] == "2") ? "checked=\"checked\"" : "";
                $controle['VISIBLE'] = ($controle['CONTROLE_VISIBLE'] == "1") ? "checked=\"checked\"" : "";
                $controle['NONVISIBLE'] = ($controle['CONTROLE_VISIBLE'] == "0") ? "checked=\"checked\"" : "";

                affectToXHTML($template, $controle);

                $les_groupes = "0";
                $semestre_du_groupe = -1;

                /**
                 * Enseignants
                 */
                if ($acces_chef) {
                    affectToBlocAndRepeat($template, "un_enseignant_filtre", Enseignants::getEnseignantsDeLaMatiere($_GET['bfmw_orig_m'], $annee_courante, true), new Comparateur("ENS_ID", $controle["CONTROLE_ENS_ID"]));
                }

                /**
                 * Groupes
                 */
                $les_groupes_courants = Groupes::getGroupesPourUneMatiere($matiere_courante, $annee_courante);
                foreach ($les_groupes_courants as $groupe) {
                    $les_groupes .= "," . $groupe['GROUPE_ID'];
                    $semestre_du_groupe = $groupe['SEM_ID'];
                    affectToBloc($template, "un_groupe", $groupe);
                }

                affectToXHTML($template, array(
                        "SHOW" => count($les_groupes_courants)
                    )
                );

                /**
                 * Année
                 */
                $req = "SELECT * FROM common_annee WHERE ANNEE_CLOSE=0";
                $res = $conn->query($req);
                while ($une_annee = $res->fetch_assoc()) {
                    if ($une_annee['ANNEE_ID'] == $controle['CONTROLE_ANNEE_ID']) {
                        $une_annee['SELECTED'] = "selected";
                        $annee_courante = $une_annee['ANNEE_ID'];
                    } else {
                        $une_annee['SELECTED'] = "";
                    }
                    affectToBloc($template, "une_annee", $une_annee);
                }


                /**
                 * Etudiants
                 */
                $req = "SELECT * FROM ((`etudiants_groupes`, common_inscription) LEFT JOIN common_dispense_ue ON (ET_ID=DISP_ET_ID AND DISP_UE_ID=$ue_id AND DISP_ANNEE_ID=$annee_courante)) LEFT JOIN common_dispense_matieres ON (ET_ID=common_dispense_matieres.DISP_ET_ID AND DISP_MAT_ID=$matiere_courante AND common_dispense_matieres.DISP_ANNEE_ID=$annee_courante) LEFT JOIN common_notes ON (ET_ID=NOTES_ET_ID AND NOTES_CONTROLE_ID=" . $_GET['bfmw_num_c'] . ") WHERE INSCRIPT_ANNEE_ID=$annee_courante AND ET_ID=INSCRIPT_ET_ID AND INSCRIPT_SEM_ID=$semestre_du_groupe AND ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID IN (" . $les_groupes . ") AND GROUPE_DELETED=0 GROUP BY ET_NUMERO,GROUPE_ID ORDER BY ET_NOM";
                $res = $conn->query($req);
                $first = 0;
                $id_courant = -1;
                while ($etu = $res->fetch_assoc()) {
                    if ($id_courant != $etu['ET_ID']) {
                        $id_courant = $etu['ET_ID'];
                        $first++;
                    }

                    if ($etu['NOTES_ID'] == null) {
                        $etu['NOTES_ID'] = 'NULL';
                    }
                    if ($etu['NOTES_VALEUR'] == null) {
                        $etu['NOTES_VALEUR'] = $etu['NOTES_SPECIAL'];
                    }
                    $etu['ME'] = $first;
                    $etu['NEXT'] = $first + 1;
                    affectToBloc($template, "un_etudiant", $etu);
                }
            }
        }
    }
}
generateCompleteXHTML($template, "accueil");
