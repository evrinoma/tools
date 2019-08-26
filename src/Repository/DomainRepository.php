<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/14/19
 * Time: 7:20 PM
 */

namespace App\Repository;


use App\Dto\DomainDto;
use Doctrine\ORM\EntityRepository;

/**
 * Class DomainRepository
 *
 * @package App\Repository
 */
class DomainRepository extends EntityRepository
{
//region SECTION: Fields
    /**
     * @var DomainDto
     */
    private $dto;
//endregion Fields

//region SECTION: Dto
    /**
     * @param DomainDto $dto
     *
     * @return DomainRepository
     */
    public function setDto(DomainDto $dto)
    {
        $this->dto = $dto;

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Find Filters Repository
    public function findDomain()
    {
        $builder = $this->createQueryBuilder('domain');

        $builder
            ->leftJoin('domain.server', 'server')
            ->where("domain.active = 'a'")
            ->andWhere("server.active = 'a'");
        if ($this->dto && $this->dto->getFilter()) {
            $builder->andWhere('domain.domain like :filter or server.hostname like :filter')
                ->setParameter('filter', '%'.$this->dto->getFilter().'%');
        }
        if ($this->dto && $this->dto->getIp()) {
            $builder->andWhere('server.ip like :filter')
                ->setParameter('filter', $this->dto->getIp());
        }
        if ($this->dto && $this->dto->getPerPage()) {
            $builder->setMaxResults($this->dto->getPerPage());
        }
        if ($this->dto && $this->dto->getPage() && $this->dto->getPerPage()) {
            $builder->setFirstResult($this->dto->getPage() * $this->dto->getPerPage() - $this->dto->getPerPage());
        }

        return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}