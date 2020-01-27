<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 1/27/20
 * Time: 6:32 PM
 */

namespace App\Dto\ApartDto;


use App\Dto\AbstractDto;

/**
 * Class ContactDto
 *
 * @package App\Dto\ApartDto
 */
class ContactDto extends AbstractDto
{
//region SECTION: Fields
    private $firstName;
    private $lastName;
    private $position;
    private $comapanyName;
    private $telWork;
    private $telWorkDop;
    private $telMobile;
    private $email;
    private $url;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getTelWorkDop()
    {
        return $this->telWorkDop;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getComapanyName()
    {
        return $this->comapanyName;
    }

    /**
     * @return mixed
     */
    public function getTelWork()
    {
        return $this->telWork;
    }

    /**
     * @return mixed
     */
    public function getTelMobile()
    {
        return $this->telMobile;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $firstName
     *
     * @return ContactDto
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param mixed $lastName
     *
     * @return ContactDto
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param mixed $position
     *
     * @return ContactDto
     */
    public function setPosition($position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param mixed $comapanyName
     *
     * @return ContactDto
     */
    public function setComapanyName($comapanyName): self
    {
        $this->comapanyName = $comapanyName;

        return $this;
    }

    /**
     * @param mixed $telWork
     *
     * @return ContactDto
     */
    public function setTelWork($telWork): self
    {
        $this->telWork = $telWork;

        return $this;
    }

    /**
     * @param mixed $telWorkDop
     *
     * @return ContactDto
     */
    public function setTelWorkDop($telWorkDop): self
    {
        $this->telWorkDop = $telWorkDop;

        return $this;
    }

    /**
     * @param mixed $telMobile
     *
     * @return ContactDto
     */
    public function setTelMobile($telMobile): self
    {
        $this->telMobile = $telMobile;

        return $this;
    }

    /**
     * @param mixed $email
     *
     * @return ContactDto
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param mixed $url
     *
     * @return ContactDto
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

//endregion Getters/Setters
}