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

class ReleveNotes extends Connectable
{
    private static function computeMoyennes(mysqli_result $resMOYENNES,array &$containerPrincipal,array &$resultatCALCUL,bool &$fail_ABI, &$rang,string $prefixe_colonnes,string $prefixe_affichage,int $parametre)
    {
        $moyenne_pour_rang = 0;

        while ($les_moyenne = $resMOYENNES->fetch_assoc()) {
            if ($les_moyenne[$prefixe_colonnes.'_ET_ID'] == $parametre) {
                if (! isset($les_moyenne[$prefixe_colonnes.'_DISPENSE'])) {
                    if ($les_moyenne[$prefixe_colonnes . '_VALEUR'] != "") {
                        $moyenne_pour_rang = $les_moyenne[$prefixe_colonnes . '_VALEUR'];
                        $containerPrincipal[$prefixe_affichage . '_NOTE'] = (($les_moyenne[$prefixe_colonnes . '_SPECIAL'] == "ABI") ? "ABI" : round($les_moyenne[$prefixe_colonnes . '_VALEUR'], 2));
                        $containerPrincipal[$prefixe_affichage . '_BARREE'] = isset($les_moyenne[$prefixe_colonnes . '_BARREE']) ? round($les_moyenne[$prefixe_colonnes . '_BARREE'], 2) : "";
                        if ($les_moyenne[$prefixe_colonnes . '_SPECIAL'] == "ABI") {
                            $fail_ABI = true;
                        } else {
                            $les_moyenne[$prefixe_colonnes . '_SPECIAL'] = "";
                        }
                    } else {
                        $containerPrincipal[$prefixe_affichage . '_NOTE'] = $les_moyenne[$prefixe_colonnes . '_SPECIAL'];
                        $fail_ABI = true;
                    }
                }

            }
            if ($les_moyenne[$prefixe_colonnes.'_SPECIAL'] != "ABI" && $les_moyenne[$prefixe_colonnes.'_SPECIAL'] != "ABJ") {
                array_push($resultatCALCUL, $les_moyenne[$prefixe_colonnes.'_VALEUR']);
            }

        }

        if (count($resultatCALCUL) > 0) {
            rsort($resultatCALCUL);
            $rang = array_search($moyenne_pour_rang, $resultatCALCUL);
            $containerPrincipal[$prefixe_affichage.'_MAX'] = $resultatCALCUL[0]==null?"":round($resultatCALCUL[0], 2);
            $containerPrincipal[$prefixe_affichage.'_MOY'] = round(array_sum($resultatCALCUL) / count($resultatCALCUL), 2);
            $containerPrincipal[$prefixe_affichage.'_MIN'] = round(array_pop($resultatCALCUL), 2);
            if (!$fail_ABI) {
                if ($rang === false) {
                    $containerPrincipal[$prefixe_affichage . '_RANK'] = "";
                } else {
                    switch ($rang + 1) {
                        case 1 :
                            $containerPrincipal[$prefixe_affichage . '_RANK'] = "<b>1</b>er";
                            break;
                        case 2 :
                            $containerPrincipal[$prefixe_affichage . '_RANK'] = "<b>2</b>nd";
                            break;
                        default :
                            $containerPrincipal[$prefixe_affichage . '_RANK'] = ("<b>" . ($rang + 1) . "</b>ième");
                            break;
                    }
                }
            }
        }
    }

