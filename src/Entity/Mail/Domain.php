<?php

namespace App\Entity\Mail;

use App\Entity\Model\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table(name="mail_domain")
 * @ORM\Entity(repositoryClass="App\Repository\DomainRepository")
 */
class Domain
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
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain = '';
    /**
     * @var Server
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Mail\Server", inversedBy="id")
     */
    private $server;
//endregion Fields

//region SECTION: Public
    /**
     * @param $server
     *
     * @return $this
     */
    public function addServer($server)
    {
        if ($server) {
            $this->server = $server;
        }

        return $this;
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
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getRelayAdr(): string
    {
        return $this->server->getIp();
    }

    /**
     * @return string|null
     */
    public function getMx(): ?string
    {
        return $this->server->getHostname();
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
