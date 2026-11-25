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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

if ((Formations::isMediateur() || Formations::isSecretaire() || Formations::isResponsable()) && isset($_GET['bfmw_orig_generate']) && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_num_groupe'])) {

    $annee_courante = Annees::getIdAnneeCourante();
    if (isset($_POST['bfmw_num_a'])) {
        $annee_courante = $_POST['bfmw_num_a'];
    }


    $formations_autorisees = Formations::getFormationsDuConnecteString();

    $les_resultats = Resultats::getBilanPourUnGroupe($annee_courante,$_POST['bfmw_num_groupe'],CURRENT_DEPT);

    try {
        //Initialisation de PhpExcel
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->setActiveSheetIndex(0);
        $feuille = $objSpreadsheet->getActiveSheet();
        $feuille->setTitle("COMPETENCES");


        //Initialisation des requêtes
        $colonne = 1;
        $ligne = 1;

        //Préparation des styles conditionnels
        $lesStylesConditionnels = [];
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"ADM"', "00B050");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"AJAC"', "0070C0");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"?"', "FFFF00");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"RED"', "7030A0");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"ELIM"', "FF0000");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"VDJ"', "A9D08E");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"ADCD"', "8D2323");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"ATST"', "8EA9DB");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"ATT"', "FFFFFF");
        $lesStylesConditionnels[] = ajouterStyleConditonnel('"DEM"', "FFFFFF");
        $feuille->getStyle('A:ZZ')->setConditionalStyles($lesStylesConditionnels);

        makeEntete($feuille,$colonne,$ligne,"BAC",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        makeEntete($feuille,$colonne+1,$ligne,"NOM - PRENOM",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        makeEntete($feuille,$colonne+2,$ligne,"ANNEE",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        makeEntete($feuille,$colonne+3,$ligne,"Niveau",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        makeEntete($feuille,$colonne+4,$ligne,"Résultats",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        $ligne++;
        makeEntete($feuille,$colonne,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        $feuille->mergeCells(array($colonne,$ligne-1,$colonne,$ligne));
        makeEntete($feuille,$colonne+1,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        $feuille->mergeCells(array($colonne+1,$ligne-1,$colonne+1,$ligne));
        makeEntete($feuille,$colonne+2,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        $feuille->mergeCells(array($colonne+2,$ligne-1,$colonne+2,$ligne));
        makeEntete($feuille,$colonne+3,$ligne,"",Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN);
        $feuille->mergeCells(array($colonne+3,$ligne-1,$colonne+3,$ligne));

        $etudiant_courant = -1;
        $annee_en_cours = -1;
        $niveau_courant = -1;
        $regroupement_courant = -1;
        $ligne_etudiant = $ligne;
        $ligne_annee = $ligne;
        $colonne_regroupement = $colonne;
        $merge_done = false;
        $ligne_de_etudiant = true;
        $premiere_ligne_etudiant = true;
        foreach ($les_resultats as $un_resultat) {
            if ($etudiant_courant != $un_resultat["ET_ID"]) {
                if ($colonne_regroupement != $colonne && !$merge_done) {
                    for ($i=$colonne+5;$i<$colonne_regroupement;$i++) {
                        makeEntete($feuille, $i, $ligne - 1, "", Border::BORDER_THIN, Border::BORDER_THIN, Border::BORDER_THIN, Border::BORDER_THIN);
                    }
                    //Merge le titre RESULTAT
                    $feuille->mergeCells(array($colonne+4,$ligne-1,$colonne_regroupement-1,$ligne-1));

                    $merge_done = true;
                }
                $etudiant_courant = $un_resultat["ET_ID"];
                $annee_en_cours = -1;
                $niveau_courant = -1;
                $regroupement_courant = -1;
                if ($ligne_annee-$ligne_etudiant > 0) {
                    for ($i=$ligne_etudiant+1;$i<=$ligne_annee;$i++) {
                        makeData($feuille, 1, $i, "", Border::BORDER_THIN, Border::BORDER_THIN);
                        makeData($feuille, 2, $i, "", Border::BORDER_THIN, Border::BORDER_THIN);
                    }
                    //Merge BAC
                    $feuille->mergeCells(array(1,$ligne_etudiant,1,$ligne_annee));
                    //Merge Nom
                    $feuille->mergeCells(array(2,$ligne_etudiant,2,$ligne_annee));
                }
                $ligne_etudiant = $ligne_annee+1;
                $ligne_annee = $ligne_etudiant-1;
                makeData($feuille,$colonne,$ligne_etudiant,$un_resultat["ET_BAC"],Border::BORDER_THIN,Border::BORDER_THIN, Border::BORDER_MEDIUM);
                makeData($feuille,$colonne+1,$ligne_etudiant,$un_resultat["ET_NOM"],Border::BORDER_THIN,Border::BORDER_THIN, Border::BORDER_MEDIUM);
                $ligne_de_etudiant = true;
            }
            if ($annee_en_cours != $un_resultat["ANNEE_ID"]) {
                $annee_en_cours = $un_resultat["ANNEE_ID"];
                $niveau_courant = -1;
                $regroupement_courant = -1;
                if ($ligne_etudiant != $ligne_annee+1) {
                    $ligne_de_etudiant = false;
                }
                makeData($feuille,$colonne+2,++$ligne_annee,$un_resultat["ANNEE_NOM"],Border::BORDER_THIN,Border::BORDER_THIN,($ligne_de_etudiant?Border::BORDER_MEDIUM:Border::BORDER_DOTTED),Border::BORDER_DOTTED);
                if ($colonne_regroupement != $colonne) {
                    if ($premiere_ligne_etudiant) {
                        $ligne_annee--;
                        $annee_en_cours--;
                    }
                    $colonne_regroupement = affecterFormuleCalcul($colonne_regroupement, $colonne, $ligne_annee, $annee_courante, $annee_en_cours, $feuille, $ligne_de_etudiant);
                    if ($premiere_ligne_etudiant) {
                        $premiere_ligne_etudiant = false;
                        $colonne_regroupement = affecterFormuleCalcul(--$colonne_regroupement, $colonne, ++$ligne_annee, $annee_courante, ++$annee_en_cours, $feuille, $ligne_de_etudiant);
                    }
                }
            }

            if ($niveau_courant != $un_resultat["NIVEAU_ID"]) {
                $niveau_courant = $un_resultat["NIVEAU_ID"];
                $regroupement_courant = -1;
                $colonne_regroupement = $colonne+4;
                makeData($feuille,$colonne+3,$ligne_annee,$un_resultat["NIVEAU_NOM"],Border::BORDER_THIN,Border::BORDER_THIN,($ligne_de_etudiant?Border::BORDER_MEDIUM:Border::BORDER_DOTTED),Border::BORDER_DOTTED);

            }

            if ($regroupement_courant != $un_resultat["REGROUP_ID"]) {
                $regroupement_courant = $un_resultat["REGROUP_ID"];
                if (!$merge_done) {
                    makeEntete($feuille,$colonne_regroupement,$ligne,$un_resultat["REGROUP_NOM"],Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_THIN,Border::BORDER_DOTTED);
                }
                makeData($feuille,$colonne_regroupement++,$ligne_annee,$un_resultat["SPECIAL"]??$un_resultat["VALEUR"],Border::BORDER_THIN,Border::BORDER_THIN,($ligne_de_etudiant?Border::BORDER_MEDIUM:Border::BORDER_DOTTED),Border::BORDER_DOTTED);
                if ($un_resultat["SPECIAL"] != "") {
                    $couleur = Color::COLOR_RED;
                } else if ($un_resultat["VALEUR"] < 8) {
                    $couleur = '808000';
                } else if ($un_resultat["VALEUR"] < 10) {
                    $couleur = '538DD5';
                } else {
                    $couleur = 'C4D79B';
                }
                $feuille->getCell([$colonne_regroupement-1,$ligne_annee])->getStyle()->applyFromArray(array('fill' => array('fillType' => Fill::FILL_SOLID,'color' => array('rgb' => $couleur))));

                if ($un_resultat["BARREE"] != "") {
                    $feuille->getCell([$colonne_regroupement-1,$ligne_annee])->getStyle()->getFont()->setColor(new Color((Color::COLOR_RED)));
                }
            }
        }

        if ($ligne_annee-$ligne_etudiant > 0) {
            for ($i=$ligne_etudiant+1;$i<=$ligne_annee;$i++) {
                makeData($feuille, 1, $i, "", Border::BORDER_THIN, Border::BORDER_THIN);
                makeData($feuille, 2, $i, "", Border::BORDER_THIN, Border::BORDER_THIN);
            }
            $feuille->mergeCells(array(1,$ligne_etudiant,1,$ligne_annee));
            $feuille->mergeCells(array(2,$ligne_etudiant,2,$ligne_annee));
        }




        //Fusion des cellules d'entête
        miseEnPage($feuille);

        $groupe_nom = Groupes::getGroupe($_POST['bfmw_num_groupe'])[0]['GROUPE_NOM'];

        //Préparation du fichier
        $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
            ->setLastModifiedBy($_SESSION['notes_nom'])
            ->setTitle("Bilan de compétence - ".$groupe_nom);
        //Sortie
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        if (isset($_POST['bfmw_orig_generer_competences_ods'])) {
            header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
            header('Content-Disposition: attachment;filename="BILAN_COMPETENCES_' . $groupe_nom . '.ods"');
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Ods');
        } else if (isset($_POST['bfmw_orig_generer_competences_csv'])) {
            header('Content-Type: application/x-download');
            header('Content-Disposition: attachment;filename="BILAN_COMPETENCES_' . $groupe_nom . '.csv"');
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Csv')
                ->setDelimiter(',')
                ->setEnclosure('"')
                ->setSheetIndex(0);
        } else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="BILAN_COMPETENCES_' . $groupe_nom . '.xlsx"');
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
        }

        $objWriter->save('php://output');
    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        var_dump($e);
    }
    exit;
}

function makeEntete(Worksheet $feuille,int $colonnes,int $lignes,string $titre,string $right, string $left, string $top, string $bottom, string $horizontal_alignement = Alignment::HORIZONTAL_CENTER, bool $wrap_text = true, string $fill="E6B8B8")
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

function makeData(Worksheet $feuille,int $colonnes,int $lignes,$titre,string $right, string $left, string $top=Border::BORDER_THIN, string $bottom=Border::BORDER_THIN, string $horizontal_alignement = Alignment::HORIZONTAL_CENTER, bool $wrap_text = true)
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
        )
    ));
}

function miseEnPage(Worksheet $feuille): void
{
    $feuille->freezePane("A3");
    $feuille->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);
    $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
    for ($i=1;$i<12;$i++) {
        $feuille->getColumnDimensionByColumn($i)->setAutoSize(1);
    }
    $feuille->getPageSetup()->setFitToWidth(1);
    $feuille->getPageSetup()->setFitToHeight(0);
    $feuille->getPageMargins()->setBottom(0);
    $feuille->getPageMargins()->setTop(0);
    $feuille->getPageMargins()->setLeft(0.1);
    $feuille->getPageMargins()->setRight(0.1);
}

