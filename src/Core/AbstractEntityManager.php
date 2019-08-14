<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/5/19
 * Time: 8:09 PM
 */

namespace App\Core;


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
    private $data;
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
//endregion Protected

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