<?php

namespace App\Entity;

use App\Entity\Common\CreateByUser;
use App\Entity\Common\UpdateByUser;
use Evrinoma\ContrAgentBundle\Entity\BaseContrAgent;
use Evrinoma\ContrAgentBundle\Model\AbstractBaseContrAgent;
use JMS\Serializer\Annotation\Type;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContrAgent
 *
 * @package App\Entity
 * @ORM\Table(name="contragent")
 * @ORM\Entity
 */
class ContrAgent extends AbstractBaseContrAgent
{
    use CreateByUser, UpdateByUser;
}