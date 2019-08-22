<?php

namespace App\Entity\Mail;

use App\Entity\Model\AclModel;
use App\Entity\Model\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Acl
 *
 * @ORM\Table(name="mail_acl")
 * @ORM\Entity
 */
class Acl
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
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type = AclModel::WHITE;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Mail\Domain", inversedBy="id")
     */
    private $domain;
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
     * @return bool
     */
    public function isWhite()
    {
        return $this->type === AclModel::WHITE;
    }

    /**
     * @return bool
     */
    public function isBlack()
    {
        return $this->type === AclModel::BLACK;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return $this->domain;
    }

    /**
     * @param string $type
     *
     * @return Acl
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return Acl
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param Domain $domain
     *
     * @return Acl
     */
    public function setDomain(Domain $domain)
    {
        $this->domain = $domain;

        return $this;
    }
//endregion Getters/Setters

}
