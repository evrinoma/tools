<?php

namespace App\Entity\Mail\Migrations;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbDomains
 *
 * @ORM\Table(name="tb_domains", uniqueConstraints={@ORM\UniqueConstraint(name="domain", columns={"domain"}), @ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class TbDomains
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=false)
     */
    private $ownerId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="spamscan", type="boolean", nullable=false)
     */
    private $spamscan;

    /**
     * @var bool
     *
     * @ORM\Column(name="virusscan", type="boolean", nullable=false)
     */
    private $virusscan;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject;

    /**
     * @var float
     *
     * @ORM\Column(name="tag", type="float", precision=10, scale=0, nullable=false)
     */
    private $tag;

    /**
     * @var float
     *
     * @ORM\Column(name="quarantine", type="float", precision=10, scale=0, nullable=false)
     */
    private $quarantine;

    /**
     * @var float
     *
     * @ORM\Column(name="block", type="float", precision=10, scale=0, nullable=false)
     */
    private $block;

    /**
     * @var float
     *
     * @ORM\Column(name="delta", type="float", precision=10, scale=0, nullable=false)
     */
    private $delta;

    /**
     * @var bool
     *
     * @ORM\Column(name="reject", type="boolean", nullable=false)
     */
    private $reject;

    /**
     * @var string
     *
     * @ORM\Column(name="forward", type="string", length=255, nullable=false)
     */
    private $forward;

    /**
     * @var bool
     *
     * @ORM\Column(name="fwd_verbose", type="boolean", nullable=false)
     */
    private $fwdVerbose;

    /**
     * @var bool
     *
     * @ORM\Column(name="hdr_report", type="boolean", nullable=false)
     */
    private $hdrReport;

    /**
     * @var string
     *
     * @ORM\Column(name="reley_adr", type="string", length=255, nullable=false)
     */
    private $releyAdr;

    /**
     * @var int
     *
     * @ORM\Column(name="geoip", type="integer", nullable=false)
     */
    private $geoip = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="mx", type="string", length=255, nullable=true)
     */
    private $mx;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return bool
     */
    public function isSpamscan(): bool
    {
        return $this->spamscan;
    }

    /**
     * @return bool
     */
    public function isVirusscan(): bool
    {
        return $this->virusscan;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return float
     */
    public function getTag(): float
    {
        return $this->tag;
    }

    /**
     * @return float
     */
    public function getQuarantine(): float
    {
        return $this->quarantine;
    }

    /**
     * @return float
     */
    public function getBlock(): float
    {
        return $this->block;
    }

    /**
     * @return float
     */
    public function getDelta(): float
    {
        return $this->delta;
    }

    /**
     * @return bool
     */
    public function isReject(): bool
    {
        return $this->reject;
    }

    /**
     * @return string
     */
    public function getForward(): string
    {
        return $this->forward;
    }

    /**
     * @return bool
     */
    public function isFwdVerbose(): bool
    {
        return $this->fwdVerbose;
    }

    /**
     * @return bool
     */
    public function isHdrReport(): bool
    {
        return $this->hdrReport;
    }

    /**
     * @return string
     */
    public function getReleyAdr(): string
    {
        return $this->releyAdr;
    }

    /**
     * @return int
     */
    public function getGeoip(): int
    {
        return $this->geoip;
    }

    /**
     * @return string|null
     */
    public function getMx(): ?string
    {
        return $this->mx;
    }


}
