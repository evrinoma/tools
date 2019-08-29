<?php

namespace App\Entity\Mail;

use App\Entity\Model\ActiveTrait;
use App\Entity\Model\ClassEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Domains
 *
 * @ORM\Table(name="mail_domain")
 * @ORM\Entity(repositoryClass="App\Repository\DomainRepository")
 */
class Domain
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
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain = '';
    /**
     * @var Server
     * @Type("App\Entity\Mail\Server")
     * @ORM\ManyToOne(targetEntity="App\Entity\Mail\Server", inversedBy="id", cascade={"all"})
     */
    private $server;
//endregion Fields

//region SECTION: Public
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @VirtualProperty
     * @SerializedName("domainId")
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

//    /**
//     * @return int
//     */
//    public function getDomainId(): int
//    {
//        return $this->getId();
//    }

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getIpServer(): string
    {
        return $this->server->getIp();
    }

    /**
     * @return string|null
     */
    public function getHostNameServer(): ?string
    {
        return $this->server->getHostname();
    }

    /**
     * @param $server
     *
     * @return $this
     */
    public function setServer($server)
    {
        if ($server) {
            $this->server = $server;
        }

        return $this;
    }

    /**
     * @param string $domain
     *
     * @return Domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param string $relayAdr
     *
     * @return Domain
     */
    public function setRelayAdr(string $relayAdr)
    {
        $this->server->setIp($relayAdr);

        return $this;
    }

    /**
     * @param string|null $mx
     *
     * @return Domain
     */
    public function setMx(?string $mx)
    {
        $this->server->setHostname($mx);

        return $this;
    }
//endregion Getters/Setters
}
