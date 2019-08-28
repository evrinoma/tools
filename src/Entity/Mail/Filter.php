<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/27/19
 * Time: 6:09 PM
 */

namespace App\Entity\Mail;

use App\Entity\Model\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Spam
 *
 * @package App\Entity\Mail
 * @ORM\Table(name="mail_filter")
 * @ORM\Entity()
 */
class Filter
{
    use ActiveTrait;

//region SECTION: Fields
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
     * @var string
     *
     * @ORM\Column(name="pattern", type="string")
     */
    private $pattern;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isPatternBurn(): bool
    {
        return $this->pattern === 'burn';
    }

    /**
     * @return bool
     */
    public function isPatternIP(): bool
    {
        return $this->pattern === 'ip';
    }

    /**
     * @return bool
     */
    public function isPattern(): bool
    {
        return $this->pattern === '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param bool $pattern
     *
     * @return Filter
     */
    public function setPattern(bool $pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return Filter
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters


}