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

class MatieresListView extends Connectable
{
    public static function generateListView(array &$la_maquette, Template &$template, int $annee_courante, string $template_open, string $template_close , ?Closure $do_contenu, ?Closure $get_matiere, int $matiere_courante = -1, string $prefixe = "", string $decalage="", bool $with_decalage=false) : int {
        $selection_valide = -1;
        $departement_courant = -1;
        $formation_courante = -1;
        $semestre_courant = -1;
        foreach ($la_maquette as $un_element) {
            if ($departement_courant != $un_element['DEPT_ID']) {
                $departement_courant = $un_element['DEPT_ID'];
                affectToBloc($template,$prefixe."un_departement",$un_element);
            }
            if ($formation_courante != $un_element['FORM_ID']) {
                $formation_courante = $un_element['FORM_ID'];
                affectToBloc($template,$prefixe."un_departement.une_formation",$un_element);
            }
            if ($semestre_courant != $un_element['SEM_ID']) {
                $semestre_courant = $un_element['SEM_ID'];
                affectToBloc($template,$prefixe."un_departement.une_formation.un_semestre",$un_element);
            }
            if ($un_element['UE_ID'] != "") {
                affectToBloc($template, $prefixe . "un_departement.une_formation.un_semestre.une_ue", $un_element);


                $lesMatieres = $get_matiere($un_element, $annee_courante);
                affectToBloc($template, $prefixe . "un_departement.une_formation.un_semestre.une_ue.une_hierarchie", array(
                    "HIERARCHIE" => self::arbreMatieres($lesMatieres, "ROOT", $annee_courante, $semestre_courant, $template_open, $template_close, $do_contenu, $matiere_courante, $decalage, $with_decalage, $selection_valide)
                ));
            }
        }

        return $selection_valide;
    }

    private static function arbreMatieres(array $lesMatieresATraiter,string $MAT_ID, int $annee_courante, int $semestre_courant, string $template_open, string $template_close, ?Closure $do_contenu, int $matiere_courante, string $decalage, bool $with_decalage, int &$selection_valide) : string {
        $retour = "";

        if (isset($lesMatieresATraiter[$MAT_ID])) {
            foreach ($lesMatieresATraiter[$MAT_ID] as $uneMatiere) {
                if ($uneMatiere['MAT_HAS_NOTE'] == 1) {
                    if ($do_contenu != null) {
                        if ($selection_valide == -1) {
                            $selection_valide = $uneMatiere['MAT_ID'];
                        }
                        if ($uneMatiere['MAT_ID'] == $matiere_courante) {
                            $selection_valide = $uneMatiere['MAT_ID'];
                            $uneMatiere['SELECTED'] = "selected";
                        } else {
                            $uneMatiere['SELECTED'] = "";
                        }

                        if ($with_decalage) {
                            $uneMatiere['MAT_NOM'] = $decalage . $uneMatiere['MAT_NOM'];
                        }

                        $retour .= $do_contenu($uneMatiere, $annee_courante, $semestre_courant);
                    }
                } else {
                    $template2 = attachXHTML();
                    setAttachment($template2, "gererenseignant_template_module_open", $template_open);
                    if ($with_decalage) {
                        $uneMatiere['MAT_NOM'] = $decalage . $uneMatiere['MAT_NOM'];
                    }
                    $uneMatiere['ANNEE_COURANTE'] = $annee_courante;
                    $uneMatiere['FORM_ID'] = Formations::getFormationDuSemestre($semestre_courant)['FORM_ID'];
                    affectToXHTML($template2, $uneMatiere);
                    $retour .= generateCompleteXHTML($template2,"gererenseignant_template_module_open",true);
                    $retour .= self::arbreMatieres($lesMatieresATraiter,$uneMatiere['MAT_ID'],$annee_courante,$semestre_courant, $template_open,$template_close, $do_contenu,$matiere_courante,$decalage,$with_decalage,$selection_valide);
                    $template3 = attachXHTML();
                    setAttachment($template3, "gererenseignant_template_module_close", $template_close);
                    $retour .= generateCompleteXHTML($template3,"gererenseignant_template_module_close",true);
                }
            }
        }
        return $retour;
    }

}