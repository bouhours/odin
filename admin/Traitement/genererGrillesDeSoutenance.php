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
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {

    if (isset($_GET['bfmw_num_a']) && isset($_GET['bfmw_num_s']) && isset($_GET['bfmw_num_f'])) {

        $annee_courante = $_GET['bfmw_num_a'];
        $session_courante = $_GET['bfmw_num_s'];
        $formation_courante = $_GET['bfmw_num_f'];

        //Initialisation de PhpExcel
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->setActiveSheetIndex(0);
        $feuille = $objSpreadsheet->getActiveSheet();

        //Préparation du fichier
        $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
            ->setLastModifiedBy($_SESSION['admin_nom'])
            ->setTitle("Grilles de soutenances");

        //Une destination par feuille
        $les_informations = Notation_Soutenances::getGrille($formation_courante,$session_courante);
        $destination_courante = -1;
        $section_courante = -1;
        $critere_courante = -1;
        $niveau_courante = -1;
        $explication_courante = -1;

        if (count($les_informations) > 0) {
            $objSpreadsheet->removeSheetByIndex(0);
        } else {
            $feuille->setTitle("Extraction des affectations");
        }

        $colonne = 1;
        $lignes = 1;
        $new_section = false;
        $from_section = 0;
        $to_section = 0;
        foreach ($les_informations as $un_element) {
            if ($destination_courante != $un_element['DEST_ID']) {
                if ($to_section !=0 && $from_section != 0) {
                    $feuille->mergeCells([1,$from_section,1,$to_section]);
                    $from_section = 0;
                    $to_section = 0;

                    for ($i = 1; $i < 50; $i++) {
                        $feuille->getColumnDimensionByColumn($i)->setWidth(20);
                    }

                }

                $destination_courante = $un_element['DEST_ID'];
                $feuille = $objSpreadsheet->addSheet(new Worksheet($objSpreadsheet, $un_element['DEST_CONTENU']));
                $colonne = 2;
                $lignes = 1;
                makeEntete($feuille,1,$lignes,"Grille ".$un_element['DEST_CONTENU'],Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                makeEntete($feuille,2,$lignes,"Critère",Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                $lignes = 0;
            }

            if ($section_courante != $un_element['SECTION_ID']) {
                if ($to_section !=0 && $from_section != 0) {
                    $feuille->mergeCells([1,$from_section,1,$to_section]);
                }
                $lignes += 2;
                $from_section = $lignes;
                $to_section = $lignes;
                $new_section = true;
                $section_courante = $un_element['SECTION_ID'];
                makeEntete($feuille,1,$lignes,$un_element['SECTION_CONTENU'],Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
            }

            if ($critere_courante != $un_element['CRITERE_ID']) {
                if (!$new_section) {
                    $lignes += 2;
                }
                $colonne = 2;
                $new_section = false;
                $critere_courante = $un_element['CRITERE_ID'];
                makeEntete($feuille,$colonne,$lignes,$un_element['CRITERE_CONTENU'],Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                makeEntete($feuille,$colonne,$lignes+1,"",Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                $feuille->mergeCells([$colonne,$lignes,$colonne,$lignes+1]);
            }

            if ($niveau_courante != $un_element['NIVEAU_ID']) {
                $niveau_courante = $un_element['NIVEAU_ID'];
                makeEntete($feuille,++$colonne,$lignes,$un_element['NIVEAU_CONTENU']."(".$un_element['NIVEAU_POIDS'].")",Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
            }

            if ($explication_courante != $un_element['EXPLICATION_ID']) {
                $explication_courante = $un_element['EXPLICATION_ID'];
                makeData($feuille,$colonne,$lignes+1,$un_element['EXPLICATION_CONTENU'],Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                $to_section = $lignes+1;
            }
        }

        if ($to_section !=0 && $from_section != 0) {
            $feuille->mergeCells([1,$from_section,1,$to_section]);
            $from_section = 0;
            $to_section = 0;

            for ($i = 1; $i < 50; $i++) {
                $feuille->getColumnDimensionByColumn($i)->setWidth(20);
            }

        }

        $objSpreadsheet->setActiveSheetIndex(0);

        //Préparation de l'impression
        $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $feuille->getPageSetup()->setFitToHeight(0);
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
        header('Content-Disposition: attachment;filename="Fiches de soutenances.xlsx"');
        $objWriter = IOFactory::createWriter($objSpreadsheet,'Xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
exit;

function makeEntete(Worksheet $feuille,int $colonnes,int $lignes,string $titre,string $right, string $left)
{
    $feuille->setCellValue([$colonnes, $lignes], $titre);
    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => "Arial"
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
                'borderStyle' => $left
            ),
            'right' => array(
                'borderStyle' => $right
            )
        ),
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'D9D9D9')
        )
    ));
}

function makeData(Worksheet $feuille,int $colonnes,int $lignes,$titre,string $right, string $left)
{
    if ($titre == null) {
        $titre = "";
    }
    $feuille->setCellValue([$colonnes, $lignes], $titre);
    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => "Arial"
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
                'borderStyle' => $left
            ),
            'right' => array(
                'borderStyle' => $right
            )
        )
    ));
    if ($titre == "???") {
        $feuille->getCell([$colonnes, $lignes])->getStyle()->getFill()->applyFromArray(array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ));
    }
}