    private static function afficherMoyennesDesMatieres(int $ET_ID,array $module, Template &$template,bool $controles,bool $clotures,int $anneeEnCours,string $prefixeTemplate, &$savedOut=0, int $semestreEnCours = -1)
    {
        $module['MAT_NOTE'] = "";
        $module['MAT_MIN'] = "";
        $module['MAT_MAX'] = "";
        $module['MAT_MOY'] = "";
        $module['MAT_RANK'] = "";

        if ($clotures) {
            if ($controles) {
                $req = "SELECT MOYMAT_ET_ID,MOYMAT_VALEUR,MOYMAT_SPECIAL FROM common_clotures_moyennes_matiere WHERE MOYMAT_ANNEE_ID=$anneeEnCours AND MOYMAT_MAT_ID=" . $module['MAT_ID'];
            } else {
                $req = "SELECT MOYMAT_ET_ID,MOYMAT_VALEUR,MOYMAT_SPECIAL FROM common_clotures_moyennes_surmatieres WHERE MOYMAT_ANNEE_ID=$anneeEnCours AND MOYMAT_MAT_ID=" . $module['MAT_ID'];
            }
        } else {
            if ($controles) {
                $req = "SELECT MOYMAT_ET_ID,MOYMAT_VALEUR,MOYMAT_SPECIAL,MOYMAT_DISPENSE FROM ".CURRENT_DEPT."_notes_moyennes_matiere WHERE MOYMAT_ANNEE_ID=$anneeEnCours AND MOYMAT_MAT_ID=" . $module['MAT_ID'];
            } else {
                $req = "SELECT MOYMAT_ET_ID,MOYMAT_VALEUR,MOYMAT_SPECIAL,MOYMAT_DISPENSE FROM ".CURRENT_DEPT."_notes_moyennes_surmatieres WHERE MOYMAT_ANNEE_ID=$anneeEnCours AND MOYMAT_MAT_ID=" . $module['MAT_ID'];
            }
        }

        $moduleCALCULEE = array();
        $resCALCULMATIERE = self::doRequete($req);
        $fail_ABI = false;
        self::computeMoyennes($resCALCULMATIERE, $module, $moduleCALCULEE, $fail_ABI, $rang, "MOYMAT","MAT", $ET_ID);
        affectToBloc($template, "$prefixeTemplate.releve.une_ue.un_module", $module);
        if ($savedOut !== 0) {
            $savedOut[$anneeEnCours][$semestreEnCours]["UE"][$module["MAT_UE_ID"]]["MAT"][$module["MAT_ID"]] = $module;
        }
        if ($controles) {
            self::afficherControles($ET_ID, $module['MAT_ID'], $template, $anneeEnCours, $clotures, $prefixeTemplate, $savedOut, $semestreEnCours, $module["MAT_UE_ID"],$module["MAT_ID"]);
        }
    }

    private static function afficherControles(int $ET_ID,int $MAT_ID,Template &$template,int $annee, bool $clotures = false, string $prefixeTemplate, &$savedOut = 0, int $semestreEnCours = -1, int $ueEnCours = -1, int $matiereEnCours = -1)
    {
        if (Etudiants::isDispense($ET_ID,$annee,$MAT_ID)) {
            return;
        }

        $suffixe_table = $clotures?"clotures_":"";

        //Liste des contrôles de la matière
        $la_matiere_copiee = Formations::getMatiereCopiee($MAT_ID);
        $la_clef_copiee[] = -1;
        if (count($la_matiere_copiee) > 0) {
            $la_clef_copiee = array_keys($la_matiere_copiee);
        }
        $req = "SELECT * FROM common_enseignant,common_controle LEFT JOIN (common_".$suffixe_table."notes) ON CONTROLE_ID=NOTES_CONTROLE_ID AND NOTES_ET_ID=" . $ET_ID . " WHERE (NOTES_VALEUR IS NOT NULL OR (NOTES_VALEUR IS NULL AND NOTES_SPECIAL IS NOT NULL)) AND (CONTROLE_MAT_ID=" . $MAT_ID . " OR CONTROLE_MAT_ID IN (".implode(",",$la_clef_copiee).")) AND CONTROLE_VALIDE = '1' AND CONTROLE_ANNEE_ID=$annee AND ENS_ID=CONTROLE_ENS_ID";
        $resNOTE = self::doRequete($req);
        while ($note = $resNOTE->fetch_assoc()) {

            $req = "SELECT NOTES_ID,MAX(NOTES_VALEUR) AS NOTE_MAXI,"
                . "MIN(NOTES_VALEUR) AS NOTE_MINI,"
                . "ROUND(AVG(NOTES_VALEUR),2) AS NOTE_MOY,"
                . "COUNT(*) AS NOTE_COUNT,"
                . "(SELECT FIND_IN_SET( NOTES_VALEUR, (SELECT GROUP_CONCAT(NOTES_VALEUR ORDER BY NOTES_VALEUR DESC ) FROM common_".$suffixe_table."notes WHERE NOTES_CONTROLE_ID=" . $note['CONTROLE_ID'] . " AND NOTES_VALEUR IS NOT NULL)) FROM common_".$suffixe_table."notes WHERE NOTES_CONTROLE_ID=" . $note['CONTROLE_ID'] . " AND NOTES_ET_ID=" . $ET_ID . " AND NOTES_VALEUR IS NOT NULL) AS NOTE_RANK "
                . "FROM common_".$suffixe_table."notes WHERE NOTES_CONTROLE_ID=" . $note['CONTROLE_ID'] . " AND (NOTES_VALEUR IS NOT NULL OR (NOTES_VALEUR IS NULL AND NOTES_SPECIAL IS NOT NULL))";
            $resNOTEcalculee = self::doRequete($req);

            if ($noteCALCULEE = $resNOTEcalculee->fetch_assoc()) {
                if ($noteCALCULEE['NOTE_RANK'] != "") {
                    $noteCALCULEE['NOTE_RANK'] = "<b>".$noteCALCULEE['NOTE_RANK']. "</b>/" . $noteCALCULEE['NOTE_COUNT'];
                }
                $note = array_merge($noteCALCULEE, $note);
            }

            if ($note['CONTROLE_MOYENNE'] == '2') {
                $note['CONTROLE_COEFF'] = "";
            }
            $note['NOTES_AFFICHE'] = $note['NOTES_VALEUR'] == "" ? "" : $note['NOTES_VALEUR'];

            affectToBloc($template, "$prefixeTemplate.releve.une_ue.un_module.une_note", $note);
            if ($savedOut !== 0) {
                $savedOut[$annee][$semestreEnCours]["UE"][$ueEnCours]["MAT"][$matiereEnCours]['CONTROLES'][] = $note;
            }

            if ($note['CONTROLE_MOYENNE'] != '0') {
                openBloc($template, "$prefixeTemplate.releve.une_ue.un_module.une_note.moyenne");
            }
            if ($note['CONTROLE_VISIBLE'] != '1') {
                openBloc($template, "$prefixeTemplate.releve.une_ue.un_module.une_note.nonvisible");
            }
        }
    }

