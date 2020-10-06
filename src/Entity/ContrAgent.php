<?php

namespace App\Entity;

use App\Entity\Common\CreateByUser;
use App\Entity\Common\UpdateByUser;
use Evrinoma\ContrAgentBundle\Entity\BaseContrAgent;
use JMS\Serializer\Annotation\Type;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContrAgent
 *
 * @package App\Entity
 * @ORM\Table(name="contragent")
 * @ORM\Entity
 */
class ContrAgent extends BaseContrAgent
{
    use CreateByUser, UpdateByUser;
}