function affecterFormuleCalcul(int $colonne_regroupement, int $colonne, int $ligne_annee, int $annee_courante, int $annee_en_cours, Worksheet $feuille, bool $ligne_de_etudiant): int
{
    $intervale_competences = (Coordinate::stringFromColumnIndex($colonne + 4)) . ($ligne_annee) . ':' . (Coordinate::stringFromColumnIndex($colonne_regroupement - 1)) . ($ligne_annee);
    $formule =
        '=IF(' . $annee_courante . '=' . $annee_en_cours . ',' .
        'IF(COUNTIF(' . $intervale_competences . ',"<8")>=1,"?",' .
        'IF(COUNTIF(' . $intervale_competences . ',"<10")>=INT(COUNT(' . $intervale_competences . ')/2),"?",' .
        'IF(COUNTIF(' . $intervale_competences . ',">=10")=COUNT(' . $intervale_competences . '),"ADM","AJAC")' .
        ')' .
        '),' .
        '"" )';
    makeData($feuille, $colonne_regroupement++, $ligne_annee, $formule, Border::BORDER_THIN, Border::BORDER_THIN, ($ligne_de_etudiant ? Border::BORDER_MEDIUM : Border::BORDER_DOTTED), Border::BORDER_DOTTED);
    return $colonne_regroupement;
}

function ajouterStyleConditonnel(bool|float|int|string $valeurCondition, string $couleur, string $conditionType = Conditional::CONDITION_CELLIS, string $operateur = Conditional::OPERATOR_EQUAL) : Conditional
{
    $condition = new Conditional();
    $condition->setConditionType($conditionType );
    $condition->setOperatorType($operateur);
    $condition->addCondition($valeurCondition);
    $condition->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB($couleur);
    return $condition;
}