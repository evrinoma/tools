<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/5/19
 * Time: 8:02 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Delta\DiscreetInfo;
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
    private $params = [];

    /** @var Params[] */
    private $paramsHasDiscretInfo = [];

    /** @var DiscreetInfo[] */
    private $discretInfo = [];

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
     * @var \DateTime
     */
    private $date;

    private $dto;
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
        $dto = $this->getDto();
        $dto->setService($this->settingsManager->getDeltaServiceByDescription($dataFlow));
        $dto->setDate($date);

        if ($dto->isValid()) {
            $this->dto = $dto;
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }
//endregion Public

//region SECTION: Private
    private function toTableName()
    {
        return 'D'.$this->dto->getDate()->format('dmY');
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

    /**
     * @return $this
     */
    private function getDiscretInfo()
    {
        $this->connectionSwitcher($this->dto->getService()->getChildFirst()->getDescription());

        $metadata = $this->entityManagerDelta->getClassMetadata(DiscreetInfo::class);
        $metadata->setPrimaryTable(['name' => $this->toTableName()]);
        /** @var EntityRepository $repository */
        $repository = $this->entityManagerDelta->getRepository(DiscreetInfo::class);
        $this->dto->addDiscreetInfo($repository->findBy([], ['t' => 'ASC']));

        return $this;
    }
//endregion Private

//region SECTION: Dto
    private function getDto()
    {
        return new class()
        {
            /** @var Params[] */
            private $params = [];

            /** @var Params[] */
            private $hasDiscreetInfo = [];

            /** @var DiscreetInfo[] */
            private $discreetInfo = [];
            /**
             * @var DescriptionService
             */
            private $service;
            /**
             * @var \DateTime
             */
            private $date;

            /**
             * @return Params[]
             */
            public function getParams(): array
            {
                return $this->params;
            }

            /**
             * @param Params[] $params
             *
             * @return $this
             */
            public function setParams($params): self
            {
                $this->params = $params;

                return $this;
            }

            /**
             * @param Params $param
             *
             * @return $this
             */
            public function addParam($param): self
            {
                $this->params[$param->getId()] = $param;

                return $this;
            }

            /**
             * @return Params[]
             */
            public function getHasDiscreetInfo(): array
            {
                return $this->hasDiscreetInfo;
            }

            /**
             * @param Params[] $hasDiscreetInfo
             *
             * @return $this
             */
            public function setHasDiscreetInfo($hasDiscreetInfo): self
            {
                $this->hasDiscreetInfo = $hasDiscreetInfo;

                return $this;
            }

            /**
             * @return DiscreetInfo[]
             */
            public function getDiscreetInfo(): array
            {
                return $this->discreetInfo;
            }

            /**
             * @param DiscreetInfo[] $discreetInfo
             *
             * @return $this
             */
            public function setDiscreetInfo($discreetInfo): self
            {
                $this->discreetInfo = $discreetInfo;

                return $this;
            }

            /**
             * @param DiscreetInfo[] $discreetInfo
             *
             * @return $this
             */
            public function addDiscreetInfo($discreetInfo): self
            {
                $this->setDiscreetInfo($discreetInfo);

                /** @var DiscreetInfo $item */
                foreach ($this->discreetInfo as $item) {
                    $param = &$this->params[$item->getN()];
                    if ($item->getV()) {
                        $param
                            ->addDiscreetInfo($item)
                            ->setInitial();
                        $this->hasDiscreetInfo[] = &$param;
                    } elseif($this->params[$item->getN()]->getInitial()) {
                        $discreetInfo = $param->getLastDiscreetInfo();
                        $discreetInfo->setTe($item->getT());
                        $param->setInitial();
                    }
                }

                return $this;
            }

            /**
             * @return DescriptionService
             */
            public function getService(): DescriptionService
            {
                return $this->service;
            }

            /**
             * @param DescriptionService $service
             *
             * @return $this
             */
            public function setService(DescriptionService $service): self
            {
                $this->service = $service;

                return $this;
            }

            /**
             * @return \DateTime
             */
            public function getDate(): \DateTime
            {
                return $this->date;
            }

            /**
             * @param string $date
             *
             * @return $this
             */
            public function setDate(string $date): self
            {
                $this->date = (new \DateTime())->createFromFormat('d-m-Y', $date);

                return $this;
            }

            /**
             * @return bool
             */
            public function isValid(): bool
            {
                return ($this->getService() && $this->getService()->getChildFirst()->leDate($this->getDate()));
            }

        };
    }
//endregion SECTION: Dto

//region SECTION: Find Filters Repository
    /**
     * @return $this
     */
    public function findParams(): self
    {
        if ($this->dto) {
            /** @var Params $item */
            $this->connectionSwitcher($this->dto->getService()->getDescription());
            $repository = $this->entityManagerDelta->getRepository(Params::class);
            foreach ($repository->findAll() as $item) {
                $this->dto->addParam($item);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function findDiscretInfo(): self
    {
        if ($this->dto) {
            $this->getDiscretInfo();
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
        return $this->dto->getHasDiscreetInfo();
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}