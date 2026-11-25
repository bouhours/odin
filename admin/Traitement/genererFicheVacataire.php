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
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {

    if (isset($_GET['bfmw_num_a'])) {
        $annee = Annees::getAnneeCourante()[0];
        $annee_courante = $annee["ANNEE_ID"];
        $departement = Departements::getDepartement(CURRENT_DEPT_ID)[0];

        try {
            if ($_GET["bfmw_num_c"] == 0) {
                $objSpreadsheet = IOFactory::load("Templates/fiche_permanent.xlsx");
            } else {
                $objSpreadsheet = IOFactory::load("Templates/fiche_vacataire.xlsx");
            }

            $objSpreadsheet->setActiveSheetIndex(0);
            $feuille = $objSpreadsheet->getActiveSheet();
            $feuille->setCellValue('A2', "Année Universitaire ".$annee["ANNEE_NOM"]);
            $feuille->setCellValue('A3', $departement["DEPT_NOM"]);
            //$today = new DateTime();
            //$feuille->setCellValue('A25', "A _ _ _ _ _ _ _ _ _ _ _ _ _le, ".$today->format("d/m/Y"));


            $nom_enseignant = "";
            if (isset($_POST['bfmw_num_ens_id']) && isset($_POST['bfmw_num_affect_id']) && isset($_POST['bfmw_orig_code_apogee'])) {
                $code_ade = Enseignants::getEnseigant($_POST['bfmw_num_ens_id'])[0]["ENS_ADE"];
                ChargeEnseignements::basculerEnReel($code_ade, $_POST['bfmw_num_affect_id'],$_POST['bfmw_orig_code_apogee']);
                $les_charges = ChargeEnseignements::computeChargeEqTDDetailParMatiere($annee_courante, CURRENT_DEPT_ID,$_GET["bfmw_num_c"], $_POST['bfmw_num_ens_id']);
            } else {
                $les_charges = ChargeEnseignements::computeChargeEqTDDetailParMatiere($annee_courante, CURRENT_DEPT_ID,$_GET["bfmw_num_c"]);
            }
            $i=0;
            foreach ($les_charges as $ENS_ID => $les_interventions) {
                $nom_enseignant = $les_interventions[0]["ENS_NOM"];
                try {
                        $i++;
                        $objSpreadsheet->setActiveSheetIndex(0);
                        $feuille = $objSpreadsheet->getActiveSheet();
                        $clonedWorksheet = clone $feuille;
                        $clonedWorksheet->setTitle($les_interventions[0]["ENS_NOM"]);
                        $objSpreadsheet->addSheet($clonedWorksheet);
                        $objSpreadsheet->setActiveSheetIndex($i);
                        $feuille = $objSpreadsheet->getActiveSheet();
                        $feuille->setCellValue('B4', $les_interventions[0]["ENS_NOM"]);
                        $feuille->setCellValue('I4', $les_interventions[0]["ENS_NAISSANCE"] ?? "");

                        $ligne = 9;
                        if (count($les_interventions) > 7) {
                            $feuille->insertNewRowBefore(14, count($les_interventions) - 7);
                        }
                        foreach ($les_interventions as $une_charge) {
                            $feuille->setCellValue('A' . $ligne, $une_charge["FORM_NOM_COURT"] ?? "");
                            $feuille->setCellValue('B' . $ligne, $une_charge["UE_CODE_APOGEE"] ?? "");
                            $feuille->setCellValue('C' . $ligne, $une_charge["MAT_CODE_APOGE"] ?? "");
                            $feuille->setCellValue('D' . $ligne, $une_charge["MAT_NOM"] ?? "");
                            $feuille->setCellValue('E' . $ligne, $une_charge["PERIODE_PAIEMENT"] ?? "");
                            $feuille->setCellValue('F' . $ligne, $une_charge["TOTAL_CM"] ?? "");
                            $feuille->setCellValue('G' . $ligne, $une_charge["TOTAL_TD"] ?? "");
                            $feuille->setCellValue('H' . $ligne, $une_charge["TOTAL_TP"] ?? "");
                            if ($une_charge["PERIODE_PAIEMENT"] == "P1") {
                                $feuille->setCellValue('I' . $ligne, $une_charge["REEL_CM"] ?? "");
                                $feuille->setCellValue('J' . $ligne, $une_charge["REEL_TD"] ?? "");
                                $feuille->setCellValue('K' . $ligne, $une_charge["REEL_TP"] ?? "");
                            } else if ($une_charge["PERIODE_PAIEMENT"] == "P2") {
                                $feuille->setCellValue('L' . $ligne, $une_charge["REEL_CM"] ?? "");
                                $feuille->setCellValue('M' . $ligne, $une_charge["REEL_TD"] ?? "");
                                $feuille->setCellValue('N' . $ligne, $une_charge["REEL_TP"] ?? "");
                            } else {
                                $feuille->setCellValue('O' . $ligne, $une_charge["REEL_CM"] ?? "");
                                $feuille->setCellValue('P' . $ligne, $une_charge["REEL_TD"] ?? "");
                                $feuille->setCellValue('Q' . $ligne, $une_charge["REEL_TP"] ?? "");
                            }

                            $ligne++;
                        }
                        //Préparation de l'impression
                        $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                        $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                        $feuille->getPageSetup()->setFitToHeight(0);
                        /*$feuille->getPageMargins()->setBottom(0.2);
                        $feuille->getPageMargins()->setTop(0.2);
                        $feuille->getPageMargins()->setLeft(0.1);
                        $feuille->getPageMargins()->setRight(0.1);*/
                } catch (Exception $e) {
                    $i--;
                    continue;
                }
            }

            $objSpreadsheet->removeSheetByIndex(0);
            $objSpreadsheet->setActiveSheetIndex(0);

            //Sortie
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if ($_GET["bfmw_num_c"] == 0) {
                header('Content-Disposition: attachment;filename="Fiche prévisionnelle des permanents.xlsx"');
            } else {
                if (isset($_POST['bfmw_num_ens_id'])) {
                    header('Content-Disposition: attachment;filename="Fiche de mise en paiement - '.$nom_enseignant.' .xlsx"');
                } else {
                    header('Content-Disposition: attachment;filename="Fiche prévisionnelle des vacataires.xlsx"');
                }

            }
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
            //$objWriter->setOffice2003Compatibility(true);
            $objWriter->save('php://output');
            exit;
        } catch (Exception $e) {

        }
    }
}