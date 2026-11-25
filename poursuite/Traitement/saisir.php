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

if (!isRegistered() || Formations::isSecretaire()) {
    echo "Non autorisé";
    exit;
}

$req = "SELECT * FROM poursuites_access_enseignants WHERE ENS_ID=".CURRENT_ID;
if ($conn->query($req)->num_rows == 0) {
    echo "Non autorisé.";
    exit;
}


if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

$annee_courante = Annees::getIdAnneeCourante();

setAttachment($template, "saisir", "saisir.html");

affectToXHTML($template,array(
    'MATIERE_ID' => isset($_GET['bfmw_num_m'])?$_GET['bfmw_num_m']:-1
));

/**
 * Groupes
 */
$req = "SELECT ET_ID,ET_NOM,GROUPE_ID,GROUPE_NOM, FORM_ID, FORM_NOM FROM  common_inscription, common_etudiant, common_groupes, common_etudiant_groupes, common_formation WHERE `odin`.`common_formation`.`FORM_ID` = `odin`.`common_groupes`.`GROUPE_FORM_ID` and `odin`.`common_etudiant`.`ET_ID` = `odin`.`common_inscription`.`INSCRIPT_ET_ID` and `odin`.`common_etudiant_groupes`.`ET_GROUPE_CODE` like concat(`odin`.`common_groupes`.`GROUPE_CODE`,'%') and `odin`.`common_etudiant_groupes`.`GROUPE_ET_ID` = `odin`.`common_etudiant`.`ET_ID` and `odin`.`common_inscription`.`INSCRIPT_ANNEE_ID` = `odin`.`common_etudiant_groupes`.`ET_GROUPE_ANNEE_ID` AND ET_GROUPE_ANNEE_ID=$annee_courante AND INSCRIPT_ANNEE_ID=$annee_courante AND ET_DEM = 0 AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND GROUPE_POURSUITE=1   GROUP BY GROUPE_ID ORDER BY FORM_NOM,GROUPE_CODE";
$res = $conn->query($req);
$formation_en_cours = -1;

