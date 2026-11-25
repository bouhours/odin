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

if (!Formations::isResponsable() && !Formations::isSecretaire() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
    $send = "p=accueil";
    require 'refresh.php';
    exit;
}

$groupe_courant = $_GET['bfmw_num_g']??-1;
$groupe_nom = "";

if ($groupe_courant == -1) {
    die("Erreur : le groupe courant n'est pas valide");
}

$formation = getFirst(Groupes::getFormation($groupe_courant));
$formation_courante = $formation['FORM_ID']??-1;

if ($formation_courante == -1) {
    die("Erreur : la formation n'existe pas");
}

$formation_nom = $formation['FORM_NOM'];
$departement_nom = $formation['DEPT_NOM'];
$annee_courante = $_GET["bfmw_num_a"]??Annees::getIdAnneeCourante();
$configuration = Annees::getAnneeWithId($annee_courante)[0];

if (isset($_GET['bfmw_num_pro']) && $_GET['bfmw_num_pro'] == 1) {
    $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$groupe_courant,-1,"ET_PROFESSIONNALISATION = 1 AND");
} else {
    $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante,$groupe_courant,-1);
}


if (count($les_etudiants) == 0) {
    die("Erreur : le groupe courant ne contient pas d'étudiant en alternance");
}

$les_fiches = Signatures::getFicheEmargementAvecEnseignants($annee_courante,$groupe_courant);

class PDF extends TCPDF {

    public $laDate;
    public $creneau;
    public $matiere;
    public $enseignant;
    public $signature;


    function Footer() {
        $configuration['HAUTEUR_SIGNATURE'] = 20;
        $configuration['OFFSET_SIGNATURE'] = 60;
        $configuration['OFFSET_Y_SIGNATURE'] = -5;

        $this->SetY(-50);
        $this->SetX(20);
        $this->SetFont('CALIBRI_', 'B', 14);
        $this->Cell(50, 0, "Le $this->laDate de $this->creneau", 0, 0, 'L');
        $this->SetX(100);
        $this->Cell(0, 0, "Enseignant : $this->enseignant", 0, 0, 'L');
        $this->Ln(10);
        $this->SetX(20);
        $this->Cell(50, 0, "Matière : $this->matiere", 0, 0, 'L');
        $this->SetX(100);
        $this->Ln(10);
        $this->SetX(20);
        if ($this->signature != "") {
            $this->ImageSVG("@".$this->signature,$this->GetX()+$configuration['OFFSET_SIGNATURE'],$this->GetY()+$configuration['OFFSET_Y_SIGNATURE'],0, $configuration['HAUTEUR_SIGNATURE']);
        }
        $this->Cell(70, 0,"Signature de l'enseignant : ", 0, 2, 'L');
    }

}

//Initialisation
$pdf = new PDF();
$pdf->AddFont("CALIBRI_", "", __DIR__."/../../common/TCPDF/fonts/calibri.php");
$pdf->AddFont("CALIBRI_", "B",  __DIR__."/../../common/TCPDF/fonts/calibrib.php");
$pdf->AddFont("CALIBRI_", "I",  __DIR__."/../../common/TCPDF/fonts/calibrili.php");
$pdf->AddFont("CALIBRI_", "BI",  __DIR__."/../../common/TCPDF/fonts/calibriz.php");
$pdf->setPrintHeader(false);

$configuration['ANNEE_LARGEUR_1'] = 80;
$configuration['ANNEE_LARGEUR_2'] = 40;
$configuration['ANNEE_LARGEUR_3'] = 60;
$configuration['ANNEE_HAUTEUR_EMARGEMENT'] = 10;
$configuration['HAUTEUR_SIGNATURE'] = 13;
$configuration['OFFSET_SIGNATURE'] = 20;
$configuration['Y_SIGNATURE'] = 112;
$configuration['ANNEE_HAUTEUR_EMARGEMENT'] = 10;
$configuration['ANNEE_DESIGNATION'] = $formation_nom;
$configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE'] = 14;

$nombre_etudiants = count($les_etudiants);
if ($nombre_etudiants == $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE']+1) {
    $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE'] += 1;
}

$toutes_les_signatures_par_dates = array();
foreach ($les_fiches as $une_signature) {
    if ($une_signature['SIGNATURE_ET_ID'] == "" ) {
        //Le dernier enseignant à avoir signé est conservé. C'est voulu.
        $toutes_les_signatures_par_dates[$une_signature['EDT_DATE_DEBUT']]["ENSEIGNANT"] = $une_signature;
    } else {
        $toutes_les_signatures_par_dates[$une_signature['EDT_DATE_DEBUT']][$une_signature['SIGNATURE_ET_ID']] = $une_signature;
    }
    $une_signature['SIGNATURE'] = "";
    $toutes_les_signatures_par_dates[$une_signature['EDT_DATE_DEBUT']]["LAST"] = $une_signature;

}

