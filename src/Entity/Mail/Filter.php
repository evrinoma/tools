<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/27/19
 * Time: 6:09 PM
 */

namespace App\Entity\Mail;

use App\Entity\Model\ActiveTrait;
use App\Entity\Model\ClassEntityTrait;
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
    use ClassEntityTrait;
    use ActiveTrait;

    public const FILTER_BURN = 'burn';
    public const FILTER_IP = 'ip';
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
    private $pattern = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isPatternBurn(): bool
    {
        return $this->pattern === self::FILTER_BURN;
    }

    /**
     * @return bool
     */
    public function isPatternIP(): bool
    {
        return $this->pattern === self::FILTER_IP;
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
     * @param string $pattern
     *
     * @return Filter
     */
    public function setPattern($pattern)
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