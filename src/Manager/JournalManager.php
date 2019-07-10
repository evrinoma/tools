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
use App\Entity\DescriptionService;
use App\Rest\Core\RestTrait;
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
    use RestTrait;

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

    /**
     * @var SettingsManager
     */
    private $settingsManager;

    /**
     * @var DescriptionService
     */
    private $service;

    /**
     * @var \DateTime
     */
    private $date;
//endregion Fields


//region SECTION: Constructor
    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry, SettingsManager $settingsManager)
    {
        parent::__construct($entityManager);

        $this->entityManagerDelta = $registry->getEntityManager(self::MSSQL_LINK);
        $this->connection         = $this->entityManagerDelta->getConnection();

        $this->settingsManager = $settingsManager;
    }
//endregion Constructor

//region SECTION: Public
    public function validate($dataFlow, $date): self
    {
        $service    = $this->settingsManager->getDeltaServiceByDescription($dataFlow);
        $this->date = (new \DateTime())->createFromFormat('d-m-Y', $date);
        if ($service && $service->getChildFirst()->leDate($this->date)) {
            $this->service = $service;
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }
//endregion Public

//region SECTION: Private
    private function toTableName()
    {
        return 'D'.$this->date->format('dmY');
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
    public function findParams(): self
    {
        if ($this->service) {
            /** @var Params $item */
            $this->connectionSwitcher($this->service->getDescription());
            $repository = $this->entityManagerDelta->getRepository(Params::class);
            foreach ($repository->findAll() as $item) {
                $this->params[$item->getId()] = $item;
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function findDataParams(): self
    {
        if ($this->service) {
            $this->connectionSwitcher($this->service->getChildFirst()->getDescription());

            $metadata = $this->entityManagerDelta->getClassMetadata(DiscretInfo::class);
            $metadata->setPrimaryTable(['name' => $this->toTableName()]);
            /** @var EntityRepository $repository */
            $repository       = $this->entityManagerDelta->getRepository(DiscretInfo::class);
            $this->dataParams = $repository->findAll();

            /** @var DiscretInfo $item */
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

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}