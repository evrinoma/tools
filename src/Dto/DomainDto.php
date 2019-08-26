<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;


use App\Annotation\Dto;
use App\Entity\Mail\Domain;
use App\Entity\Model\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DomainDto
 *
 * @package App\Dto
 */
class DomainDto extends AbstractFactoryDto implements VuetableInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
    private $ip;
    private $name;
    private $page;
    private $perPage;
    private $filter;

    /**
     * @Dto(class="App\Dto\ServerDto")
     * @var ServerDto
     */
    private $server;
//endregion Fields

//region SECTION: Public
    /**
     * @param Domain $entity
     *
     * @return Domain
     */
    public function fillEntity($entity)
    {
        $entity->setDomain($this->getName())->setServer($this->getServer()->generatorEntity()->current())->setActive();

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
     * @return FactoryDtoInterface
     */
    public static function toDto(Request $request)
    {
        $page    = $request->get('page');
        $perPage = $request->get('per_page');
        $filter  = $request->get('filter');
        $ip      = $request->get('ip');
        $name    = $request->get('hostname');
        $id      = $request->get('id');

        $dto = new self();

        if ($id) {
            $dto->setId($id);
        }
        if ($ip) {
            $dto->setIp($ip);
        }
        if ($name) {
            $dto->setName($name);
        }
        if ($page) {
            $dto->setPage($page);
        }
        if ($perPage) {
            $dto->setPerPage($perPage);
        }
        if ($filter) {
            $dto->setFilter($filter);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return ServerDto
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param FactoryDtoInterface $server
     *
     * @return DomainDto
     */
    public function setServer($server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @param mixed $page
     *
     * @return DomainDto
     */
    public function setPage($page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param mixed $perPage
     *
     * @return DomainDto
     */
    public function setPerPage($perPage = null)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @param mixed $filter
     *
     * @return DomainDto
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param mixed $ip
     *
     * @return DomainDto
     */
    public function setIp($ip = null)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @param mixed $name
     *
     * @return DomainDto
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return DomainDto
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }
//endregion Getters/Setters
}