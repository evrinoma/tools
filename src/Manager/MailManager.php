<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/11/19
 * Time: 10:54 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Mail\Domain;
use App\Entity\Mail\Server;
use App\Entity\Mail\TbDomains;
use App\Repository\DomainRepository;
use App\Rest\Core\RestTrait;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MailManager
 *
 * @package App\Manager
 * @property DomainRepository $repository
 */
class MailManager extends AbstractEntityManager
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
     * MailManager constructor.
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
     * @param $ip
     * @param $name
     *
     * @return Domain
     * @throws \Exception
     */
    public function saveDomain($ip, $name)
    {
        $entity = ['ip' => $ip, 'name' => $name];
        if ($ip && $name && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $name) === 1)) {
            $criteria = new Criteria();
            $criteria->where(
                $criteria->expr()->eq('domain', $name)
            );
            $existDomain = $this->repository->matching($criteria);
            $server      = $this->serverManager->getServer($ip)->getData();
            $entity      = $this->save($existDomain->count() ? $existDomain->first() : new Domain(), $name, $server->count() ? $server->first():null);
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
        return [];

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
     * @param Domain $entity
     * @param        $name
     * @param Server $server
     *
     * @return Domain
     */
    private function save(Domain $entity, $name, $server = null)
    {
        $entity->setDomain($name)->addServer($server)->setActive();

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

            $this->setData($this->repository->filterDomain());

        return $this;
    }

    /**
     * @param $id
     *
     * @return MailManager
     */
    public function getDomain($id)
    {
        if ($id) {
            $criteria = $this->getCriteria();
            $criteria->andWhere(
                $criteria->expr()->eq('id', $id)
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

        return count($this->repository->filterDomain());
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
     * @return MailManager
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param mixed $page
     *
     * @return MailManager
     */
    public function setPage($page)
    {
        $this->page = (int)$page;

        return $this;
    }

    /**
     * @param mixed $perPage
     *
     * @return MailManager
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int)$perPage;

        return $this;
    }
//endregion Getters/Setters
}