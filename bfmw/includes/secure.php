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

$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
foreach ($process as $key => $val) {
    foreach ($val as $k => $v) {
        unset($process[$key][$k]);
        if (is_array($v)) {
            $process[$key][addslashes($k)] = $v;
            $process[] = &$process[$key][addslashes($k)];
        } else {
            $process[$key][addslashes($k)] = addslashes($v);
        }
    }
}
unset($process);

$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
foreach ($process as $key => $val) {
    foreach ($val as $k => $v) {
        unset($process[$key][$k]);
        if (is_array($v)) {
            $process[$key][htmlspecialchars($k)] = $v;
            $process[] = &$process[$key][htmlspecialchars($k)];
        } else {
            $process[$key][htmlspecialchars($k)] = htmlspecialchars($v);
        }
    }
}
unset($process);

$process = array(&$_GET, &$_POST, &$_REQUEST);
manual_bfmw_secure($process);
unset($process);

if (isset($_GET['bfmw_orig_ticket'])) {
    $_GET['ticket'] = $_GET['bfmw_orig_ticket'];
}

function get_numeric($val) {
    if ($val == null) {
        return null;
    }
    if ($val == "NULL") {
        return null;
    }
    if (is_array($val)) {
        foreach ($val as $key => $valeur) {
            $val[$key] = get_numeric($valeur);
        }
        return $val;
    }
    if (is_numeric(str_replace(",",".",$val))) {
        $val = str_replace(",",".",$val);
        return $val;
    }
    return null;
}

function manual_bfmw_secure(&$process) {
    foreach ($process as $key => $val) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key]["bfmw_orig_".$k] = $v;
                $process[$key]["bfmw_num_".$k] = get_numeric($v);
                $process[] = &$process[$key]["bfmw_orig_".$k];
                $process[] = &$process[$key]["bfmw_num_".$k];
            } else {
                $process[$key]["bfmw_orig_".$k] = $v;
                $process[$key]["bfmw_num_".$k] = get_numeric($v);
            }
        }
    }
}

function bfmw_add_secured(array &$data,string $field,$value) {
    $data["bfmw_orig_".$field] = $value;
    $data["bfmw_num_".$field] = get_numeric($value);
}