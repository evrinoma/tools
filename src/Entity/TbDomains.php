<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbDomains
 *
 * @ORM\Table(name="tb_domains", uniqueConstraints={@ORM\UniqueConstraint(name="domain", columns={"domain"})})
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


}
