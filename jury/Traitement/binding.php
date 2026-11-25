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

/**
 * Ouverture d'un vote
 */
if (isset($_GET['bfmw_orig_do']) && $_GET['bfmw_orig_do'] == "openvote" && isset($_GET['bfmw_orig_f']) && isset($_GET['bfmw_orig_a'])) {
    if (Formations::isResponsableFormation($_GET['bfmw_orig_f'])) {
        if (isset($_POST['bfmw_orig_creer_vote'])) {
            echo Jury::creerVote($_POST);
        }
    }
    exit;
}

/**
 * Zone de vote
 */
if (isset($_GET['bfmw_orig_checkvote']) && isset($_POST['bfmw_orig_j']) && isset($_POST['bfmw_orig_f'])) {
    $les_votes = Jury::getVote($_POST['bfmw_orig_j'],CURRENT_ID);
    foreach ($les_votes as $ET_ID=>$un_vote) {
        echo $ET_ID;
        echo $un_vote["VOTE_GROUPE_ID"];
        echo "¤**!!**¤";
        echo $un_vote["VOTE_ID"];
        echo "¤**!!**¤";
        if ($un_vote["VOTE_CLOT"] != 1) {
            $template2 = attachXHTML();
            setAttachment($template2, "vote", "template_vote.html");
            $un_vote["IS_RESPONSABLE"] = Formations::isResponsableFormation($_POST['bfmw_num_f']);
            $un_vote["FORMATION_ID"] = $_POST['bfmw_num_f'];
            $votants = Jury::getVotantEnCours($un_vote["VOTE_ID"]);
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
    $les_votes = Jury::getVoteAvecResultats($_POST['bfmw_num_j']);
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

if (isset($_GET['bfmw_orig_show_bilan']) && isset($_POST['bfmw_orig_e']) && isset($_POST['bfmw_orig_a'])) {
    $template2 = attachXHTML();
    setAttachment($template2, "vote", "template_bilan.html");
    BilanEtudiant::generateBilan($template2,$_POST['bfmw_num_a'],$_POST['bfmw_num_e']);
    echo generateCompleteXHTML($template2, "vote", true);
    exit;
}

if (isset($_GET['bfmw_orig_show_competences']) && isset($_POST['bfmw_orig_e']) && isset($_POST['bfmw_orig_a'])) {
    $template2 = attachXHTML();
    setAttachment($template2, "competences", "template_competences.html");
    BilanCompetences::afficheurBilan($_POST['bfmw_num_a'],$_POST['bfmw_num_e'],$template2);
    echo generateCompleteXHTML($template2, "competences", true);
    exit;
}

if (isset($_GET['bfmw_orig_show_resume_matieres']) && isset($_POST['bfmw_orig_e']) && isset($_POST['bfmw_orig_a'])) {
    $template2 = attachXHTML();
    setAttachment($template2, "resume_matieres", "template_resume_matieres.html");
    affectToBlocAndRepeat($template2,"annee_matieres.un_semestre.une_ue.une_matiere",Jury::getMatieresValorisees($_POST['bfmw_num_e'],CURRENT_DEPT),null,
        array(
            "annee_matieres" => array(-1,"ANNEE_ID"),
            "annee_matieres.un_semestre" => array(-1,"SEM_ID"),
            "annee_matieres.un_semestre.une_ue" => array(-1,"UE_ID"),
        ));
    echo generateCompleteXHTML($template2, "resume_matieres", true);
    exit;
}

if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
    $req = "";

    if (isset($_POST['bfmw_orig_bind']) && isset($_POST['bfmw_orig_type']) && isset($_POST['bfmw_orig_where']) && isset($_POST['bfmw_orig_valeur']) && isset($_POST['bfmw_orig_tag'])) {
        $validation = false;
        switch ($_POST['bfmw_orig_type']) {
            case "qsdhgfqksbhdfgqsdfmxqnuxsgd" :
                $validation = Jury::doBind($_POST['bfmw_orig_tag'],$_POST['bfmw_orig_valeur'],$_POST['bfmw_orig_where'],$_POST['bfmw_num_valeur'],$_POST['bfmw_num_where']);
                break;
            default : exit();
        }

        if ($validation) {
            echo "OK";
        } else {
            echo "KO";
        }

        exit();
    }

    exit();
}

