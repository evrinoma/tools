<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbEmails
 *
 * ORM\Table(name="tb_emails")
 * ORM\Entity
 */
class TbEmails
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var TbDomains
     *
     * @ORM\ManyToOne(targetEntity="TbDomains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     * })
     */
    private $domain;


}