foreach ($toutes_les_signatures_par_dates as $un_creneau => $les_signatures) {

    $enseignant_courant = $les_signatures["ENSEIGNANT"]??$les_signatures["LAST"];

    try {
        $la_signature = gzuncompress(base64_decode($enseignant_courant['SIGNATURE']));
    } catch (Exception $e) {
        $la_signature = base64_decode($enseignant_courant['SIGNATURE']??"");
    }
    for ($i = 0; $i < sizeof($les_etudiants) / $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE'] ; $i++) {
        $pdf->AddPage();
        $pdf->enseignant = $enseignant_courant['ENS_NOM'];
        $pdf->matiere = $enseignant_courant['EDT_NOM'];
        $pdf->laDate = date("j/m/Y", $enseignant_courant['EDT_DATE_DEBUT']);
        $pdf->creneau = date("H:i", $enseignant_courant['EDT_HEURE_DEBUT']) . " à " . date("H:i", $enseignant_courant['EDT_HEURE_FIN']);
        $pdf->signature = $la_signature;
        $pdf->SetMargins(10, 0.1);

        //Entête
        $pdf->SetY(5);
        $pdf->Image("images/logo_iut.jpg", 90, null, 28.2);
        $pdf->Ln(28);
        $pdf->SetFont('CALIBRI_', 'B', 16);
        $pdf->Cell(0, 0, "Fiche d'émargement", 0, 2, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('CALIBRI_', 'B', 12);
        $pdf->Cell(0, 0, "Année universitaire " . $configuration['ANNEE_NOM'], 0, 2, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('CALIBRI_', '', 12);
        $pdf->Cell(0, 0, $departement_nom, 0, 2, 'C');
        $pdf->Ln(1);
        $pdf->Cell(0, 0, $configuration['ANNEE_DESIGNATION'], 0, 2, 'C');

        //Préparation tableau
        $largeurs = array($configuration['ANNEE_LARGEUR_1'], $configuration['ANNEE_LARGEUR_2'], $configuration['ANNEE_LARGEUR_3']);
        $centre_tableau = ($pdf->GetPageWidth()) / 2 - (array_sum($largeurs) / 2);
        $hauteur_cellule = $configuration['ANNEE_HAUTEUR_EMARGEMENT'];
        $hauteur_tableau = ($pdf->GetPageHeight() / 2) - ($hauteur_cellule * sizeof(array_slice($les_etudiants, $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE'] * $i, $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE'])) / 2);

        //Tableau
        $pdf->SetY($hauteur_tableau);
        $pdf->SetX($centre_tableau);
        $pdf->SetFont('CALIBRI_', 'B', 9);
        $pdf->Cell($largeurs[0], 6, "", "LT", 0, 'C');
        $pdf->Cell($largeurs[1], 6, "Groupe", "LT", 0, 'C');
        $pdf->Cell($largeurs[2], 6, "Signature", "LTR", 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('CALIBRI_', '', 16);

        foreach (array_slice($les_etudiants, $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE'] * $i, $configuration['NOMBRE_MAX_ETUDIANTS_PAR_PAGE']) as $un_etudiant) {

            try {
                $un_etudiant['SIGNATURE'] = gzuncompress(base64_decode($les_signatures[$un_etudiant["ET_ID"]]['SIGNATURE']));
            } catch (Exception $e) {
                $un_etudiant['SIGNATURE'] = base64_decode($les_signatures[$un_etudiant["ET_ID"]]['SIGNATURE'] ?? "");
            }

            $pdf->SetX($centre_tableau);
            $pdf->Cell($largeurs[0], $hauteur_cellule, $un_etudiant['ET_NOM'], "LT", 0, 'C');
            $pdf->Cell($largeurs[1], $hauteur_cellule, $un_etudiant['GROUPE_NOM'], "LT", 0, 'C');
            if ($un_etudiant['SIGNATURE'] != "") {
                $pdf->ImageSVG("@" . $un_etudiant['SIGNATURE'], $pdf->GetX() + $configuration['OFFSET_SIGNATURE'], $pdf->GetY(), 0, $configuration['HAUTEUR_SIGNATURE']);
                $pdf->Cell($largeurs[2], $hauteur_cellule, "", "LTR", 0, 'C');
            } else {
                $pdf->Cell($largeurs[2], $hauteur_cellule, "Absent", "LTR", 0, 'C');
            }
            $pdf->SetFont('CALIBRI_', '', 16);
            $pdf->Ln();
            $groupe_nom = $un_etudiant["GROUPE_NOM"];
        }
    }
    $pdf->SetX($centre_tableau);
    $pdf->Cell(array_sum($largeurs), 0, "", "T");
}


//Export
$pdf->Output("Emmargement_$groupe_nom.pdf", 'D');
exit();



