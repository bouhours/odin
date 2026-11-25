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

if (!isRegistered()) {
    echo "Non autorisé";
    exit;
}

if (!Formations::isSecretaire() && !isAdmin()) {
    echo "Non autorisé.";
    exit;
}

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

if (!isset($_GET['bfmw_num_a'])) {
    $_GET['bfmw_num_a'] = Annees::getIdAnneeCourante();
}

$annee_courante = $_GET['bfmw_num_a'];

setAttachment($template, "export", "export.html");

$req = "SELECT * FROM common_annee WHERE ANNEE_CLOSE=0 ORDER BY ANNEE_NOM";
$res = $conn->query($req);
$fail = true;
while ($une_annee = $res->fetch_assoc()) {
    if ($une_annee['ANNEE_ID'] == $_GET['bfmw_num_a']) {
        $fail = false;
        $une_annee['SELECT'] = "selected";
    } else {
        $une_annee['SELECT'] = "";
    }
    affectToBloc($template, "une_annee", $une_annee);
}

if ($fail) {
    $_GET['bfmw_num_a'] = Annees::getIdAnneeCourante();
    $annee_courante = $_GET['bfmw_num_a'];
}

if (!isset($_GET['bfmw_orig_f'])) {
    openBloc($template, "par_semestre");

    $req = "SELECT * FROM common_semestre,common_formation WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND FORM_ID=SEM_FORM_ID AND FORM_ID IN (" . Formations::getFormationsDuSecretaire() . ") AND FORM_DEPT_ID=" . CURRENT_DEPT_ID . " ORDER BY FORM_NOM,FORM_ID,SEM_ORDRE";
    if (isAdmin()) {
        $req = "SELECT * FROM common_semestre,common_formation WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND FORM_ID=SEM_FORM_ID AND FORM_DEPT_ID=" . CURRENT_DEPT_ID . " ORDER BY FORM_NOM,SEM_ORDRE";
    }
    $res = $conn->query($req);
    $formation_en_cours = -1;
    $semestre_courant = -1;
    $fail = true;
    $first = true;
    while ($un_sem = $res->fetch_assoc()) {

        if ($first) {
            $semestre_courant = $un_sem['SEM_ID'];
            $first = false;
        }

        if ($formation_en_cours != $un_sem['FORM_ID']) {
            $formation_en_cours = $un_sem['FORM_ID'];
            affectToBloc($template, "par_semestre.une_formation_select", $un_sem);
        }

        if (!isset($_GET['bfmw_num_s'])) {
            $_GET['bfmw_num_s'] = $un_sem['SEM_ID'];
        }
        if ($un_sem['SEM_ID'] == $_GET['bfmw_num_s']) {
            $fail = false;
            $un_sem['SELECT'] = "selected";
        } else {
            $un_sem['SELECT'] = "";
        }
        affectToBloc($template, "par_semestre.une_formation_select.un_semestre", $un_sem);
    }

    if ($fail) {
        $_GET['bfmw_num_s'] = $semestre_courant;
    }

    affectToXHTML($template,array(
        "ANNEE_ID" => $annee_courante,
        "SEM_ID" => $_GET['bfmw_num_s']
    ));
} else {
    openBloc($template, "par_formation");

    $req = "SELECT * FROM common_formation WHERE FORM_ID IN (" . Formations::getFormationsDuSecretaire() . ") AND FORM_DEPT_ID=" . CURRENT_DEPT_ID . " ORDER BY FORM_NOM,FORM_ID";
    if (isAdmin()) {
        $req = "SELECT * FROM common_formation WHERE FORM_DEPT_ID=" . CURRENT_DEPT_ID . " ORDER BY FORM_NOM";
    }
    $res = $conn->query($req);
    $formation_courant = -1;
    $fail = true;
    $first = true;
    while ($une_formation = $res->fetch_assoc()) {

        if ($first) {
            $formation_courant = $une_formation['FORM_ID'];
            $first = false;
        }

        if (!isset($_GET['bfmw_num_f'])) {
            $_GET['bfmw_num_f'] = $une_formation['FORM_ID'];
        }
        if ($une_formation['FORM_ID'] == $_GET['bfmw_num_f']) {
            $fail = false;
            $une_formation['SELECT'] = "selected";
        } else {
            $une_formation['SELECT'] = "";
        }
        affectToBloc($template, "par_formation.une_formation", $une_formation);
    }

    if ($fail) {
        $_GET['bfmw_num_f'] = $formation_courant;
    }

    affectToXHTML($template,array(
        "ANNEE_ID" => $annee_courante,
        "FORM_ID" => $_GET['bfmw_num_f']
    ));
}



