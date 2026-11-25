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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

if ((Formations::isMediateur() || Formations::isSecretaire() || Formations::isResponsable()) && isset($_GET['bfmw_orig_generate']) && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_orig_matiere']) && isset($_POST['bfmw_num_groupe'])) {

    $annee_courante = Annees::getIdAnneeCourante();
    if (isset($_POST['bfmw_num_a'])) {
        $annee_courante = $_POST['bfmw_num_a'];
    }


    $formations_autorisees = Formations::getFormationsDuConnecteString();

    /**
     * Collecte des étudiants en base
     */
    $lesEtudiantsConcernes = Etudiants::getEtudiantsDuResponsable($formations_autorisees,$annee_courante,CURRENT_ID,$_POST['bfmw_num_groupe']);
    foreach ($lesEtudiantsConcernes as &$unEtudiantA) {
        $is_groupe_feuille = $unEtudiantA['GROUPE_FEUILLE'];
        $code_groupe_selectionne = $unEtudiantA['GROUPE_CODE'];
        $unEtudiantA['BILAN_MATIERES'] = array();
        $unEtudiantA['NB_ABS'] = 0;
        $lesEtudiantsConcernes[$unEtudiantA['ET_ID']]['NB_ABS'] = Absences::getNombreDeDemiJourneesNonJustifiees($unEtudiantA['ET_ID']);
        $nom_groupe = $unEtudiantA['GROUPE_NOM'];
    }

    /**
     * Mise à jour des étudiants avec les groupes feuilles
     */
    if ($is_groupe_feuille == 0) {
        $les_groupes_feuilles = Groupes::getGroupeFeuille($code_groupe_selectionne,$annee_courante);
        foreach ($les_groupes_feuilles as $unEtudiant) {
            if (isset($lesEtudiantsConcernes[$unEtudiant['ET_ID']])) {
                $lesEtudiantsConcernes[$unEtudiant['ET_ID']]['GROUPE_ID'] = $unEtudiant['GROUPE_ID'];
                $lesEtudiantsConcernes[$unEtudiant['ET_ID']]['GROUPE_NOM'] = $unEtudiant['GROUPE_NOM'];
                $lesEtudiantsConcernes[$unEtudiant['ET_ID']]['GROUPE_CODE'] = $unEtudiant['GROUPE_CODE'];
            }
        }
    }


    /**
     * Collecte des matières en base
     */
    $toutes_les_matieres = array();
    $les_matieres = Moyennes::getMoyennesMatieresUnionSurMatieres(CURRENT_DEPT,$annee_courante);
    foreach ($_POST['bfmw_orig_matiere'] as $une_matiere) {
        foreach ($les_matieres as &$uneMatiereA) {
            if ($uneMatiereA['MOYMAT_MAT_ID'] != $une_matiere) {
                continue;
            }
            $uneMatiereA['MOYMAT_COEF'] = $_POST['bfmw_orig_coeff_' . $une_matiere];
            $toutes_les_matieres[$uneMatiereA['MOYMAT_MAT_ID']] = $uneMatiereA;
            if (isset($lesEtudiantsConcernes[$uneMatiereA['MOYMAT_ET_ID']])) {
                $lesEtudiantsConcernes[$uneMatiereA['MOYMAT_ET_ID']]['BILAN_MATIERES'][$uneMatiereA['MOYMAT_UE_ID']]['MATIERES'][$une_matiere] = $uneMatiereA;
                $lesEtudiantsConcernes[$uneMatiereA['MOYMAT_ET_ID']]['BILAN_MATIERES'][$uneMatiereA['MOYMAT_UE_ID']]['UE_NOM'] = $uneMatiereA['UE_NOM'];
            }
        }
    }


    /**
     * Calcul des moyennes intermédiaires
     */
    foreach ($lesEtudiantsConcernes as $id_etudiant => $etudiant) {
        $bilansommeprod = 0;
        $bilansommecoef = 0;
        foreach ($etudiant['BILAN_MATIERES'] as $id_ue => $ue) {
            $sommeprod = 0;
            $sommecoef = 0;
            foreach ($ue['MATIERES'] as $id_matiere => $matiere) {
                $sommeprod += ($matiere['MOYMAT_VALEUR'] * $matiere['MOYMAT_COEF']);
                $sommecoef += $matiere['MOYMAT_COEF'];
            }
            $moyenne_a_ue = $sommeprod / ($sommecoef == 0 ? 1 : $sommecoef);
            $lesEtudiantsConcernes[$id_etudiant]['BILAN_MATIERES'][$id_ue]['UE_VALEUR'] = round($moyenne_a_ue, 2);
            if ($_POST['bfmw_orig_ue_coeff_' . $id_ue] != "auto") {
                $sommecoef = $_POST['bfmw_orig_ue_coeff_' . $id_ue];
            }
            $lesEtudiantsConcernes[$id_etudiant]['BILAN_MATIERES'][$id_ue]['UE_COEF'] = $sommecoef;
            $bilansommeprod += $moyenne_a_ue * $sommecoef;
            $bilansommecoef += $sommecoef;
        }
        $moyenne_a_afficher = round($bilansommeprod / ($bilansommecoef == 0 ? 1 : $bilansommecoef), 2);
        $lesEtudiantsConcernes[$id_etudiant]['BILAN_MOYENNE'] = ($moyenne_a_afficher == 0 ? "???" : $moyenne_a_afficher);
    }

    //Initialisation de PhpExcel
    $objSpreadsheet = new Spreadsheet();
    $objSpreadsheet->setActiveSheetIndex(0);
    $feuille = $objSpreadsheet->getActiveSheet();

    //Initialisation des requêtes
    $colonnes = 1;
    $lignes = 1;

    /**
     * Tri du tableau
     */
    $tri = "";
    switch ($_POST['bfmw_orig_tri']) {
        case "alpha" :
            uasort($lesEtudiantsConcernes, "triAlpha");
            $tri = "Tri alphabétique";
            break;
        case "groupe" :
            uasort($lesEtudiantsConcernes, "triGroupes");
            $tri = "Tri par groupe";
            break;
        default :
            uasort($lesEtudiantsConcernes, "triMoyenne");
            $tri = "Tri par moyenne";
            break;
    }
    $feuille->setCellValue([$colonnes, $lignes], "BILAN DU " . date("d/m/Y") . "\nGROUPE $nom_groupe\n$tri");
    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true
        ),
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial Black"
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));
    $feuille->getCell([$colonnes + 1, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true
        ),
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial Black"
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));
    $feuille->getCell([$colonnes + 2, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true
        ),
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial Black"
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));
    $feuille->getCell([$colonnes + 3, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true
        ),
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial Black"
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));
    $feuille->getCell([$colonnes + 4, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true
        ),
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial Black"
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));

    $feuille->setCellValue([$colonnes++, $lignes + 1], "BAC")->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'BFBFBF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    $feuille->setCellValue([$colonnes++, $lignes + 1], "GROUPE")->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'BFBFBF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    $feuille->setCellValue([$colonnes++, $lignes + 1], "ABS")->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'BFBFBF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    $feuille->setCellValue([$colonnes++, $lignes + 1], "NOM")->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'BFBFBF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_LEFT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    $feuille->setCellValue([$colonnes++, $lignes + 1], "")->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'BFBFBF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_LEFT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    $feuille->setCellValue([$colonnes++, $lignes], "MOYENNE");
    $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'CCFFFF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));
    $feuille->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'CCFFFF')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        )
    ));

    /**
     * Génération des lignes
     */
    $ue_en_cours = -1;
    foreach ($toutes_les_matieres as $id_matiere => $matiere) {
        if ($ue_en_cours != $matiere['MOYMAT_UE_ID']) {
            //Nom de l'UE
            $feuille->setCellValue([$colonnes++, $lignes], $matiere['UE_NOM']);
            $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FF8080')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'left' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));
            $ue_en_cours = $matiere['MOYMAT_UE_ID'];
            $coef = 0;
            if ($_POST['bfmw_orig_ue_coeff_' . $ue_en_cours] != "auto") {
                $coef = $_POST['bfmw_orig_ue_coeff_' . $ue_en_cours];
            } else {
                foreach ($toutes_les_matieres as $id_matiere2 => $matiere2) {
                    if ($matiere2['MOYMAT_UE_ID'] == $ue_en_cours) {
                        $coef += $matiere2['MOYMAT_COEF'];
                    }
                }
            }
            //Coef de l'UE
            $feuille->setCellValue([$colonnes - 1, $lignes + 1], "coef : " . $coef);
            $feuille->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FF8080')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'left' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));
        }
        // Nom de la matière
        $feuille->setCellValue([$colonnes++, $lignes], $matiere['MAT_NOM']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'CCFFCC')
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'wrapText' => true,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));

        //Coeff de la matière
        $feuille->setCellValue([$colonnes - 1, $lignes + 1], "coef : " . $matiere['MOYMAT_COEF']);
        $feuille->getCell([$colonnes - 1, $lignes + 1])->getStyle()->applyFromArray(array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'CCFFCC')
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));
    }

    $lignes++;

    foreach ($lesEtudiantsConcernes as $id_etudiant => $etudiant) {
        $colonnes = 1;
        $une_ligne = array();
        //Bac de l'étudiant
        $feuille->setCellValue([$colonnes++, ++$lignes], $etudiant['ET_BAC']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            )
        ));
        //Groupe de l'étudiant
        $feuille->setCellValue([$colonnes++, $lignes], $etudiant['GROUPE_NOM']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            )
        ));
        //Absences de l'étudiant
        $feuille->setCellValue([$colonnes++, $lignes], $etudiant['NB_ABS']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            )
        ));
        //Nom de l'étudiant
        $feuille->setCellValue([$colonnes++, $lignes], $etudiant['ET_NOM']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            )
        ));
        //Redoublant
        $feuille->setCellValue([$colonnes++, $lignes], $etudiant['ET_RED']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            )
        ));
        //Moyenne de l'étudiant
        $feuille->setCellValue([$colonnes++, $lignes], $etudiant['BILAN_MOYENNE']);
        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => ($etudiant['BILAN_MOYENNE'] == "???" ? array('rgb' => 'FFFF00') : array('rgb' => 'CCFFFF'))
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));


        $ue_en_cours = -1;
        foreach ($toutes_les_matieres as $id_matiere => $matiere) {
            if ($ue_en_cours != $matiere['MOYMAT_UE_ID']) {
                $ue_en_cours = $matiere['MOYMAT_UE_ID'];
                //Moyenne à l'UE de l'étudiant
                $fail = false;
                if (array_key_exists($ue_en_cours, $etudiant['BILAN_MATIERES'])) {
                    $feuille->setCellValue([$colonnes++, $lignes], $etudiant['BILAN_MATIERES'][$ue_en_cours]['UE_VALEUR']);
                } else {
                    $fail = true;
                    $feuille->setCellValue([$colonnes++, $lignes], "??");
                }
                $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => ($fail ? 'FFFF00' : 'FF8080'))
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'borders' => array(
                        'top' => array(
                            'borderStyle' => Border::BORDER_MEDIUM
                        ),
                        'bottom' => array(
                            'borderStyle' => Border::BORDER_MEDIUM
                        ),
                        'left' => array(
                            'borderStyle' => Border::BORDER_MEDIUM
                        ),
                        'right' => array(
                            'borderStyle' => Border::BORDER_MEDIUM
                        )
                    )
                ));
            }
            // Moyenne à la matière de l'étudiant
            $fail = false;
            if (array_key_exists($ue_en_cours, $etudiant['BILAN_MATIERES']) && array_key_exists($id_matiere, $etudiant['BILAN_MATIERES'][$ue_en_cours]['MATIERES'])) {
                $feuille->setCellValue([$colonnes++, $lignes], $etudiant['BILAN_MATIERES'][$ue_en_cours]['MATIERES'][$id_matiere]['MOYMAT_VALEUR_ROUND']);
            } else {
                $fail = true;
                $feuille->setCellValue([$colonnes++, $lignes], "?");
            }
            $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'type' => ($fail ? (Fill::FILL_SOLID) : (Fill::FILL_NONE)),
                    'color' => array('rgb' => ($fail ? 'FFFF00' : 'FFFFFF'))
                ),
                'font' => array(
                    'bold' => true
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'left' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));
        }
    }

    //Moyenne des colonnes
    $feuille->setCellValue([1, ++$lignes], "MOYENNE");
    $feuille->getCell([1, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF99CC')
        ),
        'font' => array(
            'bold' => true
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        ),
        'numberformat' => array(
            'formatCode' => NumberFormat::FORMAT_NUMBER_00
        )
    ));
    $feuille->getCell([2, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF99CC')
        ),
        'font' => array(
            'bold' => true
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        ),
        'numberformat' => array(
            'formatCode' => NumberFormat::FORMAT_NUMBER_00
        )
    ));
    $feuille->getCell([3, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF99CC')
        ),
        'font' => array(
            'bold' => true
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        ),
        'numberformat' => array(
            'formatCode' => NumberFormat::FORMAT_NUMBER_00
        )
    ));
    $feuille->getCell([4, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF99CC')
        ),
        'font' => array(
            'bold' => true
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        ),
        'numberformat' => array(
            'formatCode' => NumberFormat::FORMAT_NUMBER_00
        )
    ));
    $feuille->getCell([5, $lignes])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF99CC')
        ),
        'font' => array(
            'bold' => true
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_MEDIUM
            )
        ),
        'numberformat' => array(
            'formatCode' => NumberFormat::FORMAT_NUMBER_00
        )
    ));
    $feuille->mergeCells([1, $lignes, 5, $lignes]);
    for ($i = 6; $i < $colonnes; $i++) {
        $feuille->setCellValue([$i, $lignes], "=AVERAGE(" . ($feuille->getCell([$i,1])->getColumn()) . "3:" . ($feuille->getCell([$i,1])->getColumn()) . ($lignes - 1) . ")");
        $feuille->getCell([$i, $lignes])->getStyle()->applyFromArray(array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF99CC')
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            ),
            'numberformat' => array(
                'formatCode' => NumberFormat::FORMAT_NUMBER_00
            )
        ));
    }

    //Mise en place de la taille
    for ($i = 1; $i < 6; $i++) {
        $feuille->getColumnDimensionByColumn($i)->setAutoSize(true);
    }
    for ($i = 6; $i < $colonnes; $i++) {
        $feuille->getColumnDimensionByColumn($i)->setWidth(11);
    }
    $feuille->getRowDimension(1)->setRowHeight(100);

    //Fusion des cellules d'entête
    $feuille->mergeCells([1, 1, 5, 1]);
    $feuille->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);
    $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
    $feuille->getPageSetup()->setFitToHeight(0);
    $feuille->getPageMargins()->setBottom(0);
    $feuille->getPageMargins()->setTop(0);
    $feuille->getPageMargins()->setLeft(0);
    $feuille->getPageMargins()->setRight(0);

    //Préparation du fichier
    $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
        ->setLastModifiedBy($_SESSION['notes_nom'])
        ->setTitle("Bilan groupe : $nom_groupe");
    $feuille->setTitle("Bilan");

    //Sortie
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    if (isset($_POST['bfmw_orig_generer_bilan_ods'])) {
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="BILAN_' . $nom_groupe . '.ods"');
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Ods');
    } else if (isset($_POST['bfmw_orig_generer_bilan_csv'])) {
        header('Content-Type: application/x-download');
        header('Content-Disposition: attachment;filename="BILAN_' . $nom_groupe . '.csv"');
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Csv')
            ->setDelimiter(',')
            ->setEnclosure('"')
            ->setSheetIndex(0);
    } else {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="BILAN_' . $nom_groupe . '.xlsx"');
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
        //$objWriter->setOffice2003Compatibility(true);
    }
    $objWriter->save('php://output');
    exit;
}

function triAlpha($elem1, $elem2)
{
    if ($elem1['ET_NOM'] == $elem2['ET_NOM']) {
        return 0;
    }

    return ($elem1['ET_NOM'] < $elem2['ET_NOM']) ? -1 : 1;
}

function triGroupes($elem1, $elem2)
{
    if ($elem1['GROUPE_CODE'] == $elem2['GROUPE_CODE']) {
        if ($elem1['ET_NOM'] == $elem2['ET_NOM']) {
            return 0;
        }

        return ($elem1['ET_NOM'] < $elem2['ET_NOM']) ? -1 : 1;
    }

    return ($elem1['GROUPE_CODE'] < $elem2['GROUPE_CODE']) ? -1 : 1;
}

function triMoyenne($elem1, $elem2)
{
    if ($elem1['BILAN_MOYENNE'] == $elem2['BILAN_MOYENNE']) {
        return 0;
    }

    return ($elem1['BILAN_MOYENNE'] > $elem2['BILAN_MOYENNE']) ? -1 : 1;
}

exit;
