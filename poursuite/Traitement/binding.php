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

$annee_courante = Annees::getIdAnneeCourante();

/**
 * Ouverture d'un vote
 */
if (isset($_GET['bfmw_orig_do']) && $_GET['bfmw_orig_do'] == "openvote" && isset($_POST['bfmw_orig_*VOTE_ET_ID'])) {
    if (isAdmin()) {
        if (isset($_POST['bfmw_orig_creer_vote'])) {
            echo Vote::creerVote($_POST);
        }
    }
    exit;
}

/**
 * Zone de vote
 */
if (isset($_GET['bfmw_orig_checkvote']) && isset($_POST['bfmw_orig_j'])) {
    $les_votes = Vote::getVote($_POST['bfmw_orig_j'],CURRENT_ID);
    foreach ($les_votes as $ET_ID=>$un_vote) {
        echo $ET_ID;
        echo "¤**!!**¤";
        echo $un_vote["VOTE_ID"];
        echo "¤**!!**¤";
        if ($un_vote["VOTE_CLOT"] != 1) {
            $template2 = attachXHTML();
            setAttachment($template2, "vote", "template_vote.html");
            $un_vote["IS_RESPONSABLE"] = isAdmin();
            $votants = Vote::getVotantEnCours($un_vote["VOTE_ID"]);
            $un_vote["NB_VOTANTS"] = count($votants);

            $les_enseignants = array();
            foreach ($votants as $un_votant) {
                $les_enseignants[] = $un_votant['ENS_NOM'];
            }
            $un_vote["VOTANTS"] = implode("\n",$les_enseignants);

            affectToXHTML($template2, $un_vote);
            echo generateCompleteXHTML($template2, "vote", true);
        }
        echo " ";
        echo "¤**!!**¤";
    }
    exit;
}

/**
 * Résultats des votes
 */
if (isset($_GET['bfmw_orig_checkvoteclot']) && isset($_POST['bfmw_orig_j'])) {
    $les_votes = Vote::getVoteAvecResultats($_POST['bfmw_orig_j']);
    foreach ($les_votes as $identifier_courant=>$un_vote) {
        echo $identifier_courant;
        echo "¤**!!**¤";
        $template2 = attachXHTML();
        setAttachment($template2, "vote", "template_a_vote.html");
        affectToBlocAndRepeat($template2, "un_vote", $un_vote);
        echo generateCompleteXHTML($template2, "vote", true);
        echo " ";
        echo "¤**!!**¤";
    }
    exit;
}

if (isset($_GET['bfmw_orig_getAvis']) && isset($_GET['bfmw_orig_groupe']) && isset($_GET['bfmw_orig_categorie'])) {
    try {
        $les_etudiants = Poursuites::getEtudiantsDuGroupe($_GET['bfmw_num_getAvis'],$_GET['bfmw_orig_groupe'],$_GET['bfmw_orig_categorie']);
        $les_avis = Poursuites::getLesAvisDesEtudiants($_GET['bfmw_num_getAvis'],implode(",",array_keys($les_etudiants)), $_GET['bfmw_orig_categorie'], CURRENT_DEPT_ID);
        foreach ($les_avis as $un_avis) {
            echo $un_avis["AVIS_COMPLET"];
        }
        echo "¤**!!**¤";
        $les_totaux = Poursuites::getNombreAvisDesEtudiants($_GET['bfmw_num_getAvis'], implode(",",array_keys($les_etudiants)), $_GET['bfmw_orig_categorie'], CURRENT_DEPT_ID);
        foreach ($les_totaux as $un_total) {
            echo $un_total["NOMBRE_TOTAL"];
        }
    } catch (Exception $e) {
        echo "KO";
    }

    exit;
}

