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
exit;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {

    if (isset($_GET['bfmw_num_a1'])) {

        $annee_courante = $_GET['bfmw_num_a1'];

        //Initialisation de PhpExcel
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->setActiveSheetIndex(0);
        $feuille = $objSpreadsheet->getActiveSheet();

        //Préparation du fichier
        $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
            ->setLastModifiedBy($_SESSION['admin_nom'])
            ->setTitle("Extraction des affectations");

        $feuille->setTitle("Extraction des affectations");
        $objSpreadsheet->removeSheetByIndex(0);

        //Récupération des données
        $res = ChargeEnseignements::getChargeEnseignantDeLaFormation(Formations::getFormationsDuConnecteString(),$annee_courante,CURRENT_DEPT_ID);
        $formation_en_cours = -1;
        $semestre_en_cours = -1;
        $ue_en_cours = -1;
        $matiere_en_cours = -1;
        $periode_en_cours = -1;
        $premier_enseignant = true;
        $lignes = 1;
        $colonnes = 1;
        $premiere_formation = 0;
        $premier_semestre = 0;
        $nombre_de_periodes = $res->num_rows;
        while ($les_affectations = $res->fetch_assoc()) {
            if ($periode_en_cours != $les_affectations['PERIODE_ID']) {
                $feuille = $objSpreadsheet->addSheet(new Worksheet($objSpreadsheet, $les_affectations['PERIODE_NOM']));
                $premiere_formation = 0;
                //Mise en place de la taille
                for ($i = 1; $i < 5; $i++) {
                    $feuille->getColumnDimensionByColumn($i)->setWidth(2);
                }
                $feuille->getColumnDimensionByColumn(6)->setAutoSize(true);
                for ($i = 7; $i < 23; $i++) {
                    $feuille->getColumnDimensionByColumn($i)->setWidth(9);
                }

                $formation_en_cours = -1;
                $semestre_en_cours = -1;
                $ue_en_cours = -1;
                $matiere_en_cours = -1;
                $periode_en_cours = $les_affectations['PERIODE_ID'];
                $colonnes = 1;
                $lignes = 1;

                $feuille->setCellValue([$colonnes, $lignes], $les_affectations['PERIODE_NOM']);
                $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12,
                        'name' => "Arial Black"
                    )
                ));
                $lignes++;
            }
            if ($formation_en_cours != $les_affectations['FORM_ID']) {
                $premier_semestre = 0;
                if ($premiere_formation++ != 0) {
                    $feuille->setBreak([1, $lignes - 1], Worksheet::BREAK_ROW);
                }
                $formation_en_cours = $les_affectations['FORM_ID'];
                $semestre_en_cours = -1;
                $ue_en_cours = -1;
                $matiere_en_cours = -1;
                $colonnes = 2;

                $feuille->setCellValue([$colonnes, $lignes], $les_affectations['FORM_NOM']);
                $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12,
                        'name' => "Arial Black"
                    )
                ));
                $lignes++;
            }
            if ($semestre_en_cours != $les_affectations['SEM_ID']) {
                if ($premier_semestre++ != 0) {
                    $feuille->setBreak([1, $lignes - 1], Worksheet::BREAK_ROW);
                }
                $semestre_en_cours = $les_affectations['SEM_ID'];
                $ue_en_cours = -1;
                $matiere_en_cours = -1;
                $colonnes = 3;

                $feuille->setCellValue([$colonnes, $lignes], $les_affectations['SEM_NOM']);
                $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12,
                        'name' => "Arial Black"
                    )
                ));
                $lignes++;
            }
            if ($ue_en_cours != $les_affectations['UE_ID']) {
                $ue_en_cours = $les_affectations['UE_ID'];
                $matiere_en_cours = -1;
                $colonnes = 4;

                $feuille->setCellValue([$colonnes, $lignes], $les_affectations['UE_NOM']);
                $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12,
                        'name' => "Arial Black"
                    )
                ));
                $lignes++;
            }
            if ($matiere_en_cours != $les_affectations['MAT_ID']) {
                $matiere_en_cours = $les_affectations['MAT_ID'];
                $colonnes = 5;
                $premier_enseignant = true;

                $feuille->setCellValue([$colonnes, $lignes], $les_affectations['MAT_NOM']);
                $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12,
                        'name' => "Arial Black"
                    )
                ));
                $lignes++;
            }

            $colonnes = 6;
            if ($premier_enseignant) {
                $premier_enseignant = false;
                $feuille->setCellValue([$colonnes, $lignes], "");

                enteteFicheA($feuille, $colonnes, $lignes);

                $colonnes = 6;
                $lignes++;
            }

            makeData($feuille, $colonnes, $lignes, $les_affectations['ENS_NOM'], Border::BORDER_MEDIUM, Border::BORDER_MEDIUM);


            donneesFicheA($feuille, $colonnes, $lignes, $les_affectations);

            $lignes++;

            //Préparation de l'impression
            $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
            $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
            $feuille->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
            $feuille->getPageSetup()->setFitToHeight(0);
            $feuille->getPageMargins()->setBottom(0);
            $feuille->getPageMargins()->setTop(0);
            $feuille->getPageMargins()->setLeft(0);
            $feuille->getPageMargins()->setRight(0);
        }

        if ($nombre_de_periodes == 0) {
            $objSpreadsheet->addSheet(new Worksheet($objSpreadsheet, "AUCUNE"));
        }
        $objSpreadsheet->setActiveSheetIndex(0);

        //Sortie
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Extraction des affectations.xlsx"');
        $objWriter = IOFactory::createWriter($objSpreadsheet,'Xlsx');
        //$objWriter->setOffice2003Compatibility(true);
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

