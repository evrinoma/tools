<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/14/19
 * Time: 7:20 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * Class DomainRepository
 *
 * @package App\Repository
 */
class DomainRepository extends EntityRepository
{
//region SECTION: Fields
    private $criteria;
//endregion Fields

//region SECTION: Public
    public function filterDomain()
    {
        $builder = $this->createQueryBuilder('domain');

        $builder
            ->leftJoin('domain.server', 'server')
            ->where("domain.active = 'a'");
        if ($this->criteria->getFilterDomain()) {
            $builder->andWhere('domain.domain like :filter or server.hostname like :filter')
                ->setParameter('filter', '%'.$this->criteria->getFilterDomain().'%');
        }
        if ($this->criteria->getFilterIp()) {
            $builder->andWhere('server.ip like :filter')
                ->setParameter('filter', $this->criteria->getFilterIp());
        }
        $builder->setMaxResults($this->criteria->getMaxResults())
            ->setFirstResult($this->criteria->getFirstResult());

        return $builder->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function createCriteria()
    {
        return $this->criteria = new class()
        {
            private $filterDomain;
            private $filterIp;
            private $firstResult;
            private $maxResults;

            /**
             * @return mixed
             */
            public function getFilterIp()
            {
                return $this->filterIp;
            }

            /**
             * @param mixed $filterIp
             *
             * @return self
             */
            public function setFilterIp($filterIp)
            {
                $this->filterIp = $filterIp;

                return $this;
            }

            /**
             * @return mixed
             */
            public function getMaxResults()
            {
                return $this->maxResults;
            }

            /**
             * @param mixed $maxResults
             *
             * @return self
             */
            public function setMaxResults($maxResults)
            {
                $this->maxResults = $maxResults;

                return $this;
            }


            /**
             * @return mixed
             */
            public function getFilterDomain()
            {
                return $this->filterDomain;
            }

            /**
             * @param mixed $filterDomain
             *
             * @return self
             */
            public function setFilterDomain($filterDomain)
            {
                $this->filterDomain = $filterDomain;

                return $this;
            }

            /**
             * @return mixed
             */
            public function getFirstResult()
            {
                return $this->firstResult;
            }

            /**
             * @param mixed $firstResult
             *
             * @return self
             */
            public function setFirstResult($firstResult)
            {
                $this->firstResult = $firstResult;

                return $this;
            }

        };
    }
//endregion Public
}