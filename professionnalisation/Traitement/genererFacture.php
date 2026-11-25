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

verifSession();

if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID) || !isset($_POST['bfmw_orig_date_debut']) || !isset($_POST['bfmw_orig_date_fin'])) {
    echo "Accès interdit";
    exit;
}

$les_formations_autorisees = Formations::getFormationsDuConnecteString();

$annee_courante = $_POST["bfmw_num_a"]??Annees::getIdAnneeCourante();


class PDF extends TCPDF {

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('CALIBRI_', '', 8);
        $this->Cell(0, 0,"Université Clermont Auvergne - IUT", 0, 2, 'C');
        $this->ln(1);
        $this->Cell(0, 0, "Service Formation Continue et Alternance - 5 avenue Blaise Pascal - TSA 90110 - 63178 Aubière Cedex - Tél. 04 73 17 70 12 / 70 05", 0, 2, 'C');
        $this->ln(1);
        $this->Cell(0, 0, "Déclaration d'activité « enregistré sous le numéro 84630531763 auprès du préfet de région Auvergne-Rhône-Alpes » ", 0, 2, 'C');
    }

}

//Initialisation
$pdf = new PDF();
$pdf->AddFont("CALIBRI_", "", __DIR__."/../../common/TCPDF/fonts/calibri.php");
$pdf->AddFont("CALIBRI_", "B",  __DIR__."/../../common/TCPDF/fonts/calibrib.php");
$pdf->AddFont("CALIBRI_", "I",  __DIR__."/../../common/TCPDF/fonts/calibrili.php");
$pdf->AddFont("CALIBRI_", "BI",  __DIR__."/../../common/TCPDF/fonts/calibriz.php");
$pdf->setPrintHeader(false);

try {
    $date_de_debut = transformDate($_POST['bfmw_orig_date_debut']);
} catch (Exception $e) {
    echo  "La date de début est invalide";
    exit;
}
try {
    $date_de_fin = transformDate2359($_POST['bfmw_orig_date_fin']);
} catch (Exception $e) {
    echo  "La date de fin est invalide";
    exit;
}