    public static function genererMoyennesSemestre(mysqli_result $resSEMESTRE,Template &$template,int $param_etudiant,string $prefixeTemplate,&$savedOut=0)
    {
        while ($semestre = $resSEMESTRE->fetch_assoc()) {

            $semestre['GENERAL_NOTE'] = "";
            $semestre['GENERAL_MIN'] = "";
            $semestre['GENERAL_MAX'] = "";
            $semestre['GENERAL_MOY'] = "";
            $semestre['GENERAL_RANK'] = "";

            $annee_du_semestre = $semestre['INSCRIPT_ANNEE_ID'];
            $clotures = false;

            $req = "SELECT * FROM ".CURRENT_DEPT."_notes_moyennes_semestre WHERE MOYSEM_ID = " . $semestre['SEM_ID'] . " AND MOYSEM_ANNEE_ID=$annee_du_semestre";

            $resCALCULSEM = self::doRequete($req);
            if ($resCALCULSEM->num_rows === 0) {
                $req = "SELECT * FROM common_clotures_moyennes_semestre WHERE MOYSEM_ID = " . $semestre['SEM_ID'] . " AND MOYSEM_ANNEE_ID=$annee_du_semestre";
                $resCALCULSEM = self::doRequete($req);
                if ($resCALCULSEM->num_rows > 0) {
                    $clotures = true;
                }
            }
            $semCALCULE = array();

            $fail_ABI = false;
            self::computeMoyennes($resCALCULSEM, $semestre, $semCALCULE, $fail_ABI, $rang, "MOYSEM", "GENERAL", $param_etudiant);
            affectToBloc($template, "$prefixeTemplate.releve", $semestre);
            if ($savedOut !== 0) {
                $savedOut[$annee_du_semestre][$semestre['SEM_ID']] = $semestre;
            }

            //Liste des ue
            $req = "SELECT * FROM common_ue WHERE UE_START_ANNEE_ID <= $annee_du_semestre AND (UE_END_ANNEE_ID > $annee_du_semestre OR UE_END_ANNEE_ID IS NULL) AND UE_SEM_ID = " . $semestre['SEM_ID'] . " AND UE_COEF > 0 ORDER BY UE_ORDRE";
            $resUE = self::doRequete($req);
            while ($ue = $resUE->fetch_assoc()) {

                $ue['UE_NOTE'] = "";
                $ue['UE_BARREE'] = "";
                $ue['UE_MIN'] = "";
                $ue['UE_MAX'] = "";
                $ue['UE_MOY'] = "";
                $ue['UE_RANK'] = "";

                if ($clotures) {
                    $req = "SELECT * FROM common_clotures_moyennes_ue WHERE MOYUE_ANNEE_ID=$annee_du_semestre AND MOYUE_UE_ID = " . $ue['UE_ID'];
                } else {
                    $req = "SELECT * FROM ".CURRENT_DEPT."_notes_moyennes_ue_meilleures WHERE MOYUE_ANNEE_ID=$annee_du_semestre AND MOYUE_UE_ID = " . $ue['UE_ID'];
                }

                $ueCALCULE = array();
                $resCALCULUE = self::doRequete($req);
                $fail_ABI = false;
                self::computeMoyennes($resCALCULUE, $ue, $ueCALCULE, $fail_ABI, $rang, "MOYUE", "UE", $param_etudiant);
                affectToBloc($template, "$prefixeTemplate.releve.une_ue", $ue);
                if ($savedOut !== 0) {
                    $savedOut[$annee_du_semestre][$semestre['SEM_ID']]["UE"][$ue["UE_ID"]] = $ue;
                }

                //Liste des matières
                $req = "SELECT common_matiere.* FROM common_matiere LEFT JOIN common_enseignants_matieres ON (MAT_ID=ENS_MAT_ID AND ENS_MAT_ANNEE_ID=$annee_du_semestre) WHERE MAT_START_ANNEE_ID <= $annee_du_semestre AND (MAT_END_ANNEE_ID > $annee_du_semestre OR MAT_END_ANNEE_ID IS NULL) AND MAT_UE_ID=" . $ue['UE_ID'] . " AND MAT_SURMAT_ID IS NULL AND (ENS_MAT_NOTEUR=1 OR ENS_MAT_NOTEUR IS NULL) GROUP BY MAT_ID ORDER BY MAT_ORDRE";
                $resMOD = self::doRequete($req);
                while ($module = $resMOD->fetch_assoc()) {
                    self::hierarchieMatieres($param_etudiant,$module,$template,$clotures,$annee_du_semestre,$prefixeTemplate,$savedOut,$semestre['SEM_ID']);
                }
            }
        }
    }

