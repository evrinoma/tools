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
use App\Rest\Core\RestTrait;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MailManager
 *
 * @package App\Manager
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

//endregion Fields

//region SECTION: Constructor
    /**
     * MailManager constructor.
     *
     * @param string $repositoryClass
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
     * @return Domain|array
     * @throws \Exception
     */
    public function createDomain($ip, $name)
    {
        $entity = [];

        if ($ip && $name) {
            $criteria = new Criteria();
            $criteria->where(
                $criteria->expr()->eq('domain', $name)
            );

            $value = $this->repository->matching($criteria);

            if ($value->count() > 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                $server = $this->serverManager->getServer($ip);
                $entity = $this->save($value->count() ? $value->first() : new Domain(), $server, $name);
            }
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }

    public function megrateDomains()
    {
        return [];

        $this->deleteAllEntity(Domain::class)->deleteAllEntity(Server::class);
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
    private function save(Domain $entity, Server $server, $name)
    {
        $entity->setDomain($name)->addServer($server)->setActive();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    private function deleteAllEntity($className)
    {
        $repository = $this->entityManager->getRepository($className);
        $entities   = $repository->findAll();
        foreach ($entities as $entity) {
            $this->entityManager->remove($entity);
        }
        $this->entityManager->flush();

        return $this;
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getDomains()
    {
        $criteria = new Criteria();
        $criteria->where(
            $criteria->expr()->eq('active', 'a')
        );

        return $this->repository->matching($criteria)->toArray();
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}