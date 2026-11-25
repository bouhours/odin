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

if ($_SERVER['SERVER_NAME'] !== LOCALHOST) {
    //session_start();
    $cas_host = 'ent.uca.fr';
    $cas_context = '/cas';
    $cas_port = 443;

    /*session_name(
        'session_for:'
        . preg_replace('/[^a-z0-9-]/i', '_', basename($_SERVER['SCRIPT_NAME']))
    );*/

    //phpCAS::setDebug('totutytotuty');
    phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, APP_URL);
   // phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
    //phpCAS::setCasServerCACert($cas_server_ca_cert_path);
    phpCAS::setNoCasServerValidation();
    //phpCAS::forceAuthentication();


    try {
        phpCAS::forceAuthentication();
    } catch (Exception $e) {

    }
} else {
    session_start();
}