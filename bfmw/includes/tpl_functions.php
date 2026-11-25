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

include_once('template.php');

DEFINE("BFWM_TEMPLATE_ROOT",$dossier_racine."/Templates/");

function attachXHTML() : Template {
   $template = new Template(BFWM_TEMPLATE_ROOT);
   return $template;
}

function setAttachment(Template &$template,string $identificator_name,string $file_path) {
    if (!defined("CURRENT_DEPT")) {
        DEFINE("CURRENT_DEPT",".");
    }
    $construct = CURRENT_DEPT."/".$file_path;
    if (file_exists(BFWM_TEMPLATE_ROOT."/".$construct)) {
        $file_path = $construct;
    }

   $template->set_filenames(array($identificator_name => $file_path));
    //addGlobalVariable
    $aujourdhui = new DateTime();
    affectToXHTML($template,array(
        "BFMW_GLOBAL_DAYTIME" => mktime(0,0,0,$aujourdhui->format("m"), $aujourdhui->format("d"),$aujourdhui->format("Y"))
    ));
}

function affectToXHTML(Template &$template,array $var_table) {
   $template->assign_vars($var_table);
}

function openBloc(Template &$template,string $bloc_name) {
   $template->assign_block_vars($bloc_name,array());
}

function affectToBloc(Template &$template,string $bloc_name,array $var_table) {
   $template->assign_block_vars($bloc_name,$var_table);
}

function affectToBlocAndRepeat(Template &$template,string $bloc_name,array $donnes_de_la_table,?Comparateur $comparateur = null,?array $multiplicateur=null,?Closure $toDoAtEnd = null,?string $clefSansRepetition = null) : ?string {
    $retour = "";
    $first = "-1";
    $valeur_non_repetition = array();
    foreach ($donnes_de_la_table as $une_ligne_de_la_table) {
        if ($clefSansRepetition != null) {
            if (!in_array($une_ligne_de_la_table[$clefSansRepetition],$valeur_non_repetition)) {
                $valeur_non_repetition[] = $une_ligne_de_la_table[$clefSansRepetition];
            } else {
                continue;
            }
        }


        if ($comparateur != null) {
            if ($first === "-1") {
                $first = $une_ligne_de_la_table[$comparateur->getClef()];
            }
            if ($une_ligne_de_la_table[$comparateur->getClef()] ==  $comparateur->getComparateur()) {
                $retour = $une_ligne_de_la_table[$comparateur->getClef()];
                $une_ligne_de_la_table[$comparateur->getSelecteur()] = $comparateur->getValeurTrue();
            } else {
                $une_ligne_de_la_table[$comparateur->getSelecteur()] = $comparateur->getValeurFalse();
            }
        }
        if ($multiplicateur != null) {
            foreach ($multiplicateur as $bloc_de_break=>&$clef_de_break) {
                if ($clef_de_break[0] != $une_ligne_de_la_table[$clef_de_break[1]]) {

                    $go_clean = false;
                    foreach ($multiplicateur as $clean_key=>&$clean_value) {
                        if ($clean_key === $bloc_de_break) {
                            $go_clean = true;
                            continue;
                        }
                        if ($go_clean) {
                            $clean_value[0] = -1;
                        }
                    }

                    $clef_de_break[0] = $une_ligne_de_la_table[$clef_de_break[1]];
                    affectToBloc($template, $bloc_de_break, $une_ligne_de_la_table);
                }
            }
        }
        if ($toDoAtEnd != null) {
            $toDoAtEnd($une_ligne_de_la_table);
        } else {
            affectToBloc($template, $bloc_name, $une_ligne_de_la_table);
        }
    }
    return $retour===""?$first:$retour;
}

function generateCompleteXHTML(Template &$template,$identificator_name,bool $without_echo=false) {
   if ($without_echo) {
       return $template->assign_display($identificator_name);
   } else {
       return $template->display($identificator_name);
   }
}