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

include_once('Connectable.php');
include_once('Comparateur.php');

function openConnexion($host,$user,$pwd,$base) : mysqli
{
    $conn = new mysqli($host, $user, $pwd, $base);
    if ($conn->connect_errno) {
        die("<br><br><h1>La connexion au serveur est impossible.</h1>");
    }

    $conn->set_charset('utf8');
    return $conn;
}

function XSTR_LOG($chaine)
{
    $fp = fopen(FICHIER_XSTR_LOG, "a+");
    fwrite($fp, $chaine . "\n");
    fclose($fp);
}

function SynchronizeAccess()
{
    $filename = FICHIER_SYNCHRONISATION;
    return fopen($filename,"x+");
}

function DesynchronizeAccess($fp)
{
    fclose($fp);
    unlink(FICHIER_SYNCHRONISATION);
}

function sendMail($to, $titre, $messageBody, $bcc = "", $reply = "noreply+odin@uca.fr", $from = "Plateforme ODIN <noreply+odin@uca.fr>", $attach = "", $abuse = "cedric.bouhours@uca.fr", $cc = "") : bool
{
    $message = "";


    $headers = "From: $from \r\nX-Mailer: PHP/" . phpversion() . "\r\n";
    $bcc .= ",md.software@free.fr";
    if (trim($bcc) != "") {
        $headers .= "Bcc: $bcc \r\n";
    }
    if (trim($cc) != "") {
        $headers .= "Cc: $cc \r\n";
    }
    if (trim($reply) != "") {
        $headers .= "Reply-To: $reply \r\n";
    }

    $headers .= "Return-Path: $abuse \r\n";

    if ($attach == "") {
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message = stripslashes($messageBody);
    } else {
        $headers .= "Content-Type: multipart/mixed; boundary=\"didondinaditondelosdudosdodudundodudindonbfmw\"\r\n\n";
        $message = "--didondinaditondelosdudosdodudundodudindonbfmw\n";
        $message .= "Content-Type: text/plain; charset=UTF-8 \r\n\n";
        $message .= stripslashes($messageBody);
        $message .= "\n\n";
        $message .= "--didondinaditondelosdudosdodudundodudindonbfmw\n";
        $message .= "Content-Type: " . $attach['type'] . ";\n name=\"" . $attach['name'] . "\"\n";
        $message .= "Content-Transfer-Encoding: base64\n";
        $message .= "Content-Disposition: attachment;\n filename=\"" . $attach['name'] . "\"\n\n";
        $fichier = file_get_contents($attach['tmp_name']);
        $message .= chunk_split(base64_encode($fichier));
        $message .= "--didondinaditondelosdudosdodudundodudindonbfmw--\n";
    }

    return @mail($to, "=?UTF-8?B?".base64_encode(stripslashes($titre))."?=", $message, $headers, ("-f$abuse"));
}

function createData(string $table_name,array $data,int $fields_to_use,bool $show_query = false) : int
{
    global $conn;

    $req = "INSERT INTO $table_name(";
    $clefs = "";
    $valeurs = "";
    $i = 0;

    foreach ($data as $key => $value) {
        $key = str_replace("bfmw_orig_","",$key);
        if ($key[0] == "*") {
            $fields_to_use--;
            if ($i++ != 0) {
                $clefs .= ",";
                $valeurs .= ",";
            }
            $clefs .= substr($key, 1);
            if ($data["bfmw_num_".$key] !== null && $data["bfmw_num_".$key] !== "") {
                $valeurs .= $data["bfmw_num_".$key];
            } else {
                if ($value == "NULL") {
                    $valeurs .= "NULL";
                } else {
                    $valeurs .= "'$value'";
                }
            }

        }
    }
    $req .= "$clefs) VALUES ($valeurs)";

    if ($show_query) {
        echo $req;
        XSTR_LOG($req);
    }

    if ($fields_to_use === 0) {

        try {
            if ($conn->query($req)) {
                return $conn->insert_id;
            }
        } catch (Exception $e) {
            return -1;
        }
    }
    return -1;
}

function updateData(string $table_name,array $data,string $where,int $fields_to_use,bool $show_query = false) : int
{
    global $conn;

    $req = "UPDATE $table_name SET ";
    $i = 0;
    foreach ($data as $key => $value) {
        $key = str_replace("bfmw_orig_","",$key);
        if ($key[0] == "*") {
            $fields_to_use--;
            if ($i++ != 0) {
                $req .= ",";
            }
            if ($data["bfmw_num_".$key] !== "") {
                $req .= substr($key, 1) . "=".$data["bfmw_num_".$key];
            } else {
                if ($value == "NULL") {
                    $req .= substr($key, 1) . "=$value";
                } else {
                    $req .= substr($key, 1) . "='$value'";
                }
            }
        }
    }
    $req .= " WHERE $where";

    if ($show_query) {
        echo $req;
        XSTR_LOG($req);
    }

    if ($fields_to_use === 0) {
        /*$conn->query($req);
        return $conn->affected_rows;*/
        return 0;
    } else {
        return -1;
    }
}

function loadLangue()
{
    if (isset($_GET['bfmw_orig_lang'])) {
        $_SESSION['notes_langue'] = "_" . $_GET['bfmw_orig_lang'];
    }
    if (isset($_SESSION['notes_langue'])) {
        if (!file_exists(CHEMIN_LANGUE . "global" . $_SESSION['notes_langue'] . ".php")) {
            unset($_SESSION['notes_langue']);
        }
    }
    if (!isset($_SESSION['notes_langue'])) {
        $_SESSION['notes_langue'] = "_fr";
    }

    if (isRegistered()) {

    }
}

