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

if (isAdmin() || Formations::isSecretaire()) {

    $req = "SELECT * FROM common_annee WHERE ANNEE_COURANTE = 1";
    $res = $conn->query($req);
    $annee_courante = $res->fetch_assoc();

    $req = "SELECT * FROM common_departement, common_enseignant WHERE ENS_ID=DEPT_ENS_ID AND DEPT_ID=".CURRENT_DEPT_ID;
    
    $res = $conn->query($req);
    $departement_courant = $res->fetch_assoc();

    /**
     * Collecte des étudiants en base
     */
    $req = "SELECT * FROM etudiants_groupes, common_formation WHERE FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND GROUPE_POURSUITE=1 AND ET_GROUPE_ANNEE_ID=".$annee_courante['ANNEE_ID']." GROUP BY ET_ID ORDER BY ET_NOM";
    $res = $conn->query($req);
    $lesEtudiantsConcernes = array();
    while ($unEtudiant = $res->fetch_assoc()) {
        $lesEtudiantsConcernes[$unEtudiant['ET_ID']] = $unEtudiant;
    }

    /**
     * Collecte des avis en base
     */
    $req = "SELECT * FROM (common_poursuite_avis,common_poursuite_matiere, common_enseignant) LEFT JOIN common_poursuite_niveau_matiere ON (NIVEAU_PMAT_ID=PMAT_ID AND NIVEAU_ANNEE_ID=".$annee_courante['ANNEE_ID'].") WHERE AVIS_ANNEE_ID=".$annee_courante['ANNEE_ID']." AND ENS_ID=AVIS_ENS_ID AND PMAT_ID=AVIS_PMAT_ID AND PMAT_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY PMAT_NOM";
    $res = $conn->query($req);
    while ($uneMatiere = $res->fetch_assoc()) {
        if (array_key_exists($uneMatiere['AVIS_ET_ID'], $lesEtudiantsConcernes)) {
            $lesEtudiantsConcernes[$uneMatiere['AVIS_ET_ID']]['MATIERES'][] = $uneMatiere;
        }
    }

    /**
     * Enseignants par matières
     */
    $req = "SELECT ENS_NOM, MAT_PMAT_ID FROM common_poursuite_matiere_composition, affectations_enseignants, common_enseignant WHERE SEM_START_ANNEE_ID <= ".$annee_courante['ANNEE_ID']." AND (SEM_END_ANNEE_ID > ".$annee_courante['ANNEE_ID']." OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= ".$annee_courante['ANNEE_ID']." AND (UE_END_ANNEE_ID > ".$annee_courante['ANNEE_ID']." OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= ".$annee_courante['ANNEE_ID']." AND (MAT_END_ANNEE_ID > ".$annee_courante['ANNEE_ID']." OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=PMAT_MAT_ID AND ENS_ID=MAT_ENS_ID AND ANNEE_ID=ENS_MAT_ANNEE_ID AND FORM_DEPT_ID=".CURRENT_DEPT_ID." AND  ANNEE_ID=".$annee_courante['ANNEE_ID']." GROUP BY MAT_PMAT_ID,ENS_ID ORDER BY ENS_NOM";
    $res = $conn->query($req);
    $lesEnseignantsDeMatiere = array();
    while ($uneMatiere = $res->fetch_assoc()) {
        if (isset($lesEnseignantsDeMatiere[$uneMatiere['MAT_PMAT_ID']])) {
            $lesEnseignantsDeMatiere[$uneMatiere['MAT_PMAT_ID']] .= "\n".$uneMatiere['ENS_NOM'];
        } else {
            $lesEnseignantsDeMatiere[$uneMatiere['MAT_PMAT_ID']] = $uneMatiere['ENS_NOM'];
        }
    }

    /**
     * Avis et appréciation générale
     */
    $req = "SELECT * FROM common_poursuite_etudiants WHERE POURSUITE_ANNEE_ID=".$annee_courante['ANNEE_ID'];
    $res = $conn->query($req);
    while ($unAvisG = $res->fetch_assoc()) {
        if (array_key_exists($unAvisG['POURSUITE_ET_ID'], $lesEtudiantsConcernes)) {
            $lesEtudiantsConcernes[$unAvisG['POURSUITE_ET_ID']]['GENERAL'] = $unAvisG;
        }
    }

    /**
     * Nombre d'avis
     */
    $req = "SELECT * FROM common_poursuite_etudiants WHERE POURSUITE_ANNEE_ID=".$annee_courante['ANNEE_ID']." AND POURSUITE_AVIS='TF'";
    $TF = $conn->query($req)->num_rows;
    $req = "SELECT * FROM common_poursuite_etudiants WHERE POURSUITE_ANNEE_ID=".$annee_courante['ANNEE_ID']." AND POURSUITE_AVIS='F'";
    $F = $conn->query($req)->num_rows;
    $req = "SELECT * FROM common_poursuite_etudiants WHERE POURSUITE_ANNEE_ID=".$annee_courante['ANNEE_ID']." AND POURSUITE_AVIS='AF'";
    $AF = $conn->query($req)->num_rows;
    $req = "SELECT * FROM common_poursuite_etudiants WHERE POURSUITE_ANNEE_ID=".$annee_courante['ANNEE_ID']." AND POURSUITE_AVIS='SA'";
    $SA = $conn->query($req)->num_rows;

     //Initialisation de PhpExcel
    try {
        $objSpreadsheet = new Spreadsheet();
        $objSpreadsheet->removeSheetByIndex(0);

        foreach ($lesEtudiantsConcernes as $ET_ID=>$les_avis) {

            $feuille = new Worksheet($objSpreadsheet,$les_avis['ET_NOM']);
            $objSpreadsheet->addSheet($feuille);

            //Initialisation des requêtes
            $colonnes = 1;
            $lignes = 1;

            $feuille->setCellValue([$colonnes, $lignes], "UNIVERSITÉ CLERMONT-AUVERGNE - INSTITUT UNIVERSITAIRE DE TECHNOLOGIE");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_BOTTOM
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 11,
                    'name' => "Arial Narrow"
                )
            ));
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);
            $feuille->getRowDimension($lignes)->setRowHeight(25);

            $feuille->setCellValue([$colonnes, ++$lignes], "Département Informatique - Campus des Cézeaux - 5 Avenue Blaise Pascal - TSA 90110 - 63178 AUBIÈRE CEDEX");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 11,
                    'name' => "Arial Narrow"
                )
            ));
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);


            $feuille->setCellValue([$colonnes, ++$lignes], "secrétariat : 04.73.17.71.00");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                )
            ));

            $feuille->setCellValue([$colonnes + 4, $lignes], "ANNÉE UNIVERSITAIRE " . $annee_courante['ANNEE_NOM']);
            $feuille->getCell([$colonnes + 4, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                )
            ));

            $feuille->setCellValue([$colonnes, ++$lignes], "FICHE \"AVIS DE POURSUITES D'ÉTUDES\" CONCERNANT");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 14,
                    'name' => "Arial Narrow"
                )
            ));
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);

            $feuille->setCellValue([$colonnes, ++$lignes], $les_avis['ET_NOM']);
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 24,
                    'name' => "Arial Narrow",
                    'color' => array('rgb' => "CC0066")
                )
            ));
            $feuille->getRowDimension($lignes)->setRowHeight(45);
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);

            $feuille->setCellValue([$colonnes, ++$lignes], "ÉTUDIANT EN DEUXIÈME ANNÉE D'INFORMATIQUE");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 12,
                    'name' => "Arial Narrow"
                )
            ));
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);

            //Matières
            $feuille->setCellValue([$colonnes, ++$lignes], "MATIÈRES");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCECFF')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'left' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));

            //Enseignants
            $feuille->setCellValue([++$colonnes, $lignes], "ENSEIGNANTS");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCECFF')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));

            //Niveau de la classe
            $feuille->setCellValue([++$colonnes, $lignes], "NIVEAU CLASSE");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCECFF')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));

            //Niveau étudiant
            $feuille->setCellValue([++$colonnes, $lignes], "NIVEAU ÉTUDIANT");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCECFF')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));

            //Appréciations
            $feuille->setCellValue([++$colonnes, $lignes], "APPRÉCIATIONS");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCECFF')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                ),
                'borders' => array(
                    'top' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_THICK
                    )
                )
            ));

            if (isset($lesEtudiantsConcernes[$ET_ID]['MATIERES'])) {
                foreach ($lesEtudiantsConcernes[$ET_ID]['MATIERES'] as $lesAvisParMatiere) {
                    $colonnes = 1;

                    //Matières
                    $feuille->setCellValue([$colonnes, ++$lignes], $lesAvisParMatiere["PMAT_NOM"]);
                    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ),
                        'font' => array(
                            'bold' => true,
                            'size' => 10,
                            'name' => "Arial Narrow"
                        ),
                        'borders' => array(
                            'bottom' => array(
                                'borderStyle' => Border::BORDER_THIN
                            ),
                            'left' => array(
                                'borderStyle' => Border::BORDER_THICK
                            ),
                            'right' => array(
                                'borderStyle' => Border::BORDER_THIN
                            )
                        )
                    ));

                    //Enseignants
                    $enseignants = "";
                    switch ($lesAvisParMatiere["PMAT_MODE"]) {
                        case "ENS" :
                            $enseignants = $lesAvisParMatiere['ENS_NOM'];
                            break;
                        case "PERSO" :
                            $enseignants = $lesAvisParMatiere['PMAT_PERSO'];
                            break;
                        case "ALL" :
                            $enseignants = $lesEnseignantsDeMatiere[$lesAvisParMatiere['PMAT_ID']];
                            break;
                    }

                    $feuille->setCellValue([++$colonnes, $lignes], $enseignants);
                    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ),
                        'font' => array(
                            'size' => 10,
                            'name' => "Arial Narrow"
                        ),
                        'borders' => array(
                            'bottom' => array(
                                'borderStyle' => Border::BORDER_THIN
                            ),
                            'right' => array(
                                'borderStyle' => Border::BORDER_THIN
                            )
                        )
                    ));

                    //Niveau de la classe
                    $feuille->setCellValue([++$colonnes, $lignes], $lesAvisParMatiere["NIVEAU"]);
                    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ),
                        'font' => array(
                            'size' => 10,
                            'name' => "Arial Narrow"
                        ),
                        'borders' => array(
                            'bottom' => array(
                                'borderStyle' => Border::BORDER_THIN
                            ),
                            'right' => array(
                                'borderStyle' => Border::BORDER_THIN
                            )
                        )
                    ));

                    //Niveau étudiant
                    $feuille->setCellValue([++$colonnes, $lignes], $lesAvisParMatiere["AVIS_NIVEAU"]);
                    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ),
                        'font' => array(
                            'size' => 10,
                            'name' => "Arial Narrow"
                        ),
                        'borders' => array(
                            'bottom' => array(
                                'borderStyle' => Border::BORDER_THIN
                            ),
                            'right' => array(
                                'borderStyle' => Border::BORDER_THIN
                            )
                        )
                    ));

                    //Appréciations
                    $feuille->setCellValue([++$colonnes, $lignes], html_entity_decode(trim($lesAvisParMatiere["AVIS_APPRECIATION"])));
                    $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ),
                        'font' => array(
                            'size' => 10,
                            'name' => "Arial Narrow"
                        ),
                        'borders' => array(
                            'bottom' => array(
                                'borderStyle' => Border::BORDER_THIN
                            ),
                            'right' => array(
                                'borderStyle' => Border::BORDER_THICK
                            )
                        )
                    ));

                }
            }

            $colonnes = 1;
            $lignes++;
            for ($i=0;$i<5;$i++) {
                $feuille->getCell([$colonnes+$i,$lignes])->getStyle()->applyFromArray(array(
                    'borders' => array(
                        'bottom' => array(
                            'borderStyle' => Border::BORDER_THICK
                        ),
                        'top' => array(
                            'borderStyle' => Border::BORDER_THICK
                        )
                    )
                ));
            }

            $feuille->setCellValue([$colonnes, ++$lignes], "Avis de poursuite d'études :");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCECFF')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                ),
                'borders' => array(
                    'left' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'bottom' => array(
                        'borderStyle' => Border::BORDER_THICK
                    ),
                    'right' => array(
                        'borderStyle' => Border::BORDER_MEDIUM
                    )
                )
            ));

            if (array_key_exists("GENERAL",$lesEtudiantsConcernes[$ET_ID])) {
                $feuille->setCellValue([$colonnes + 1, $lignes], getAvisVersionLongue($lesEtudiantsConcernes[$ET_ID]["GENERAL"]["POURSUITE_AVIS"]) . ($lesEtudiantsConcernes[$ET_ID]["GENERAL"]["POURSUITE_APPRECIATION_G"] == "" ? "" : " - " . ($lesEtudiantsConcernes[$ET_ID]["GENERAL"]["POURSUITE_APPRECIATION_G"])));
            } else {
                $feuille->setCellValue([$colonnes + 1, $lignes], "");
            }
            $feuille->getCell([$colonnes+1, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'size' => 12,
                    'name' => "Arial Narrow"
                )
            ));

            for ($i=1;$i<5;$i++) {
                $feuille->getCell([$colonnes+$i,$lignes])->getStyle()->applyFromArray(array(
                    'borders' => array(
                        'bottom' => array(
                            'borderStyle' => Border::BORDER_THICK
                        ),
                        'right' => array(
                            'borderStyle' => Border::BORDER_THICK
                        )
                    )
                ));
            }
            $feuille->mergeCells([$colonnes+1, $lignes, $colonnes + 4, $lignes]);

            $feuille->setCellValue([$colonnes, ++$lignes], "Nombres d'avis donnés pour les poursuites d'études (promotion ".($TF+$F+$AF+$SA)." étudiants) :");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'italic' => true,
                    'size' => 10,
                    'name' => "Arial Narrow"
                )
            ));
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);

            $feuille->setCellValue([$colonnes, ++$lignes], "$TF Très favorables - $F Favorables - $AF Assez favorables - $SA Sans avis");
            $feuille->getCell([$colonnes, $lignes])->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => true,
                    'italic' => true,
                    'size' => 12,
                    'name' => "Arial Narrow"
                )
            ));
            $feuille->mergeCells([$colonnes, $lignes, $colonnes + 4, $lignes]);

            /*$feuille->setCellValue([$colonnes+4, $lignes+3, "Le Chef du ".$departement_courant['DEPT_NOM'].",");
            $feuille->getCell([$colonnes+4, $lignes+3)->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => false,
                    'italic' => false,
                    'size' => 12,
                    'name' => "Calibri"
                )
            ));

            $feuille->setCellValue([$colonnes+4, $lignes+9, $departement_courant['ENS_NOM'].".");
            $feuille->getCell([$colonnes+4, $lignes+9)->getStyle()->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ),
                'font' => array(
                    'bold' => false,
                    'italic' => false,
                    'size' => 12,
                    'name' => "Calibri"
                )
            ));*/


            //Mise en place de la taille
            $feuille->getColumnDimensionByColumn(1)->setWidth(15);
            $feuille->getColumnDimensionByColumn(2)->setAutoSize(1);
            $feuille->getColumnDimensionByColumn(3)->setWidth(14);
            $feuille->getColumnDimensionByColumn(4)->setWidth(15);
            $feuille->getColumnDimensionByColumn(5)->setWidth(40);

            $feuille->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
            $feuille->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
            $feuille->getPageSetup()->setFitToWidth(1);
            $feuille->getPageMargins()->setBottom(0);
            $feuille->getPageMargins()->setTop(0);
            $feuille->getPageMargins()->setLeft(0.1);
            $feuille->getPageMargins()->setRight(0.1);
        }

        //Préparation du fichier
        $objSpreadsheet->getProperties()->setCreator("Plateforme ODIN")
            ->setLastModifiedBy($_SESSION['poursuites_nom'])
            ->setTitle("Fiches de poursuites d'études - ".$annee_courante['ANNEE_NOM']);
        //Sortie
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="FICHES_POURSUITES_ETUDES_' . $annee_courante['ANNEE_NOM'] . '.xlsx"');
        $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');

        $objWriter->save('php://output');
    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        var_dump($e);
    }
    exit;
}

exit;

function getAvisVersionLongue($avis) {
    switch ($avis) {
        case "TF" : return "Très favorable";
        case "F" : return "Favorable";
        case "AF" : return "Assez favorable";
        case "SA" : return "Sans avis";
        default : return "";
    }
}