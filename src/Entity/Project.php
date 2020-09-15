<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ProjectBundle\Model\AbstractBaseProject;
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

    /**
     * @var User
     * @Type("App\Entity\User")
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_id", referencedColumnName="id")
     * })
     */
    private $created;

    /**
     * @var User
     * @Type("App\Entity\User")
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_id", referencedColumnName="id")
     * })
     */
    private $updated;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return Contragent
     */
    public function getContrAgent(): Contragent
    {
        return $this->contrAgent;
    }

    /**
     * @return User
     */
    public function getCreated(): User
    {
        return $this->created;
    }

    /**
     * @return User
     */
    public function getUpdated(): User
    {
        return $this->updated;
    }
//endregion Getters/Setters
}