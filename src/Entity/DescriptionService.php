<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/10/19
 * Time: 10:07 AM
 */

namespace App\Entity;

use App\Entity\Model\RelationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DescriptionSettings
 *
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="description_settings")
 */
class DescriptionService
{
    use RelationTrait;

//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(name="instance", type="string", nullable=true)
     */
    protected $instance;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="date", nullable=true)
     */
    protected $date;

    /**
     * @var DescriptionService
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DescriptionService", inversedBy="children")
     */
    protected $parent = null;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\DescriptionService", mappedBy="parent")
     */
    protected $children = null;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getInstance(): string
    {
        return $this->instance;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $name
     *
     * @return DescriptionService
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return DescriptionService
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return DescriptionService
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $instance
     *
     * @return DescriptionService
     */
    public function setInstance(string $instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * @return DescriptionService|null
     */
    public function getChildFirst()
    {
        return $this->getChildren() ? $this->getChildren()->first() : null;
    }

    /**
     * @param \DateTime $date
     *
     * @return string
     */
    public function leDate(\DateTime $date)
    {
        return $this->date ? $this->date <= $date : false;
    }

    /**
     * @param \DateTime $date
     *
     * @return DescriptionService
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
//endregion Getters/Setters
}