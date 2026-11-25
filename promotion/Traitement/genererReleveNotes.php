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


/**
 * @param PDF $pdf
 * @param int $gauche_tableau
 * @param int $largeur_designation
 * @param int $largeur_note
 * @param int $hauteur_cellule
 * @param bool $afficher_rang
 */
if ((Formations::isSecretaire() || Formations::isResponsable() || Formations::isChef() || isAdmin()) && isset($_POST['bfmw_num_etudiant'])  && isset($_POST['bfmw_num_a']) && isset($_POST['bfmw_num_break'])) {

    $afficher_rang = isset($_POST['bfmw_orig_rang']);
    $marge_provoquant_le_break_page = $_POST['bfmw_num_break']??50;


    class PDF extends TCPDF
    {

        function setVert()
        {
            $this->SetTextColor(102, 255, 102);
        }

        function setNoir()
        {
            $this->SetTextColor(0, 0, 0);
        }

        function setBleu()
        {
            $this->SetTextColor(102, 102, 255);
        }

        function setRouge()
        {
            $this->SetTextColor(255, 102, 102);
        }

        function Footer()
        {
            $this->SetY(-18);
            $this->SetX(20);
            $this->SetFont('CALIBRI_', '', 10);
            $this->Cell(50, 0,"Relevé intermédiaire édité le " . date("d/m/Y"), 0, 0, 'L');
        }

    }

//Initialisation
    $pdf = new PDF();
    $pdf->AddFont("CALIBRI_", "", __DIR__."/../../common/TCPDF/fonts/calibri.php");
    $pdf->AddFont("CALIBRI_", "B",  __DIR__."/../../common/TCPDF/fonts/calibrib.php");
    $pdf->AddFont("CALIBRI_", "I",  __DIR__."/../../common/TCPDF/fonts/calibrili.php");
    $pdf->AddFont("CALIBRI_", "BI",  __DIR__."/../../common/TCPDF/fonts/calibriz.php");
    $pdf->setPrintHeader(false);

//Récupération étudiants
    $req = "SELECT * FROM common_etudiant WHERE ET_ID =" . $_POST['bfmw_num_etudiant'];

    $res = $conn->query($req);
    $nom_etudiant = "";
    if ($un_etudiant = $res->fetch_assoc()) {

        $nom_etudiant = $un_etudiant['ET_NOM'];

        $req = "SELECT INSCRIPT_ANNEE_ID, SEM_ID, SEM_NOM, ANNEE_NOM, FORM_NOM FROM common_semestre,common_inscription,common_annee, common_formation WHERE FORM_ID=SEM_FORM_ID AND ANNEE_ID=INSCRIPT_ANNEE_ID AND SEM_ID=INSCRIPT_SEM_ID AND INSCRIPT_ET_ID = " . $un_etudiant['ET_ID'] . " GROUP BY SEM_ID,INSCRIPT_ANNEE_ID ORDER BY ANNEE_NOM,SEM_ORDRE";

        $resSEMESTRE = $conn->query($req);
        $resultatOut = array();
        ReleveNotes::genererMoyennesSemestre($resSEMESTRE, $template,$un_etudiant['ET_ID'],"show", $resultatOut);

        $pdf->setAutoPageBreak(false);

        foreach ($resultatOut as $ANNEE_ID=>$les_semestres) {
            foreach ($les_semestres as $SEM_ID => $semestre) {

                creerPage($pdf, $semestre, $un_etudiant['ET_NOM']);

                $largeur_designation = 110;
                $largeur_note = 10;
                $hauteur_cellule = 6;
                $gauche_tableau = 30;

                $pdf->SetY(28);
                $pdf->SetX($gauche_tableau);
                $pdf->SetFont('CALIBRI_', 'B', 9);
                $pdf->Cell($largeur_designation, $hauteur_cellule, "", "LT", 0, 'C');
                $pdf->setRouge();
                $pdf->Cell($largeur_note, $hauteur_cellule, "--", "LT", 0, 'C', true);
                $pdf->setNoir();
                if ($afficher_rang) {
                    $pdf->Cell($largeur_note, $hauteur_cellule, "--", "LT", 0, 'C', true);
                }
                $pdf->Cell($largeur_note, $hauteur_cellule, "--", "LT", 0, 'C', true);
                $pdf->Cell($largeur_note, $hauteur_cellule, "--", "LT", 0, 'C', true);
                $pdf->Cell($largeur_note, $hauteur_cellule, "--", "LTR", 0, 'C', true);
                entete_tableau($pdf, $gauche_tableau, $largeur_designation, $largeur_note, $hauteur_cellule, $afficher_rang);

                if (isset($semestre['UE'])) {
                    foreach ($semestre['UE'] as $UE_ID => $ue) {

                        if ($pdf->GetY() > $pdf->getPageHeight() - $marge_provoquant_le_break_page) {
                            creerPage($pdf, $semestre, $un_etudiant['ET_NOM']);
                            entete_tableau($pdf, $gauche_tableau, $largeur_designation, $largeur_note, $hauteur_cellule, $afficher_rang);
                        }

                        $pdf->setOverprint();
                        //if (isset($ue['MAT']) && $pdf->y)

                        $pdf->SetX($gauche_tableau);
                        $pdf->setBleu();
                        $pdf->MultiCell($largeur_designation - $largeur_note, $hauteur_cellule, $ue["UE_NOM"], "LTB", "L", false, 0, '', '', true, 0, false, true, $hauteur_cellule, 'M', true);
                        $pdf->setNoir();
                        $pdf->Cell($largeur_note, $hauteur_cellule, $ue["UE_COEF"], "LT", 0, 'C');
                        $pdf->SetFont('CALIBRI_', 'B', 9);
                        $pdf->setRouge();
                        $pdf->Cell($largeur_note, $hauteur_cellule, $ue["UE_NOTE"], "LT", 0, 'C');
                        $pdf->SetFont('CALIBRI_', '', 9);
                        $pdf->setNoir();
                        if ($afficher_rang) {
                            $pdf->Cell($largeur_note, $hauteur_cellule, purgeRang($ue["UE_RANK"]), "LT", 0, 'C');
                        }
                        $pdf->Cell($largeur_note, $hauteur_cellule, $ue["UE_MOY"], "LT", 0, 'C', true);
                        $pdf->Cell($largeur_note, $hauteur_cellule, $ue["UE_MAX"], "LT", 0, 'C', true);
                        $pdf->Cell($largeur_note, $hauteur_cellule, $ue["UE_MIN"], "LTR", 0, 'C', true);
                        $pdf->Ln();

                        if (!isset($ue['MAT'])) {
                            continue;
                        }

                        foreach ($ue['MAT'] as $MAT_ID => $module) {

                            if ($module['MAT_END_ANNEE_ID'] != null && $semestre['INSCRIPT_ANNEE_ID'] > $module['MAT_END_ANNEE_ID']) {
                                continue;
                            }

                            if ($module['MAT_CODE_APOGE'] == "") {
                                continue;
                            }


                            $pdf->SetX($gauche_tableau + 10);
                            $pdf->MultiCell($largeur_designation - $largeur_note - 10, $hauteur_cellule, $module["MAT_NOM"], "LB", "L", false, 0, '', '', true, 0, false, true, $hauteur_cellule, 'M', true);
                            $pdf->Cell($largeur_note, $hauteur_cellule, $module["MAT_COEF"], "LT", 0, 'C');
                            $pdf->setRouge();
                            $pdf->Cell($largeur_note, $hauteur_cellule, $module["MAT_NOTE"], "LT", 0, 'C');
                            $pdf->setNoir();
                            if ($afficher_rang) {
                                $pdf->Cell($largeur_note, $hauteur_cellule, purgeRang($module["MAT_RANK"]), "LT", 0, 'C');
                            }
                            $pdf->Cell($largeur_note, $hauteur_cellule, $module["MAT_MOY"], "LT", 0, 'C', true);
                            $pdf->Cell($largeur_note, $hauteur_cellule, $module["MAT_MAX"], "LT", 0, 'C', true);
                            $pdf->Cell($largeur_note, $hauteur_cellule, $module["MAT_MIN"], "LTR", 0, 'C', true);
                            $pdf->Ln();
                        }
                    }
                }
                $pdf->SetX($gauche_tableau + 20);
                $pdf->Cell($largeur_designation + ($largeur_note * 4) - 20, $hauteur_cellule, "", "T", 0, 'C');
            }
        }
    }
    //Export
    $pdf->Output("RELEVE_$nom_etudiant.pdf", 'D');
    exit();
} else {
    exit;
}

