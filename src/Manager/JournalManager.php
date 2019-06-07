<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/5/19
 * Time: 8:02 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Customer\ParamData;
use App\Entity\Journal\Params;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class JournalManager
 *
 * @package App\Manager
 */
class JournalManager extends AbstractEntityManager
{
//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Params::class;

    /** @var Params[] */
    private $params = [];

    private $dataParams = [];

    private $entityManagerCustom;

//endregion Fields


//region SECTION: Constructor
    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry)
    {
        parent::__construct($entityManager);

        $this->entityManagerCustom = $registry->getEntityManager('customer');
    }
//endregion Constructor

//region SECTION: Private
    private function toTableName($date)
    {
        $d = new \DateTime($date);

        return 'D'.$d->format('dmY');
    }
//endregion Private

//region SECTION: Find Filters Repository
    /**
     * @return $this
     */
    public function findParams()
    {
        /** @var Params $item */
        foreach ( $this->repository->findAll() as $item)
        {
            $this->params[$item->getId()] = $item;
        }

        return $this;
    }

    /**
     * @param $date
     *
     * @return $this
     */
    public function findDataParams($date)
    {
        $metadata = $this->entityManagerCustom->getClassMetadata(ParamData::class);
        $metadata->setPrimaryTable(['name' => $this->toTableName($date)]);
        /** @var EntityRepository $repository */
        $repository       = $this->entityManagerCustom->getRepository(ParamData::class);
        $this->dataParams = $repository->findAll();

        /** @var ParamData $item */
        foreach ( $this->dataParams as $item)
        {
            $this->params[$item->getN()]->addParamData($item);
        }

        return $this;
    }
//endregion Find Filters Repository

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->params;
    }
//endregion Getters/Setters
}