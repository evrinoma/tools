<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbSpamFishing
 *
 * @ORM\Table(name="tb_spam_fishing", uniqueConstraints={@ORM\UniqueConstraint(name="sender_host_name", columns={"sender_host_name", "sender_helo_name", "sender_ident", "local_part"})}, indexes={@ORM\Index(name="tb_spam_rules", columns={"tb_spam_rules"})})
 * @ORM\Entity
 */
class TbSpamFishing
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
     * @var string|null
     *
     * @ORM\Column(name="sender_host_name", type="string", length=255, nullable=true)
     */
    private $senderHostName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sender_helo_name", type="string", length=255, nullable=true)
     */
    private $senderHeloName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sender_ident", type="string", length=255, nullable=true)
     */
    private $senderIdent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="local_part", type="string", length=255, nullable=true)
     */
    private $localPart;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sender_address_local_part", type="string", length=255, nullable=true)
     */
    private $senderAddressLocalPart;

    /**
     * @var \TbSpamRules
     *
     * @ORM\ManyToOne(targetEntity="TbSpamRules")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tb_spam_rules", referencedColumnName="id")
     * })
     */
    private $tbSpamRules;


}
