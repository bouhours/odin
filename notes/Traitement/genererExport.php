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

if ((Formations::isSecretaire() || isAdmin()) && isset($_GET['bfmw_orig_generate'])) {

    if (isset($_POST['bfmw_orig_export'])) {

        $annee_courante = Annees::getIdAnneeCourante();
        if (isset($_POST['bfmw_num_a'])) {
            $annee_courante = $_POST['bfmw_num_a'];
        }

        $data = file_get_contents($_FILES['fichier']["tmp_name"]);
        $fichier_extension = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));
        if ($fichier_extension != "txt") {
            if ($_POST['bfmw_num_f'] != "") {
                header('Location: ?p=export&a=' . $_POST['bfmw_num_a'] . '&f=' . $_POST['bfmw_num_f'] . '&cpl=&ttr=Impossible d\'exporter&mss=Le fichier chargé n\'est pas un fichier texte');
            } else {
                header('Location: ?p=export&a=' . $_POST['bfmw_num_a'] . '&s=' . $_POST['bfmw_num_s'] . '&cpl=&ttr=Impossible d\'exporter&mss=Le fichier chargé n\'est pas un fichier texte');
            }
            exit;
        }

        $req = "SELECT * FROM common_matiere WHERE MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID IN (" . $_POST['bfmw_orig_export'].")";
        $res = $conn->query($req);
        $les_matieres_disponibles = array();
        while ($une_matiere = $res->fetch_assoc()) {
            $les_matieres_disponibles[$une_matiere['MAT_CODE_APOGE']][] = $une_matiere;
        }


        $tabFinal = array();
        $tab = explode("\n", $data);
        $saisie = false;
        $firstLigneSaisie = false;
        $matiere_en_cours = array();
        $codes_en_cours = array();
        $matiere_invalide = false;
        $RES = false;
        foreach ($tab as $ligne) {
            foreach (array_keys($les_matieres_disponibles) as $code ) {
                if (strstr(strtolower($ligne), "\t".strtolower($code)) !== false) {
                    if (!isset($codes_en_cours[$code])) {
                        foreach ($les_matieres_disponibles[$code] as $une_matiere) {
                            $matiere_en_cours[] = $une_matiere["MAT_ID"];
                        }
                        $codes_en_cours[$code] = $code;
                    }
                }
            }
        }

        $decision_apogee = "";
        if (count($matiere_en_cours)>0) {
            $req = "SELECT FORM_CODE_APOGEE FROM common_matiere, common_ue, common_semestre, common_formation WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND UE_ID=MAT_UE_ID AND SEM_ID=UE_SEM_ID AND FORM_ID=SEM_FORM_ID AND MAT_ID IN (".implode(",",$matiere_en_cours).")";
            $res = $conn->query($req);
            if ($val = $res->fetch_assoc()) {
                $decision_apogee = $val['FORM_CODE_APOGEE'];
            }
        } else {
            $matiere_invalide = true;
        }

        if (!$matiere_invalide) {
            $req = "DELETE FROM common_notes WHERE NOTES_SPECIAL='ABJ'";
            $conn->query($req);

            $les_etudiants_dispenses = Formations::getExportDispense($annee_courante-1,implode(",", $matiere_en_cours));

            $req = "select MOYMAT_SPECIAL AS MOYMAT_REMONTEE,MOYMAT_VALEUR,ET_NUMERO, MOYMAT_ET_ID AS ET_ID, MOYMAT_MAT_ID, VALEUR_TO_EXPORT from " . CURRENT_DEPT . "_notes_moyennes_export WHERE MOYMAT_MAT_ID IN (" . implode(",", $matiere_en_cours) . ") AND MOYMAT_ANNEE_ID = $annee_courante ";
            $res = $conn->query($req);
            $etudiants_concernes_par_export = array();
            while ($unEtudiant = $res->fetch_assoc()) {
                $dispense = false;
                if (isset($les_etudiants_dispenses[$unEtudiant['ET_ID']])) {
                    $dispense = true;
                }

                if ($unEtudiant['MOYMAT_REMONTEE'] == "ABI") {
                    $etudiants_concernes_par_export[$unEtudiant['ET_NUMERO']][$unEtudiant['MOYMAT_MAT_ID']] = "ABI";
                } else {
                    if ($unEtudiant['MOYMAT_VALEUR'] == "" && $unEtudiant['MOYMAT_REMONTEE'] == "") {
                        $etudiants_concernes_par_export[$unEtudiant['ET_NUMERO']][$unEtudiant['MOYMAT_MAT_ID']] = $decision_apogee;
                    } else {
                        if ($unEtudiant['MOYMAT_VALEUR'] !== "" && is_numeric($unEtudiant['MOYMAT_VALEUR'])) {
                            $etudiants_concernes_par_export[$unEtudiant['ET_NUMERO']][$unEtudiant['MOYMAT_MAT_ID']] = ($dispense && isset($les_etudiants_dispenses[$unEtudiant['ET_ID']][$unEtudiant['MOYMAT_MAT_ID']])) ? round($les_etudiants_dispenses[$unEtudiant['ET_ID']][$unEtudiant['MOYMAT_MAT_ID']]['VALEUR_TO_EXPORT'], 2) : round($unEtudiant['VALEUR_TO_EXPORT'], 2);
                        } else {
                            $etudiants_concernes_par_export[$unEtudiant['ET_NUMERO']][$unEtudiant['MOYMAT_MAT_ID']] = $unEtudiant['MOYMAT_REMONTEE'];
                        }
                    }
                }

                if ($dispense) {
                    foreach ($les_etudiants_dispenses[$unEtudiant['ET_ID']] as $mat_id => $une_matiere) {
                        if (!isset($etudiants_concernes_par_export[$unEtudiant['ET_NUMERO']][$mat_id])) {
                            $etudiants_concernes_par_export[$unEtudiant['ET_NUMERO']][$mat_id] = $une_matiere['VALEUR_TO_EXPORT'];
                        }

                    }
                }
            }


            foreach ($tab as $ligne) {

                if (strcmp(trim($ligne), 'XX-APO_TYP_RES-XX') == 0) {
                    $RES = true;
                }
                if (strcmp(trim($ligne), 'XX-APO_COLONNES-XX') == 0) {
                    $RES = false;
                }

                if (!$RES) {
                    if (strcmp(trim($ligne), 'XX-APO_VALEURS-XX') == 0) {
                        $saisie = true;
                        $firstLigneSaisie = true;
                        $tabFinal[] = $ligne;
                    } else {
                        if ($saisie) {
                            if ($firstLigneSaisie) {
                                $tabFinal[] = $ligne;
                                $firstLigneSaisie = false;
                            } else {
                                if (strcmp($ligne, "") !== 0) {
                                    $ligne_etudiant_en_traitement = explode("\t", $ligne);
                                    if (array_key_exists($ligne_etudiant_en_traitement[0], $etudiants_concernes_par_export)) {
                                        $indice_courant = 3;
                                        foreach ($codes_en_cours as $code_a_traiter) {
                                            ++$indice_courant;
                                            $ligne_etudiant_en_traitement[$indice_courant] = $decision_apogee;
                                            $ligne_etudiant_en_traitement[$indice_courant + 1] = "";
                                            foreach ($les_matieres_disponibles[$code_a_traiter] as $une_matiere) {
                                                if (isset($etudiants_concernes_par_export[$ligne_etudiant_en_traitement[0]][$une_matiere["MAT_ID"]])) {
                                                    $note = $etudiants_concernes_par_export[$ligne_etudiant_en_traitement[0]][$une_matiere["MAT_ID"]];
                                                    $ligne_etudiant_en_traitement[$indice_courant] = $note;
                                                    $ligne_etudiant_en_traitement[$indice_courant + 1] = (is_numeric($note) ? 20 : "");
                                                }
                                            }
                                            ++$indice_courant;
                                        }
                                        $tabFinal[] = (implode("\t", $ligne_etudiant_en_traitement) . "\r");
                                    } else {
                                        $ligne_etudiant_en_traitement[4] = $decision_apogee;
                                        $ligne_etudiant_en_traitement[5] = "";
                                        $tabFinal[] = (implode("\t", $ligne_etudiant_en_traitement) . "\r");
                                    }
                                } else {
                                    $tabFinal[] = $ligne;
                                }
                            }
                        } else {
                            $tabFinal[] = $ligne;
                        }

                    }
                }

            }
            $result = implode("\n", $tabFinal);

            lockModulesEtMatieres($conn,$annee_courante,implode(",",$matiere_en_cours));
        } else {
            if ($_POST['bfmw_num_f'] != "") {
                header('Location: ?p=export&a='.$_POST['bfmw_num_a'].'&f='.$_POST['bfmw_num_f'].'&cpl=&ttr=Impossible d\'exporter&mss=Le fichier chargé ne concerne pas une des matières de cette formation');
            } else {
                header('Location: ?p=export&a='.$_POST['bfmw_num_a'].'&s='.$_POST['bfmw_num_s'].'&cpl=&ttr=Impossible d\'exporter&mss=Le fichier chargé ne concerne pas une des matières de ce semestre');
            }
            exit;
        }

        //Sortie
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment;filename="' . pathinfo($_FILES['fichier']['name'], PATHINFO_FILENAME) . '_ODIN.txt"');
        print_r($result);
        exit;
    }
}
exit;

function lockModulesEtMatieres(mysqli &$conn,$annee_courante,$MAT_ID){
    $req = "UPDATE common_matiere SET MAT_LOCK_ANNEE_ID=".$annee_courante." WHERE MAT_ID IN (".$MAT_ID.")";
    $conn->query($req);
    $req = "SELECT * from common_matiere WHERE MAT_SURMAT_ID IN (".$MAT_ID.")";
    $res = $conn->query($req);
    while ($une_matiere = $res->fetch_assoc()) {
        lockModulesEtMatieres($conn,$annee_courante,$une_matiere['MAT_ID']);
    }


}
