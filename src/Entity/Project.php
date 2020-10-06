<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ProjectBundle\Model\AbstractBaseProject;
use App\Entity\Common\CreateByUser;
use App\Entity\Common\UpdateByUser;
use JMS\Serializer\Annotation\Type;

/**
 * Class Project
 *
 * @package App\Entity
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project extends AbstractBaseProject
{
//region SECTION: Fields
    use CreateByUser, UpdateByUser;

    /**
     * @var Contragent
     * @Type("App\Entity\ContrAgent")
     *
     * @ORM\ManyToOne(targetEntity="ContrAgent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contragent_id", referencedColumnName="id")
     * })
     */
    private $contrAgent;

//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return Contragent
     */
    public function getContrAgent(): Contragent
    {
        return $this->contrAgent;
    }
//endregion Getters/Setters
}