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
     * @param ServerDto[] $serverDto
     *
     * @return Server|array
     */
    public function saveServer($serverDto)
    {
        $dto = reset($serverDto);
        if ($dto->isValidHostName() && $dto->isValidIp()) {
            $criteria = $this->getCriteria();
            $criteria
                ->andWhere(
                    $criteria->expr()->orX(
                        $criteria->expr()->eq('ip', $dto->getIp()),
                        $criteria->expr()->eq('hostname', $dto->getHostName())
                    )
                );

            $existServer = $this->repository->matching($criteria);
            if ($existServer->count() > 1) {
                $this->setRestServerErrorUnknownError();
            } else {
                $dto = $this->save($existServer->count() ? $existServer->first() : new Server(), $dto);
            }
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $dto;
    }
//endregion Public

//region SECTION: Private
    /**
     * @param Server    $entity
     * @param ServerDto $serverDto
     *
     * @return Server
     */
    private function save(Server $entity, $serverDto)
    {
        $serverDto->fillEntity($entity);
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
     * @param ServerDto[] $serverDto
     *
     * @return $this
     * @throws \Exception
     */
    public function getServer($serverDto)
    {
        $dto = reset($serverDto);

        $criteria = new Criteria();
        $criteria->where(
            $criteria->expr()->eq('ip', $dto->getIp())
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