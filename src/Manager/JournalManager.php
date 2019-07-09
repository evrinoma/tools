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
use App\Entity\Delta\DiscretInfo;
use App\Entity\Delta\Params;
use Doctrine\DBAL\Connection;
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
    const MSSQL_LINK      = 'delta';
    const DEFAULT_DB      = 'TAZOVSKIY';
    const DEFAULT_DB_DATA = 'TAZOVSKIY_DATA';

    /** @var Params[] */
    private $params     = [];
    private $dataParams = [];
    private $entityManagerDelta;

    /**
     * @var Connection
     */
    private $connection;
//endregion Fields


//region SECTION: Constructor
    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry)
    {
        parent::__construct($entityManager);

        $this->entityManagerDelta = $registry->getEntityManager(self::MSSQL_LINK);
        $this->connection         = $this->entityManagerDelta->getConnection();
    }
//endregion Constructor

//region SECTION: Private
    private function toTableName($date)
    {
        $d = new \DateTime($date);

        return 'D'.$d->format('dmY');
    }

    private function connectionSwitcher($dbName)
    {
        $params           = $this->connection->getParams();
        $params['dbname'] = $dbName;
        if ($this->connection->isConnected()) {
            $this->connection->close();
        }

        $this->connection->__construct(
            $params,
            $this->connection->getDriver(),
            $this->connection->getConfiguration(),
            $this->connection->getEventManager()
        );
        try {
            $this->connection->connect();
        } catch (Exception $e) {
            // log and handle exception
        }
    }
//endregion Private

//region SECTION: Find Filters Repository
    /**
     * @return $this
     */
    public function findParams()
    {
        /** @var Params $item */
        $this->connectionSwitcher(self::DEFAULT_DB);
        $repository = $this->entityManagerDelta->getRepository(Params::class);
        foreach ($repository->findAll() as $item) {
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
        if ($date) {
            $this->connectionSwitcher(self::DEFAULT_DB_DATA);

            $metadata = $this->entityManagerDelta->getClassMetadata(DiscretInfo::class);
            $metadata->setPrimaryTable(['name' => $this->toTableName($date)]);
            /** @var EntityRepository $repository */
            $repository       = $this->entityManagerDelta->getRepository(DiscretInfo::class);
            $this->dataParams = $repository->findAll();

            /** @var ParamData $item */
            foreach ($this->dataParams as $item) {
                $this->params[$item->getN()]->addParamData($item);
            }

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