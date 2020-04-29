<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use JMS\Serializer\Annotation\Type;

/**
 * Project
 *
 * @ORM\Table(name="project", indexes={@ORM\Index(name="IDX_2FB3D0EE979B1AD6", columns={"company_id"}), @ORM\Index(name="IDX_2FB3D0EE896DBBDE", columns={"updated_by_id"}), @ORM\Index(name="IDX_2FB3D0EEB03A8386", columns={"created_by_id"})})
 * @ORM\Entity
 */
class Project
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
     * @var Contragent
     * @Type("App\Entity\Contragent")
     * @ORM\ManyToOne(targetEntity="Contragent")
     */
    private $contragent;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @Type("DateTime<'d-m-Y'>")
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="date", nullable=false)
     */
    private $dateStart;

    /**
     * @Type("DateTime<'d-m-Y'>")
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_finish", type="date", nullable=true)
     */
    private $dateFinish;

    /**
     * @Type("DateTime<'d-m-Y'>")
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @Type("DateTime<'d-m-Y'>")
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="created_by_id", type="integer", nullable=true)
     */
    private $createdById;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updated_by_id", type="integer", nullable=true)
     */
    private $updatedById;
//endregion Fields

//region SECTION: Getters/Setters
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFinish(): ?\DateTime
    {
        return $this->dateFinish;
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
    public function getCreatedById(): ?int
    {
        return $this->createdById;
    }

    /**
     * @return int|null
     */
    public function getUpdatedById(): ?int
    {
        return $this->updatedById;
    }

    /**
     * @return Contragent
     */
    public function getContragent(): Contragent
    {
        return $this->contragent;
    }


//endregion Getters/Setters

}
