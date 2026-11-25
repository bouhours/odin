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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

if (isRegistered() && isset($_POST['bfmw_orig_g']) && isset($_POST['bfmw_orig_s']) && isset($_GET['bfmw_orig_generate'])) {

    //Récupération des étudiants
    $annee_courante = Annees::getIdAnneeCourante();
    $groupe_general = Groupes::getGroupeParCode($_POST['bfmw_orig_g'])->fetch_assoc();
    $les_etudiants = Etudiants::getEtudiantsParGroupesEtSemestresParCode($_POST['bfmw_orig_g'], $_POST['bfmw_num_s'], $annee_courante);
    if (count($les_etudiants) == 0) {
        echo "Erreur - Groupe vide";
        exit;
    }

    //Initialisation de PhpExcel
    $objSpreadsheet = new Spreadsheet();
    $objSpreadsheet->setActiveSheetIndex(0);
    $feuille = $objSpreadsheet->getActiveSheet();

    //Initialisation
    $colonne = 1;
    $ligne = 1;
    for ($i = 1; $i < 14; $i++) {
        $feuille->getColumnDimensionByColumn($i)->setWidth(14.5);
    }

    //Ligne d'entête
    $feuille->setCellValue([$colonne, $ligne], $les_etudiants[array_keys($les_etudiants)[0]]['FORM_NOM'])->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => '8DB4E2')
        ),
        'font' => array(
            'bold' => true,
            'size' => 22,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_LEFT,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));
    $feuille->getCell([$colonne + 1, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->getCell([$colonne + 2, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->getCell([$colonne + 3, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->mergeCells([$colonne, 1, $colonne + 3, 1]);

    $colonne = 5;
    $ligne = 1;
    $feuille->setCellValue([$colonne, $ligne], $les_etudiants[array_keys($les_etudiants)[0]]['ANNEE_NOM'])->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => '8DB4E2')
        ),
        'font' => array(
            'bold' => true,
            'size' => 22,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));
    $feuille->getCell([$colonne + 1, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->getCell([$colonne + 2, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->getCell([$colonne + 3, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->mergeCells([$colonne, 1, $colonne + 3, 1]);

    $colonne = 9;
    $ligne = 1;
    $feuille->setCellValue([$colonne, $ligne], $groupe_general['GROUPE_NOM'])->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => '8DB4E2')
        ),
        'font' => array(
            'bold' => true,
            'size' => 22,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));
    $feuille->getCell([$colonne + 1, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->getCell([$colonne + 2, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->getCell([$colonne + 3, $ligne])->getStyle()->getFill()->applyFromArray(array(
        'fillType' => Fill::FILL_SOLID,
        'color' => array('rgb' => '8DB4E2')
    ));
    $feuille->mergeCells([$colonne, 1, $colonne + 3, 1]);

    $init_ligne = -2;
    $groupe_courant = -1;
    foreach ($les_etudiants as $etudiant_courant) {

        if ($etudiant_courant['GROUPE_ID'] != $groupe_courant) {
            $colonne = -1;
            $groupe_courant = $etudiant_courant['GROUPE_ID'];
            if ($init_ligne == -2) {
                $feuille->getRowDimension(2)->setRowHeight(13.5);
            } else {
                $feuille->getRowDimension($init_ligne++)->setRowHeight(13.5);
            }
        }

        if (++$colonne % 13 == 0) {
            $colonne = 1;
            $init_ligne += 5;

            $feuille->getRowDimension($init_ligne)->setRowHeight(13.5);
            $feuille->getRowDimension($init_ligne + 1)->setRowHeight(13.5);
            $feuille->getRowDimension($init_ligne + 2)->setRowHeight(91.5);
            $feuille->getRowDimension($init_ligne + 3)->setRowHeight(13.5);
            $feuille->getRowDimension($init_ligne + 4)->setRowHeight(30);

        }
        $ligne = $init_ligne;

        $feuille->setCellValue([$colonne, $ligne], $etudiant_courant['GROUPE_NOM']);
        $feuille->getCell([$colonne, $ligne++])->getStyle()->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => "Arial"
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_NONE
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));

        $feuille->setCellValue([$colonne, $ligne], $etudiant_courant['ET_NAISSANCE'] . " (" . getAge($etudiant_courant['ET_NAISSANCE']) . ")");
        $feuille->getCell([$colonne, $ligne++])->getStyle()->applyFromArray(array(
            'font' => array(
                'size' => 8,
                'name' => "Arial"
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_NONE
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_NONE
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));

        $feuille->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_NONE
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_NONE
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));

        $objDrawing = new Drawing();
        $objDrawing->setName($etudiant_courant['ET_NUMERO']);
        $objDrawing->setDescription($etudiant_courant['ET_NUMERO']);
        try {
            $objDrawing->setPath("../trombi/" . $etudiant_courant['ET_NUMERO'] . ".jpg");
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            $objDrawing->setPath("../trombi/fantome.jpg");
        } catch (ErrorException $e) {
            $objDrawing->setPath("../trombi/fantome.jpg");
        }
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWidth(94);
        $objDrawing->setCoordinates($feuille->getCell([$colonne, $ligne++])->getCoordinate());
        $objDrawing->setOffsetX(5);
        $objDrawing->setWorksheet($feuille);

        $feuille->setCellValue([$colonne, $ligne], $etudiant_courant['ET_RED']);
        $feuille->getCell([$colonne, $ligne++])->getStyle()->applyFromArray(array(
            'font' => array(
                'size' => 8,
                'name' => "Arial"
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_NONE
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
            )
        ));

        $feuille->setCellValue([$colonne, $ligne], $etudiant_courant['ET_NOM']);
        $feuille->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => "Arial Narrow"
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
        $feuille->getCell([$colonne, $ligne++])->getStyle()->getAlignment()->setWrapText(true);

        $feuille->getCell([$colonne, $ligne++])->getStyle()->applyFromArray(array(
            'font' => array(
                'size' => 11,
                'name' => "Calibri"
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            )
        ));
    }

    $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
    $feuille->getPageSetup()->setFitToPage(true);
    $feuille->getPageMargins()->setBottom(0);
    $feuille->getPageMargins()->setTop(0);
    $feuille->getPageMargins()->setLeft(0);
    $feuille->getPageMargins()->setRight(0);
    //Sortie
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="GROUPE_' . $groupe_general['GROUPE_NOM'] . '.xlsx"');
    $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');

    $objWriter->save('php://output');
    exit;
}
exit;
