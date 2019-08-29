<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/11/19
 * Time: 11:19 PM
 */

namespace App\Entity\Mail;

use App\Entity\Model\ActiveTrait;
use App\Entity\Model\ClassEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table(name="mail_server")
 * @ORM\Entity
 */
class Server
{
    use ClassEntityTrait;
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
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255, nullable=false)
     */
    private $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hostname", type="string", length=255, nullable=true)
     */
    private $hostname;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string|null
     */
    public function getHostname(): ?string
    {
        return $this->hostname;
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
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return Server
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @param string|null $hostname
     *
     * @return Server
     */
    public function setHostname(?string $hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

//endregion Getters/Setters


}