function enteteFicheA(Worksheet $feuille, $colonnes, $lignes)
{
    makeEntete($feuille,++$colonnes, $lignes, "hCM",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grCM", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "hTD",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grTD", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "hTDr",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grTDr", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "hTP",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grTP", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "hTP",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grTP", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "hTP",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grTP", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "hDS",Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "nbSEM",Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "grDS", Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeEntete($feuille,++$colonnes, $lignes, "h etu", Border::BORDER_MEDIUM,Border::BORDER_MEDIUM);
    makeEntete($feuille,++$colonnes, $lignes, "h eqTD", Border::BORDER_MEDIUM,Border::BORDER_MEDIUM);

    return $colonnes;
}

function donneesFicheA(Worksheet $feuille, $colonnes, $lignes, $les_affectations)
{
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_CM"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_CM"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_CM"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_TD"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_TD"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_TD"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_TDR"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_TDR"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_TDR"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_TP"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_TP"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_TP"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_TPR"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_TPR"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_TPR"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_TPV"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_TPV"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_TPV"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_DS"],Border::BORDER_DASHED,Border::BORDER_MEDIUM);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_SEMAINES_DS"],Border::BORDER_DASHED,Border::BORDER_DASHED);
    makeData($feuille,++$colonnes, $lignes, $les_affectations["CHARGE_GROUPES_DS"], Border::BORDER_MEDIUM,Border::BORDER_DASHED);


    $formule = "";
    ++$colonnes;
    for ($i=20;$i>=0;$i-=3) {
        $formule .= $feuille->getCell([$colonnes-$i,$lignes])->getColumn();
        $formule .= $feuille->getCell([$colonnes-$i,$lignes])->getRow();
        $formule .= "*";
        $formule .= $feuille->getCell([$colonnes-$i-1,$lignes])->getColumn();
        $formule .= $feuille->getCell([$colonnes-$i-1,$lignes])->getRow();
        $formule .= "+";
    }
    $formule .= "0";
    makeEntete($feuille,$colonnes, $lignes, "=$formule", Border::BORDER_MEDIUM,Border::BORDER_MEDIUM);

    $formule = "";
    ++$colonnes;
    for ($i=20;$i>0;$i-=3) {
        $formule .= $feuille->getCell([$colonnes-$i,$lignes])->getColumn();
        $formule .= $feuille->getCell([$colonnes-$i,$lignes])->getRow();
        $formule .= "*";
        $formule .= $feuille->getCell([$colonnes-$i-1,$lignes])->getColumn();
        $formule .= $feuille->getCell([$colonnes-$i-1,$lignes])->getRow();
        $formule .= "*";
        $formule .= $feuille->getCell([$colonnes-$i-2,$lignes])->getColumn();
        $formule .= $feuille->getCell([$colonnes-$i-2,$lignes])->getRow();
        $formule .= "*";
        $formule .= match ($i) {
            20 => "1.5*" . ($les_affectations["CHARGE_MULT_CM"] == "" ? 1 : $les_affectations["CHARGE_MULT_CM"]),
            17 => ($les_affectations["CHARGE_MULT_TD"] == "" ? 1 : $les_affectations["CHARGE_MULT_TD"]),
            14 => ($les_affectations["CHARGE_MULT_TDR"] == "" ? 1 : $les_affectations["CHARGE_MULT_TDR"]),
            11 => ($les_affectations["CHARGE_MULT_TP"] == "" ? 1 : $les_affectations["CHARGE_MULT_TP"]),
            8 => "(0.85)*" . ($les_affectations["CHARGE_MULT_TPR"] == "" ? 1 : $les_affectations["CHARGE_MULT_TPR"]),
            5 => "(0.67)*" . ($les_affectations["CHARGE_MULT_TPV"] == "" ? 1 : $les_affectations["CHARGE_MULT_TPV"]),
            2 => ($les_affectations["CHARGE_MULT_DS"] == "" ? 1 : $les_affectations["CHARGE_MULT_DS"]),
        };
        $formule .= "+";
    }
    $formule .= "0";
    makeEntete($feuille,$colonnes, $lignes, "=$formule", Border::BORDER_MEDIUM,Border::BORDER_MEDIUM);

    return $colonnes;
}