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

class Comparateur
{
    private string $clef;
    private ?string $comparateur;
    private string $selecteur;
    private string $valeur_true;
    private string $valeur_false;

    /**
     * Comparateur constructor.
     * @param $clef
     * @param $comparateur
     * @param $selecteur
     * @param $valeur_true
     * @param $valeur_false
     */
    public function __construct(string $clef,?string $comparateur,string $selecteur = "SELECTED",string $valeur_true = "selected",string $valeur_false = "")
    {
        $this->clef = $clef;
        $this->comparateur = $comparateur;
        $this->selecteur = $selecteur;
        $this->valeur_true = $valeur_true;
        $this->valeur_false = $valeur_false;
    }

    /**
     * @return string
     */
    public function getClef() : string
    {
        return $this->clef;
    }

    /**
     * @return string
     */
    public function getComparateur() : ?string
    {
        return $this->comparateur;
    }


    /**
     * @return string
     */
    public function getSelecteur() : string
    {
        return $this->selecteur;
    }


    /**
     * @return string
     */
    public function getValeurTrue() : string
    {
        return $this->valeur_true;
    }

    /**
     * @return string
     */
    public function getValeurFalse() : string
    {
        return $this->valeur_false;
    }


}