<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;


use App\Entity\Mail\Domain;
use App\Entity\Mail\Server;
use App\Entity\Model\ActiveTrait;
use Doctrine\ORM\LazyCriteriaCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerDto
 *
 * @package App\Dto
 */
class DomainDto implements FactoryDtoInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
    private $ip;
    private $name;

    /**
     * @var LazyCriteriaCollection
     */
    private $servers;
//endregion Fields

//region SECTION: Public
    /**
     * @param Domain $entity
     *
     * @return Domain
     */
    public function fillEntity($entity)
    {
        $entity->setDomain($this->getName())->addServer($this->getServers())->setActive();

        return $entity;
    }

    /**
     * @return bool
     */
    public function isValidName()
    {
        return $this->name && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->name) === 1);
    }

    /**
     * @return bool
     */
    public function isValidIp()
    {
        return $this->ip && (preg_match("/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $this->ip) === 1);
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param $request
     *
     * @return array
     */
    public static function toDto(Request $request)
    {
        $ip   = $request->get('ip');
        $name = $request->get('name');
        $id   = $request->get('id');

        $result = [];

        if ($ip && $name) {
            $dto    = new self();
            $dto->setIp($ip)->setName($name);
            $result[] = $dto;
        } else {
            if ($id) {
                $dto    = new self();
                $dto->setId($id);
                $result[] = $dto;
            }
        }

        return $result;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return Server
     */
    public function getServers(): ?Server
    {
        return $this->servers->count() ? $this->servers->first() : null;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request)
    {
        return $request;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param LazyCriteriaCollection $servers
     *
     * @return DomainDto
     */
    public function setServers(LazyCriteriaCollection $servers)
    {
        $this->servers = $servers;

        return $this;
    }

    /**
     * @param mixed $ip
     *
     * @return DomainDto
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @param mixed $name
     *
     * @return DomainDto
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return DomainDto
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


//endregion Getters/Setters
}