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

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if ((Formations::isSecretaire() || Formations::isChef() || Formations::isResponsable() || isAdmin()) && isset($_GET['bfmw_orig_generate'])) {

    mysqli_report(MYSQLI_REPORT_ERROR);

    if (isset($_FILES['fichier']) && isset($_POST['bfmw_num_g'])) {
        try {
            $annee_courante = Annees::getIdAnneeCourante();
            $groupe_courant = $_POST['bfmw_num_g'];

            $fichier_extension = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));
            if ($fichier_extension != "xlsx") {
                exit;
            }

            $objSpreadsheet = IOFactory::load($_FILES['fichier']["tmp_name"]);
            $objSpreadsheet->setActiveSheetIndex(0);
            $feuille = $objSpreadsheet->getActiveSheet();
            if ($feuille->getTitle() != "\$¤\$") {
                die ("La page de configuration dans le fichier modèle n'a pas été trouvée.");
            }

            $colonne_minimum = Coordinate::columnIndexFromString($feuille->getCell("A1")->getValue());
            $colonne_maximum = Coordinate::columnIndexFromString($feuille->getCell("A2")->getValue());
            $ligne_minimum = $feuille->getCell("B1")->getValue();
            $ligne_maximum = $feuille->getCell("B2")->getValue();

            try {
                $objSpreadsheet->setActiveSheetIndex(1);
                $feuille = $objSpreadsheet->getActiveSheet();
            } catch (Exception $e) {
                die ("La page de poursuite dans le fichier modèle n'a pas été trouvée.");
            }

            $lesCasesAMettreAJour = [];

            for ($colonne = $colonne_minimum; $colonne <= $colonne_maximum; $colonne++) {
                for ($ligne = $ligne_minimum; $ligne <= $ligne_maximum; $ligne++) {
                    $valeur = $feuille->getCell(Coordinate::stringFromColumnIndex($colonne) . $ligne)->getValue();
                    if ($valeur == null) {
                        continue;
                    }
                    if (str_starts_with($valeur, "\$¤\$")) {
                        $lesCasesAMettreAJour[Coordinate::stringFromColumnIndex($colonne) . $ligne] = explode("_", $valeur);
                    }
                }
            }

            if (empty($lesCasesAMettreAJour)) {
                die ("Aucune case à remplacer n'a été trouvée.");
            }

            $lesEtudiantsConcernes = Poursuites::extractEtudiants($annee_courante,$groupe_courant);
            $feuille_courante = 1;
            $les_notes_extraites = [];

            foreach ($lesEtudiantsConcernes as $nom_groupe => $un_groupe) {
                foreach ($un_groupe as $une_categorie => $les_etudiants) {
                    foreach ($les_etudiants as $et_id => $un_etudiant) {
                        if ($et_id == "-1") {
                            continue;
                        }
                        $clonedWorksheet = clone $feuille;
                        $clonedWorksheet->setTitle(substr($un_etudiant["ET_NOM"],0,31),false,false);
                        $objSpreadsheet->addSheet($clonedWorksheet);
                        $objSpreadsheet->setActiveSheetIndex(++$feuille_courante);

                        foreach ($lesCasesAMettreAJour as $coordonnees => $formule) {
                            $cellule = $clonedWorksheet->getCell($coordonnees);
                            switch ($formule[0]) {
                                case "\$¤\$DATE" :
                                    $cellule->setValue(date("d/m/Y"));
                                    break;
                                case "\$¤\$NOMPRENOM" :
                                    $cellule->setValue($un_etudiant["ET_NOM"]);
                                    break;
                                case "\$¤\$NOM" :
                                    $cellule->setValue($un_etudiant["ET_NOM_DE_FAMILLE"]);
                                    break;
                                case "\$¤\$PRENOM" :
                                    $cellule->setValue($un_etudiant["ET_PRENOM"]);
                                    break;
                                case "\$¤\$BAC" :
                                    $cellule->setValue($un_etudiant["ET_BAC"]);
                                    break;
                                case "\$¤\$AVIS" :
                                    try {
                                        if ($un_groupe[$formule[1]][$un_etudiant['ET_ID']]["POURSUITE_AVIS"] == $formule[2]) {
                                            $cellule->setValue("X");
                                        } else {
                                            $cellule->setValue("");
                                        }

                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$NBAVIS" :
                                    try {
                                        $cellule->setValue($un_groupe[$formule[1]][-1][$formule[2]]);
                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$APPRECIATION" :
                                    try {
                                        $cellule->setValue(html_entity_decode($un_groupe[$formule[1]][$un_etudiant['ET_ID']]["POURSUITE_APPRECIATION_G"],ENT_QUOTES));
                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$MOYENNE" :
                                    try {
                                        $les_codes = [];
                                        foreach ($formule as $un_parametre) {
                                            if (! str_starts_with($un_parametre,"\$¤\$")) {
                                                $les_codes[] = $un_parametre;
                                            }
                                        }
                                        if (empty($les_codes)) {
                                            die("$coordonnees : Formule invalide");
                                        }

                                        if (! isset($les_notes_extraites[implode(",",$les_codes)])) {
                                            $les_notes_extraites[implode(",", $les_codes)] = extractMoyennes(implode(",", $les_codes), implode(",", array_keys($les_etudiants)), $annee_courante, CURRENT_DEPT);
                                        }

                                        $valeur = $les_notes_extraites[implode(",",$les_codes)]["CALCULEE"][$un_etudiant['ET_ID']]??null;
                                        if ($valeur == null) {
                                            $cellule->setValue('--');
                                        } else {
                                            $cellule->setValue(round($valeur,2)??'--');
                                        }
                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$MOYENNEPOND" :
                                    try {
                                        $les_codes = [];
                                        foreach ($formule as $un_parametre) {
                                            if (! str_starts_with($un_parametre,"\$¤\$")) {
                                                $les_codes[] = $un_parametre;
                                            }
                                        }
                                        if (empty($les_codes)) {
                                            die("$coordonnees : Formule invalide");
                                        }

                                        if (! isset($les_notes_extraites[implode(",",$les_codes)])) {
                                            $les_notes_extraites[implode(",", $les_codes)] = extractMoyennes(implode(",", $les_codes), implode(",", array_keys($les_etudiants)), $annee_courante, CURRENT_DEPT);
                                        }

                                        $valeur = $les_notes_extraites[implode(",",$les_codes)]["PONDEREE"][$un_etudiant['ET_ID']]??null;
                                        if ($valeur == null) {
                                            $cellule->setValue('--');
                                        } else {
                                            $cellule->setValue(round($valeur,2)??'--');
                                        }
                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$RANGPOND" :
                                    try {
                                        $les_codes = [];
                                        foreach ($formule as $un_parametre) {
                                            if (! str_starts_with($un_parametre,"\$¤\$")) {
                                                $les_codes[] = $un_parametre;
                                            }
                                        }
                                        if (empty($les_codes)) {
                                            die("$coordonnees : Formule invalide");
                                        }

                                        if (! isset($les_notes_extraites[implode(",",$les_codes)])) {
                                            $les_notes_extraites[implode(",", $les_codes)] = extractMoyennes(implode(",", $les_codes), implode(",", array_keys($les_etudiants)), $annee_courante, CURRENT_DEPT);
                                        }

                                        if (isset($les_notes_extraites[implode(",",$les_codes)]["RANG_PONDERE"])) {
                                            $valeur = $les_notes_extraites[implode(",", $les_codes)]["RANG_PONDERE"][$un_etudiant['ET_ID']] ?? "--";
                                            $valeur .= "/" . sizeof($les_notes_extraites[implode(",", $les_codes)]["RANG_PONDERE"]);
                                            $cellule->setValue($valeur ?? '--');
                                        } else {
                                            $cellule->setValue('--');
                                        }

                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$RANG" :
                                    try {
                                        $les_codes = [];
                                        foreach ($formule as $un_parametre) {
                                            if (! str_starts_with($un_parametre,"\$¤\$")) {
                                                $les_codes[] = $un_parametre;
                                            }
                                        }
                                        if (empty($les_codes)) {
                                            die("$coordonnees : Formule invalide");
                                        }

                                        if (! isset($les_notes_extraites[implode(",",$les_codes)])) {
                                            $les_notes_extraites[implode(",", $les_codes)] = extractMoyennes(implode(",", $les_codes), implode(",", array_keys($les_etudiants)), $annee_courante, CURRENT_DEPT);
                                        }

                                        if (isset($les_notes_extraites[implode(",",$les_codes)]["RANG_CALCULE"])) {
                                            $valeur = $les_notes_extraites[implode(",", $les_codes)]["RANG_CALCULE"][$un_etudiant['ET_ID']] ?? "--";
                                            $valeur .= "/" . sizeof($les_notes_extraites[implode(",", $les_codes)]["RANG_CALCULE"]);
                                            $cellule->setValue($valeur ?? '--');
                                        } else {
                                            $cellule->setValue('--');
                                        }
                                    } catch (Exception $e) {
                                        die("$coordonnees : Formule invalide");
                                    }
                                    break;
                                case "\$¤\$ABS" :
                                    $les_absencesNonJustif = Absences::getNombreDeDemiJourneesNonJustifiees($un_etudiant['ET_ID'],-1,"ABS_ENS_ID",$annee_courante+$formule[1]);
                                    $les_absencesJustif = Absences::getNombreDeDemiJourneesNonJustifiees($un_etudiant['ET_ID'],-1,"ABS_ENS_ID",$annee_courante+$formule[1],"",true);
                                    $total = $les_absencesJustif+$les_absencesNonJustif;
                                    $cellule->setValue("$total dont $les_absencesNonJustif ".($les_absencesNonJustif<2?"injustifiée":"injustifiées"));
                                    break;
                                case "\$¤\$INSCRIPTION" :
                                    $une_formation = Etudiants::getFormationInscrit($un_etudiant['ET_ID'],$annee_courante+$formule[1])[0]??null;
                                    $cellule->setValue($une_formation["FORM_NOM"]??'--');
                                    break;
                                case "\$¤\$ANNEE" :
                                    $une_annee = Annees::getAnneeWithId($annee_courante+$formule[1])[0]??null;
                                    $cellule->setValue($une_annee['ANNEE_NOM']??'--');
                                    break;
                                case "\$¤\$ANNEEFORM" :
                                    $une_formation = Etudiants::getFormationInscritFormation($un_etudiant['ET_ID'],$formule[1])[0]??null;
                                    $cellule->setValue($une_formation['ANNEE_NOM']??'--');
                                    break;
                                case "\$¤\$INSCRIPTIONFORM" :
                                    $une_formation = Etudiants::getFormationInscritFormation($un_etudiant['ET_ID'],$formule[1])[0]??null;
                                    $cellule->setValue($une_formation['FORM_NOM']??'--');
                                    break;
                                case "\$¤\$ABSFORM" :
                                    $une_formation = Etudiants::getFormationInscritFormation($un_etudiant['ET_ID'],$formule[1])[0]??null;
                                    $les_absencesNonJustif = Absences::getNombreDeDemiJourneesNonJustifiees($un_etudiant['ET_ID'],-1,"ABS_ENS_ID",$une_formation["ANNEE_ID"]??0);
                                    $les_absencesJustif = Absences::getNombreDeDemiJourneesNonJustifiees($un_etudiant['ET_ID'],-1,"ABS_ENS_ID",$une_formation["ANNEE_ID"]??0,"",true);
                                    $total = $les_absencesJustif+$les_absencesNonJustif;
                                    $cellule->setValue("$total dont $les_absencesNonJustif ".($les_absencesNonJustif<2?"injustifiée":"injustifiées"));
                                    break;
                            }
                        }
                    }
                    break;
                }
            }

            $objSpreadsheet->removeSheetByIndex(0);
            $objSpreadsheet->removeSheetByIndex(0);
            $objSpreadsheet->setActiveSheetIndex(0);
            //Sortie
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Fiches de poursuites d\'études.xlsx"');
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
            $objWriter->save('php://output');
            exit;
        } catch (Exception $e) {
            die("Erreur générale");
        }
    }
}
exit;

function extractMoyennes(string $les_codes, string $les_etudiants, int $annee_courante, string $dept_code) : array
{
    $retour = array();
    $les_moyennes = Moyennes::getValeurAPartirDeCodeApogee($les_codes,$les_etudiants, $annee_courante,$dept_code);
    $les_moyennes_calculees = [];
    $les_moyennes_ponderees = [];
    foreach($les_moyennes as $et_id => $un_ensemble) {
        $les_moyennes_calculees[$et_id] = Moyennes::computeMoyenne($un_ensemble);
        $les_moyennes_ponderees[$et_id] = Moyennes::computeMoyenne($un_ensemble,true);
    }
    arsort($les_moyennes_calculees);
    arsort($les_moyennes_ponderees);

    $retour["CALCULEE"] = $les_moyennes_calculees;
    $retour["PONDEREE"] = $les_moyennes_ponderees;

    $i=1;
    foreach ($les_moyennes_calculees as $et_id => $unused) {
        $retour["RANG_CALCULE"][$et_id] = $i++;
    }

    $i=1;
    foreach ($les_moyennes_ponderees as $et_id => $unused) {
        $retour["RANG_PONDERE"][$et_id] = $i++;
    }

    return $retour;
}