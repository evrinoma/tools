<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/27/19
 * Time: 6:37 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Mail\FilterType;
use App\Entity\Mail\Migrations\TbSpamRules;
use App\Entity\Mail\Spam;
use App\Rest\Core\RestTrait;

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
            ->getRepositoryAll(FilterType::class)->removeEntitys()
            ->getRepositoryAll(Spam::class)->removeEntitys();

        $rTbSpamRules = $this->entityManager->getRepository(TbSpamRules::class);

        $types = [];

        /** @var TbSpamRules $value */
        foreach ($rTbSpamRules->findAll() as $value) {
            $spamRule = new Spam();
            $spamRule
                ->setDomain($value->getDomain())
                ->setConformity($value->getConformity())
                ->setHit($value->getHit())
                ->setUpdateAt($value->getUpdateAt());


            $pos = strripos($value->getType(), '_disable');
            if ($pos === false) {
                if (!array_key_exists($value->getType(), $types)) {
                    $type = new FilterType();
                    $type->setType($value->getType());
                    $types[$value->getType()] = $type;
                    $this->entityManager->persist($type);
                } else {
                    $type = $types[$value->getType()];
                }
            } else {
                $valueType = substr($value->getType(), 0, $pos);
                if (!array_key_exists($valueType, $types)) {
                    $type = new FilterType();
                    $type->setType($valueType);
                    $types[$valueType] = $type;
                    $this->entityManager->persist($type);
                } else {
                    $type = $types[$valueType];
                }

                $spamRule->setActiveToDelete();
            }


            $spamRule->setType($type);

            $this->entityManager->persist($spamRule);
        }

        $this->entityManager->flush();

        return [];
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}