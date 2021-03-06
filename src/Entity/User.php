<?php

namespace App\Entity;

use App\QrCode\Std\ContactStd;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="plain", type="string", nullable=true)
     */
    private $plain;

    /**
     * @var ContactStd
     *
     * @ORM\Column(name="contact", type="object")
     */
    private $contact;

//endregion Fields

//region SECTION: Constructor
    public function __construct()
    {
        parent::__construct();
    }
//endregion Constructor

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getPlain(): string
    {
        return $this->plain;
    }

    /**
     * @return ContactStd
     */
    public function getContact()
    {
        return $this->contact;
    }

    public function getVCard()
    {
        $vCard = '';

        if ($this->getContact()) {
            $vCard .= "BEGIN:VCARD\n";
            $vCard .= "VERSION:4.0\n";
            $vCard .= 'N:'.$this->getContact()->getFirstName().';'.$this->getContact()->getLastName()."\n";
            $vCard .= 'ORG:'.$this->getContact()->getComapanyName()."\n";
            $vCard .= 'TITLE:'.$this->getContact()->getPosition()."\n";
            $vCard .= 'TEL;WORK,VOICE:'.$this->getContact()->getTelWork().($this->getContact()->getTelWorkDop() ? 'p*'.$this->getContact()->getTelWorkDop() : '')."\n";
            $vCard .= 'TEL;MOBILE,VOICE:'.$this->getContact()->getTelMobile()."\n";
            $vCard .= 'EMAIL:'.$this->getContact()->getEmail()."\n";
            $vCard .= "URL:".$this->getContact()->getEmail()."\n";
            $vCard .= 'END:VCARD';
        }

        return $vCard;
    }

    /**
     * @param string $plain
     *
     * @return User
     */
    public function setPlain(string $plain)
    {
        $this->plain = $plain;

        return $this;
    }

    /**
     * @param ContactStd $contact
     *
     * @return User
     */
    public function setContact(ContactStd $contact)
    {
        $this->contact = $contact;

        return $this;
    }
//endregion Getters/Setters
}