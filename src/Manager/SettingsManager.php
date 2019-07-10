<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/10/19
 * Time: 9:20 AM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Settings;
use App\Rest\Core\RestTrait;

/**
 * Class SettingsManager
 *
 * @package App\Manager
 */
class SettingsManager extends AbstractEntityManager
{

    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Settings::class;
//endregion Fields

//region SECTION: Getters/Setters
    public function getSqlServers()
    {
        $builder = $this->repository->createQueryBuilder('settings');

        $builder
            ->leftJoin('settings.serviceType', 'serviceType')
            ->andWhere('serviceType.type = :type')
            ->setParameter('type', 'sql')
            ->groupBy('settings.port', 'serviceType.type', 'settings.host')
;

        return $builder->getQuery()->getResult();
    }

    public function getLocalSsh()
    {
        $builder = $this->repository->createQueryBuilder('settings');

        $builder->where('settings.isRemote = 0')
            ->andWhere('settings.host = :host')
            ->setParameter('host', 'localhost')
            ->leftJoin('settings.serviceType', 'serviceType')
            ->andWhere('serviceType.type = :type')
            ->setParameter('type', 'ssh');

        return $builder->getQuery()->getResult();
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}