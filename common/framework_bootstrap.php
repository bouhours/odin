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
 */

$racineProjet = dirname(__DIR__);
$autoloadTrouve = false;

foreach (array(
    $racineProjet . '/vendor/autoload.php',
    $racineProjet . '/bfmw/vendor/autoload.php',
) as $cheminAutoload) {
    if (!file_exists($cheminAutoload)) {
        continue;
    }
    require_once $cheminAutoload;
    $autoloadTrouve = true;
    break;
}

if (!$autoloadTrouve) {
    throw new RuntimeException("Impossible de charger l'autoload Composer.");
}

$frameworkTrouve = false;
foreach (array(
    $racineProjet . '/bfmw/includes/common.php',
    $racineProjet . '/vendor/b_fmw/bfmw/includes/common.php',
) as $cheminFramework) {
    if (!file_exists($cheminFramework)) {
        continue;
    }
    require_once $cheminFramework;
    $frameworkTrouve = true;
    break;
}

if (!$frameworkTrouve) {
    throw new RuntimeException("Impossible de charger le bootstrap BFMW.");
}
