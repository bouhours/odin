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


class Components
{
    public static function generateOptions(array $donnes,string $clef,string $nom,int &$selected_value,?Comparateur $comparateur,?array $multiplicateur = null,?Closure $toDoAtEnd=null,?string $clefSansRepetition=null) : string
    {
        $template = new Template(BFWM_TEMPLATE_ROOT);
        setAttachment($template, "template_option", "../../common/View/Templates/option.html");
        foreach ($donnes as &$une_donnee) {
            $une_donnee["OPTION_ID"] = $une_donnee[$clef];
            $une_donnee["OPTION_NOM"] = $une_donnee[$nom];
            if ($comparateur == null) {
                $une_donnee["SELECTED"] = "" ;
            }
        }
        $selected_value = affectToBlocAndRepeat($template,"une_option",$donnes,$comparateur,$multiplicateur,$toDoAtEnd,$clefSansRepetition);
        return generateCompleteXHTML($template,"template_option",true);
    }

}