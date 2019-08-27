<?php

namespace App\Entity\Mail\Migrations;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbSpamRules
 *
 * @ORM\Table(name="tb_spam_rules", indexes={@ORM\Index(name="type", columns={"type"}), @ORM\Index(name="domain", columns={"domain"}), @ORM\Index(name="conformity", columns={"conformity"})})
 * @ORM\Entity
 */
class TbSpamRules
{
//region SECTION: Fields
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="conformity", type="string", length=255, nullable=true)
     */
    private $conformity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain", type="string", length=512, nullable=true)
     */
    private $domain;

    /**
     * @var int
     *
     * @ORM\Column(name="hit", type="integer", nullable=false)
     */
    private $hit = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateAt = 'CURRENT_TIMESTAMP';
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getConformity(): ?string
    {
        return $this->conformity;
    }

    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getHit(): int
    {
        return $this->hit;

    }

    /**
     * @return \DateTime|null
     */
    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param string|null $type
     *
     * @return TbSpamRules
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|null $conformity
     *
     * @return TbSpamRules
     */
    public function setConformity(?string $conformity)
    {
        $this->conformity = $conformity;

        return $this;
    }

    /**
     * @param string|null $domain
     *
     * @return TbSpamRules
     */
    public function setDomain(?string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param int $hit
     *
     * @return TbSpamRules
     */
    public function setHit(int $hit)
    {
        $this->hit = $hit;

        return $this;
    }

    /**
     * @param \DateTime|null $updateAt
     *
     * @return TbSpamRules
     */
    public function setUpdateAt(?\DateTime $updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }
//endregion Getters/Setters


}