if ($res->num_rows > 0) {
    while ($un_groupe = $res->fetch_assoc()) {
        $un_groupe['SELECTED'] = "";
        if ($formation_en_cours != $un_groupe['FORM_ID']) {
            $formation_en_cours = $un_groupe['FORM_ID'];
            affectToBloc($template, "une_formation", $un_groupe);
        }
        if (isset($_GET['bfmw_orig_g']) && $_GET['bfmw_num_g'] == $un_groupe['GROUPE_ID']) {
            $un_groupe['SELECTED'] = "selected";
        }

        affectToBloc($template, "une_formation.un_groupe", $un_groupe);
    }

    if (isset($_GET['bfmw_orig_g']) && $_GET['bfmw_num_g']!=-1) {
        affectToXHTML($template, array(
            'GROUPE_ID' => $_GET['bfmw_num_g'],
            'MATIERE_ID' => isset($_GET['bfmw_num_m']) ? $_GET['bfmw_num_m'] : -1
        ));

        /**
         * Matières
         */
        $req = "SELECT PMAT_NOM,PMAT_ID FROM poursuites_pmatieres WHERE ENS_ID=" . CURRENT_ID . " AND ENS_MAT_POURSUITE=1 GROUP BY PMAT_ID ORDER BY PMAT_NOM";
        $res = $conn->query($req);
        $les_matieres_de_poursuites = array();
        while ($une_matiere = $res->fetch_assoc()) {
            array_push($les_matieres_de_poursuites, $une_matiere);
        }

        $existe = false;
        if ($res->num_rows > 1) {
            openBloc($template, "open_matiere");
            foreach ($les_matieres_de_poursuites as $une_matiere) {
                if (isset($_GET['bfmw_orig_m']) && $_GET['bfmw_orig_m'] == $une_matiere['PMAT_ID']) {
                    $une_matiere['SELECTED'] = 'selected="selected"';
                    $existe = true;
                } else {
                    $une_matiere['SELECTED'] = "";
                }
                affectToBloc($template, "open_matiere.une_matiere", $une_matiere);
            }
        }

        if (!$existe && $res->num_rows > 0) {
            $_GET['bfmw_orig_m'] = $les_matieres_de_poursuites[0]['PMAT_ID'];
            $_GET['bfmw_num_m'] = get_numeric($les_matieres_de_poursuites[0]['PMAT_ID']);
        }

        if ($res->num_rows == 0) {
            unset($_GET['bfmw_orig_m']);
            unset($_GET['bfmw_num_m']);
        }

        if (isset($_GET['bfmw_orig_m'])) {


            $req = "SELECT PMAT_ID,PMAT_NOM, ENS_NOM FROM common_poursuite_matiere,common_enseignant WHERE PMAT_ID=" . $_GET['bfmw_num_m'] . " AND PMAT_ENS_ID <>" . CURRENT_ID . " AND ENS_ID=PMAT_ENS_ID";
            $res = $conn->query($req);
            if ($res->num_rows != 0) {
                openBloc($template, "locked");
                if ($data = $res->fetch_assoc()) {
                    affectToXHTML($template, $data);
                }
            } else {
                $req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=" . CURRENT_ID . " WHERE PMAT_ID=" . $_GET['bfmw_num_m'];
                $conn->query($req);

                openBloc($template, "unlocked");


                /**
                 * Matières dans matières de poursuite
                 */
                $les_matieres_de_pmatiere = array();
                $req = "SELECT * from common_poursuite_matiere_composition, common_matiere WHERE MAT_START_ANNEE_ID <= $annee_courante-1 AND (MAT_END_ANNEE_ID > $annee_courante-1 OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=PMAT_MAT_ID AND MAT_PMAT_ID=" . $_GET['bfmw_num_m'];
                $res = $conn->query($req);
                while ($une_matiere = $res->fetch_assoc()) {
                    $les_matieres_de_pmatiere[$une_matiere['MAT_ID']] = $une_matiere;
                }


                $req = "SELECT * FROM common_poursuite_niveau";
                $res = $conn->query($req);
                $les_niveaux = array();
                while ($niveau = $res->fetch_assoc()) {
                    affectToBloc($template, "unlocked.un_niveau", $niveau);
                    $les_niveaux[] = $niveau;
                }

                $req = "SELECT PMAT_ID,PMAT_NOM,NIVEAU, PMAT_PERSO, PMAT_MODE FROM common_poursuite_matiere LEFT JOIN common_poursuite_niveau_matiere ON (PMAT_ID=NIVEAU_PMAT_ID AND NIVEAU_ANNEE_ID=$annee_courante) WHERE PMAT_ID=" . $_GET['bfmw_num_m'];
                $annee = $conn->query($req)->fetch_assoc();
                $var_table = array(
                    "MATIERE_ID" => $_GET['bfmw_orig_m'],
                    "NOM_MATIERE" => $annee['PMAT_NOM'],
                    "NIVEAU_MATIERE" => $annee['NIVEAU'],
                    "PMAT_PERSO" => $annee['PMAT_PERSO'],
                    "CHECKED_ENS" => ($annee['PMAT_MODE']=="ENS"?"checked":""),
                    "CHECKED_ALL" => ($annee['PMAT_MODE']=="ALL"?"checked":""),
                    "CHECKED_PERSO" => ($annee['PMAT_MODE']=="PERSO"?"checked":"")
                );

                if (isset($_GET['bfmw_orig_o'])) {
                    switch ($_GET['bfmw_orig_o']) {
                        case "ET_NOM" :
                            $var_table["O1"] = "DESC";
                            break;
                        case "GROUPE_ID ,ET_NOM" :
                            $var_table["O2"] = "DESC";
                            break;
                        case "AVIS_NIVEAU ,ET_NOM" :
                            $var_table["O3"] = "DESC";
                            break;
                        case "AVIS_APPRECIATION ,ET_NOM" :
                            $var_table["O4"] = "DESC";
                            break;
                    }
                }

                $req = "SELECT MAT_ID, MAT_NOM, SEM_NOM FROM common_poursuite_matiere_composition, common_matiere, common_ue, common_semestre WHERE SEM_START_ANNEE_ID <= $annee_courante-1 AND (SEM_END_ANNEE_ID > $annee_courante-1 OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante-1 AND (UE_END_ANNEE_ID > $annee_courante-1 OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante-1 AND (MAT_END_ANNEE_ID > $annee_courante-1 OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=UE_SEM_ID AND UE_ID=MAT_UE_ID AND PMAT_MAT_ID=MAT_ID AND MAT_PMAT_ID = " . $_GET['bfmw_num_m'] . " GROUP BY MAT_ID ORDER BY SEM_NOM,MAT_NOM";
                $resMATIERES = $conn->query($req);
                $les_matieres_de_poursuites = array();
                while ($une_matiere = $resMATIERES->fetch_assoc()) {
                    array_push($les_matieres_de_poursuites, $une_matiere);
                }

                $req = "SELECT GROUPE_CODE FROM common_groupes WHERE GROUPE_ID=" . $_GET['bfmw_num_g'];
                $res = $conn->query($req);
                $un_groupe = $res->fetch_assoc()['GROUPE_CODE'];

                $req = "SELECT ET_NUMERO,ET_NOM,ET_ID,GROUPE_ID, ET_BAC, ET_RED, ET_TIERS, GROUPE_NOM, AVIS_NIVEAU, AVIS_APPRECIATION, CHOIX_ENS_ID FROM (etudiants_groupes left join common_poursuite_avis on (ET_ID = AVIS_ET_ID AND AVIS_PMAT_ID=" . $_GET['bfmw_num_m'] . " AND AVIS_ANNEE_ID=$annee_courante)) LEFT JOIN common_poursuite_choix_etudiant ON (ET_ID=CHOIX_ET_ID AND CHOIX_ANNEE_ID=$annee_courante AND CHOIX_PMAT_ID=".$_GET['bfmw_num_m'].") WHERE   ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_CODE LIKE '" . $un_groupe . "%'  AND GROUPE_FEUILLE=1 GROUP BY ET_ID ORDER BY " . (isset($_GET['bfmw_orig_o']) ? $_GET['bfmw_orig_o'] : "ET_NOM");
                $res = $conn->query($req);
                while ($un_etudiant = $res->fetch_assoc()) {

                    if ($un_etudiant['CHOIX_ENS_ID'] != CURRENT_ID && $un_etudiant['CHOIX_ENS_ID'] != "") {
                        continue;
                    }

                    affectToBloc($template, "unlocked.une_ligne", $un_etudiant);

                    $req = "SELECT COURS_ID AS MAT_ID,COURS_NOM AS MAT_NOM,COUNT(ABS_ID) AS TOTAL ,SUM(IF(ABS_JUSTIFICATION='non',1,0)) AS NB_ABS_NONJUSTIF FROM poursuites_absences WHERE ABS_ENS_ID=" . CURRENT_ID . " AND ABS_ET_ID=" . $un_etudiant['ET_ID'] . " GROUP BY COURS_ID";
                    $resABS = $conn->query($req);
                    while ($un_cours = $resABS->fetch_assoc()) {

                        $un_cours['TXT_ABS_NONJUSTIF'] = Absences::formatNonJustifiee($un_cours['NB_ABS_NONJUSTIF']);
                        affectToBloc($template, "unlocked.une_ligne.une_absence", $un_cours);
                        $un_cours['ANNEE_NOM'] = "2017-2018";
                        affectToBloc($template, "unlocked.une_ligne.une_absence.une_annee", $un_cours);
                    }

                    //$resABS = Absences::getAbsencesParMatieresParAnnees($un_etudiant['ET_ID'],implode(',', array_keys($les_matieres_de_pmatiere)),"MAT_ID, MAT_NOM, ABS_ANNEE_ID, ANNEE_NOM, COUNT(ABS_ID) AS TOTAL, SUM(IF(ABS_JUSTIFICATION='non',1,0)) AS NB_ABS_NONJUSTIF", "","GROUP BY ABS_ANNEE_ID, MAT_ID", "ORDER BY MAT_ID,ABS_ANNEE_ID");
                    $resABS = Absences::getAbsencesNewGen(-1,-1,"=".$un_etudiant['ET_ID'],"ENS_ID","MAT_ID IN (".implode(',', array_keys($les_matieres_de_pmatiere)).") AND ","GROUP BY MAT_ID,ANNEE_ID","","MAT_ID, MAT_NOM, ABS_ANNEE_ID, ANNEE_NOM, COUNT(ABS_ID) AS TOTAL, SUM(IF(ABS_JUSTIFICATION='non',1,0)) AS NB_ABS_NONJUSTIF",true);
                    $matiere_en_parcours = -1;
                    foreach ($resABS as $un_cours) {
                        if ($matiere_en_parcours != $un_cours['MAT_ID']) {
                            $matiere_en_parcours = $un_cours['MAT_ID'];
                            affectToBloc($template, "unlocked.une_ligne.une_absence", $un_cours);
                        }

                        $un_cours['TXT_ABS_NONJUSTIF'] = Absences::formatNonJustifiee($un_cours['NB_ABS_NONJUSTIF']);
                        affectToBloc($template, "unlocked.une_ligne.une_absence.une_annee", $un_cours);
                    }

                    foreach ($les_niveaux as $value) {
                        affectToBloc($template, "unlocked.une_ligne.un_niveau", $value);
                    }

                    foreach ($les_matieres_de_poursuites as $une_matiere) {
                        $req = "SELECT NOTES_VALEUR,NOTES_SPECIAL, NOTES_AVIS,CONTROLE_NOM, ANNEE_ID, ANNEE_NOM, ENS_NOM FROM common_controle,common_notes, common_annee, common_enseignant WHERE ENS_ID=CONTROLE_ENS_ID AND ANNEE_ID=CONTROLE_ANNEE_ID AND CONTROLE_ID = NOTES_CONTROLE_ID AND NOTES_ET_ID=" . $un_etudiant['ET_ID'] . " AND CONTROLE_MAT_ID=" . $une_matiere['MAT_ID'] . " ORDER BY ANNEE_ID,CONTROLE_NOM";
                        $resNOTES = $conn->query($req);

                        $req = "SELECT NOTES_VALEUR,NOTES_SPECIAL, NOTES_AVIS,CONTROLE_NOM, ANNEE_ID, ANNEE_NOM, ENS_NOM FROM common_controle,common_clotures_notes, common_annee, common_enseignant WHERE ENS_ID=CONTROLE_ENS_ID AND ANNEE_ID=CONTROLE_ANNEE_ID AND CONTROLE_ID = NOTES_CONTROLE_ID AND NOTES_ET_ID=" . $un_etudiant['ET_ID'] . " AND CONTROLE_MAT_ID=" . $une_matiere['MAT_ID'] . " ORDER BY ANNEE_ID,CONTROLE_NOM";
                        $resNOTES_CLOT = $conn->query($req);

                        if ($resNOTES->num_rows > 0 || $resNOTES_CLOT->num_rows > 0) {
                            $req = "SELECT MOYMAT_VALEUR,MOYMAT_ANNEE_ID FROM " . CURRENT_DEPT . "_notes_moyennes_matiere WHERE MOYMAT_ET_ID=" . $un_etudiant['ET_ID'] . " AND MOYMAT_MAT_ID=" . $une_matiere['MAT_ID'];
                            $resMOY = $conn->query($req);
                            $les_moyennes = array();
                            while ($MOYENNE = $resMOY->fetch_assoc()) {
                                $les_moyennes[$MOYENNE['MOYMAT_ANNEE_ID']] = round($MOYENNE['MOYMAT_VALEUR'], 2);
                            }

                            $req = "SELECT MOYMAT_VALEUR,MOYMAT_ANNEE_ID FROM common_clotures_moyennes_matiere WHERE MOYMAT_ET_ID=" . $un_etudiant['ET_ID'] . " AND MOYMAT_MAT_ID=" . $une_matiere['MAT_ID'];
                            $resMOY = $conn->query($req);
                            while ($MOYENNE = $resMOY->fetch_assoc()) {
                                $les_moyennes[$MOYENNE['MOYMAT_ANNEE_ID']] = round($MOYENNE['MOYMAT_VALEUR'], 2);
                            }
                            affectToBloc($template, "unlocked.une_ligne.une_matiere", $une_matiere);

                            afficherNotes($resNOTES_CLOT,  $les_moyennes, $template);
                            afficherNotes($resNOTES,  $les_moyennes, $template);
                        }
                    }
                }

                affectToXHTML($template, $var_table);
            }
        }
    }
    generateCompleteXHTML($template, "saisir");
}

function afficherNotes( mysqli_result $resNOTES, array &$les_moyennes,Template &$template): void
{
    $annee_en_parcours = -1;
    while ($un_controle = $resNOTES->fetch_assoc()) {
        if ($annee_en_parcours != $un_controle['ANNEE_ID']) {
            $annee_en_parcours = $un_controle['ANNEE_ID'];
            if (isset($les_moyennes[$un_controle['ANNEE_ID']])) {
                $un_controle['MOYENNE'] = $les_moyennes[$un_controle['ANNEE_ID']];
            } else {
                $un_controle['MOYENNE'] = "";
            }

            affectToBloc($template, "unlocked.une_ligne.une_matiere.une_annee", $un_controle);
        }
        $un_controle['NOTES'] = ($un_controle['NOTES_VALEUR'] == "" ? $un_controle['NOTES_SPECIAL'] : $un_controle['NOTES_VALEUR']);
        affectToBloc($template, "unlocked.une_ligne.une_matiere.une_annee.un_controle", $un_controle);
    }
}