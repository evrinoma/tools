<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/3/19
 * Time: 6:59 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Dto\ServerDto;
use App\Entity\Mail\Server;
use App\Rest\Core\RestTrait;

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
     * @param ServerDto $serverDto
     *
     * @return Server|array
     */
    public function saveServer($serverDto)
    {
        $entity = null;

        if ($serverDto->isValidHostName() && $serverDto->isValidIp()) {
            $criteria = $this->getCriteria();
            if ($serverDto->getId()) {
                $criteria->andWhere(
                    $criteria->expr()->orX(
                        $criteria->expr()->eq('hostname', $serverDto->getHostName()),
                        $criteria->expr()->eq('id', $serverDto->getId())
                    )
                );
            } else {
                $criteria->andWhere($criteria->expr()->eq('hostname', $serverDto->getHostName()));
                if ($serverDto->getHostName()) {
                    $criteria->andWhere($criteria->expr()->eq('ip', $serverDto->getIp()));
                }
            }
            $existServer = $this->repository->matching($criteria);
            if (!$serverDto->getId() && $existServer->count() >= 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                if ($existServer->count() > 1) {
                    $this->setRestServerErrorUnknownError();
                } else {
                    $entity = $this->save($existServer->count() ? $existServer->first() : new Server(), $serverDto);
                }
            }
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }
//endregion Public


//region SECTION: Getters/Setters
    /**
     * @param ServerDto $serverDto
     *
     * @return $this
     * @throws \Exception
     */
    public function getServers($serverDto)
    {
        $criteria = $this->getCriteria();
        if ($serverDto->getIp()) {
            $criteria->andWhere(
                $criteria->expr()->eq('ip', $serverDto->getIp())
            );
        }
        if ($serverDto->getHostName()) {
            $criteria->andWhere(
                $criteria->expr()->eq('hostname', $serverDto->getHostName())
            );
        }
        $value = $this->repository->matching($criteria);

        $this->setData($value->count() ? $value->toArray() : null);

        return $this;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}