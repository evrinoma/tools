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
     * @param SpamDto $spamDto
     *
     * @return SpamRepository
     */
    public function setDto($spamDto)
    {
        $this->dto = $spamDto;

        return $this;
    }

//endregion SECTION: Dto

//region SECTION: Find Filters Repository
    public function findSpam()
    {

        $builder = $this->createQueryBuilder('spam');

        $builder->where("spam.active = 'a'");

        if ($this->dto && $this->dto->getId()) {
            $builder->andWhere('spam.id =  :id')
                ->setParameter('id', $this->dto->getId());
        } else {
            if ($this->dto && $this->dto->getRuleType() && $this->dto->getRuleType()->getType()) {
                $builder->leftJoin('spam.type', 'filterType')
                    ->andWhere('filterType.type = :filter')
                    ->setParameter('filter', $this->dto->getRuleType()->getType());
            }

            if ($this->dto && $this->dto->isConformity() && $this->dto->getConformity() && $this->dto->getConformity()->getType()) {
                $builder->leftJoin('spam.conformity', 'conformityType')
                    ->andWhere('conformityType.type = :conformity')
                    ->setParameter('conformity', $this->dto->getConformity()->getType());
            }

            if ($this->dto && $this->dto->getSpamRecord()) {
                $builder->andWhere('spam.domain like :spamRecordLike or spam.domain = :spamRecord')
                    ->setParameter('spamRecordLike', '%'.$this->dto->getSpamRecord())
                    ->setParameter('spamRecord', $this->dto->getSpamRecord());
            }
        }

        return $builder->getQuery()->getResult();
    }
//endregion Find Filters Repository
}