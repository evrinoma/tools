<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relaytofrom
 *
 * @ORM\Table(name="relaytofrom")
 * @ORM\Entity
 */
class Relaytofrom
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="relay_ip", type="string", length=16, nullable=true, options={"fixed"=true})
     */
    private $relayIp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail_from", type="string", length=255, nullable=true)
     */
    private $mailFrom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rcpt_to", type="string", length=255, nullable=true)
     */
    private $rcptTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="block_expires", type="datetime", nullable=false)
     */
    private $blockExpires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="record_expires", type="datetime", nullable=false)
     */
    private $recordExpires;

    /**
     * @var int
     *
     * @ORM\Column(name="blocked_count", type="bigint", nullable=false)
     */
    private $blockedCount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="passed_count", type="bigint", nullable=false)
     */
    private $passedCount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="aborted_count", type="bigint", nullable=false)
     */
    private $abortedCount = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="origin_type", type="string", length=255, nullable=false)
     */
    private $originType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time", type="datetime", nullable=false)
     */
    private $createTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdate = 'CURRENT_TIMESTAMP';


}
