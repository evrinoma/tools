<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/3/19
 * Time: 6:59 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Mail\Server;
use App\Rest\Core\RestTrait;
use Doctrine\Common\Collections\Criteria;

/**
 * Class ServerManger
 *
 * @package App\Manager
 */
class ServerManager extends AbstractEntityManager
{

    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Server::class;
//endregion Fields

//region SECTION: Public
    /**
     * @param $ip
     * @param $hostname
     *
     * @return array
     * @throws \Exception
     */
    public function createServer($ip, $hostname)
    {
        $entity = [];

        if ($ip && $hostname) {
            $criteria = new Criteria();
            $criteria->where(
                $criteria->expr()->eq('ip', $ip)
            )->orWhere(
                $criteria->expr()->eq('hostname', $hostname)
            );

            $value = $this->repository->matching($criteria);

            if ($value->count() > 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                $entity = $this->save($value->count() ? $value->first() : new Server(), $ip, $hostname);
            }
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }
//endregion Public

//region SECTION: Private
    private function save(Server $entity, $ip, $hostname)
    {
        if (($entity->getIp() && $entity->getIp() === $ip) && ($entity->getHostname() && $entity->getHostname() === $hostname)) {
            $entity->setIp($ip)->setHostname($hostname)->setActive();
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } else {
            $this->setRestClientErrorConflict();
        }

        return $entity;
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @return Server[]
     */
    public function getServers()
    {
        $criteria = $this->getCriteria();

        return $this->repository->matching($criteria)->toArray();
    }


    public function getServer($ip = '')
    {
        $criteria = new Criteria();
        $criteria->where(
            $criteria->expr()->eq('ip', $ip)
        );

        $value = $this->repository->matching($criteria);

        if ($value->count() > 1) {
            throw new \Exception(__METHOD__);
        }

        return $value->first();
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}