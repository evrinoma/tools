<?php

namespace App\Entity;

use Evrinoma\ContrAgentBundle\Entity\BaseContrAgent;
use JMS\Serializer\Annotation\Type;

class Contragent extends BaseContrAgent
{
//region SECTION: Fields
    /**
     * @var User
     * @Type("App\Entity\User")
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $created;

    /**
     * @var User
     * @Type("App\Entity\User")
     * @ORM\ManyToOne(targetEntity="User")
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