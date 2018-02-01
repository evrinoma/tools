<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/1/18
 * Time: 10:54 AM
 */

namespace App\Dto;


class ModuleDto
{
//region SECTION: Fields
    private $category;
    private $name;
    private $version;
    private $publisher;
    private $license;
    private $description;
    private $status;
//endregion Fields

//region SECTION: Constructor
    /**
     * ModuleDto constructor.
     */
    public function __construct($category, $name, $version, $publisher, $status, $license, $description)
    {
        $this->category    = $category;
        $this->name        = $name;
        $this->version     = $version;
        $this->publisher   = $publisher;
        $this->license     = $license;
        $this->description = $description;
        $this->status      = $status;
    }
//endregion Constructor

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @return mixed
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher): void
    {
        $this->publisher = $publisher;
    }

    /**
     * @param mixed $license
     */
    public function setLicense($license): void
    {
        $this->license = $license;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
//endregion Getters/Setters

}