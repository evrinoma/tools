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
//region SECTION: Fields
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
     */
    private $te;

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

//region SECTION: Private
    private function toTime($time)
    {
        $mktime = mktime(null, null, $time / 1000);

        return date("H:i:s", $mktime);
    }
//endregion Private

//region SECTION: Getters/Setters
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
        return $this->toTime($this->getT());
    }

    /**
     * @JMS\VirtualProperty()
     */
    public function getTimeEnd()
    {
        return $this->toTime($this->getTe());
    }

    /**
     * @return int
     */
    public function getTe()
    {
        return $this->te;
    }

    /**
     * @param int $te
     *
     * @return DiscreetInfo
     */
    public function setTe(int $te): self
    {
        $this->te = $te;

        return $this;
    }
//endregion Getters/Setters
}
