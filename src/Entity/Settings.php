<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:30 AM
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;

/**
 * Class Settings
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="settings")
 */
class Settings
{
    use ActiveTrait;

//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var DescriptionService
     *
     * @ORM\ManyToOne(targetEntity="DescriptionService")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="description_id", referencedColumnName="id")
     * })
     */
    protected $serviceType;

    /**
     * @var string
     * @ORM\Column(name="host", type="string", nullable=true)
     */
    protected $host;

    /**
     * @var string
     * @ORM\Column(name="port", type="string", nullable=true)
     */
    protected $port;

    /**
     * @ORM\Column(name="remote", type="boolean", options={"default":"0"})
     */
    protected $isRemote = false;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    protected $type;

    /**
     * @var object
     * @ORM\Column(name="data", type="object")
     */
    protected $data;
//endregion Fields

//region SECTION: Public
    /**
     * @return mixed
     */
    public function isRemote()
    {
        return $this->isRemote;
    }

//region SECTION: Getters/Setters
    /**
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DescriptionService
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param object $data
     *
     * @return Settings
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return Settings
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param $serviceType
     *
     * @return $this
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    /**
     * @param string $host
     *
     * @return Settings
     */
    public function setHost(string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param string $port
     *
     * @return Settings
     */
    public function setPort(string $port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @param mixed $isRemote
     *
     * @return Settings
     */
    public function setRemote($isRemote = true)
    {
        $this->isRemote = $isRemote;

        return $this;
    }
//endregion Getters/Setters


//endregion Getters/Setters
}