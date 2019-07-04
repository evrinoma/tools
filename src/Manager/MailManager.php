<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/11/19
 * Time: 10:54 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Core\Rest\RestTrait;
use App\Entity\Mail\Domain;
use App\Entity\Mail\Server;
use App\Entity\Mail\TbDomains;

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
//endregion Fields

//region SECTION: Public
    public function createDomain()
    {
        return [];
    }

    public function megrateDomains()
    {

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
        return [];
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}