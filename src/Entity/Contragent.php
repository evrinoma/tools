<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;

/**
 * Contragent
 *
 * @ORM\Table(name="contragent", indexes={@ORM\Index(name="IDX_4FBF094FB03A8386", columns={"created_by_id"}), @ORM\Index(name="IDX_4FBF094F896DBBDE", columns={"updated_by_id"})})
 * @ORM\Entity
 */
class Contragent
{
    use ActiveTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=255, nullable=false)
     */
    private $shortName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inn", type="string", length=255, nullable=true)
     */
    private $inn;

    /**
     * @var int|null
     *
     * @ORM\Column(name="created_by_id", type="integer", nullable=true)
     */
    private $createdById;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updated_by_id", type="integer", nullable=true)
     */
    private $updatedById;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @return string|null
     */
    public function getInn(): ?string
    {
        return $this->inn;
    }

    /**
     * @return int|null
     */
    public function getCreatedById(): ?int
    {
        return $this->createdById;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return int|null
     */
    public function getUpdatedById(): ?int
    {
        return $this->updatedById;
    }
}
