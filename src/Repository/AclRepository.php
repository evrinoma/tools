<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 8:24 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * Class AclRepository
 *
 * @package App\Repository
 */
class AclRepository extends EntityRepository
{
    //region SECTION: Fields
    private $criteria;
//endregion Fields

//region SECTION: Public
    /**
     * @return mixed
     */
    public function createCriteria()
    {
        return $this->criteria = new class()
        {
            private $id;

            /**
             * @return mixed
             */
            public function getId()
            {
                return $this->id;
            }

            /**
             * @param mixed $id
             *
             * @return self
             */
            public function setId($id)
            {
                $this->id = $id;

                return $this;
            }
        };
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @return mixed
     */
    public function findAcl()
    {
        $builder = $this->createQueryBuilder('acl');

        $builder
            ->leftJoin('acl.domain', 'domain')
            ->where("acl.active = 'a'");
        if ($this->criteria->getId()) {
            $builder->andWhere('domain.id =  :id')
                ->setParameter('id', $this->criteria->getId());
        }

        $builder->orderBy('acl.type', 'desc');

        return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}