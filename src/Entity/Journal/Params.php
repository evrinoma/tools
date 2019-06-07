<?php

namespace App\Entity\Journal;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Params
 *
 * @ORM\Table(
 *     name="PARAMS",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="ID", columns={"ID"})},
 *     indexes={@ORM\Index(name="GROUPID", columns={"GROUPID"})}
 *     )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Params
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
     * @ORM\Column(name="NAME", type="string", length=508, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="SHORTNAME", type="string", length=508, nullable=false)
     */
    private $shortName;

    /**
     * @var Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumn(name="GROUPID", referencedColumnName="ID")
     */
    private $group;


    /**
     * @var ArrayCollection
     */
    private $paramData;
//endregion Fields

//region SECTION: Constructor
    /**
     * @ORM\PostLoad()
     */
    public function setInitialFoo()
    {
        $this->paramData = new ArrayCollection();
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @return ArrayCollection
     */
    public function addParamData($paramData)
    {
        return $this->paramData->add($paramData);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return ArrayCollection
     */
    public function getParamData()
    {
        return $this->paramData;
    }

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
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return Groups
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $name
     *
     * @return Params
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $shortName
     *
     * @return Params
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @param Groups $group
     *
     * @return Params
     */
    public function setGroup(Groups $group)
    {
        $this->group = $group;

        return $this;
    }
//endregion Getters/Setters
}
