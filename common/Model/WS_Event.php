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

class WS_Event extends Connectable
{
    private $id;
    private $activityId;
    private $name;
    private $start;
    private $end;
    private $enseignants;
    private $salles;
    private $groupes;
    private $color;
    private $departements;

    /**
     * WS_Event constructor.
     * @param string $id
     * @param string $activityId
     * @param string $name
     * @param int $start
     * @param int $end
     * @param string $color
     * @param array $enseignants
     * @param array $salles
     * @param array $groupes
     * @param array $departements
     */
    public function __construct(string $id,string $activityId,string $name,int $start,int $end,string $color,array $enseignants,array $salles,array $groupes, array $departements)
    {
        $this->id = $id;
        $this->activityId = $activityId;
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
        $this->color = $color;
        $this->enseignants = $enseignants;
        $this->salles = $salles;
        $this->groupes = $groupes;
        $this->departements = $departements;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getActivityId(): string
    {
        return $this->activityId;
    }

    /**
     * @return string
     */
    public function getUid() : string
    {
        return "WSAPI".$this->activityId.$this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function getEnseignants(): string
    {
        return implode(", ",$this->enseignants);
    }

    /**
     * @return int
     */
    public function countEnseignants(): int
    {
        return count($this->enseignants);
    }

    /**
     * @return string
     */
    public function getSalles(): string
    {
        return implode(", ",$this->salles);
    }

    /**
     * @return array
     */
    public function getGroupes(): string
    {
        return implode(", ",$this->groupes);
    }

    /**
     * @return string
     */
    public function getRed(): int
    {
        return explode(",",$this->color)[0];
    }

    /**
     * @return string
     */
    public function getGreen(): int
    {
        return explode(",",$this->color)[1];
    }

    /**
     * @return string
     */
    public function getBlue(): int
    {
        return explode(",",$this->color)[2];
    }

    /**
     * @return string
     */
    public function getRVB(): string
    {
        return sprintf('%02d', dechex($this->getRed())).sprintf('%02d', dechex($this->getGreen())).sprintf('%02d', dechex($this->getBlue()));
    }

    /**
     * @return array
     */
    public function getDepartements(): string
    {
        return implode(", ", $this->departements);
    }



}
