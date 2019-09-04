<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 10:21 AM
 */

namespace App\Entity\LiveVideo;


use App\Entity\Model\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * Class Cam
 *
 * @package App\Entity\LiveVideo
 * @ORM\Entity
 * @ORM\Table(name="live_cam")
 */
class Cam
{
    use ActiveTrait;

//region SECTION: Fields
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"restrict", "full"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50, nullable=false)
     * @Groups({"full"})
     */
    private $ip = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=50, nullable=false)
     * @Groups({"full"})
     */
    private $userName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     * @Groups({"full"})
     */
    private $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=50, nullable=false)
     * @Groups({"full"})
     */
    private $link = '';

    /**
     * @var string
     *
     * @ORM\Column(name="stream", type="string", length=50, nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $stream = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $title = '';

    /**
     * @var Type
     * @ORM\ManyToOne(targetEntity="App\Entity\LiveVideo\Type", inversedBy="id")
     * @Groups({"full"})
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $control = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $startPlay = false;
    /**
     * @Exclude()
     * @var Group
     * @ORM\ManyToOne(targetEntity="App\Entity\LiveVideo\Group", inversedBy="id")
     */
    private $group;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isStartPlay(): bool
    {
        return $this->startPlay;
    }

    /**
     * @return bool
     */
    public function isControl(): bool
    {
        return $this->control;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param bool $startPlay
     *
     * @return Cam
     */
    public function setStartPlay($startPlay)
    {
        $this->startPlay = $startPlay;

        return $this;
    }

    /**
     * @param Group $group
     *
     * @return Cam
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Cam
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $ip
     *
     * @return Cam
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @param string $userName
     *
     * @return Cam
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return Cam
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $link
     *
     * @return Cam
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param string $stream
     *
     * @return Cam
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return Cam
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param Type $type
     *
     * @return Cam
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param bool $control
     *
     * @return Cam
     */
    public function setControl($control)
    {
        $this->control = $control;

        return $this;
    }
//endregion Getters/Setters
}