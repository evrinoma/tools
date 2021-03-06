<?php

namespace App\QrCode\Std;

class ContactStd
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
     * @return ContactStd
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param mixed $lastName
     *
     * @return ContactStd
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param mixed $position
     *
     * @return ContactStd
     */
    public function setPosition($position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param mixed $comapanyName
     *
     * @return ContactStd
     */
    public function setComapanyName($comapanyName): self
    {
        $this->comapanyName = $comapanyName;

        return $this;
    }

    /**
     * @param mixed $telWork
     *
     * @return ContactStd
     */
    public function setTelWork($telWork): self
    {
        $this->telWork = $telWork;

        return $this;
    }

    /**
     * @param mixed $telWorkDop
     *
     * @return ContactStd
     */
    public function setTelWorkDop($telWorkDop): self
    {
        $this->telWorkDop = $telWorkDop;

        return $this;
    }

    /**
     * @param mixed $telMobile
     *
     * @return ContactStd
     */
    public function setTelMobile($telMobile): self
    {
        $this->telMobile = $telMobile;

        return $this;
    }

    /**
     * @param mixed $email
     *
     * @return ContactStd
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param mixed $url
     *
     * @return ContactStd
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

//endregion Getters/Setters
}