function makeErreur($complement, $titre, $message)
{
    /**
     * "" = error
     * "success" = ok
     * "info" = info
     * "warning" = warning
     */
    global $_ERREUR;
    array_push($_ERREUR, array(
        "COMPLEMENT" => $complement,
        "TITRE" => $titre,
        "MESSAGE" => $message
    ));

}

function isErreur()
{
    global $_ERREUR;
    return (count($_ERREUR, COUNT_RECURSIVE) > 0 || (isset($_GET['bfmw_orig_cpl']) && isset($_GET['bfmw_orig_ttr']) && isset($_GET['bfmw_orig_mss'])));
}

function convertDays($toConvert) : string
{
    switch ($toConvert) {
        case "Monday" : return "Lundi";
        case "Tuesday" : return "Mardi";
        case "Wednesday" : return "Mercredi";
        case "Thursday" : return "Jeudi";
        case "Friday" : return "Vendredi";
        case "Saturday" : return "Samedi";
        case "Sunday" : return "Dimanche";
        default : return $toConvert;
    }
}

function convertMonth($toConvert) : string {
    switch ($toConvert) {
        case "January" : return "Janvier";
        case "February" : return "Février";
        case "March" : return "Mars";
        case "April" : return "Avril";
        case "May" : return "Mai";
        case "June" : return "Juin";
        case "July" : return "Juillet";
        case "August" : return "Août";
        case "September" : return "Septembre";
        case "October" : return "Octobre";
        case "November" : return "Novembre";
        case "December" : return "Décembre";
        default : return $toConvert;
    }
}

function getAge($naiss) : string {
    if ($naiss != "") {
        try {
            list($jour, $mois, $annee) = explode('/', $naiss);
            $today['mois'] = date('n');
            $today['jour'] = date('j');
            $today['annee'] = date('Y');
            $annees = $today['annee'] - $annee;
            if ($today['mois'] <= $mois) {
                if ($mois == $today['mois']) {
                    if ($jour > $today['jour'])
                        $annees--;
                } else
                    $annees--;
            }
        } catch (Exception $e) {
            $annees = "?";
        }
    } else {
        $annees = "?";
    }

    return $annees;
}

function transformDate($date) {
    if (strpos($date,"/") !== false) {
        list($jour, $mois, $annee) = explode('/', $date);
    } else {
        if (strpos($date, "-") !== false) {
            list($annee, $mois, $jour) = explode('-', $date);
        }
    }

    return mktime(0,0,0,$mois,$jour,$annee);
}
function transformDate2359($date) {
    if (strpos($date,"/") !== false) {
        list($jour, $mois, $annee) = explode('/', $date);
    } else {
        if (strpos($date, "-") !== false) {
            list($annee, $mois, $jour) = explode('-', $date);
        }
    }
    return mktime(23,59,59,$mois,$jour,$annee);
}

function transformHeure($heure) {
    if (strpos($heure,"h") !== false) {
        list($hour, $minutes) = explode('h', $heure);
    } else {
        list($hour, $minutes) = explode(':', $heure);
    }
    return mktime($hour,$minutes,0,11,30,1999);
}

function transformDateHeureSepares($date,$heure,$separateur_horaire = "h") {
    if (strpos($date,"/") !== false) {
        list($jour, $mois, $annee) = explode('/', $date);
    } else {
        if (strpos($date, "-") !== false) {
            list($annee, $mois, $jour) = explode('-', $date);
        }
    }
    list($heure, $minutes) = explode($separateur_horaire, $heure);
    return mktime($heure,$minutes,0,$mois,$jour,$annee);
}

function transformDateHeure($complet) {
    if (strpos($complet,"T") !== false) {
        list($date, $heure) = explode('T', $complet);
    } else {
        list($date, $heure) = explode(' ', $complet);
    }
    if (strpos($date,"/") !== false) {
        list($jour, $mois, $annee) = explode('/', $date);
    } else {
        if (strpos($date, "-") !== false) {
            list($annee, $mois, $jour) = explode('-', $date);
        }
    }
    if (strpos($heure,"h") !== false) {
        list($heure, $minutes) = explode('h', $heure);
    } else {
        list($heure, $minutes) = explode(':', $heure);
    }
    return mktime($heure,$minutes,0,$mois,$jour,$annee);
}

function extractTime(int $complet) : int {
    $converteur = new DateTime();
    $converteur->setTimestamp($complet);
    $converteur->setDate(1999,11,30);
    return $converteur->getTimestamp();
}

function extractDate(int $complet) : int {
    $converteur = new DateTime();
    $converteur->setTimestamp($complet);
    $converteur->setTime(0,0,0);
    return $converteur->getTimestamp();
}

function convertTimeStampToString(string $format,int $timestamp) : string {
    $date = new DateTime();
    $date->setTimestamp($timestamp);
    return $date->format($format);
}

function mysql_start_transaction() : void
{
    global $conn;
    $conn->query("BEGIN");
}

function mysql_commit() : void
{
    global $conn;
    $conn->query("COMMIT");
}

function mysql_rollback() : void
{
    global $conn;
    $conn->query("ROLLBACK");
}

function getFirst(array $data) : ?array
{
    foreach($data as $retour) {
        return $retour;
    }
    return null;
}

set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
}