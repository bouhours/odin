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

if (isErreur()) {
    require_once 'Traitement/alerts.php';
}

setAttachment($template, "rendre", "rendre.html");

$req = "SELECT * FROM (((common_objet left join emprunt on OBJ_ID=EMPRUNT_OBJ_ID) left join common_enseignant on ENS_ID=EMPRUNT_ENS_ID) left join common_etudiant on ET_ID = EMPRUNT_ET_ID) WHERE ENS_ID=".CURRENT_ID." ORDER BY ENS_NOM,OBJ_NOM ";
afficher($req,$conn,$template);
$req = "SELECT * FROM (((common_objet left join emprunt on OBJ_ID=EMPRUNT_OBJ_ID) left join common_enseignant on ENS_ID=EMPRUNT_ENS_ID) left join common_etudiant on ET_ID = EMPRUNT_ET_ID) WHERE ENS_ID!=".CURRENT_ID." ORDER BY ENS_NOM,OBJ_NOM ";
afficher($req,$conn,$template);

function afficher($req, $conn, &$template) {
    $res = $conn->query($req);
    while ($objet = $res->fetch_assoc()) {
        if ($objet['EMPRUNT_EXTERNE'] == "" && $objet['EMPRUNT_ET_ID'] == "") {
            $objet['EMPRUNTEUR'] = $objet['ENS_NOM'];
        } else if ($objet['EMPRUNT_EXTERNE'] == "" && $objet['EMPRUNT_ET_ID'] != "") {
            $objet['EMPRUNTEUR'] = "Etudiant " . $objet['ET_NOM'] . " (" . $objet['ENS_NOM'] . ")";
        } else {
            $objet['EMPRUNTEUR'] = $objet['EMPRUNT_EXTERNE'] . " (" . $objet['ENS_NOM'] . ")";
        }

        affectToBloc($template, "un_objet", $objet);
        if ($objet['EMPRUNT_ENS_ID'] == CURRENT_ID) {
            openBloc($template, "un_objet.emprunteur");
        }
    }
}

generateCompleteXHTML($template, "rendre");
