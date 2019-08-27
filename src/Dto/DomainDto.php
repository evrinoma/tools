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
    private $hostNameServer;
    private $domainName;
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
        $entity->setDomain($this->getDomainName())->setServer($this->getServer()->generatorEntity()->current())->setActive();

        return $entity;
    }

    /**
     * @return bool
     */
    public function isValidDomainName()
    {
        return $this->domainName && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->domainName) === 1);
    }

    /**
     * @return bool
     */
    public function isValidHostNameServer()
    {
        return $this->hostNameServer &&  (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->hostNameServer) === 1);
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto(&$request)
    {
        $page    = $request->get('page');
        $perPage = $request->get('per_page');
        $filter  = $request->get('filter');
        $hostNameServer      = $request->get('hostNameServer');
        $domainName    = $request->get('domainName');
        $id      = $request->get('domainId');

        $dto = new self();

        if ($id!==null) {
            $dto->setId($id);
        }
        if ($hostNameServer!==null) {
            $dto->setHostNameServer($hostNameServer);
        }
        if ($domainName!==null) {
            $dto->setDomainName($domainName);
        }
        if ($page!==null) {
            $dto->setPage($page);
        }
        if ($perPage!==null) {
            $dto->setPerPage($perPage);
        }
        if ($filter!==null) {
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
    public function getHostNameServer()
    {
        return $this->hostNameServer;
    }

    /**
     * @return mixed
     */
    public function getDomainName()
    {
        return $this->domainName;
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
        $this->page = (int) $page;

        return $this;
    }

    /**
     * @param mixed $perPage
     *
     * @return DomainDto
     */
    public function setPerPage($perPage = null)
    {
        $this->perPage = (int) $perPage;

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
     * @param mixed $hostNameServer
     *
     * @return DomainDto
     */
    public function setHostNameServer($hostNameServer = null)
    {
        $this->hostNameServer = $hostNameServer;

        return $this;
    }

    /**
     * @param mixed $domainName
     *
     * @return DomainDto
     */
    public function setDomainName($domainName = null)
    {
        $this->domainName = $domainName;

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