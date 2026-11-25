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

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

verifSession();

if (isset($_POST['bfmw_orig_alpha']) || isset($_POST['bfmw_orig_moyenne'])  || isset($_POST['bfmw_orig_moyennemoins1'])) {

    if (isset($_POST['bfmw_orig_moyennemoins1'])) {
        $annee = Annees::getAnneeWithId(Annees::getIdAnneeCourante()-1)[0];
        $annee_courante = $annee['ANNEE_ID'];
    } else {
        $annee = Annees::getAnneeCourante()[0];
        $annee_courante = $annee['ANNEE_ID'];
    }

    $lesEtudiantsConcernes = Poursuites::extractEtudiants($annee_courante);

    //Initialisation de PhpExcel
    try {
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->removeSheetByIndex(0);

        foreach ($lesEtudiantsConcernes as $nom_groupe => $un_groupe) {
            $nom_groupe = str_replace(Worksheet::getInvalidCharacters(), '', $nom_groupe);
            $nom_groupe = substr($nom_groupe, 0, Worksheet::SHEET_TITLE_MAXIMUM_LENGTH);

            $feuille = new Worksheet($objSpreadsheet,$nom_groupe??"--");
            $objSpreadsheet->addSheet($feuille);

            $colonnes = 1;
            $lignes = 1;

            makeEntete($feuille,$colonnes,$lignes,"POURSUITES D'ÉTUDES $nom_groupe ".$annee['ANNEE_NOM'],Border::BORDER_MEDIUM,Border::BORDER_NONE,Border::BORDER_NONE,Border::BORDER_NONE);
            if (isset($_POST['bfmw_orig_alpha'])) {
                makeEntete($feuille,$colonnes, $lignes + 1, "TRI ALPHABÉTIQUE",Border::BORDER_MEDIUM,Border::BORDER_NONE,Border::BORDER_NONE,Border::BORDER_MEDIUM);
            } else {
                makeEntete($feuille,$colonnes, $lignes + 1, "TRI PAR MOYENNE",Border::BORDER_MEDIUM,Border::BORDER_NONE,Border::BORDER_NONE,Border::BORDER_MEDIUM);
            }
            $colonnes++;
            makeEntete($feuille,$colonnes,$lignes,"NOTE",Border::BORDER_MEDIUM,Border::BORDER_NONE,Border::BORDER_NONE,Border::BORDER_NONE);
            makeEntete($feuille,$colonnes,$lignes+1,"FUSION",Border::BORDER_MEDIUM,Border::BORDER_NONE,Border::BORDER_NONE,Border::BORDER_MEDIUM);
            $premier_tour = true;
            foreach ($un_groupe as $une_categorie=>$les_etudiants) {
                $lignes = 1;
                $colonnes++;
                makeEntete($feuille, $colonnes, $lignes, "AVIS", Border::BORDER_MEDIUM, Border::BORDER_NONE, Border::BORDER_NONE, Border::BORDER_NONE);
                makeEntete($feuille, $colonnes, $lignes + 1, html_entity_decode($une_categorie,ENT_QUOTES), Border::BORDER_MEDIUM, Border::BORDER_NONE, Border::BORDER_NONE, Border::BORDER_MEDIUM);

                $lignes = 2;
                foreach ($les_etudiants as $et_id => $un_etudiant) {
                    if ($et_id == -1) {
                        continue;
                    }
                    $lignes++;
                    if ($premier_tour) {
                        $colonnes_etudiant = 1;
                        makeData($feuille, $colonnes_etudiant, $lignes, $un_etudiant['ET_NOM'], Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                        $colonnes_etudiant++;
                        makeData($feuille, $colonnes_etudiant, $lignes, $un_etudiant['MOYAN_VALEUR']??"--", Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                        $feuille->getCell(Coordinate::stringFromColumnIndex($colonnes_etudiant) . $lignes)->getStyle()->applyFromArray(array(
                            'fill' => array(
                                'fillType' => Fill::FILL_SOLID,
                                'color' => array('rgb' => "FFFF00")
                            )
                        ));
                        $colonnes_etudiant++;
                        makeData($feuille, $colonnes_etudiant, $lignes, $un_etudiant['POURSUITE_AVIS']??"--", Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                    } else {
                        $colonnes_etudiant = $colonnes;
                        makeData($feuille, $colonnes_etudiant, $lignes, $un_etudiant['POURSUITE_AVIS']??"--", Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);
                    }
                }
                foreach ($les_etudiants[-1] as $modele => $nombre) {
                    $lignes++;
                    makeEntete($feuille, $colonnes, $lignes, $nombre . " " . $modele, Border::BORDER_MEDIUM, Border::BORDER_MEDIUM,Border::BORDER_MEDIUM,Border::BORDER_MEDIUM);
                }
                $premier_tour = false;
            }
            miseEnPage($feuille);
        }



        //Préparation du fichier
        $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
            ->setLastModifiedBy($_SESSION['poursuites_nom'])
            ->setTitle("Récapitulatif poursuites - ".$annee['ANNEE_NOM']);
        //Sortie
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="RECAPITUALIF_POURSUITES_ETUDES_' . $annee['ANNEE_NOM'] . '.xlsx"');
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');

        $objWriter->save('php://output');
    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        var_dump($e);
    }
    exit;
}

exit;

function makeEntete(Worksheet $feuille,int $colonnes,int $lignes,string $titre,string $right, string $left, string $top, string $bottom, string $horizontal_alignement = Alignment::HORIZONTAL_CENTER, bool $wrap_text = true, string $fill="66CCFF")
{
    if ($titre == null) {
        $titre = "";
    }
    $feuille->setCellValue(Coordinate::stringFromColumnIndex($colonnes) . $lignes, $titre);
    $feuille->getCell(Coordinate::stringFromColumnIndex($colonnes) . $lignes)->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 16,
            'name' => "Arial Narrow"
        ),
        'alignment' => array(
            'horizontal' => $horizontal_alignement,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => $wrap_text
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => $top
            ),
            'bottom' => array(
                'borderStyle' => $bottom
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
            'color' => array('rgb' => $fill)
        )
    ));
}

function makeData(Worksheet $feuille,int $colonnes,int $lignes,$titre,string $right, string $left, string $horizontal_alignement = Alignment::HORIZONTAL_CENTER, bool $wrap_text = true)
{
    if ($titre == null) {
        $titre = "";
    }
    $feuille->setCellValue(Coordinate::stringFromColumnIndex($colonnes) . $lignes, $titre);
    $feuille->getCell(Coordinate::stringFromColumnIndex($colonnes) . $lignes)->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 14,
            'name' => "Calibri"
        ),
        'alignment' => array(
            'horizontal' => $horizontal_alignement,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => $wrap_text
        ),
        'borders' => array(
            'top' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'bottom' => array(
                'borderStyle' => Border::BORDER_THIN
            ),
            'left' => array(
                'borderStyle' => $left
            ),
            'right' => array(
                'borderStyle' => $right
            )
        )
    ));
}

function miseEnPage(Worksheet $feuille): void
{
    $feuille->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);
    $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
    for ($i=1;$i<20;$i++) {
        $feuille->getColumnDimensionByColumn($i)->setAutoSize(1);
    }
    $feuille->getPageSetup()->setFitToWidth(1);
    $feuille->getPageSetup()->setFitToHeight(0);
    $feuille->getPageMargins()->setBottom(0);
    $feuille->getPageMargins()->setTop(0);
    $feuille->getPageMargins()->setLeft(0.1);
    $feuille->getPageMargins()->setRight(0.1);
}