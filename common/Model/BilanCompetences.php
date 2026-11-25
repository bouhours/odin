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

class BilanCompetences extends Connectable
{
    public static function afficheurBilan(int $annee_courante, int $ET_ID,Template &$template, string $prefixe = ""): void
    {
        if ($prefixe != "") {
            $prefixe .= ".";
        }
        $les_departements_du_groupe = Departements::getDepartementDeLEtudiant($annee_courante,$ET_ID);
        foreach ($les_departements_du_groupe as $un_departement) {
            affectToBlocAndRepeat($template, $prefixe."un_niveau.une_annee.un_regroupement.une_moyenne", Resultats::getBilanPourUnEtudiant($ET_ID, $un_departement["DEPT_CODE"],Etudiants::isMeilleureUE($ET_ID,$annee_courante)), null,
                array($prefixe."un_niveau" => array(-1, "NIVEAU_ID"),
                    $prefixe."un_niveau.une_annee" => array(-1, "ANNEE_ID"),
                    $prefixe."un_niveau.une_annee.un_regroupement" => array(-1, "REGROUP_ID")
                ));
        }
    }

    public static function afficheurBilanToutEtudiant(int $annee_id,int $groupe_id,Template &$template, string $prefixe) : void
    {
        $les_departements_du_groupe = Departements::getDepartementDuGroupe($groupe_id);
        foreach ($les_departements_du_groupe as $un_departement) {
            affectToBlocAndRepeat($template, "$prefixe.un_etudiant.un_niveau.une_annee.un_regroupement.une_moyenne", Resultats::getBilanPourUnGroupe($annee_id, $groupe_id, $un_departement["DEPT_CODE"]), null,
                array("$prefixe.un_etudiant" => array(-1, "ET_ID"),
                    "$prefixe.un_etudiant.un_niveau" => array(-1, "NIVEAU_ID"),
                    "$prefixe.un_etudiant.un_niveau.une_annee" => array(-1, "ANNEE_ID"),
                    "$prefixe.un_etudiant.un_niveau.une_annee.un_regroupement" => array(-1, "REGROUP_ID")
                ));
        }
    }
}