<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbSpamRules
 *
 * @ORM\Table(name="tb_spam_rules", indexes={@ORM\Index(name="conformity", columns={"conformity"}), @ORM\Index(name="domain", columns={"domain"}), @ORM\Index(name="type", columns={"type"})})
 * @ORM\Entity
 */
class TbSpamRules
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


}
