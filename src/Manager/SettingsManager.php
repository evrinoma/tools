<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/10/19
 * Time: 9:20 AM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\DescriptionService;
use App\Entity\Settings;
use App\Rest\Core\RestTrait;
use Doctrine\Common\Collections\Criteria;

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

//region SECTION: Public
    public function save($settingsDto)
    {
//        $criteria = new Criteria();
//        $criteria
//            ->where(
//                $criteria->expr()->in('id', $range)
//            );
//        $loadSettings = $this->repository->matching($criteria);
//        /** @var Settings $item */
//        foreach ($loadSettings as $item) {
//            $item->setActive($settings[$item->getId()]['active']);
//        }
        $this->entityManager->flush();
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getSqlServers()
    {
        $builder = $this->repository->createQueryBuilder('settings');

        $builder
            ->leftJoin('settings.serviceType', 'serviceType')
            ->andWhere('serviceType.type = :type')
            ->setParameter('type', 'sql')
            ->groupBy('settings.port', 'serviceType.type', 'settings.host');

        return $builder->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
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

    /**
     * @param string $class
     *
     * @return mixed
     */
    public function getSettings($class = '')
    {
        $builder = $this->repository->createQueryBuilder('settings');

        $builder
            ->where('settings.active != \'d\'')
            ->andWhere('settings.type = :classEntity')
            ->setParameter('classEntity', $class);

        return $builder->getQuery()->getResult();
    }

    /**
     * @return DescriptionService[]
     */
    public function getDeltaServices()
    {
        $repository = $this->entityManager->getRepository(DescriptionService::class);

        $builder = $repository->createQueryBuilder('service');
        $builder->where('service.type = :type')
            ->setParameter('type', 'sql')
            ->andWhere('service.parent is null')
            ->andWhere('service.instance is not null');

        return $builder->getQuery()->getResult();
    }

    /**
     * @return DescriptionService
     */
    public function getDeltaServiceByDescription($description)
    {
        $repository = $this->entityManager->getRepository(DescriptionService::class);

        $builder = $repository->createQueryBuilder('service');
        $builder->where('service.parent is null')
            ->andWhere('service.type = :type')
            ->setParameter('type', 'sql')
            ->andWhere('service.description = :description')
            ->setParameter('description', $description);


        return $builder->getQuery()->getOneOrNullResult();
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