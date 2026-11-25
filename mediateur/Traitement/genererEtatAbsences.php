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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


if (isRegistered() && isset($_POST['bfmw_orig_date_start']) && isset($_POST['bfmw_orig_date_end']) && isset($_POST['bfmw_orig_groupe_id']) && isset($_POST['bfmw_orig_annee_id'])) {

    //Initialisation de PhpExcel
    $objSpreadsheet = new Spreadsheet();
    $objSpreadsheet->setActiveSheetIndex(0);
    $feuille = $objSpreadsheet->getActiveSheet();

    //Récupération des données
    $annee_courante = $_POST['bfmw_num_annee_id'];
    $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$_POST['bfmw_num_groupe_id']);
    $donnees_etudiants_absences = array();
    $nom_groupe = "";
    foreach ($les_etudiants as $un_etudiant) {
        $nom_groupe = $un_etudiant["GROUPE_NOM"];
        $les_absences = Absences::getAbsencesNewGen(-1, -1, "=".$un_etudiant['ET_ID'],"ENS_ID","ABS_REAL_DATE BETWEEN ".transformDate($_POST['bfmw_orig_date_start'])." AND ".transformDate($_POST['bfmw_orig_date_end'])." AND ","GROUP BY ABS_ID","ORDER BY ABS_REAL_DATE, CRENEAU_REAL_START, CRENEAU_REAL_END, EDT_DATE_DEBUT, EDT_DATE_FIN");
        $donnees_etudiants_absences[$un_etudiant['ET_ID']] = $un_etudiant;
        $donnees_etudiants_absences[$un_etudiant['ET_ID']]['ABSENCES'] = $les_absences;
        $abs = Absences::getAbsencesNewGen(-1,-1,"=".$un_etudiant['ET_ID'],"ENS_ID","ABS_REAL_DATE BETWEEN ".transformDate($_POST['bfmw_orig_date_start'])." AND ".transformDate($_POST['bfmw_orig_date_end'])." AND ","GROUP BY MAT_ID,EDT_NOM","","COUNT(*) AS TOTAL, SUM(CASE WHEN ABS_JUSTIFICATION='non' THEN 1 ELSE 0 END) AS NON_JUSTIF, ENS_NOM, EDT_HEURE_DEBUT, EDT_HEURE_FIN, EDT_NOM",true);
        $donnees_etudiants_absences[$un_etudiant['ET_ID']]['COUNT'] = $abs;
    }

    $colonne = 1;
    $ligne = 1;
    makeEntete($feuille,$colonne++,$ligne,"NOM Prénom",Border::BORDER_THIN,Border::BORDER_MEDIUM);
    makeEntete($feuille,$colonne++,$ligne,"Date de l'absence",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Horaire",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Module",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Enseignant",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Justification",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Motif",Border::BORDER_MEDIUM,Border::BORDER_THIN, Alignment::HORIZONTAL_LEFT,false);

    $ligne = 2;
    foreach ($donnees_etudiants_absences as $un_etudiant) {
        if (count($un_etudiant["ABSENCES"]) == 0) {
            continue;
        }
        foreach ($un_etudiant["ABSENCES"] as $une_absence) {
            $colonne = 1;
            makeData($feuille,$colonne++,$ligne,$un_etudiant['ET_NOM'],Border::BORDER_THIN,Border::BORDER_MEDIUM);
            makeData($feuille,$colonne++,$ligne,$une_absence['ABS_DATE'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['CRENEAU_NOM'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['MAT_NOM']==""?$une_absence['EDT_NOM']:$une_absence['MAT_NOM'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['ENS_NOM'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['ABS_JUSTIFICATION'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['ABS_EXCUSE'],Border::BORDER_THIN,Border::BORDER_THIN, Alignment::HORIZONTAL_LEFT, false);
            $ligne++;
        }
        for ($i=1;$i<8;$i++) {
            makeEntete($feuille,$i,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN);
        }
        $feuille->getRowDimension($ligne)->setRowHeight(5);
        $ligne++;
    }

    $feuille->setTitle("DETAIL");
    for ($i=1;$i<7;$i++) {
        $feuille->getColumnDimensionByColumn($i)->setAutoSize(1);
    }
    $feuille->getColumnDimensionByColumn(7)->setWidth(60);

    //Mise en page
    miseEnPage($feuille);

    //Calcul de la feuille bilan
    $feuille = new Worksheet($objSpreadsheet,"BILAN");
    $objSpreadsheet->addSheet($feuille);
    $objSpreadsheet->setActiveSheetIndex(1);

    $colonne = 1;
    $ligne = 1;
    makeEntete($feuille,$colonne++,$ligne,"NOM Prénom",Border::BORDER_THIN,Border::BORDER_MEDIUM);
    makeEntete($feuille,$colonne++,$ligne,"Nombre total",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"dont non justifié",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Matière",Border::BORDER_THIN,Border::BORDER_THIN);
    makeEntete($feuille,$colonne++,$ligne,"Enseignant",Border::BORDER_MEDIUM,Border::BORDER_THIN);

    $ligne = 2;
    foreach ($donnees_etudiants_absences as $un_etudiant) {
        $total = 0;
        $total_non_justif = 0;
        foreach ($un_etudiant["COUNT"] as $une_absence) {
            $total += $une_absence['TOTAL'];
            $total_non_justif += $une_absence['NON_JUSTIF'];

            $colonne = 1;
            makeData($feuille,$colonne++,$ligne,$un_etudiant['ET_NOM'],Border::BORDER_THIN,Border::BORDER_MEDIUM);
            makeData($feuille,$colonne++,$ligne,$une_absence['TOTAL'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['NON_JUSTIF'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['MAT_NOM']==""?$une_absence['EDT_NOM']:$une_absence['MAT_NOM'],Border::BORDER_THIN,Border::BORDER_THIN);
            makeData($feuille,$colonne++,$ligne,$une_absence['ENS_NOM'],Border::BORDER_MEDIUM,Border::BORDER_THIN);
            $ligne++;
        }
        if ($total == 0) {
            continue;
        }
        $colonne = 1;
        makeEntete($feuille,$colonne++,$ligne,$un_etudiant['ET_NOM'],Border::BORDER_THIN,Border::BORDER_MEDIUM,Alignment::HORIZONTAL_CENTER,true,"FFFF00");
        $demi = Absences::getNombreDeDemiJourneesNonJustifiees($un_etudiant['ET_ID'],-1,"ABS_ENS_ID",-1,"ABS_REAL_DATE BETWEEN ".transformDate($_POST['bfmw_orig_date_start'])." AND ".transformDate($_POST['bfmw_orig_date_end'])." AND ");
        makeEntete($feuille,$colonne++,$ligne,Absences::formatAbsences($total) . " dont $total_non_justif " . Absences::formatNonJustifiee($total_non_justif) . ($demi == 0 ? "" : " sur " . Absences::formatDemiJournees($demi)),Border::BORDER_THIN,Border::BORDER_THIN,Alignment::HORIZONTAL_LEFT,false, "FFFF00");
        makeEntete($feuille,$colonne++,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN,Alignment::HORIZONTAL_CENTER,true,"FFFF00");
        makeEntete($feuille,$colonne++,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN,Alignment::HORIZONTAL_CENTER,true,"FFFF00");
        makeEntete($feuille,$colonne,$ligne,"",Border::BORDER_MEDIUM,Border::BORDER_THIN,Alignment::HORIZONTAL_CENTER,true,"FFFF00");
        $feuille->mergeCells([$colonne-3, $ligne, $colonne, $ligne]);

        $ligne++;

        for ($i=1;$i<6;$i++) {
            makeEntete($feuille,$i,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN);
        }
        $feuille->getRowDimension($ligne)->setRowHeight(5);

        $ligne++;
    }

    for ($i=1;$i<6;$i++) {
        $feuille->getColumnDimensionByColumn($i)->setAutoSize(1);
    }

    $objSpreadsheet->setActiveSheetIndex(0);

    //Préparation du fichier
    $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
        ->setLastModifiedBy($_SESSION['mediateur_nom'])
        ->setTitle("EtatAbsence_".$nom_groupe);


    //Mise en page
    miseEnPage($feuille);

    //Sortie
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ETAT_ABSENCE_'.$nom_groupe.'.xlsx"');
    $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');

    $objWriter->save('php://output');
    exit;
}

exit;

function makeEntete(Worksheet $feuille,int $colonnes,int $lignes,string $titre,string $right, string $left, string $horizontal_alignement = Alignment::HORIZONTAL_CENTER, bool $wrap_text = true, string $fill="D9D9D9")
{
    $feuille->setCellValue([$colonnes, $lignes], $titre);
    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => "Arial"
        ),
        'alignment' => array(
            'horizontal' => $horizontal_alignement,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => $wrap_text
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
            'color' => array('rgb' => $fill)
        )
    ));
}

function makeData(Worksheet $feuille,int $colonnes,int $lignes,$titre,string $right, string $left, string $horizontal_alignement = Alignment::HORIZONTAL_CENTER, bool $wrap_text = true)
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
    if ($titre == "???") {
        $feuille->getCell([$colonnes, $lignes])->getStyle()->getFill()->applyFromArray(array(
            'fillType' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ));
    }
}

function miseEnPage(Worksheet $feuille): void
{
    $feuille->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
    $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
    $feuille->getPageSetup()->setFitToWidth(1);
    $feuille->getPageSetup()->setFitToHeight(null);
    $feuille->getPageMargins()->setBottom(0);
    $feuille->getPageMargins()->setTop(0);
    $feuille->getPageMargins()->setLeft(0);
    $feuille->getPageMargins()->setRight(0);
}