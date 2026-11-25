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
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {

    if (isset($_GET['bfmw_orig_c'])) {

        //Initialisation de PhpExcel
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->setActiveSheetIndex(0);
        $feuille = $objSpreadsheet->getActiveSheet();

        $annee_courante = Annees::getIdAnneeCourante();
        if (isset($_GET['bfmw_num_a'])) {
            $annee_courante = $_GET['bfmw_num_a'];
        }

        $req = "SELECT ET_ID,ET_NOM,ET_NUMERO,GROUPE_NOM, ET_MAIL, NOTES_VALEUR, NOTES_AVIS, CONTROLE_NOM, NOTES_SPECIAL FROM common_controle, common_notes, etudiants_groupes, affectations_enseignants, common_semestres_groupes WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=GROUPE_SEM_ID AND SEM_GROUPE_ID=GROUPE_ID AND MAT_ID=CONTROLE_MAT_ID AND CONTROLE_ENS_ID=MAT_ENS_ID AND ET_GROUPE_ANNEE_ID=$annee_courante AND ENS_MAT_ANNEE_ID=$annee_courante AND ET_ID=NOTES_ET_ID AND GROUPE_FEUILLE=1 AND CONTROLE_ID=NOTES_CONTROLE_ID AND CONTROLE_ID=".$_GET['bfmw_num_c']." ORDER BY ET_NOM";
        $res = $conn->query($req);
        if ($res->num_rows > 0) {
            $les_etudiants = array();
            $controle_nom = "";
            //Cellules contenant les étudiants
            $ligne = 3;
            while ($un_etudiant = $res->fetch_assoc()) {
                $nomgroupe = $un_etudiant['GROUPE_NOM'];


                $feuille->setCellValue([1, $ligne], $nomgroupe)
                    ->getCell([1, $ligne])->getStyle()->getFill()->applyFromArray(array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    ));
                $feuille->setCellValue([2, $ligne], $un_etudiant['ET_MAIL'])
                    ->getCell([2, $ligne])->getStyle()->getFill()->applyFromArray(array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    ));
                $feuille->setCellValue([3, $ligne], $un_etudiant['ET_NOM'])
                    ->getCell([3, $ligne])->getStyle()->getFill()->applyFromArray(array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    ));
                $feuille->setCellValue([4, $ligne], $un_etudiant['ET_NUMERO'])
                    ->getCell([4, $ligne])->getStyle()->getFill()->applyFromArray(array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    ));
                $feuille->setCellValue([5, $ligne], $un_etudiant['NOTES_VALEUR'] == "" ? $un_etudiant['NOTES_SPECIAL'] : $un_etudiant['NOTES_VALEUR']);
                $feuille->setCellValue([6, $ligne++], $un_etudiant['NOTES_AVIS']);

                $controle_nom = $un_etudiant['CONTROLE_NOM'];
            }

            //Préparation du fichier
            $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
                ->setLastModifiedBy($_SESSION['notes_nom'])
                ->setTitle("$controle_nom");
            $feuille->setTitle(str_replace($feuille->getInvalidCharacters(), '', substr($controle_nom,0,Worksheet::SHEET_TITLE_MAXIMUM_LENGTH)));

            //Cellules d'entête
            $feuille->setCellValue('A1', 'GROUPE')->getCell('A1')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue('B1', 'MAIL')->getCell('B1')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue('C1', 'NOM')->getCell('C1')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue('D1', 'NUMERO')->getCell('D1')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue('E1', 'NOTES (0->[Barême];ABI;ABJ)')->getCell('E1')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue('F1', 'AVIS')->getCell('F1')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell('A2')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell('B2')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell('C2')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell('D2')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell('E2')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell('F2')->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));

            //Style
            $feuille->getCell([1, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([2, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([3, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([4, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([5, $ligne++])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([1, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([2, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->getCell([3, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue([4, $ligne], "MOYENNE")
                ->getCell([4, $ligne])->getStyle()->getFill()->applyFromArray(array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ));
            $feuille->setCellValue([5, $ligne], "=AVERAGE(E3:E" . ($ligne - 2) . ")")
                ->getCell([5, $ligne])->getStyle()->getFill()->applyFromArray(array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'D9D9D9')
                ));

            //Protection des colonnes
            $feuille->getProtection()->setSheet(true);
            $feuille->getStyle('E3:E' . ($ligne - 2))->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

            //Mise en place de la taille
            $feuille->getColumnDimension('A')->setAutoSize(true);
            $feuille->getColumnDimension('B')->setAutoSize(true);
            $feuille->getColumnDimension('C')->setAutoSize(true);
            $feuille->getColumnDimension('D')->setAutoSize(true);
            $feuille->getColumnDimension('E')->setAutoSize(true);

            //Sortie
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            if (isset($_GET['bfmw_orig_type']) && $_GET['bfmw_orig_type'] == "ods") {
                header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
                header('Content-Disposition: attachment;filename="CONTROLE_' . $controle_nom . '.ods"');
                $objWriter = IOFactory::createWriter($objSpreadsheet, 'Ods');
            } else if (isset($_GET['bfmw_orig_type']) && $_GET['bfmw_orig_type'] == "csv") {
                header('Content-Type: application/x-download');
                header('Content-Disposition: attachment;filename="CONTROLE_' . $controle_nom . '.csv"');
                $objWriter = IOFactory::createWriter($objSpreadsheet, 'Csv')
                    ->setDelimiter(',')
                    ->setEnclosure('"')
                    ->setSheetIndex(0);
            } else {
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="CONTROLE_' . substr($controle_nom, 0, 30) . '.xlsx"');
                $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
            }
        } else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="CONTROLE_PAS_DE_NOTES.xlsx"');
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
            //$objWriter->setOffice2003Compatibility(true);
        }
        $objWriter->save('php://output');
        exit;
    }
}
exit;
