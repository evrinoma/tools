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
     * @return Server[]
     */
    public function saveServer($ip, $name)
    {
        $entity = ['ip' => $ip, 'name' => $name];
        if ($ip && $name
            && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $name) === 1)
            && (preg_match("/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $ip) === 1)
        ) {
            $criteria = $this->getCriteria();
            $criteria
                ->andWhere(
                    $criteria->expr()->orX(
                        $criteria->expr()->eq('ip', $ip),
                        $criteria->expr()->eq('hostname', $name)
                    )
                );

            $existServer = $this->repository->matching($criteria);
            if ($existServer->count() > 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                $entity = $this->save($existServer->count() ? $existServer->first() : new Server(), $ip, $name);
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
        $entity->setIp($ip)->setHostname($hostname)->setActive();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

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


    /**
     * @param $ip
     *
     * @return $this
     * @throws \Exception
     */
    public function getServer($ip)
    {
        $criteria = new Criteria();
        $criteria->where(
            $criteria->expr()->eq('ip', $ip)
        );

        $value = $this->repository->matching($criteria);

        if ($value->count() > 1) {
            throw new \Exception(__METHOD__);
        }

        $this->setData($value);

        return $this;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}