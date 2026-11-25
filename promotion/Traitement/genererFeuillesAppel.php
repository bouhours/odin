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
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

if (isRegistered() && isset($_POST['bfmw_orig_g']) && isset($_POST['bfmw_orig_s']) && isset($_GET['bfmw_orig_generate'])) {

    //Initialisation de PhpExcel
    $objSpreadsheet = new Spreadsheet();
    $objSpreadsheet->setActiveSheetIndex(0);
    $feuille = $objSpreadsheet->getActiveSheet();
    $annee_courante = Annees::getIdAnneeCourante();

    //Récupération des étudiants
    $les_etudiants = Etudiants::getEtudiantsParGroupesEtSemestres( $_POST['bfmw_num_g'],$_POST['bfmw_num_s'],$annee_courante);
    if (count($les_etudiants) == 0) {
        echo "Erreur - Groupe vide";
        exit;
    }
    //Initialisation des entêtes
    $feuille->mergeCells([1, 1, 2, 1]);
    $feuille->getCell([1, 1])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 18,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));

    $feuille->mergeCells([4, 1, 7, 1]);
    $feuille->getCell([4, 1])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 16,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));

    $feuille->getCell([8, 1])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_RIGHT,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));

    $feuille->setCellValue([1, 3], "Enseignant :");
    $feuille->getCell([1, 3])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial"
        ),
        'alignment' => array(
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            )
        )
    ));
    $feuille->getCell([2, 3])->getStyle()->applyFromArray(array(
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            )
        )
    ));
    $feuille->getCell([3, 3])->getStyle()->applyFromArray(array(
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            )
        )
    ));
    $feuille->setCellValue([4, 3], count($les_etudiants));
    $feuille->getCell([4, 3])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 20,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));
    $feuille->setCellValue([5, 3], "Matière :");
    $feuille->getCell([5, 3])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => "Arial"
        ),
        'alignment' => array(
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'left' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            )
        )
    ));
    $feuille->getCell([6, 3])->getStyle()->applyFromArray(array(
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            )
        )
    ));
    $feuille->getCell([7, 3])->getStyle()->applyFromArray(array(
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            ),
            'right' => array(
                'borderStyle' => Border::BORDER_SLANTDASHDOT
            )
        )
    ));
    $feuille->setCellValue([1, 5], "NOM");
    $feuille->mergeCells([1, 5, 1, 7]);
    $feuille->getCell([1, 5])->getStyle()->applyFromArray(array(
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'font' => array(
            'bold' => true,
            'size' => 14,
            'name' => "Arial"
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
    $feuille->getCell([1, 6])->getStyle()->applyFromArray(array(
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
    $feuille->getCell([1, 7])->getStyle()->applyFromArray(array(
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

    for ($i = 2; $i <= 8; $i++) {
        $feuille->setCellValue([$i, 5], "Jours et heures");
        $feuille->getCell([$i, 5])->getStyle()->applyFromArray(array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ),
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => "Arial"
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
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
        $feuille->getCell([$i, 6])->getStyle()->applyFromArray(array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'CCFFCC')
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
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
        $feuille->setCellValue([$i, 7], "EMARGEMENT");
        $feuille->getCell([$i, 7])->getStyle()->applyFromArray(array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ),
            'font' => array(
                'italic' => true,
                'size' => 10,
                'name' => "Arial"
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

    //Initialisation des requêtes
    $colonnes = 1;
    $lignes = 8;
    $i=0;
    $nom_groupe="";
    foreach ($les_etudiants as $un_etudiant) {
        if (++$i == 1) {
            $feuille->setCellValue([1, 1], $un_etudiant['FORM_NOM']);
            $feuille->setCellValue([4, 1], "FICHE DE PRÉSENCE - ". $un_etudiant['SEM_NOM']);
        }
        $nom_groupe = $un_etudiant['GROUPE_NOM'];
        $feuille->setCellValue([$colonnes, $lignes], $un_etudiant['ET_NOM']);
        $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 16,
                'name' => "Calibri"
            ),
            'alignment' => array(
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
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

        for ($i = 1; $i <= 7; $i++) {
            $feuille->getCell([$colonnes + $i, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 12,
                    'name' => "Arial Black"
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_THIN
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
        }
        $feuille->getRowDimension($lignes)->setRowHeight(27);
        $lignes++;
    }

    //Cellules du groupe
    $feuille->setCellValue([3, 1], $nom_groupe);
    $feuille->getCell([3, 1])->getStyle()->applyFromArray(array(
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ),
        'font' => array(
            'bold' => true,
            'size' => 16,
            'name' => "Arial"
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

    //Dernière ligne
    for ($i = 1; $i <= 8; $i++) {
        $feuille->getCell([$colonnes + $i, $lignes])->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_MEDIUM
                )
        )));
    }

    $lignes++;

//Ligne des exams
    /*
    $feuille->setCellValue([0, $lignes, "ABSENTS SEMAINE(s) TRANSITION");
    $feuille->mergeCells([0, $lignes, 1, $lignes);
    $feuille->getCell([0, $lignes)->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 10,
            'name' => "Arial Narrow"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));

    $feuille->setCellValue([2, $lignes, "Jours et heures :");
    $feuille->getCell([2, $lignes)->getStyle()->applyFromArray(array(
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
    $feuille->getCell([3, $lignes)->getStyle()->applyFromArray(array(
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    for ($i = 4; $i < 8; $i++) {
        $feuille->getCell([$i, $lignes)->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_DOUBLE
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_DOUBLE
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_DOUBLE
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            )
        ));
    }

    $lignes++;

    $feuille->setCellValue([0, $lignes, "(Devoirs Surveillés)");
    $feuille->mergeCells([0, $lignes, 1, $lignes);
    $feuille->getCell([0, $lignes)->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 10,
            'name' => "Arial Narrow"
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));

    $feuille->setCellValue([2, $lignes, "Jours et heures :");
    $feuille->getCell([2, $lignes)->getStyle()->applyFromArray(array(
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
    $feuille->getCell([3, $lignes)->getStyle()->applyFromArray(array(
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            )
        )
    ));
    for ($i = 4; $i < 8; $i++) {
        $feuille->getCell([$i, $lignes)->getStyle()->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_DOUBLE
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_DOUBLE
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_DOUBLE
                )
            )
        ));
    }
*/
    //Préparation du fichier
    $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
            ->setLastModifiedBy($_SESSION['promotion_nom'])
            ->setTitle("Emmargement $nom_groupe");
    $feuille->setTitle("Emmargement");

    //Taille des colonnes
    $feuille->getColumnDimensionByColumn(1)->setWidth(30);
    $feuille->getColumnDimensionByColumn(2)->setWidth(18);
    $feuille->getColumnDimensionByColumn(3)->setWidth(18);
    $feuille->getColumnDimensionByColumn(4)->setWidth(18);
    $feuille->getColumnDimensionByColumn(5)->setWidth(18);
    $feuille->getColumnDimensionByColumn(6)->setWidth(18);
    $feuille->getColumnDimensionByColumn(7)->setWidth(18);
    $feuille->getColumnDimensionByColumn(8)->setWidth(18);
    $feuille->getRowDimension(1)->setRowHeight(24.75);
    $feuille->getRowDimension(2)->setRowHeight(14.25);
    $feuille->getRowDimension(3)->setRowHeight(26.25);
    $feuille->getRowDimension(4)->setRowHeight(14.25);
    $feuille->getRowDimension(5)->setRowHeight(13.5);
    $feuille->getRowDimension(6)->setRowHeight(23.25);
    $feuille->getRowDimension(7)->setRowHeight(13.5);


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
    header('Content-Disposition: attachment;filename="EMMARGEMENT_' . $nom_groupe . '.xlsx"');
    $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');

    $objWriter->save('php://output');
    exit;
}

exit;
