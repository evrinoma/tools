<?php

namespace App\Entity\Delta;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * DiscreetInfo
 *
 * @ORM\Entity
 */
class DiscreetInfo
{
    /**
     * @var int
     *
     * @ORM\Column(name="N", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $n;

    /**
     * @var int
     *
     * @ORM\Column(name="T", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $t;

    /**
     * @var int
     *
     * @ORM\Column(name="V", type="integer", nullable=false)
     */
    private $v;

    /**
     * @var int
     *
     * @ORM\Column(name="S", type="integer", nullable=false)
     */
    private $s;

    /**
     * @var int
     *
     * @ORM\Column(name="XS", type="integer", nullable=false)
     */
    private $xs;

    /**
     * @return int
     */
    public function getN(): int
    {
        return $this->n;
    }

    /**
     * @return int
     */
    public function getT(): int
    {
        return $this->t;
    }

    /**
     * @return int
     */
    public function getV(): int
    {
        return $this->v;
    }

    /**
     * @return int
     */
    public function getS(): int
    {
        return $this->s;
    }

    /**
     * @return int
     */
    public function getXs(): int
    {
        return $this->xs;
    }

    /**
     * @JMS\VirtualProperty()
     */
    public function getTime()
    {
        $time = mktime(null, null, $this->getT()/1000);

        return date("H:i:s", $time);
    }
}