if (isset($_POST['bfmw_orig_getSpecific'])) {

    setAttachment($template, "specific_fiche_jury", "specific_fiche_jury.html");

    $req = "SELECT * FROM etudiants_groupes WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND GROUPE_FEUILLE=1 AND ET_ID=".$_POST['bfmw_num_getSpecific'];
    affectToXHTML($template,$conn->query($req)->fetch_assoc());

    $req = "SELECT * FROM (common_poursuite_matiere LEFT JOIN common_poursuite_niveau_matiere on (NIVEAU_ANNEE_ID=$annee_courante AND PMAT_ID=NIVEAU_PMAT_ID)) LEFT JOIN common_poursuite_avis ON (AVIS_ET_ID=" . $_POST['bfmw_num_getSpecific'] . " AND PMAT_ID=AVIS_PMAT_ID AND AVIS_ANNEE_ID=$annee_courante) WHERE PMAT_DEPT_ID=".CURRENT_DEPT_ID." ORDER BY PMAT_NOM";
    $res2 = $conn->query($req);
    while ($une_ligne = $res2->fetch_assoc()) {

        $une_ligne["AVIS_APPRECIATION"] = nl2br($une_ligne["AVIS_APPRECIATION"]);
        affectToBloc($template,"une_ligne",$une_ligne);

        switch ($une_ligne['PMAT_MODE']) {
            case 'ENS' :
                if ($une_ligne['AVIS_ENS_ID'] != "") {
                    $req = "SELECT * FROM common_enseignant WHERE ENS_ID=" . $une_ligne['AVIS_ENS_ID'];
                    $resENS = $conn->query($req);
                    while ($un_ens = $resENS->fetch_assoc()) {
                        affectToBloc($template, "une_ligne.un_enseignant", $un_ens);
                    }
                }
                break;
            case 'ALL' :
                $req = "SELECT ENS_NOM FROM common_poursuite_matiere_composition, affectations_enseignants, common_enseignant WHERE SEM_START_ANNEE_ID <= $annee_courante AND (SEM_END_ANNEE_ID > $annee_courante OR SEM_END_ANNEE_ID IS NULL) AND UE_START_ANNEE_ID <= $annee_courante AND (UE_END_ANNEE_ID > $annee_courante OR UE_END_ANNEE_ID IS NULL) AND MAT_START_ANNEE_ID <= $annee_courante AND (MAT_END_ANNEE_ID > $annee_courante OR MAT_END_ANNEE_ID IS NULL) AND MAT_ID=PMAT_MAT_ID AND ENS_ID=MAT_ENS_ID AND MAT_PMAT_ID=".$une_ligne['PMAT_ID']." GROUP BY ENS_ID ORDER BY ENS_NOM";
                $resENS = $conn->query($req);
                while ($un_ens = $resENS->fetch_assoc()) {
                    affectToBloc($template, "une_ligne.un_enseignant", $un_ens);
                }
                break;
            case 'PERSO' :
                $un_ens = array(
                    "ENS_NOM" => $une_ligne['PMAT_PERSO']
                );
                affectToBloc($template, "une_ligne.un_enseignant", $un_ens);
        }
    }

    generateCompleteXHTML($template, "specific_fiche_jury");
    exit;
}

if (isset($_POST['bfmw_orig_free'])) {
    if ($_POST['bfmw_orig_free'] == "ORTHOGRAPHE") {
        $req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=NULL WHERE PMAT_ENS_ID=".CURRENT_ID." AND PMAT_DEPT_ID=".CURRENT_DEPT_ID;
    } else {
        $req = "UPDATE common_poursuite_matiere SET PMAT_ENS_ID=NULL WHERE PMAT_ID=".$_POST['bfmw_num_free']." AND PMAT_ENS_ID=".CURRENT_ID;
    }
    $conn->query($req);

    exit;            
}

if (isset($_GET['bfmw_orig_lazyLoad_bilan']) && isset($_GET['bfmw_orig_a'])) {
    try {
        $template2 = attachXHTML();
        setAttachment($template2, "specific_bilan_etudiant", "specific_bilan_etudiant.html");
        BilanCompetences::afficheurBilan($_GET['bfmw_num_a'], $_GET['bfmw_num_lazyLoad_bilan'], $template2);
        echo generateCompleteXHTML($template2, "specific_bilan_etudiant", true);
    } catch (Exception $e) {
        echo "KO";
    }
    exit;
}

if (isset($_GET['bfmw_orig_lazyLoad_absences'])) {
    try {
        $template2 = attachXHTML();
        $les_annees = Etudiants::getAnneeInscription($_GET['bfmw_num_lazyLoad_absences']);
        foreach ($les_annees as &$une_annee) {
            $une_annee["DEMI"] = Absences::getNombreDeDemiJourneesNonJustifiees($_GET['bfmw_num_lazyLoad_absences'],-1,"ABS_ENS_ID",$une_annee["ANNEE_ID"]);
        }
        setAttachment($template2, "specific_absence_etudiant", "specific_absence_etudiant.html");
        affectToBlocAndRepeat($template2, "une_annee", $les_annees);
        echo generateCompleteXHTML($template2, "specific_absence_etudiant", true);
    } catch (Exception $e) {
        echo "KO";
    }
    exit;
}

if (isset($_GET['bfmw_orig_lazyLoad_avis_modele'])) {
    if (Formations::isResponsable() || Formations::isChef() || Formations::isSecretaire()) {
        try {
            $template2 = attachXHTML();
            setAttachment($template2, "specific_avis_modele", "specific_avis_modele.html");
            affectToBlocAndRepeat($template2, "un_modele", Poursuites::getAvisModele(CURRENT_DEPT_ID));
            echo generateCompleteXHTML($template2, "specific_avis_modele", true);
        } catch (Exception $e) {
            echo "KO";
        }
    } else {
        echo "KO";
    }
    exit;
}

