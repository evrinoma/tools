<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 9:14 AM
 */

namespace App\Dto;


use App\Annotation\Dto;
use App\Entity\Mail\Filter;
use App\Entity\Mail\Spam;
use App\Entity\Model\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SpamDto
 *
 * @package App\Dto
 */
class SpamDto extends AbstractFactoryDto
{
    use ActiveTrait;
//region SECTION: Fields
    private $id;
    /**
     * @Dto(class="App\Dto\ConformityDto")
     * @var ConformityDto
     */
    private $conformity;
    /**
     * @var string
     */
    private $domainName;
    /**
     * @var string
     */
    private $range;
    /**
     * @Dto(class="App\Dto\RuleTypeDto")
     * @var RuleTypeDto
     */
    private $ruleType;
    /**
     * @var string
     */
    private $spamRecord;

    /**
     * @var bool
     */
    private $isConformity = true;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isConformity(): bool
    {
        return $this->isConformity;
    }

    /**
     * @param Spam $entity
     *
     * @return mixed
     * @throws \Exception
     */
    public function fillEntity($entity)
    {
        $entity
            ->setConformity($this->getConformity()->generatorEntity()->current())
            ->setType($this->getRuleType()->generatorEntity()->current())
            ->setDomain($this->getSpamRecord())
            //->setUpdateAt(date('Y-m-d G:i:s'))
            ->setUpdateAt(new \DateTime('now'))
            ->setActive($this->getActive());

        return $entity;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $valid = false;
        if (!$this->domainName) {
            if ($this->getRuleType()->hasSingleEntity()) {
                /** @var Filter $entity */
                $entity = $this->getRuleType()->generatorEntity()->current();
                if ($entity->isPatternBurn()) {
                    $valid = $this->isBurn();
                }
                if ($entity->isPatternIP()) {
                    $valid = $this->isRange();
                    if ($valid) {
                        $this->setSpamRecord($this->range);
                        $this->isConformity = false;
                    }
                }
                if ($entity->isPattern()) {
                    $valid = $this->isHostName();
                }
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @return bool
     */
    public function isBurn()
    {
        return $this->spamRecord && $this->spamRecord !== '';
    }

    /**
     * @return bool
     */
    public function isHostName()
    {
        return $this->spamRecord && (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->spamRecord) === 1);
    }
//endregion Public

//region SECTION: Private
    private function isRange()
    {
        if (strpos($this->spamRecord, '/') === false) {
            $range = '/32';
        } else {
            list($this->spamRecord, $range) = explode('/', $this->spamRecord, 2);
        }
        if (filter_var($this->spamRecord, FILTER_VALIDATE_IP)) {
            switch ($range) {
                case 24:
                    $limit       = 4;
                    $this->range = $this->formatIp(explode('.', $this->spamRecord, $limit), $limit);
                    break;
                case 16:
                    $limit       = 3;
                    $this->range = $this->formatIp(explode('.', $this->spamRecord, $limit), $limit);
                    break;
                case 8:
                    $limit       = 2;
                    $this->range = $this->formatIp(explode('.', $this->spamRecord, $limit), $limit);
                    break;
            }

            return true;
        }

        return false;
    }

    /**
     * @param $range
     * @param $count
     *
     * @return string
     */
    private function formatIp($range, $count)
    {
        $ip = '';
        for ($i = 0; $i < ($count - 1); $i++) {
            $ip .= $range[$i].'.';

        }

        return $ip;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto(&$request)
    {

        $spamId     = $request->get('spamId');
        $active     = $request->get('active');
        $deleted    = $request->get('deleted');
        $domainName = $request->get('domain');
        $spamRecord = $request->get('spamRecord');


        $dto = new self();

        if ($spamId) {
            $dto->setId($spamId);
        }

        if ($active && $deleted) {
            $dto->setActiveToDelete();
        }

        if ($spamRecord) {
            $dto->setSpamRecord($spamRecord);
        }

        if ($domainName) {
            $dto->setDomainName($domainName);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getSpamRecord()
    {
        return $this->spamRecord;
    }

    /**
     * @return string
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ConformityDto
     */
    public function getConformity()
    {
        return $this->conformity;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request)
    {
        return $request;
    }

    /**
     * @return RuleTypeDto
     */
    public function getRuleType()
    {
        return $this->ruleType;
    }

    /**
     * @param string $spamRecord
     *
     * @return SpamDto
     */
    public function setSpamRecord(string $spamRecord)
    {
        $this->spamRecord = $spamRecord;

        return $this;
    }

    /**
     * @param string $domainName
     *
     * @return SpamDto
     */
    public function setDomainName(string $domainName)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return SpamDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param ConformityDto $conformity
     *
     * @return SpamDto
     */
    public function setConformity($conformity)
    {
        $this->conformity = $conformity;

        return $this;
    }

    /**
     * @param RuleTypeDto $ruleType
     *
     * @return SpamDto
     */
    public function setRuleType($ruleType)
    {
        $this->ruleType = $ruleType;

        return $this;
    }

//endregion Getters/Setters
}