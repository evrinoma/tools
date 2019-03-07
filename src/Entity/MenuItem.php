<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 10:53 AM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MenuItem
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="menu_items")
 */
class MenuItem
{
//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var MenuItem
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuItem", inversedBy="children")
     */
    protected $parent = null;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\MenuItem", mappedBy="parent")
     */
    protected $children = null;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    protected $name = '';

    /**
     * @var string
     * @ORM\Column(name="route", type="string", nullable=true)
     */
    protected $route = null;

    /**
     * @var string
     * @ORM\Column(name="uri", type="string", nullable=true)
     */
    protected $uri = null;

    /**
     * @var array
     * @ORM\Column(name="attributes", type="array", nullable=true)
     */
    protected $attributes = null;

    /**
     * @var string
     * @ORM\Column(name="role", type="string", nullable=true)
     */
    protected $role = null;
//endregion Fields

//region SECTION: Constructor
    /**
     * MenuItem constructor.
     *
     * @param $id
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }
//endregion Constructor

//region SECTION: Public

    /**
     * @param MenuItem $child
     *
     * @return MenuItem
     */
    public function addChild(MenuItem $child): self
    {
        $child->setParent($this);

        if (!$this->children->contains($child)) {
            $this->children[] = $child;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return ($this->children->count() != 0);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MenuItem
     */
    public function getParent(): MenuItem
    {
        return $this->parent;
    }

    /**
     * @return MenuItem[]
     */
    public function getChildren(): ?array
    {
        return $this->children->getValues();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getRoute(): ?array
    {
        return $this->route ? ['route' => $this->route] : null;
    }

    /**
     * @return array|null
     */
    public function getUri(): ?array
    {
        return $this->uri ? ['uri' => $this->uri] : null;
    }

    /**
     * @return array|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes ? ['attributes' => $this->attributes] : null;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    public function getOptions()
    {
        return (array)$this->getUri() + (array)$this->getRoute() + (array)$this->getAttributes();
    }

    /**
     * @param $id
     *
     * @return MenuItem
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param MenuItem $parent
     *
     * @return MenuItem
     */
    public function setParent(MenuItem $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return MenuItem
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return MenuItem
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return MenuItem
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return MenuItem
     */
    public function setAttributes($attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param string $role
     *
     * @return MenuItem
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
//endregion Getters/Setters
}