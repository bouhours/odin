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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {
    $annee_courante = Annees::getIdAnneeCourante();
    if (isset($_GET['bfmw_num_a'])) {
        $annee_courante = $_GET['bfmw_num_a'];
    }
    if (isset($_GET['bfmw_orig_m']) && $_GET['bfmw_num_m'] != "") {
        $req = "SELECT * FROM affectations_enseignants WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND ENS_MAT_ANNEE_ID=$annee_courante AND MAT_ID=" . $_GET['bfmw_num_m'];
        if ($conn->query($req)->num_rows == 0) {
            echo "Accès interdit.";
        } else {
            //Initialisation de PhpExcel
            $objSpreadsheet = new Spreadsheet();
            $objSpreadsheet->setActiveSheetIndex(0);
            $feuille = $objSpreadsheet->getActiveSheet();

            //Initialisation des requêtes

            $nom_matiere = "";
            $colonnes = 1;
            $lignes = 1;
            $feuille->setCellValue([$colonnes, $lignes], "NUMERO")->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes, $lignes + 1], "")->getCell([$colonnes, $lignes + 1])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes++, $lignes + 2], "")->getCell([$colonnes - 1, $lignes + 2])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes, $lignes], "GROUPE")->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes, $lignes + 1], "")->getCell([$colonnes, $lignes + 1])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes++, $lignes + 2], "")->getCell([$colonnes - 1, $lignes + 2])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes, $lignes], "NOM")->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes, $lignes + 1], "BAREME")->getCell([$colonnes, $lignes + 1])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes++, $lignes + 2], "COEFFICIENT")->getCell([$colonnes - 1, $lignes + 2])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));

            //Récupération de la matière
            $req = "SELECT * FROM common_matiere WHERE MAT_ID=" . $_GET['bfmw_num_m'];
            if ($matiere = $conn->query($req)->fetch_assoc()) {
                $nom_matiere = str_replace("\n","_",trim($matiere['MAT_NOM']));
            }

            //Préparation du fichier
            $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
                    ->setLastModifiedBy($_SESSION['notes_nom'])
                    ->setTitle("Bilan matière : $nom_matiere");
            $feuille->setTitle("Résultats");

            //Liste des contrôles de la matière
            $req = "SELECT * FROM `common_controle` WHERE CONTROLE_MAT_ID=" . $_GET['bfmw_num_m'] . " AND CONTROLE_VALIDE = '1' AND CONTROLE_ANNEE_ID=$annee_courante";
            $resCONTROLE = $conn->query($req);
            $lesControles = array();
            while ($unControle = $resCONTROLE->fetch_assoc()) {
                array_push($lesControles, $unControle);
                $feuille->setCellValue([$colonnes, $lignes], $unControle['CONTROLE_NOM'])->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
                $feuille->setCellValue([$colonnes, $lignes + 1], $unControle['CONTROLE_BAREME'])->getCell([$colonnes, $lignes + 1])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
                $feuille->setCellValue([$colonnes++, $lignes + 2], $unControle['CONTROLE_COEFF'])->getCell([$colonnes - 1, $lignes + 2])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
            }

            $feuille->setCellValue([$colonnes, $lignes], "MOYENNE")->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes, $lignes + 1], "20")->getCell([$colonnes, $lignes + 1])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            $feuille->setCellValue([$colonnes++, $lignes + 2], "")->getCell([$colonnes - 1, $lignes + 2])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));

            $colonnes++;
            $lignes++;
            $lignes++;
            //Liste des étudiants
            $req = "SELECT DISTINCT ET_ID,ET_NOM,ET_NUMERO,GROUPE_NOM FROM etudiants_groupes,common_inscription,affectations_enseignants,semestres_groupes_code WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND ENS_MAT_ANNEE_ID=$annee_courante AND ET_ID = INSCRIPT_ET_ID AND INSCRIPT_ANNEE_ID = $annee_courante AND SEM_ID=INSCRIPT_SEM_ID AND SEM_ID=GROUPE_SEM_ID AND GROUPE_ID = SEM_GROUPE_ID AND MAT_ID=" . $_GET['bfmw_num_m'] . " AND GROUPE_FEUILLE='1' ORDER BY GROUPE_NOM,ET_NOM";
            $resETUDIANTS = $conn->query($req);
            while ($unEtudiant = $resETUDIANTS->fetch_assoc()) {
                $colonnes = 1;
                $feuille->setCellValue([$colonnes++, ++$lignes], $unEtudiant['ET_NUMERO'])->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
                $feuille->setCellValue([$colonnes++, $lignes], $unEtudiant['GROUPE_NOM'])->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
                $feuille->setCellValue([$colonnes++, $lignes], $unEtudiant['ET_NOM'])->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));

                foreach ($lesControles as $unControle) {
                    $req = "SELECT * FROM common_notes WHERE NOTES_CONTROLE_ID=" . $unControle['CONTROLE_ID'] . " AND NOTES_ET_ID=" . $unEtudiant['ET_ID'];
                    $resNOTES = $conn->query($req);
                    if ($une_note = $resNOTES->fetch_assoc()) {
                        $feuille->setCellValue([$colonnes++, $lignes], ($une_note['NOTES_VALEUR'] == "" ? $une_note['NOTES_SPECIAL'] : $une_note['NOTES_VALEUR']));
                        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);
                        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFont()->setBold(true);
                    } else {
                        $feuille->setCellValue([$colonnes++, $lignes], "");
                    }
                }

                $req = "SELECT ROUND(MOYMAT_VALEUR,2) AS MOYENNE FROM ".CURRENT_DEPT."_notes_moyennes_matiere WHERE `MOYMAT_MAT_ID`=" . $_GET['bfmw_num_m'] . " AND `MOYMAT_ET_ID`=" . $unEtudiant['ET_ID'] . " AND `MOYMAT_ANNEE_ID`=$annee_courante";
                if ($moyenne = $conn->query($req)->fetch_assoc()) {
                    $feuille->setCellValue([$colonnes++, $lignes], $moyenne['MOYENNE']);
                    //$feuille->getCell([$colonnes - 1, $lignes)->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);
                } else {
                    $feuille->setCellValue([$colonnes++, $lignes], "");
                }
                $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFont()->setBold(true);
                $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFill()->applyFromArray(array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ));
            }

            $colonnes = 1;
            $lignes++;
            $colonnes++;
            $colonnes++;
            $feuille->setCellValue([$colonnes++, ++$lignes], "MOYENNE")->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFD9D9')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true
                )
            ));
            foreach ($lesControles as $unControle) {
                $req = "SELECT ROUND(AVG(NOTES_VALEUR),2) AS MOYENNE FROM common_notes WHERE NOTES_CONTROLE_ID=" . $unControle['CONTROLE_ID'];
                $resMOY = $conn->query($req);
                if ($une_moyenne = $resMOY->fetch_assoc()) {
                    $feuille->setCellValue([$colonnes++, $lignes], $une_moyenne['MOYENNE'])->getCell([$colonnes - 1, $lignes])->getStyle()->getFill()->applyFromArray(array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ));
                    $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);
                    $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFont()->setBold(true);
                } else {
                    $feuille->setCellValue([$colonnes++, $lignes], "")->getCell([$colonnes - 1, $lignes])->getStyle()->getFill()->applyFromArray(array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ));
                }
            }

            $req = "SELECT ROUND(AVG(MOYMAT_VALEUR),2) AS MOYENNE FROM ".CURRENT_DEPT."_notes_moyennes_matiere WHERE `MOYMAT_MAT_ID`=" . $_GET['bfmw_num_m'] . " AND `MOYMAT_ANNEE_ID`=$annee_courante";
            $resMOY = $conn->query($req);
            if ($une_moyenne = $resMOY->fetch_assoc()) {
                $feuille->setCellValue([$colonnes++, $lignes], $une_moyenne['MOYENNE'])->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
                $feuille->getCell([$colonnes - 1, $lignes])->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_RED);
            } else {
                $feuille->setCellValue([$colonnes++, $lignes], "")->getCell([$colonnes - 1, $lignes])->getStyle()->applyFromArray(array(
                    'fill' => array(
                        'fillType' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFD9D9')
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'bold' => true
                    )
                ));
            }

            //Mise en place de la taille
            for ($i = 1; $i < $colonnes; $i++) {
                $feuille->getColumnDimensionByColumn($i)->setAutoSize(true);
            }


            //Sortie
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            if (isset($_GET['bfmw_orig_type']) && $_GET['bfmw_orig_type'] == "ods") {
                header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
                header('Content-Disposition: attachment;filename="RESULTATS_' . $nom_matiere . '.ods"');
                $objWriter = IOFactory::createWriter($objSpreadsheet, 'Ods');
            } else if (isset($_GET['bfmw_orig_type']) && $_GET['bfmw_orig_type'] == "csv") {
                header('Content-Type: application/x-download');
                header('Content-Disposition: attachment;filename="RESULTATS_' . $nom_matiere . '.csv"');
                $objWriter = IOFactory::createWriter($objSpreadsheet, 'Csv')
                        ->setDelimiter(',')
                        ->setEnclosure('"')
                        ->setSheetIndex(0);
            } else {
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="RESULTATS_' . $nom_matiere . '.xlsx"');
                $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
                //$objWriter->setOffice2003Compatibility(true);
            }
            $objWriter->save('php://output');
            exit;
        }
    }
}
exit;
