<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 2:27 PM
 */

namespace App\Repository;

use App\Dto\SpamDto;
use Doctrine\ORM\EntityRepository;


/**
 * Class SpamRepository
 *
 * @package App\Repository
 */
class SpamRepository extends EntityRepository
{

    //region SECTION: Fields
    /**
     * @var SpamDto
     */
    private $dto;
//endregion Fields

//region SECTION: Dto
    /**
     * @param SpamDto $aclDto
     *
     * @return SpamRepository
     */
    public function setDto($aclDto)
    {
        $this->dto = $aclDto;

        return $this;
    }
//endregion SECTION: Dto

    public function findSpam(){

        $builder = $this->createQueryBuilder('spam');

        $builder->where("spam.active = 'a'");

        if ($this->dto && $this->dto->getId()) {
            $builder->andWhere('spam.id =  :id')
                ->setParameter('id', $this->dto->getId());
        } else {
            if ($this->dto && $this->dto->getRuleType()->getFilterType()) {
                $builder->leftJoin('spam.type', 'filterType')
                    ->andWhere('filterType.type = :filter')
                    ->setParameter('filter', $this->dto->getRuleType()->getFilterType());
            }

            if ($this->dto && $this->dto->getConformity()) {
                $builder->leftJoin('spam.conformity', 'conformityType')
                    ->andWhere('conformityType.type = :conformity')
                    ->setParameter('conformity', $this->dto->getConformity());
            }
        }

        return $builder->getQuery()->getResult();
    }
}