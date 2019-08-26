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
     * @param ServerDto $serverDto
     *
     * @return Server|array
     */
    public function saveServer($serverDto)
    {
        $entity = null;

        if ($serverDto->isValidHostName() && $serverDto->isValidIp()) {
            $criteria = $this->getCriteria();
            $criteria
                ->andWhere(
                    $criteria->expr()->andX(
                        $criteria->expr()->eq('ip', $serverDto->getIp()),
                        $criteria->expr()->eq('hostname', $serverDto->getHostName())
                    )
                );

            $existServer = $this->repository->matching($criteria);
            if ($existServer->count() >= 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                $entity = $this->save($existServer->count() ? $existServer->first() : new Server(), $serverDto);
            }
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $entity;
    }
//endregion Public

//region SECTION: Private
//    /**
//     * @param Server    $entity
//     * @param ServerDto $serverDto
//     *
//     * @return Server
//     */
//    private function save(Server $entity, $serverDto)
//    {
//        $serverDto->fillEntity($entity);
//        $this->entityManager->persist($entity);
//        $this->entityManager->flush();
//
//        return $entity;
//    }
//endregion Private

//region SECTION: Getters/Setters
//    /**
//     * @return Server[]
//     */
//    public function getServers()
//    {
//        $criteria = $this->getCriteria();
//
//        return $this->repository->matching($criteria)->toArray();
//    }


    /**
     * @param ServerDto $serverDto
     *
     * @return $this
     * @throws \Exception
     */
    public function getServers($serverDto)
    {
        $criteria = new Criteria();
        if ($serverDto->getIp()) {
            $criteria->where(
                $criteria->expr()->eq('ip', $serverDto->getIp())
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