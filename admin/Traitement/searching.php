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
 * Recherche des enseignants
 */
if (isset($_POST['bfmw_orig_search']) && isset($_POST['bfmw_orig_valeur']) && $_POST['bfmw_orig_search']=="doing") {
    require_once 'Traitement/ldap.php';

    $les_infos = Ldap::ldap_infos("(&(sn=".$_POST['bfmw_orig_valeur']."*)(|(employeetype=9)(department=*:enseignants)(department=*:administratifs)(department=*:heberges)(department=*:vacataires)))");

    if (count($les_infos) == 0) {
        echo "Aucun enseignant de ce nom n'a été trouvé";
        exit;
    }

    foreach ($les_infos as $une_info) {
    ?>
    <div class="box">
        <p>
            <?php echo $une_info['nom'] ?><br/>
            <?php echo $une_info['prenom'] ?><br/>
            <?php echo $une_info['login'] ?><br/>
            <?php echo $une_info['mail'] ?>
        </p>
        <form method="POST" action="?p=front&amp;p2=creerenseignants">
            <input type="hidden" name="*ENS_NOM" value="<?php echo $une_info['nom']." ".$une_info['prenom'] ?>" />
            <input type="hidden" name="*ENS_NOM_DE_FAMILLE" value="<?php echo $une_info['nom'] ?>" />
            <input type="hidden" name="*ENS_PRENOM" value="<?php echo $une_info['prenom'] ?>" />
            <input type="hidden" name="*ENS_LOGIN" value="<?php echo $une_info['login'] ?>" />
            <input type="hidden" name="*ENS_MAIL" value="<?php echo $une_info['mail'] ?>" />
            <input type="hidden" name="*ENS_CODE_EMPLOYE" value="<?php echo $une_info['employeeid'] ?>" />
            <input type="hidden" name="*ENS_NAISSANCE" value="<?php echo $une_info['naissance'] ?>" />
            <input type="submit" value="Choisir cette personne" name="creerenseignant" />
        </form>
    </div>
    <?php
    }
    exit();
}

/**
 * Recherche des étudiants
 */
if (isset($_POST['bfmw_orig_search']) && isset($_POST['bfmw_orig_valeur']) && $_POST['bfmw_orig_search']=="etudiants") {
    require_once 'Traitement/ldap.php';

    $les_infos = Ldap::ldap_infos("(&(sn=".$_POST['bfmw_orig_valeur']."*)(|(distinguishedname=*etudiants*)(department=*:etudiants)))");
    $ok = false;
    $retour = "<p class='font_small'>Si votre étudiant se trouve dans la liste ci-dessous, merci de cliquer dessus. Sinon, ne tenez pas compte de la liste et complétez le formulaire.</p>";
    foreach ($les_infos as $une_info) {
        $ok = true;
        $retour .= '<a href="#" data-bfmw="'.$une_info['numero'].'" class="auto_inscription">&bull;&nbsp;'.$une_info['nom']." ".$une_info['prenom']."</a><br/>";
    }

    if (!$ok) {
        echo "KO";
    } else {
        echo $retour;
    }
    exit();
}

if (isset($_POST['bfmw_orig_search']) && isset($_POST['bfmw_orig_valeur']) && $_POST['bfmw_orig_search']=="temporaire") {

    $req = "SELECT * FROM common_etudiant WHERE ET_NUMERO='".$_POST['bfmw_orig_valeur']."'";
    if ($conn->query($req)->num_rows === 0) {
        echo "OK";
    } else {
        echo "KO";
    }
    exit();
}