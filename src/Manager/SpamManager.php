<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/27/19
 * Time: 6:37 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Dto\SpamDto;
use App\Entity\Mail\Conformity;
use App\Entity\Mail\Filter;
use App\Entity\Mail\Migrations\TbSpamRules;
use App\Entity\Mail\Spam;
use App\Rest\Core\RestTrait;
use Doctrine\ORM\QueryBuilder;

/**
 * Class SpamRuleManager
 *
 * @package App\Manager
 */
class SpamManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Spam::class;
//endregion Fields

//region SECTION: Public
    public function megrateSpamRules()
    {
        $this
            ->getRepositoryAll(Conformity::class)->removeEntitys()
            ->getRepositoryAll(Filter::class)->removeEntitys()
            ->getRepositoryAll(Spam::class)->removeEntitys();

        $rTbSpamRules = $this->entityManager->getRepository(TbSpamRules::class);

        $types       = [];
        $conformists = [];

        /** @var TbSpamRules $value */
        foreach ($rTbSpamRules->findAll() as $value) {
            $spamRule = new Spam();
            $spamRule
                ->setDomain($value->getDomain())
                ->setHit($value->getHit())
                ->setUpdateAt($value->getUpdateAt());


            $pos = strripos($value->getConformity(), 'disable_');
            if ($pos === false) {
                if (!array_key_exists($value->getConformity(), $conformists)) {
                    $conformity = new Conformity();
                    $conformity->setType($value->getConformity());
                    $conformists[$value->getConformity()] = $conformity;
                    $this->entityManager->persist($conformity);
                } else {
                    $conformity = $conformists[$value->getConformity()];
                }
            } else {
                $valueConformity = substr($value->getType(), $pos, strlen($value->getType()));
                if (!array_key_exists($valueConformity, $conformists)) {
                    $conformity = new Conformity();
                    $conformity->setType($valueConformity);
                    $conformists[$valueConformity] = $conformity;
                    $this->entityManager->persist($conformity);
                } else {
                    $conformity = $conformists[$valueConformity];
                }

                $spamRule->setActiveToBlocked();
            }

            $pos = strripos($value->getType(), '_disable');
            if ($pos === false) {
                if (!array_key_exists($value->getType(), $types)) {
                    $type = new Filter();
                    $type->setType($value->getType());
                    $types[$value->getType()] = $type;
                    $this->entityManager->persist($type);
                } else {
                    $type = $types[$value->getType()];
                }
            } else {
                $valueType = substr($value->getType(), 0, $pos);
                if (!array_key_exists($valueType, $types)) {
                    $type = new Filter();
                    $type->setType($valueType);
                    $types[$valueType] = $type;
                    $this->entityManager->persist($type);
                } else {
                    $type = $types[$valueType];
                }

                $spamRule->setActiveToBlocked();
            }


            $spamRule
                ->setType($type)
                ->setConformity($conformity);

            $this->entityManager->persist($spamRule);
        }

        $this->entityManager->flush();

        return [];
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param SpamDto $spamDto
     *
     * @return SpamManager
     */
    public function getSpamRules($spamDto)
    {
        /** @var QueryBuilder $builder */
        $builder = $this->repository->createQueryBuilder('spam');

        $builder->where("spam.active = 'a'");

        if ($spamDto->getFilterType()) {
            $builder->leftJoin('spam.type', 'filterType')
                ->andWhere('filterType.type = :filter')
                ->setParameter('filter', $spamDto->getFilterType());
        }

        if ($spamDto->getConformity()) {
            $builder->leftJoin('spam.conformity', 'conformityType')
                ->andWhere('conformityType.type = :conformity')
                ->setParameter('conformity', $spamDto->getConformity());
        }

        $this->setData($builder->getQuery()->getResult());

        return $this;
    }

    /**
     * @param SpamDto $spamDto
     *
     * @return $this
     */
    public function getSpamRuleType($spamDto)
    {
        /** @var QueryBuilder $builder */
        $builder = $this->entityManager->getRepository(Filter::class)->createQueryBuilder('filterType');

        $builder->where("filterType.active = 'a'");

        if ($spamDto->getFilterType()) {
            $builder
                ->andWhere('filterType.type = :filterType')
                ->setParameter('filterType', $spamDto->getFilterType());
        }

        $this->setData($builder->getQuery()->getResult());

        return $this;
    }

    /**
     * @param SpamDto $spamDto
     *
     * @return $this
     */
    public function getSpamRuleConformity($spamDto)
    {
        /** @var QueryBuilder $builder */
        $builder = $this->entityManager->getRepository(Conformity::class)->createQueryBuilder('conformity');

        $builder->where("conformity.active = 'a'");

        if ($spamDto->getFilterType()) {
            $builder
                ->andWhere('conformity.type = :conformity')
                ->setParameter('conformity', $spamDto->getConformity());
        }

        $this->setData($builder->getQuery()->getResult());

        return $this;
    }

    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}