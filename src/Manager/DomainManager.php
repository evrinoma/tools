<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/11/19
 * Time: 10:54 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Dto\DomainDto;
use App\Entity\Mail\Domain;
use App\Entity\Mail\Migrations\TbDomains;
use App\Entity\Mail\Server;
use App\Repository\DomainRepository;
use App\Rest\Core\RestTrait;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DomainManager
 *
 * @package App\Manager
 * @property DomainRepository $repository
 */
class DomainManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Domain::class;

    private $serverManager;

    private $page;

    private $perPage;

    private $filter;
//endregion Fields

//region SECTION: Constructor
    /**
     * DomainManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ServerManager          $serverManager
     */
    public function __construct(EntityManagerInterface $entityManager, ServerManager $serverManager)
    {
        parent::__construct($entityManager);

        $this->serverManager = $serverManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param DomainDto[] $domainDto
     *
     * @return Domain
     * @throws \Exception
     */
    public function saveDomain($domainDto)
    {
        $dto = reset($domainDto);
        if ($dto->isValidName() && $dto->isValidIp()) {
            $criteria = $this->getCriteria();
            $criteria->andWhere(
                $criteria->expr()->eq('domain', $dto->getName())
            );

            $existDomain = $this->repository->matching($criteria);
            $dto->setServers($this->serverManager->getServer($dto->getIp())->getData());
            $dto = $this->save($existDomain->count() ? $existDomain->first() : new Domain(), $dto);
        } else {
            $this->setRestClientErrorBadRequest();
            $dto =null;
        }

        return $dto;
    }

    /**
     * @return array
     */
    public function megrateDomains()
    {
        $this
            ->getRepositoryAll(Domain::class)->removeEntitys()
            ->getRepositoryAll(Server::class)->removeEntitys();

        $created    = [];
        $rTbDomains = $this->entityManager->getRepository(TbDomains::class);
        /** @var TbDomains $value */
        foreach ($rTbDomains->findAll() as $value) {
            $ip = $value->getReleyAdr();
            if (!array_key_exists($ip, $created)) {
                $server = new Server();
                $server
                    ->setIp($ip)
                    ->setHostname($value->getMx());
                $this->entityManager->persist($server);
                $created[$ip] = $server;
            } else {
                $server = $created[$ip];
            }

            $domain = new Domain();
            $domain
                ->addServer($server)
                ->setDomain($value->getDomain())
                ->setActive();
            $this->entityManager->persist($domain);
        }
        $this->entityManager->flush();

        return [];
    }

//endregion Public

//region SECTION: Private
    /**
     * @param Domain    $entity
     * @param DomainDto $domainDto
     *
     * @return Domain
     */
    private function save(Domain $entity, $domainDto)
    {
        $domainDto->fillEntity($entity);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

//endregion Private

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
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
     * @return $this
     */
    public function getDomains()
    {
        $firstResult = $this->page * $this->perPage - $this->perPage;

        $this->repository
            ->createCriteria()
            ->setDomain($this->filter)
            ->setFirstResult($firstResult)
            ->setMaxResults($this->perPage);

        $this->setData($this->repository->findDomain());

        return $this;
    }

    /**
     * @param DomainDto[] $domainDto
     *
     * @return DomainManager
     */
    public function getDomain($domainDto)
    {
        $dto = reset($domainDto);

        if ($dto->getId()) {
            $criteria = $this->getCriteria();
            $criteria->andWhere(
                $criteria->expr()->eq('id', $dto->getId())
            );

            $this->setData($this->repository->matching($criteria)->getValues());
        }

        return $this;
    }

    /**
     * если фильтр задан то возвращаем число всех найденных записей
     *
     * @return int
     */
    public function getCount($criteria = null)
    {
        $this->repository
            ->createCriteria()
            ->setDomain($this->filter);

        return count($this->repository->findDomain());
    }

    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param mixed $filter
     *
     * @return DomainManager
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param mixed $page
     *
     * @return DomainManager
     */
    public function setPage($page)
    {
        $this->page = (int)$page;

        return $this;
    }

    /**
     * @param mixed $perPage
     *
     * @return DomainManager
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int)$perPage;

        return $this;
    }
//endregion Getters/Setters
}