if (isset($_GET['bfmw_orig_send_avis_modele']) && isset($_GET['bfmw_orig_a']) && isset($_POST['bfmw_orig_deposer_avis_valeur']) && isset($_POST['bfmw_orig_categorie']) && (Formations::isResponsable() || Formations::isChef() || Formations::isSecretaire())) {
    Poursuites::deposerAvis($_GET['bfmw_num_send_avis_modele'],$_GET['bfmw_num_a'],$_POST['bfmw_orig_deposer_avis_valeur'],$_POST['bfmw_num_categorie'], CURRENT_DEPT_ID);
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {


    $req = "";

    switch ($_POST['bfmw_orig_type']) {
        case "sgh7834sdffghgkhj" :
            $req = "INSERT INTO common_poursuite_niveau_matiere(NIVEAU_PMAT_ID, NIVEAU, NIVEAU_ANNEE_ID) VALUES (".$_POST['bfmw_num_where'].",'".$_POST['bfmw_orig_valeur']."',$annee_courante) ON DUPLICATE KEY UPDATE NIVEAU='".$_POST['bfmw_orig_valeur']."'";
            break;
        case "jdljhgwdxfwxsfdgb" :
            $data = explode('$', $_POST['bfmw_orig_where']);
            if (Formations::isSecretaire()) {
                $req = "INSERT INTO common_poursuite_avis(AVIS_ET_ID,AVIS_PMAT_ID,AVIS_NIVEAU,AVIS_APPRECIATION,AVIS_ANNEE_ID) VALUES(" . get_numeric($data[0]) . "," . get_numeric($data[1]) . ",'" . ($_POST['bfmw_orig_tag'] === 'AVIS_NIVEAU' ? $_POST['bfmw_orig_valeur'] : '') . "','" . ($_POST['bfmw_orig_tag'] === 'AVIS_APPRECIATION' ? $_POST['bfmw_orig_valeur'] : '') . "',$annee_courante) ON DUPLICATE KEY UPDATE AVIS_ANNEE_ID=$annee_courante," . ($_POST['bfmw_orig_tag'] === 'AVIS_NIVEAU' ? "AVIS_NIVEAU='" . $_POST['bfmw_orig_valeur'] . "'" : '') . ($_POST['bfmw_orig_tag'] === 'AVIS_APPRECIATION' ? "AVIS_APPRECIATION='" . $_POST['bfmw_orig_valeur'] . "'" : '');
            } else {
                $req = "INSERT INTO common_poursuite_avis(AVIS_ET_ID,AVIS_PMAT_ID,AVIS_NIVEAU,AVIS_APPRECIATION, AVIS_ENS_ID,AVIS_ANNEE_ID) VALUES(" . get_numeric($data[0]) . "," . get_numeric($data[1]) . ",'" . ($_POST['bfmw_orig_tag'] === 'AVIS_NIVEAU' ? $_POST['bfmw_orig_valeur'] : '') . "','" . ($_POST['bfmw_orig_tag'] === 'AVIS_APPRECIATION' ? $_POST['bfmw_orig_valeur'] : '') . "'," . CURRENT_ID . ",$annee_courante) ON DUPLICATE KEY UPDATE " . ($_POST['bfmw_orig_tag'] === 'AVIS_NIVEAU' ? "AVIS_NIVEAU='" . $_POST['bfmw_orig_valeur'] . "'" : '') . ($_POST['bfmw_orig_tag'] === 'AVIS_APPRECIATION' ? "AVIS_APPRECIATION='" . $_POST['bfmw_orig_valeur'] . "'" : '') . ",AVIS_ANNEE_ID=$annee_courante, AVIS_ENS_ID=" . CURRENT_ID;
            }
            break;
        case "eytudsfghqfdfg" :
            $data = explode('$', $_POST['bfmw_orig_where']);
            $req = "INSERT INTO common_poursuite_etudiants (POURSUITE_ET_ID,POURSUITE_APPRECIATION_G, POURSUITE_ANNEE_ID, POURSUITE_CATEGORIE) VALUES (".$data[0].",'".$_POST['bfmw_orig_valeur']."',$annee_courante,'".$data[1]."') ON DUPLICATE KEY UPDATE POURSUITE_APPRECIATION_G='".$_POST['bfmw_orig_valeur']."',POURSUITE_CATEGORIE='".$data[1]."'";
            break;
        case "zelsfdjbntyzoeugc" :
            switch ($_POST['bfmw_orig_tag']) {
                case "PMAT_MODE":
                case "PMAT_PERSO":
                    $req = "UPDATE common_poursuite_matiere SET ".$_POST['bfmw_orig_tag']."='".$_POST['bfmw_orig_valeur']."' WHERE PMAT_ID=".$_POST['bfmw_num_where'];
                    break;

            }
            break;

        case "qsdhgfqksbhdfgqsdfmxqnuxsgd" :
            $validation = Vote::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
            if ($validation) {
                echo "OK";
            } else {
                echo "KO";
            }
            exit;


        default : exit();
    }

    if ($conn->query($req) == 1) {
        echo "OK";
    }

    exit();
}

if (isset($_GET["bfmw_orig_exit"])) {
    exit;
}