$req = "SELECT ET_ID,ET_NOM,ET_DEBUT, ET_ADRESSE, ET_ADRESSE_2, ET_ENTREPRISE,ET_ADRESSE_ENTREPRISE,FORM_NOM,ET_HEURES_MAX,ET_HEURES_FACTUREES,ET_MAX_SEMAINE,GROUP_CONCAT(GROUPE_ID) AS LES_GROUPES FROM etudiants_groupes, common_formation WHERE GROUPE_FEUILLE=1 AND FORM_ID=GROUPE_FORM_ID AND FORM_ID=".$_POST['bfmw_num_formation']." AND GROUPE_FORM_ID IN ($les_formations_autorisees) AND ET_GROUPE_ANNEE_ID=$annee_courante AND ET_PROFESSIONNALISATION=1 GROUP BY ET_ID ORDER BY GROUPE_CODE,ET_NOM";
$res = $conn->query($req);
if ($res->num_rows == 0) {
    echo  "Impossible de générer les attestations car aucun étudiant n'est inscrit à la facturation.<br/>";
    echo  "Pensez à cocher les cases \"Alt. ?\" dans la gestion des étudiants";
    exit;
}
while ($un_etudiant = $res->fetch_assoc()) {
    $pdf->AddPage();
    $pdf->SetMargins(10, 0.1);

    entete($pdf,$un_etudiant);

    try {
        $date_debut_contrat = transformDate($un_etudiant['ET_DEBUT']);
    } catch (Exception $e) {
        echo "La date de début de contrat n'a pas été renseignée pour ".$un_etudiant["ET_NOM"];
        exit;
    }

    if ($date_debut_contrat == "") {
        echo "La date de début de contrat n'a pas été renseignée pour ".$un_etudiant["ET_NOM"];
        exit;
    }

    $date_start = max($date_debut_contrat,$date_de_debut);
    $numero_semaine_min = intval(date('W', max($date_debut_contrat,$date_de_debut)));
    $numero_jour_min = intval(date('N', max($date_debut_contrat,$date_de_debut)));
    $numero_semaine_start = intval(date('W', max($date_debut_contrat,$date_de_debut)));
    $numero_semaine_max = intval(date('W', $date_de_fin));

    $tableau_total = array();
    $total_heures_semaines = array();
    for ($i=$numero_semaine_min;$i<=$numero_semaine_max;$i++) {
        $tableau_total[$i][1] = 0;
        $tableau_total[$i][2] = 0;
        $tableau_total[$i][3] = 0;
        $tableau_total[$i][4] = 0;
        $tableau_total[$i][5] = 0;
        $tableau_total[$i][6] = 0;
        $total_heures_semaines[$i] = $un_etudiant['ET_MAX_SEMAINE'];
    }

    $tableau_absences = array();

    $req = "SELECT common_backup_ade_enseignant.EDT_DATE_DEBUT,common_backup_ade_enseignant.EDT_DATE_FIN,SIGNATURE_ID,common_backup_ade_etudiant.EDT_UID
            FROM (common_backup_ade_enseignant,common_backup_ade_etudiant)
            left join common_pro_signatures on (SIGNATURE_EDT_UID=common_backup_ade_etudiant.EDT_UID AND SIGNATURE_GROUPE_ID=EDT_GROUPE_ID AND SIGNATURE_ET_ID=".$un_etudiant['ET_ID'].")
            LEFT JOIN common_backup_ade_enseignant_nonfacture ON (common_backup_ade_enseignant.EDT_UID=NONFACTURE_EDT_UID)
            WHERE EDT_GROUPE_ID IN (".$un_etudiant['LES_GROUPES'].") AND common_backup_ade_enseignant.EDT_UID=common_backup_ade_etudiant.EDT_UID AND
             common_backup_ade_enseignant.EDT_DATE_DEBUT >= $date_start AND common_backup_ade_enseignant.EDT_DATE_FIN <= $date_de_fin AND
              NONFACTURE_EDT_UID IS NULL GROUP BY common_backup_ade_etudiant.EDT_UID ORDER BY common_backup_ade_enseignant.EDT_DATE_DEBUT";

    $res2 = $conn->query($req);
    while ($un_total = $res2->fetch_assoc()) {
        if ($un_total['SIGNATURE_ID'] != "") {
            try {
                $tableau_total[intval(date('W', $un_total['EDT_DATE_DEBUT']))][intval(date('N', $un_total['EDT_DATE_DEBUT']))] += ($un_total['EDT_DATE_FIN'] - $un_total['EDT_DATE_DEBUT']) / 3600;
            } catch (Exception $e) {
                die ("Paramètre invalide dans les dates");
            }
        }
    }

    $nombre_total_abs = 0;
    $total_semaine = 0;
    $total_presence = 0;
    $total_non_facture = 0;
    $hauteur_cellule = count($tableau_total)>7?6:11;
    foreach ($tableau_total as $semaine => $totaux) {
        $req = "SELECT * FROM common_edt_ferie WHERE FERIE_SEMAINE=" . $semaine." AND FERIE_SEMAINE BETWEEN $numero_semaine_min AND $numero_semaine_max";
        $res2 = $conn->query($req);
        while ($un_ferie = $res2->fetch_assoc()) {
            $total_heures_semaines[$un_ferie['FERIE_SEMAINE']] -= ($un_etudiant['ET_MAX_SEMAINE']/5);
        }
        if ($total_heures_semaines[$semaine] < 0) {
            $total_heures_semaines[$semaine] = 0;
        }


        $pdf->SetFont('CALIBRI_', '', 9);

        $pdf->Cell(20, $hauteur_cellule, "Semaine " . $semaine, "TL", 0, 'C', true);
        $pdf->Cell(13, $hauteur_cellule, $tableau_total[$semaine][1], "TL", 0, 'C');
        $pdf->Cell(13, $hauteur_cellule, $tableau_total[$semaine][2], "TL", 0, 'C');
        $pdf->Cell(13, $hauteur_cellule, $tableau_total[$semaine][3], "TL", 0, 'C');
        $pdf->Cell(13, $hauteur_cellule, $tableau_total[$semaine][4], "TL", 0, 'C');
        $pdf->Cell(13, $hauteur_cellule, $tableau_total[$semaine][5], "TL", 0, 'C');
        $pdf->Cell(13, $hauteur_cellule, $tableau_total[$semaine][6], "TL", 0, 'C');
        $total = $tableau_total[$semaine][1] + $tableau_total[$semaine][2] + $tableau_total[$semaine][3] + $tableau_total[$semaine][4] + $tableau_total[$semaine][5] + $tableau_total[$semaine][6];
        $total_semaine += $total;
        $pdf->Cell(16, $hauteur_cellule, $total, "TL", 0, 'C');
        $heures_non_facturees_semaine = $total_heures_semaines[$semaine] - $total;
        if ($heures_non_facturees_semaine < 0) {
            $total_heures_semaines[$semaine] -= $heures_non_facturees_semaine;
            $heures_non_facturees_semaine = 0;
        }
        $pdf->Cell(15, $hauteur_cellule, $heures_non_facturees_semaine, "TL", 0, 'C');
        $total_non_facture += $heures_non_facturees_semaine;
        $pdf->Cell(17, $hauteur_cellule, "0", "TL", 0, 'C');
        $pdf->SetFont('CALIBRI_', 'B', 9);
        $pdf->Cell(17, $hauteur_cellule, $total_heures_semaines[$semaine], "TL", 0, 'C');
        $total_presence += $total_heures_semaines[$semaine];
        $pdf->Cell(30, $hauteur_cellule, "", "LTR", 1, 'C');
    }
    $pdf->Cell(20, 6, "TOTAL", "TL", 0, 'C', true);
    $pdf->Cell(78, 6, "", "TLB", 0, 'C', true);
    $pdf->Cell(16, 6, $total_semaine, "TLB", 0, 'C', true);
    $pdf->Cell(15, 6, $total_non_facture, "TLB", 0, 'C', true);
    $pdf->Cell(17, 6, "0", "TLB", 0, 'C', true);
    $pdf->Cell(17, 6, $total_presence, "TLB", 0, 'C', true);
    $pdf->Cell(30, 6, "", "LTBR", 1, 'C', true);
    $pdf->Cell(20, 6, "ABSENCES", "TL", 0, 'C');

    $nb=0;
    $req = "SELECT (EDT_DATE_FIN-EDT_DATE_DEBUT)/3600 AS TOTAL
            FROM `common_absences_v2`, common_backup_ade_enseignant
            LEFT JOIN common_backup_ade_enseignant_nonfacture ON (EDT_UID=NONFACTURE_EDT_UID)
            WHERE ABS_REAL_DATE>=$date_debut_contrat AND NONFACTURE_EDT_UID IS NULL AND ABS_EXPIRE=0 AND 
                  ABS_EDT_UID=EDT_UID AND `ABS_ET_ID`=".$un_etudiant['ET_ID']." GROUP BY ABS_EDT_UID";
    $resCOUNTABS = $conn->query($req);
    while ($une_abs = $resCOUNTABS->fetch_assoc()) {
        $nombre_total_abs+=$une_abs['TOTAL'];
    }

    $req = "SELECT *
            FROM common_absences_v2,common_backup_ade_enseignant
            LEFT JOIN common_backup_ade_enseignant_nonfacture ON (EDT_UID=NONFACTURE_EDT_UID)
            WHERE NONFACTURE_EDT_UID IS NULL AND EDT_UID=ABS_EDT_UID AND EDT_DATE_DEBUT >= $date_start AND EDT_DATE_FIN <= $date_de_fin
            AND ABS_ET_ID=".$un_etudiant['ET_ID']." GROUP BY EDT_UID ORDER BY ABS_REAL_DATE";
    $resABS = $conn->query($req);
    $lesAbsencesAAfficher = array();
    $afficherAbsences = $resABS->num_rows<=6;
    while ($absence = $resABS->fetch_assoc()) {
        if ($afficherAbsences) {
            ++$nb;
        }
        if ($nb != 1 && $afficherAbsences) {
            $pdf->Cell(20, 3, "", "L", 0, 'C');
        }
        $pdf->SetTextColor(255, 0, 0);
        $texte = $absence['ABS_DATE'] . " : " .  date("H:i",$absence['EDT_HEURE_DEBUT']) . " - " .  date("H:i",$absence['EDT_HEURE_FIN']) . " (" . $absence['EDT_NOM'] . ") : ".($absence['ABS_EXCUSE']==""?"Non justifiée":html_entity_decode($absence['ABS_EXCUSE'],ENT_QUOTES));
        $lesAbsencesAAfficher[] = $texte;
        if ($afficherAbsences) {
            $pdf->Cell(173, 3, $texte, "LR", 1, 'L');
        } else {
            if ($nb === 0) {
                ++$nb;
                $pdf->Cell(173, 3, "* détail des absences au verso", "LR", 1, 'L');
            }
        }
    }
    
    $pass=($nb==0?0:1);
    while ($nb++ < 3) {
        if (++$pass != 1) {
            $pdf->Cell(20, 6, "", "L", 0, 'C');
        }
        $pdf->Cell(173, 6,"", "LR", 1, 'C');
    }
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(193, 6, "", "T", 1, 'C');
    $pdf->Ln(2);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(65, 0, "Nombre d'heures facturées :", '', 0);
    $pdf->SetFont('CALIBRI_', 'B', 12);
    $pdf->SetTextColor(226, 107, 10);
    if ($un_etudiant['ET_HEURES_MAX'] - $nombre_total_abs - $un_etudiant['ET_HEURES_FACTUREES'] - $total_semaine < 0) {
        $total_non_facture -= $un_etudiant['ET_HEURES_MAX'] - $nombre_total_abs - $un_etudiant['ET_HEURES_FACTUREES'] - $total_semaine;
        $total_semaine += $un_etudiant['ET_HEURES_MAX'] - $nombre_total_abs - $un_etudiant['ET_HEURES_FACTUREES'] - $total_semaine;
    }
    $pdf->Cell(0, 0, $total_semaine, '', 1);
    $pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(65, 0,"Nombre d'heures non facturées :", '', 0);
    $pdf->SetFont('CALIBRI_', 'B', 12);
    $pdf->SetTextColor(226, 107, 10);
    $pdf->Cell(0, 0, $total_non_facture, '', 1);
    $pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(65, 0,  "Nombre d'heures déjà facturées :", '', 0);
    $pdf->SetFont('CALIBRI_', 'B', 12);
    $pdf->SetTextColor(226, 107, 10);
    $pdf->Cell(0, 0, $un_etudiant['ET_HEURES_FACTUREES'], '', 1);
    $pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(65, 0,  "Nombre d'heures maximum du contrat :", '', 0);
    $pdf->SetFont('CALIBRI_', 'B', 12);
    $pdf->SetTextColor(226, 107, 10);
    $pdf->Cell(0, 0, $un_etudiant['ET_HEURES_MAX'], '', 1);
    /*$pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(65, 0,  "Nombre d'heures d'absences sur l'année :", '', 0);
    $pdf->SetFont('CALIBRI_', 'B', 12);
    $pdf->SetTextColor(226, 107, 10);
    $pdf->Cell(0, 0, $nombre_total_abs, '', 1);*/
    $pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(65, 0, "Total facturé sur l'année :", '', 0);
    $pdf->SetFont('CALIBRI_', 'B', 12);
    $pdf->SetTextColor(226, 107, 10);
    $pdf->Cell(0, 0, $un_etudiant['ET_HEURES_FACTUREES'] + $total_semaine, '', 1);
    $pdf->Ln(1);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(150, 0, "Début de contrat : ".$un_etudiant['ET_DEBUT'], '', 0);
    $pdf->SetFont('CALIBRI_', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 0, "À Aubière, le ". convertTimeStampToString("d/m/Y",$date_de_fin), '', 1, 'L');
    $pdf->Ln(1);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(0, 0,  "Cachet et signature organisme de formation :", '', 1, 'R');
    $pdf->Line(11, 31, 51, 31);
    $pdf->Line(141, 31, 158, 31);
    $pdf->Line(11, 59, 30, 59);
    $pdf->Line(11, 64.5, 31, 64.5);

    if (!$afficherAbsences) {
        $pdf->AddPage();
        $pdf->SetMargins(10, 0.1);
        $pdf->setY(10);
        $pdf->Cell(20, 6, "ABSENCES", "TL", 0, 'C');
        $nb = 0;
        foreach ($lesAbsencesAAfficher as $absence) {
            if (++$nb != 1) {
                $pdf->Cell(20, 3, "", "L", 0, 'C');
            }
            $pdf->SetTextColor(255, 0, 0);
            if ($nb === 1) {
                $pdf->Cell(173, 3, $absence, "LRT", 1, 'L');
            } else {
                $pdf->Cell(173, 3, $absence, "LR", 1, 'L');
            }
        }
        $pdf->Cell(193, 6, "", "T", 1, 'C');
    }
    $pdf->SetTextColor(0, 0, 0);
}

