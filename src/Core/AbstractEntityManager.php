<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/5/19
 * Time: 8:09 PM
 */

namespace App\Core;


use App\Entity\Model\ActiveTrait;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractEntityManager
 *
 * @package App\Core
 */
abstract class AbstractEntityManager
{

//region SECTION: Fields
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $repositoryClass;

    /**
     * @var mixed
     */
    private $data = [];
//endregion Fields

//region SECTION: Constructor
    /**
     * AbstractEntity constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        if ($this->repositoryClass) {
            $this->repository = $this->entityManager->getRepository($this->repositoryClass);
        }
    }
//endregion Constructor

//region SECTION: Protected
    /**
     * @return Criteria
     */
    protected function getCriteria()
    {
        $criteria = new Criteria();
        $criteria->where(
            $criteria->expr()->eq('active', 'a')
        );

        return $criteria;
    }

    /**
     * @param $className
     *
     * @return self
     */
    protected function getRepositoryAll($className)
    {
        /** @var EntityRepository $repository */
        $repository = $this->entityManager->getRepository($className);
        $this->setData($repository->findAll());

        return $this;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @return self
     */
    public function removeEntitys()
    {
        foreach ($this->getData() as $entity) {
            $this->entityManager->remove($entity);
        }
        $this->entityManager->flush();

        return $this;
    }

    /**
     * @return self
     */
    public function lockEntitys()
    {
        /** @var ActiveTrait $entity */
        foreach ($this->getData() as $entity) {
            $entity->setActiveToDelete();
        }
        $this->entityManager->flush();

        return $this;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getCount($criteria = null)
    {
        if (!$criteria) {
            $criteria = $this->getCriteria();
        }

        return $this->repository->matching($criteria)->count();
    }

    /**
     * @param mixed $data
     *
     * @return AbstractEntityManager
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
//endregion Getters/Setters

}