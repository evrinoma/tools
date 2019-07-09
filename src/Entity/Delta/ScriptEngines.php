<?php

namespace App\Entity\Delta;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScriptEngines
 *
 * @ORM\Table(name="SCRIPT_ENGINES")
 * @ORM\Entity
 */
class ScriptEngines
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
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="PROGID", type="string", length=254, nullable=false)
     */
    private $prog;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SOURCE_CODE", type="text", length=16, nullable=true)
     */
    private $sourceCode;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProg(): string
    {
        return $this->prog;
    }

    /**
     * @return string|null
     */
    public function getSourceCode(): ?string
    {
        return $this->sourceCode;
    }

    /**
     * @param  string $name
     *
     * @return ScriptEngines
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $prog
     *
     * @return ScriptEngines
     */
    public function setProg(string $prog)
    {
        $this->prog = $prog;

        return $this;
    }

    /**
     * @param string|null $sourceCode
     *
     * @return ScriptEngines
     */
    public function setSourceCode(?string $sourceCode)
    {
        $this->sourceCode = $sourceCode;

        return $this;
    }
//endregion Getters/Setters


}
