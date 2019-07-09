<?php

namespace App\Entity\Delta;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scales
 *
 * @ORM\Table(name="SCALES")
 * @ORM\Entity
 */
class Scales
{
//region SECTION: Fields
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="TYPE", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="UNIT", type="string", length=50, nullable=false)
     */
    private $unit;

    /**
     * @var float
     *
     * @ORM\Column(name="MINVALUE", type="float", precision=53, scale=0, nullable=false)
     */
    private $min;

    /**
     * @var float
     *
     * @ORM\Column(name="MAXVALUE", type="float", precision=53, scale=0, nullable=false)
     */
    private $max;

    /**
     * @var int
     *
     * @ORM\Column(name="PRECISION", type="integer", nullable=false, options={"default"="-1"})
     */
    private $precision = '-1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FORMAT", type="string", length=254, nullable=true)
     */
    private $format;

    /**
     * @var float|null
     *
     * @ORM\Column(name="AGCOEFF", type="float", precision=53, scale=0, nullable=true)
     */
    private $agcoeff;

    /**
     * @var string|null
     *
     * @ORM\Column(name="AGUNITS", type="string", length=50, nullable=true)
     */
    private $agunits;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @return float
     */
    public function getMin(): float
    {
        return $this->min;
    }

    /**
     * @return float
     */
    public function getMax(): float
    {
        return $this->max;
    }

    /**
     * @return int
     */
    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @return float|null
     */
    public function getAgcoeff(): ?float
    {
        return $this->agcoeff;
    }

    /**
     * @return string|null
     */
    public function getAgunits(): ?string
    {
        return $this->agunits;
    }

    /**
     * @param int $type
     *
     * @return Scales
     */
    public function setType(int $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $unit
     *
     * @return Scales
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @param float $min
     *
     * @return Scales
     */
    public function setMin(float $min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @param float $max
     *
     * @return Scales
     */
    public function setMax(float $max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @param int $precision
     *
     * @return Scales
     */
    public function setPrecision(int $precision)
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * @param string|null $name
     *
     * @return Scales
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string|null $format
     *
     * @return Scales
     */
    public function setFormat(?string $format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param float|null $agcoeff
     *
     * @return Scales
     */
    public function setAgcoeff(?float $agcoeff)
    {
        $this->agcoeff = $agcoeff;

        return $this;
    }

    /**
     * @param string|null $agunits
     *
     * @return Scales
     */
    public function setAgunits(?string $agunits)
    {
        $this->agunits = $agunits;

        return $this;
    }
//endregion Getters/Setters
}
