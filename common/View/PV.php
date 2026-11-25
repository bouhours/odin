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

class PV extends Connectable
{

    private static string $selon;

    public static function generatePV(int $annee_courante, string $prefixe, Template $template, int $groupe_id, string $tri_selon, int $formation_valide, string $semestre_a_afficher="SEM_ID")
    {
        self::$selon = $tri_selon;

        if (self::$selon == "AN".$annee_courante) {
            affectToXHTML($template, array(
                "TRI_SELON" => "vert"
            ));
        } else {
            affectToXHTML($template, array(
                "TRI_SELON" => ""
            ));
        }

        if (self::$selon == "NOM") {
            affectToXHTML($template, array(
                "TRI_SELON_NOM" => "vert"
            ));
        } else {
            affectToXHTML($template, array(
                "TRI_SELON_NOM" => ""
            ));
        }


        openBloc($template, "pv");
        $req = "SELECT * FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_ID = " . $groupe_id . " GROUP BY ET_ID ORDER BY ET_NOM";

        $etudiants_concernes = array();
        $res = self::$conn->query($req);
        $formation_en_cours = -1;
        $trieur = array();
        while ($etudiants = $res->fetch_assoc()) {
            $etudiants_concernes[$etudiants['ET_ID']] = $etudiants;
            $trieur[$etudiants['ET_ID']]["NOM"] = $etudiants["ET_NOM"];
            $formation_en_cours = $etudiants['GROUPE_FORM_ID'];
        }

        $req = "SELECT * FROM common_semestre,common_ue,common_matiere WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=$semestre_a_afficher AND MAT_CODE_APOGE <> '' AND UE_ID = MAT_UE_ID AND SEM_ID = UE_SEM_ID AND SEM_FORM_ID = $formation_en_cours ORDER BY SEM_NOM,UE_NOM,MAT_NOM";
        $res = self::$conn->query($req);
        $matieres_concernees = array();
        while ($une_data = $res->fetch_assoc()) {
            array_push($matieres_concernees, $une_data);
        }

        $sem_en_cours = -1;
        $ue_en_cours = -1;
        $mat_en_cours = -1;
        foreach ($matieres_concernees as $une_data) {
            if ($sem_en_cours != $une_data['SEM_ID']) {
                $sem_en_cours = $une_data['SEM_ID'];
                if (self::$selon == "SEM".$une_data['SEM_ID']) {
                    $une_data['TRI_SELON'] = "vert";
                } else {
                    $une_data['TRI_SELON'] = "";
                }
                affectToBloc($template, $prefixe."un_semestre", $une_data);
            }
            if ($ue_en_cours != $une_data['UE_ID']) {
                $ue_en_cours = $une_data['UE_ID'];
                if (self::$selon == "UE".$une_data['UE_ID']) {
                    $une_data['TRI_SELON'] = "vert";
                } else {
                    $une_data['TRI_SELON'] = "";
                }
                affectToBloc($template, $prefixe."un_semestre.une_ue", $une_data);
            }
            if ($mat_en_cours != $une_data['MAT_ID']) {
                $mat_en_cours = $une_data['MAT_ID'];
                if (self::$selon == "MAT".$une_data['MAT_ID']) {
                    $une_data['TRI_SELON'] = "vert";
                } else {
                    $une_data['TRI_SELON'] = "";
                }
                affectToBloc($template, $prefixe."un_semestre.une_ue.une_matiere", $une_data);
            }
        }

        /*$req = "SELECT *,ROUND(MOYAN_VALEUR,2) AS MOYAN_VALEUR FROM ".CURRENT_DEPT."_notes_moyennes_annee WHERE MOYAN_FORM_ID=$formation_valide AND MOYAN_ANNEE_ID=" . $annee_courante;
        $res = self::$conn->query($req);
        $moyan_concernees = array();
        while ($une_data = $res->fetch_assoc()) {
            if ($une_data['MOYAN_SPECIAL'] == 'ABI') {
                $une_data['MOYAN_VALEUR'] = "ABI";
            }
            if ($une_data['MOYAN_SPECIAL'] == 'ABJ' && $une_data['MOYAN_VALEUR']=="") {
                $une_data['MOYAN_VALEUR'] = "ABJ";
            }
            $moyan_concernees[$une_data['MOYAN_ET_ID']] = $une_data;
            $trieur[$une_data['MOYAN_ET_ID']]["AN$annee_courante"] = $une_data['MOYAN_VALEUR'];
        }*/

        /*$req = "SELECT *,ROUND(MOYSEM_VALEUR,2) AS MOYSEM_VALEUR FROM ".CURRENT_DEPT."_notes_moyennes_semestre WHERE MOYSEM_FORM_ID=$formation_valide AND MOYSEM_ANNEE_ID=" . $annee_courante;
        $res = self::$conn->query($req);
        $moysem_concernees = array();
        while ($une_data = $res->fetch_assoc()) {
            if ($une_data['MOYSEM_SPECIAL'] == 'ABI') {
                $une_data['MOYSEM_VALEUR'] = "ABI";
            }
            if ($une_data['MOYSEM_SPECIAL'] == 'ABJ' && $une_data['MOYSEM_VALEUR']=="") {
                $une_data['MOYSEM_VALEUR'] = "ABJ";
            }
            $moysem_concernees[$une_data['MOYSEM_ET_ID']][$une_data['MOYSEM_ID']] = $une_data;
            $trieur[$une_data['MOYSEM_ET_ID']]["SEM".$une_data['MOYSEM_ID']] = $une_data['MOYSEM_VALEUR'];
        }*/

        $req = "SELECT *,ROUND(MOYUE_VALEUR,2) AS MOYUE_VALEUR,ROUND(MOYUE_BARREE,2) AS MOYUE_BARREE FROM ".CURRENT_DEPT."_notes_moyennes_ue_meilleures WHERE MOYUE_FORM_ID=$formation_valide AND MOYUE_ANNEE_ID=" . $annee_courante;
        $res = self::$conn->query($req);
        $moyue_concernees = array();
        while ($une_data = $res->fetch_assoc()) {
            if ($une_data['MOYUE_SPECIAL'] == 'ABI') {
                $une_data['MOYUE_VALEUR'] = "ABI";
            }
            if ($une_data['MOYUE_SPECIAL'] == 'ABJ' && $une_data['MOYUE_VALEUR']=="") {
                $une_data['MOYUE_VALEUR'] = "ABJ";
            }
            $moyue_concernees[$une_data['MOYUE_ET_ID']][$une_data['MOYUE_SEM_ID']][$une_data['MOYUE_UE_ID']] = $une_data;
            $trieur[$une_data['MOYUE_ET_ID']]["UE".$une_data['MOYUE_UE_ID']] = $une_data['MOYUE_VALEUR'];
        }

        $req = "SELECT * FROM common_dispense_ue,common_ue WHERE UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND UE_ID=DISP_UE_ID AND DISP_ANNEE_ID=$annee_courante";
        $resDISP = self::$conn->query($req);
        $ue_dispensees = array();
        while ($une_dispense = $resDISP->fetch_assoc()) {
            $ue_dispensees[$une_dispense['UE_ID']][$une_dispense['DISP_ET_ID']]=1;
        }

        $req = "SELECT * FROM common_dispense_matieres,common_matiere WHERE MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=DISP_MAT_ID AND DISP_ANNEE_ID=$annee_courante";
        $resDISP = self::$conn->query($req);
        $mat_dispensees = array();
        while ($une_dispense = $resDISP->fetch_assoc()) {
            $mat_dispensees[$une_dispense['MAT_ID']][$une_dispense['DISP_ET_ID']]=1;
        }

        $req = "SELECT *,ROUND(MOYMAT_VALEUR,2) AS MOYMAT_VALEUR FROM ".CURRENT_DEPT."_notes_moyennes_export WHERE MOYMAT_FORM_ID=$formation_valide AND MOYMAT_ANNEE_ID=" . $annee_courante;
        $res = self::$conn->query($req);
        $moymat_concernees = array();
        while ($une_data = $res->fetch_assoc()) {
            if ($une_data['MOYMAT_SPECIAL'] == 'ABI') {
                $une_data['MOYMAT_VALEUR'] = "ABI";
            }
            if ($une_data['MOYMAT_SPECIAL'] == 'ABJ' && $une_data['MOYMAT_VALEUR']=="") {
                $une_data['MOYMAT_VALEUR'] = "ABJ";
            }
            $moymat_concernees[$une_data['MOYMAT_ET_ID']][$une_data['MOYMAT_SEM_ID']][$une_data['MOYMAT_UE_ID']][$une_data['MOYMAT_MAT_ID']] = $une_data;
            $trieur[$une_data['MOYMAT_ET_ID']]["MAT".$une_data['MOYMAT_MAT_ID']] = $une_data['MOYMAT_VALEUR'];
        }

        uasort($trieur, self::trierSelon(...));

        foreach ($trieur as $ET_ID => $unused) {
            if (array_key_exists($ET_ID, $etudiants_concernes)) {
                $un_etudiant = $etudiants_concernes[$ET_ID];

                $un_etudiant['MOYAN_VALEUR'] = "";
                /*if (array_key_exists($un_etudiant['ET_ID'], $moyan_concernees)) {
                    $un_etudiant['MOYAN_VALEUR'] = $moyan_concernees[$un_etudiant['ET_ID']]['MOYAN_VALEUR'];
                }*/

                affectToBloc($template, $prefixe."un_etudiant", $un_etudiant);

                $sem_en_cours = -1;
                $ue_en_cours = -1;
                $mat_en_cours = -1;
                foreach ($matieres_concernees as $une_data) {
                    if ($sem_en_cours != $une_data['SEM_ID']) {
                        $sem_en_cours = $une_data['SEM_ID'];
                        $data = array('MOYSEM_VALEUR' => "");
                        /*if (array_key_exists($un_etudiant['ET_ID'], $moysem_concernees) && array_key_exists($sem_en_cours, $moysem_concernees[$un_etudiant['ET_ID']])) {
                            $data = $moysem_concernees[$un_etudiant['ET_ID']][$sem_en_cours];
                        }*/

                        affectToBloc($template, $prefixe."un_etudiant.un_semestre", array_merge($data, $une_data));
                    }
                    if ($ue_en_cours != $une_data['UE_ID']) {
                        $ue_en_cours = $une_data['UE_ID'];
                        $data = array(
                            'MOYUE_VALEUR' => "",
                            'DISP' => false);
                        if (array_key_exists($un_etudiant['ET_ID'], $moyue_concernees) && array_key_exists($sem_en_cours, $moyue_concernees[$un_etudiant['ET_ID']]) && array_key_exists($ue_en_cours, $moyue_concernees[$un_etudiant['ET_ID']][$sem_en_cours])) {
                            $data = $moyue_concernees[$un_etudiant['ET_ID']][$sem_en_cours][$ue_en_cours];
                            $data['DISP'] = false;
                        }
                        if (isset($ue_dispensees[$ue_en_cours]) && isset($ue_dispensees[$ue_en_cours][$un_etudiant['ET_ID']])) {
                            $data['DISP'] = $ue_dispensees[$ue_en_cours][$un_etudiant['ET_ID']];
                        }
                        affectToBloc($template, $prefixe."un_etudiant.un_semestre.une_ue", array_merge($data, $une_data));
                    }
                    if ($mat_en_cours != $une_data['MAT_ID']) {
                        $mat_en_cours = $une_data['MAT_ID'];
                        $data = array(
                            'MOYMAT_VALEUR' => "",
                            'DISP' => false);
                        if (array_key_exists($un_etudiant['ET_ID'], $moymat_concernees) && array_key_exists($sem_en_cours, $moymat_concernees[$un_etudiant['ET_ID']]) && array_key_exists($ue_en_cours, $moymat_concernees[$un_etudiant['ET_ID']][$sem_en_cours]) && array_key_exists($mat_en_cours, $moymat_concernees[$un_etudiant['ET_ID']][$sem_en_cours][$ue_en_cours])) {
                            $data = $moymat_concernees[$un_etudiant['ET_ID']][$sem_en_cours][$ue_en_cours][$mat_en_cours];
                            $data['DISP'] = false;
                        }
                        if (isset($mat_dispensees[$mat_en_cours]) && isset($mat_dispensees[$mat_en_cours][$un_etudiant['ET_ID']])) {
                            $data['DISP'] = $mat_dispensees[$mat_en_cours][$un_etudiant['ET_ID']];
                        }
                        affectToBloc($template, $prefixe."un_etudiant.un_semestre.une_ue.une_matiere", array_merge($data, $une_data));
                    }
                }
            }
        }
    }

    public static function trierSelon($elem1,$elem2) {
        $selon = self::$selon;

        if (!isset($elem1[$selon]) && isset($elem2[$selon])) {
            return 1;
        }

        if (isset($elem1[$selon]) && !isset($elem2[$selon])) {
            return -1;
        }

        if (!isset($elem1[$selon]) && !isset($elem2[$selon])) {
            return 0;
        }

        if (floatval($elem1[$selon]) == 0 && floatval($elem2[$selon]) == 0) {
            if ($elem1[$selon] == $elem2[$selon]) {
                return 0;
            }

            return ($elem1[$selon] < $elem2[$selon]) ? -1 : 1;
        } else {
            if (floatval($elem1[$selon]) == floatval($elem2[$selon])) {
                return 0;
            }

            return (floatval($elem1[$selon]) > floatval($elem2[$selon])) ? -1 : 1;
        }
    }

}