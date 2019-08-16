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
            ->where("domain.active = 'a'")
            ->andWhere("server.active = 'a'");
        if ($this->criteria->getDomain()) {
            $builder->andWhere('domain.domain like :filter or server.hostname like :filter')
                ->setParameter('filter', '%'.$this->criteria->getDomain().'%');
        }
        if ($this->criteria->getIp()) {
            $builder->andWhere('server.ip like :filter')
                ->setParameter('filter', $this->criteria->getIp());
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
            private $domain;
            private $ip;
            private $firstResult;
            private $maxResults;

            /**
             * @return mixed
             */
            public function getIp()
            {
                return $this->ip;
            }

            /**
             * @param mixed $ip
             *
             * @return self
             */
            public function setIp($ip)
            {
                $this->ip = $ip;

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
            public function getDomain()
            {
                return $this->domain;
            }

            /**
             * @param mixed $domain
             *
             * @return self
             */
            public function setDomain($domain)
            {
                $this->domain = $domain;

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