<?php

namespace App\Entity\Customer;

use App\Entity\Journal\Params;
use Doctrine\ORM\Mapping as ORM;

/**
 * D07062019
 *
 * ORM\Table(name="D07062019", indexes={@ORM\Index(name="IDX_40749E8F4366831A", columns={"N"})})
 *
 * @ORM\Entity
 */
class ParamData
{
//region SECTION: Fields
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
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="N", type="integer", nullable=false)
     */
    private $n;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * @return int
     */
    public function getV()
    {
        return $this->v;
    }

    /**
     * @return int
     */
    public function getS()
    {
        return $this->s;
    }

    /**
     * @return int
     */
    public function getXs()
    {
        return $this->xs;
    }

    /**
     * @return int
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * @param int $t
     *
     * @return ParamData
     */
    public function setT(int $t)
    {
        $this->t = $t;

        return $this;
    }

    /**
     * @param int $v
     *
     * @return ParamData
     */
    public function setV(int $v)
    {
        $this->v = $v;

        return $this;
    }

    /**
     * @param int $s
     *
     * @return ParamData
     */
    public function setS(int $s)
    {
        $this->s = $s;

        return $this;
    }

    /**
     * @param int $xs
     *
     * @return ParamData
     */
    public function setXs(int $xs)
    {
        $this->xs = $xs;

        return $this;
    }

    /**
     * @param int $n
     *
     * @return ParamData
     */
    public function setN(int $n)
    {
        $this->n = $n;

        return $this;
    }


//endregion Getters/Setters
}
