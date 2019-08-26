<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 8:24 PM
 */

namespace App\Repository;


use App\Dto\AclDto;
use Doctrine\ORM\EntityRepository;

/**
 * Class AclRepository
 *
 * @package App\Repository
 */
class AclRepository extends EntityRepository
{
//region SECTION: Fields
    /**
     * @var AclDto
     */
    private $dto;
//endregion Fields

//region SECTION: Dto
    /**
     * @param AclDto $aclDto
     *
     * @return AclRepository
     */
    public function setDto($aclDto)
    {
        $this->dto = $aclDto;

        return $this;
    }
//endregion SECTION: Dto
//endregion Fields

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

        if ($this->dto && $this->dto->getId()) {
            $builder->andWhere('acl.id =  :id')
                ->setParameter('id', $this->dto->getId());
        } else {
            if ($this->dto && $this->dto->getDomain()) {
                $builder->andWhere('domain.domain =  :domain')
                    ->setParameter('domain', $this->dto->getDomain());
            }

            if ($this->dto && $this->dto->getEmail() && !$this->dto->getId()) {
                if ($this->dto->isEmail()) {
                    $builder->andWhere('acl.email = :email')
                        ->setParameter('email', $this->dto->getEmail());
                } else {
                    $builder->andWhere('acl.email LIKE :email')
                        ->setParameter('email', '%'.$this->dto->getEmailDomain().'%');
                }
            }
        }
        $builder->orderBy('acl.type', 'desc');

       return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}