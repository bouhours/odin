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

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {

    if (isset($_POST['bfmw_orig_f'])) {

        $annee_courante = Annees::getIdAnneeCourante();

        $les_etudiants = Etudiants::getEtudiantsParGroupesEtSemestresInscrits($_POST['bfmw_num_f'],$annee_courante);
        $nbEtudiants = count($les_etudiants);
        $etudiants = array();
        $formation = array();
        if ($nbEtudiants == 0) {
            die ("Erreur : Groupe vide");
        }
        foreach ($les_etudiants as $un_Etu) {
            $etudiants[$un_Etu['GROUPE_NOM']][] = $un_Etu;
            $formation = $un_Etu;
        }

        //Initialisation de PhpExcel
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->setActiveSheetIndex(0);
        $feuille = $objSpreadsheet->getActiveSheet();

        //Initialisation
        $colonne = 1;
        $ligne = 1;
         //Ligne d'entête
        $feuille->setCellValue([$colonne, $ligne], $formation['FORM_NOM']."     ".$formation['SEM_NOM']."     ".$formation['ANNEE_NOM']."     ".$nbEtudiants." étudiants")->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 22,
                'name' => "Arial",
                'color' => array('rgb' => 'FF0000')
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            )
        ));
        $moitie = count($etudiants)/2;
        if ($moitie < 1) {
            $moitie = 1;
        }
        $feuille->mergeCells([$colonne, 1, $colonne + 3 + $moitie*2, 1]);



         //Ligne intermédiaire
        $feuille->getRowDimension(++$ligne)->setRowHeight(50);

        //Etudiants
        $init_ligne = $ligne-2;
        $i = 0/2;
        $max_etudiants = -3;
        foreach ($etudiants as $nom_groupe => $groupe) {
            if (($i++ % $moitie) == 0) {
                $colonne = 1;
                $init_ligne += ($max_etudiants+5);
                $ligne = $init_ligne;
                $max_etudiants = 0;
            }
            $max_etudiants = max($max_etudiants,count($groupe));
            $feuille->setCellValue([$colonne, ++$ligne], count($groupe)." étudiants")->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
                'font' => array(
                    'bold' => false,
                    'size' => 12,
                    'name' => "Arial Narrow"
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                )
            ));
            $feuille->setCellValue([$colonne, ++$ligne], $nom_groupe)->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFCCCC')
                ),
                'font' => array(
                    'bold' => false,
                    'size' => 12,
                    'name' => "Arial Narrow"
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
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
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_THIN
                    )
                )
            ));
            $feuille->getCell([$colonne+1, $ligne])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => '76933C')
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
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_THIN
                    )
                )
            ));
            foreach ($groupe as $unEtudiant) {
                $feuille->setCellValue([$colonne, ++$ligne], $unEtudiant['ET_NOM'])->getCell([$colonne, $ligne])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12,
                        'name' => "Calibri"
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
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
                        ),
                        'right' => array(
                            'borderStyle' => Border::BORDER_THIN
                        )
                    )
                ));
                $tt = "";
                if ($unEtudiant['ET_TIERS'] == 1) {
                    $tt = ($unEtudiant['ET_RED']==""?"Tiers temps":" + Tiers temps");
                }
                $feuille->setCellValue([$colonne+1, $ligne], $unEtudiant['ET_RED'].$tt)->getCell([$colonne+1, $ligne])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => false,
                        'size' => 10,
                        'name' => "Calibri"
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
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
                        ),
                        'right' => array(
                            'borderStyle' => Border::BORDER_THIN
                        )
                    )
                ));
            }
            $feuille->getColumnDimensionByColumn($colonne)->setAutoSize(true);
            $feuille->getColumnDimensionByColumn($colonne+1)->setAutoSize(true);
            $feuille->getColumnDimensionByColumn($colonne+2)->setWidth(2);
            $ligne = $init_ligne;
            $colonne += 3;
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
        header('Content-Disposition: attachment;filename="RECAPITULATIF_' . $formation['FORM_NOM'] . '.xlsx"');
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');

        $objWriter->save('php://output');
        exit;
    }
}
exit;
