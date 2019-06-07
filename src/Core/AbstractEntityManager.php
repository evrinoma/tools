<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/5/19
 * Time: 8:09 PM
 */

namespace App\Core;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractEntityManager
 *
 * @package App\Core
 */
abstract class AbstractEntityManager
{

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
     * AbstractEntity constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        if ($this->repositoryClass) {
            $this->repository = $this->entityManager->getRepository($this->repositoryClass);
        }
    }

}