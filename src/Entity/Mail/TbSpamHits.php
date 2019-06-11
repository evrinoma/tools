<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbSpamHits
 *
 * ORM\Table(name="tb_spam_hits")
 * ORM\Entity
 */
class TbSpamHits
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="time", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $time = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="destination", type="text", length=65535, nullable=true)
     */
    private $destination;

    /**
     * @var \TbSpamRules
     *
     * ORM\ManyToOne(targetEntity="TbSpamRules")
     * ORM\JoinColumns({
     *   ORM\JoinColumn(name="tb_spam_rules", referencedColumnName="id")
     * })
     */
    private $tbSpamRules;


}
