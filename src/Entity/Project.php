<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ProjectBundle\Entity\BaseProject;
use JMS\Serializer\Annotation\Type;

/**
 * Class Project
 *
 * @package App\Entity
 */
class Project extends BaseProject
{
//region SECTION: Fields
    /**
     * @var Contragent
     * @Type("App\Entity\Contragent")
     * @ORM\ManyToOne(targetEntity="Contragent")
     */
    private $contragent;
//endregion Fields


//region SECTION: Getters/Setters
    /**
     * @return Contragent
     */
    public function getContragent(): Contragent
    {
        return $this->contragent;
    }
//endregion Getters/Setters
}