<?php

namespace App\Entity;

use Evrinoma\ContrAgentBundle\Entity\BaseContrAgent;
use JMS\Serializer\Annotation\Type;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contragent
 *
 * @package App\Entity
 * @ORM\Table(indexes={@ORM\Index(name="IDX_4FBF094FB03A8386", columns={"created_id"}), @ORM\Index(name="IDX_4FBF094F896DBBDE", columns={"updated_id"})})
 */
class Contragent extends BaseContrAgent
{
//region SECTION: Fields
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