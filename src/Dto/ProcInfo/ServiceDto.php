<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/4/19
 * Time: 5:10 PM
 */

namespace App\Dto\ProcInfo;


class ServiceDto
{
//region SECTION: Fields
    private const STATUS_OK    = 'OK';
    private const STATUS_ERROR = 'ERROR';
    private const STATUS_NA    = 'NA';
    private $name;
    private $status;
    private $host;
    private $port;
//endregion Fields

//region SECTION: Public
    public function isAvailable()
    {
        return $this->status === self::STATUS_OK;
    }
//endregion Public

//region SECTION: Getters/Setters
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
    public function getTag()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    public function setStatusNA()
    {
        $this->status = self::STATUS_NA;

        return $this;
    }

    public function setStatusError()
    {
        $this->status = self::STATUS_ERROR;

        return $this;
    }

    public function setStatusOK()
    {
        $this->status = self::STATUS_OK;

        return $this;
    }

    /**
     * @param mixed $name
     *
     * @return ServiceDto
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $status
     *
     * @return ServiceDto
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param mixed $host
     *
     * @return ServiceDto
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param mixed $port
     *
     * @return ServiceDto
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }
//endregion Getters/Setters
}