    private static function hierarchieMatieres(int $param_etudiant,array $module, Template &$template,bool $clotures,int $annee_du_semestre,string $prefixeTemplate, &$savedOut=0, int $semestre = -1,$profondeur=""){
        if ($module['MAT_HAS_NOTE'] == 0) {
            self::afficherMoyennesDesMatieres($param_etudiant, $module, $template, false, $clotures, $annee_du_semestre,$prefixeTemplate, $savedOut,$semestre);
            $mat_a_traiter = $module['MAT_ID'];
            $req = "SELECT common_matiere.* FROM common_matiere LEFT JOIN common_enseignants_matieres ON (MAT_ID=ENS_MAT_ID AND ENS_MAT_ANNEE_ID=$annee_du_semestre) WHERE MAT_START_ANNEE_ID <= $annee_du_semestre AND (MAT_END_ANNEE_ID > $annee_du_semestre OR MAT_END_ANNEE_ID IS NULL) AND MAT_SURMAT_ID=$mat_a_traiter AND (ENS_MAT_NOTEUR=1 OR ENS_MAT_NOTEUR IS NULL) GROUP BY MAT_ID";
            $resSURMAT = self::doRequete($req);
            while ($ssmodule = $resSURMAT->fetch_assoc()) {
                $ssmodule['MAT_NOM'] = $profondeur.$ssmodule['MAT_NOM'];
                self::hierarchieMatieres($param_etudiant,$ssmodule,$template,$clotures,$annee_du_semestre,$prefixeTemplate,$savedOut,$semestre,$profondeur. "&nbsp;&nbsp;&nbsp;");
            }
        } else {
            $module['MAT_SUR_NOM'] = "";
            self::afficherMoyennesDesMatieres($param_etudiant, $module, $template, true, $clotures, $annee_du_semestre,$prefixeTemplate, $savedOut,$semestre);
        }
    }
}