function purgeRang(string $chaine) : string {
    $retour = str_replace("</b>", "", str_replace("<b>", "", $chaine));
    $retour = str_replace("ième", "", str_replace("nd", "", str_replace("er", "",$retour)));
    return $retour;
}

function creerPage(PDF $pdf, array $semestre, string $etudiant)
{
    $pdf->AddPage();
    $pdf->SetMargins(10, 0.1);

    //Entête
    $pdf->SetY(5);
    $pdf->Image("images/logo_iut.jpg", 5, null, 22);
    $pdf->Image("images/logo_iut.jpg", $pdf->getPageWidth()-35, null, 22);
    //$pdf->Ln(20);
    $pdf->SetFont('CALIBRI_', 'B', 16);
    $pdf->Cell(0, 0,  $semestre['FORM_NOM'] ." - ". $semestre["SEM_NOM"] ." - ". $semestre['ANNEE_NOM'], 0, 2, 'C');
//            $pdf->SetFont('CALIBRI_', 'B', 12);
//            $pdf->Cell(0, 0, "Année universitaire " . $semestre['ANNEE_NOM'], 0, 2, 'C');
    $pdf->SetFont('CALIBRI_', '', 12);
    $pdf->Cell(0, 0,  "RELEVÉ DE NOTES INTERMEDIAIRE", 0, 2, 'C');
//            $pdf->Cell(0, 0,  $semestre["SEM_NOM"], 0, 2, 'C');
    //$pdf->Ln(3);
    $pdf->SetFont('CALIBRI_', 'B', 18);
    $pdf->Cell(0, 0, $etudiant, 0, 2, 'C');
    $pdf->SetFillColor(217, 217, 217);
}

function entete_tableau(PDF $pdf, int $gauche_tableau, int $largeur_designation, int $largeur_note, int $hauteur_cellule, bool $afficher_rang): void
{
    $pdf->SetFont('CALIBRI_', 'B', 9);
    $pdf->Ln();
    $pdf->SetX($gauche_tableau);
    $pdf->Cell($largeur_designation - $largeur_note, $hauteur_cellule, "", "LT", 0, 'C', true);
    $pdf->Cell($largeur_note, $hauteur_cellule, "Coeff", "LT", 0, 'C', true);
    $pdf->Cell($largeur_note, $hauteur_cellule, "Note", "LT", 0, 'C', true);
    if ($afficher_rang) {
        $pdf->Cell($largeur_note, $hauteur_cellule, "Rang", "LT", 0, 'C', true);
    }
    $pdf->Cell($largeur_note, $hauteur_cellule, "Moy", "LT", 0, 'C', true);
    $pdf->Cell($largeur_note, $hauteur_cellule, "Maxi", "LT", 0, 'C', true);
    $pdf->Cell($largeur_note, $hauteur_cellule, "Mini", "LTR", 0, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('CALIBRI_', '', 9);
}