if (isset($_GET['bfmw_num_f'])) {
    $req = "SELECT * FROM notes_export WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND FORM_ID=" . $_GET['bfmw_num_f'] . " AND FORM_DEPT_ID=" . CURRENT_DEPT_ID . " GROUP BY MAT_ID ORDER BY FORM_ID,SEM_ID,UE_ID,MAT_CODE_APOGE";
} else {
    $req = "SELECT * FROM notes_export WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND SEM_ID=" . $_GET['bfmw_num_s'] . " AND FORM_DEPT_ID=" . CURRENT_DEPT_ID . " GROUP BY MAT_ID ORDER BY FORM_ID,SEM_ID,UE_ID,MAT_CODE_APOGE";
}
$res = $conn->query($req);
$les_modules_avec_matieres = array();
while ($une_matiere = $res->fetch_assoc()) {
    if ($une_matiere['MAT_CODE_APOGE'] != "") {
        $les_modules_avec_matieres[$une_matiere['MAT_ID']][] = $une_matiere['MAT_ID'];
        if ($une_matiere['MAT_COPIE_MAT_ID'] != "") {
            $les_modules_avec_matieres[$une_matiere['MAT_COPIE_MAT_ID']][] = $une_matiere['MAT_COPIE_MAT_ID'];
        } else {
            $les_modules_avec_matieres[$une_matiere['MAT_COPIE_MAT_ID']][] = -1;
        }
    } else {
        if ($une_matiere['MAT_SURMAT_ID'] != "") {
            $les_modules_avec_matieres[$une_matiere['MAT_SURMAT_ID']][] = $une_matiere['MAT_ID'];
        }
    }
}
if ($res->num_rows == 0) {
    openBloc($template, "no_matiere");
} else {
    openBloc($template, "matiere");
}
$ue_courante = -1;
$sem_courant = -1;
$form_courante = -1;
$les_matieres = array();
$res = $conn->query($req);
while ($une_matiere = $res->fetch_assoc()) {
    if ($une_matiere['MAT_CODE_APOGE'] == "") {
        continue;
    }
    if ($form_courante != $une_matiere['FORM_ID']) {
        $form_courante = $une_matiere['FORM_ID'];
        affectToBloc($template, "une_formation", $une_matiere);
    }
    if ($sem_courant != $une_matiere['SEM_ID']) {
        $sem_courant = $une_matiere['SEM_ID'];
        affectToBloc($template, "une_formation.un_sem", $une_matiere);
    }
    if ($ue_courante != $une_matiere['UE_ID']) {
        $ue_courante = $une_matiere['UE_ID'];
        affectToBloc($template, "une_formation.un_sem.une_ue", $une_matiere);
    }

    $req = "SELECT CONTROLE_ID,ENS_ID, ENS_NOM, CONTROLE_VALIDE FROM common_controle, common_enseignant WHERE ENS_ID=CONTROLE_ENS_ID AND CONTROLE_ANNEE_ID=$annee_courante AND (CONTROLE_MAT_ID IN (". implode(",",$les_modules_avec_matieres[$une_matiere['MAT_ID']]).") OR CONTROLE_MAT_ID IN (". implode(",",$les_modules_avec_matieres[$une_matiere['MAT_COPIE_MAT_ID']]).")) ORDER BY ENS_NOM, ENS_ID";
    $resCONTROLE = $conn->query($req);
    $une_matiere['ENSEIGNANT'] = "Brouillons créés par : <br/>";
    $une_matiere['VALIDATEUR'] = "Contrôles créés par : <br/>";
    $enseignant_courant_valide = array();
    $enseignant_courant_brouillon = array();
    $brouillons = 0;
    while ($un_enseignant = $resCONTROLE->fetch_assoc()) {
        if ($un_enseignant['CONTROLE_VALIDE'] == 0) {
            $brouillons++;
            if (!isset($enseignant_courant_brouillon[$un_enseignant['ENS_ID']])) {
                $enseignant_courant_brouillon[$un_enseignant['ENS_ID']] = 1;
                $une_matiere['ENSEIGNANT'] .= $un_enseignant["ENS_NOM"] . "<br/>";
            }
        } else {
            if (!isset($enseignant_courant_valide[$un_enseignant['ENS_ID']])) {
                $enseignant_courant_valide[$un_enseignant['ENS_ID']] = 1;
                $une_matiere['VALIDATEUR'] .= $un_enseignant["ENS_NOM"] . "<br/>";
            }
        }
    }

    $une_matiere['BROUILLONS'] = ($brouillons==0)?"":(($brouillons<2)?("$brouillons brouillon et"):("$brouillons brouillons et"));
    $req = "SELECT CONTROLE_ID FROM common_controle WHERE CONTROLE_ANNEE_ID=$annee_courante AND CONTROLE_VALIDE=1 AND (CONTROLE_MAT_ID IN (". implode(",",$les_modules_avec_matieres[$une_matiere['MAT_ID']]).") OR CONTROLE_MAT_ID IN (". implode(",",$les_modules_avec_matieres[$une_matiere['MAT_COPIE_MAT_ID']])."))";
    $controles = $conn->query($req)->num_rows;
    if ($controles == 0) {
        $une_matiere['CONTROLES'] = "";
        $une_matiere['PAS_DE_CONTROLES'] = "aucun contrôle valide";
    } else {
        $une_matiere['PAS_DE_CONTROLES'] = "";
        $une_matiere['CONTROLES'] = ($controles<2)?("$controles contrôle valide"):("$controles contrôles valides");
    }

    $une_matiere['MAT_LOCK'] = ($une_matiere['MAT_LOCK_ANNEE_ID'] < $annee_courante?1:0);
    $les_matieres[] = $une_matiere['MAT_ID'];

    affectToBloc($template, "une_formation.un_sem.une_ue.une_matiere", $une_matiere);
}

affectToXHTML($template,array(
    "MATIERES" => implode(",",$les_matieres)
));

generateCompleteXHTML($template, "export");
