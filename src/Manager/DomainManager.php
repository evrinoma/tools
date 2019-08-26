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
     * @param DomainDto $domainDto
     *
     * @return Domain
     * @throws \Exception
     */
    public function saveDomain($domainDto)
    {
        $entity = null;

        if ($domainDto->isValidName() && $domainDto->isValidIp()) {
            $criteria = $this->getCriteria();
            $criteria->andWhere(
                $criteria->expr()->eq('domain', $domainDto->getName())
            );

            $existDomain = $this->repository->matching($criteria);
            if ($domainDto->getServer()->getEntitys() === null) {
                $domainDto->getServer()->setEntitys($this->serverManager->getServers($domainDto->getServer())->getData());
            }
            $entity = $this->save($existDomain->count() ? $existDomain->first() : new Domain(), $domainDto);
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }

    /**
     * @return array
     */
    public function megrateDomains()
    {
        $this
            ->getRepositoryAll(Server::class)->removeEntitys()
            ->getRepositoryAll(Domain::class)->removeEntitys();

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
                ->setServer($server)
                ->setDomain($value->getDomain())
                ->setActive();
            $this->entityManager->persist($domain);
        }
        $this->entityManager->flush();

        return [];
    }

//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param DomainDto $domainDto
     *
     * @return $this
     */
    public function getDomains(?DomainDto $domainDto)
    {
        if ($domainDto) {
            $this->setData($this->repository->setDto($domainDto)->findDomain());
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }


    /**
     * если фильтр задан то возвращаем число всех найденных записей
     *
     * @param DomainDto|null $domainDto
     *
     * @return int
     */
    public function getCount($domainDto = null)
    {
        $count = 0;
        if ($domainDto) {
            $dtoClone = clone $domainDto;
            $dtoClone->setPerPage()->setPage();
            $count = $domainDto ? count($this->repository->setDto($dtoClone)->findDomain()) : 0;
        }

        return $count;
    }

    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}