//Export
$pdf->Output("AttestationPresence.pdf", 'D');
exit();

function entete(TCPDF &$pdf,array $un_etudiant) {
    global $date_de_debut;
    global $date_de_fin;

    //Entête
    $pdf->SetY(5);
    $pdf->Image("images/logo_iut.jpg", 10, null, 18.2);
    $pdf->Ln(4);
    $pdf->SetFont('CALIBRI_', 'B', 14);
    $pdf->Cell(0, 0, "ATTESTATION DE PRESENCE EN FORMATION", '', 1, 'C');
    $pdf->Ln(12);
    $pdf->SetFont('CALIBRI_', '', 10);
    $pdf->Cell(42, 3, "ORGANISME FORMATEUR :", '', 0, 'L');
    $pdf->SetX(140);
    $pdf->Cell(18, 3, "STAGIAIRE :", '', 1, 'L');
    $pdf->SetFont('CALIBRI_', '', 10);
    $pdf->Ln(1);
    $pdf->Cell(42, 3, "IUT - Université Clermont Auvergne", '', 0, 'L');
    $pdf->SetX(140);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(18, 3, $un_etudiant['ET_NOM'], '', 1, 'L');
    $pdf->SetFont('CALIBRI_', '', 10);
    $pdf->Ln(1);
    $pdf->Cell(42, 3, "Service Formation Continue et Alternance", '', 0, 'L');
    $pdf->SetX(140);
    $pdf->Cell(18, 3, html_entity_decode($un_etudiant['ET_ADRESSE'], ENT_QUOTES) , '', 1, 'L');
    $pdf->Ln(1);
    $pdf->Cell(42, 3,  "5 avenue Blaise Pascal - TSA 90110", '', 0, 'L');
    $pdf->SetX(140);
    $pdf->Cell(18, 3,  html_entity_decode($un_etudiant['ET_ADRESSE_2'], ENT_QUOTES), '', 1, 'L');
    $pdf->Ln(1);
    $pdf->Cell(42, 3,"63178 AUBIERE Cedex", '', 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(21, 3, "ENTREPRISE :", '', 0, 'L');
    $pdf->Cell(0, 3, $un_etudiant['ET_ENTREPRISE'] . " - " . str_replace("\n", " - ",html_entity_decode($un_etudiant['ET_ADRESSE_ENTREPRISE'], ENT_QUOTES)), '', 1, 'L');
    $pdf->Ln(1);
    $pdf->SetFont('CALIBRI_', 'B', 10);
    $pdf->Cell(22, 3, "FORMATION :", '', 0, 'L');
    $pdf->Cell(0, 3, $un_etudiant['FORM_NOM'], '', 1, 'L');
    $pdf->SetFont('CALIBRI_', '', 10);
    $pdf->Cell(0, 30, "PERIODE DU " . convertTimeStampToString("d/m/Y",$date_de_debut) . " AU " . convertTimeStampToString("d/m/Y",$date_de_fin), '', 1, 'C');
    $pdf->SetFillColor(217, 217, 217);
    $pdf->SetY(85);
    $pdf->Cell(20, 6, "", "LT", 0, 'C', true);
    $pdf->SetFont('CALIBRI_', 'B', 9);
    $pdf->Cell(13, 6, "lundi", "LT", 0, 'C', true);
    $pdf->Cell(13, 6, "mardi", "LT", 0, 'C', true);
    $pdf->Cell(13, 6, "mercredi", "LT", 0, 'C', true);
    $pdf->Cell(13, 6, "jeudi", "LT", 0, 'C', true);
    $pdf->Cell(13, 6, "vendredi", "LT", 0, 'C', true);
    $pdf->Cell(13, 6, "samedi", "LTR", 0, 'C', true);
    $pdf->MultiCell(16, 15, "Heures\nde\nformation", "LT", 'C', true);
    $pdf->SetXY(124, 85);
    $pdf->SetTextColor(0, 176, 80);
    $pdf->MultiCell(15, 15, "Heures\nnon\nfacturées", "LT", 'C', true);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(139, 85);
    $pdf->MultiCell(17, 15, "Heures de\nstage en\nentreprise", "LT", 'C', true);
    $pdf->SetXY(156, 85);
    $pdf->MultiCell(17, 15, "Base horaire par semaine", "LT", 'C', true);
    $pdf->SetXY(173, 85);
    $pdf->Cell(30, 6, "VISA", "LTR", 1, 'C', true);
    $pdf->SetFont('CALIBRI_', '', 9);
    $pdf->Cell(20, 9, "", "L", 0, 'C', true);
    $pdf->Cell(13, 9, "Nb d'h", "LT", 0, 'C', true);
    $pdf->Cell(13, 9, "Nb d'h", "LT", 0, 'C', true);
    $pdf->Cell(13, 9, "Nb d'h", "LT", 0, 'C', true);
    $pdf->Cell(13, 9, "Nb d'h", "LT", 0, 'C', true);
    $pdf->Cell(13, 9, "Nb d'h", "LT", 0, 'C', true);
    $pdf->Cell(13, 9, "Nb d'h", "LTR", 0, 'C', true);
    $pdf->Cell(16, 9, "", "", 0, 'C');
    $pdf->Cell(15, 9, "", "", 0, 'C');
    $pdf->Cell(17, 9, "", "", 0, 'C');
    $pdf->Cell(17, 9, "", "", 0, 'C');
    $pdf->Cell(30, 9, "Stagiaire", "LTR", 1, 'C', true);
}