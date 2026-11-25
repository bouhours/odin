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

if (isRegistered() && isset($_GET['bfmw_orig_generate'])) {


    $sortie = "#Fichier permettant l'import d'une maquette complète dans Odin.\n";
    $sortie .= "#Attention, le format ci-dessous doit être strictement respecté.\n";
    $sortie .= "#L'importance est dans les premières lettres de chaque ligne.\n";
    $sortie .= "#L'enchaînement des lignes les unes par rapport aux autres donne la hiérarchie.\n";
    $sortie .= "#Si vous souhaitez qu'une ligne ne soit pas lue par Odin, faites la commencer par un #.\n";
    $sortie .= "#La ligne représentant un semestre doit commencer par le numéro 1.\n";
    $sortie .= "#La ligne représentant une ue doit commencer par le numéro 2.\n";
    $sortie .= "#La ligne représentant un module contenu dans une UE doit commencer par le numéro 3.\n";
    $sortie .= "#La ligne représentant un module contenu dans un autre module doit commencer par le numéro 4.\n";
    $sortie .= "#La ligne représentant une matière (contenue dans un module) doit commencer par le numéro 5.\n";
    $sortie .= "#La ligne représentant une matière (contenue directement dans une UE) doit commencer par le numéro 6.\n";
    $sortie .= "#L'exemple ci-dessous est donné à titre d'exemple.\n";
    $sortie .= "1Semestre 1\n";
    $sortie .= "2UE 1 contenue dans le semestre 1\n";
    $sortie .= "3Module A contenu dans l'UE 1\n";
    $sortie .= "5Matière rattachée au module A\n";
    $sortie .= "5Matière rattachée au module A\n";
    $sortie .= "6Matière rattachée à l'UE 1\n";
    $sortie .= "2UE 2 contenue dans le semestre 1\n";
    $sortie .= "6Matière rattachée à l'UE 2\n";
    $sortie .= "6Matière rattachée à l'UE 2\n";
    $sortie .= "3Module B contenu dans l'UE2\n";
    $sortie .= "5Matière rattachée au module B\n";
    $sortie .= "3Module C contenu dans l'UE2\n";
    $sortie .= "4Module D contenu dans le module C\n";
    $sortie .= "5Matière rattachée au module D\n";

    //Sortie
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    header('Content-Type: text/html; charset=utf-8');
    header('Content-Disposition: attachment;filename="ModeleMaquetteOdin.txt"');
    echo $sortie;
    exit;
}
exit;
