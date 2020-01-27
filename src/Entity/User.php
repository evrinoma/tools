<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/8/18
 * Time: 2:02 PM
 */

namespace App\Entity;

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
     * @var string
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
     * @return string
     */
    public function getContact(): string
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     *
     * @return User
     */
    public function setContact(string $contact)
    {
        $this->contact = $contact;

        return $this;
    }

//endregion Getters/Setters
}