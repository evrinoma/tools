<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 5:15 PM
 */

namespace App\Dto\SysInfoDto;

/**
 * Class NetworkDto
 *
 * @package App\Dto\SysInfoDto
 */
class NetworkDto
{
//region SECTION: Fields
    private $name;
    private $rxBytes;
    private $rxPackets;
    private $rxErrors;
    private $rxDrop;
    private $txBytes;
    private $txPackets;
    private $txErrors;
    private $txDrop;
//endregion Fields

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
    public function getRxBytes()
    {
        return $this->rxBytes;
    }

    /**
     * @return mixed
     */
    public function getRxPackets()
    {
        return $this->rxPackets;
    }

    /**
     * @return mixed
     */
    public function getRxErrors()
    {
        return $this->rxErrors;
    }

    /**
     * @return mixed
     */
    public function getRxDrop()
    {
        return $this->rxDrop;
    }

    /**
     * @return mixed
     */
    public function getTxBytes()
    {
        return $this->txBytes;
    }

    /**
     * @return mixed
     */
    public function getTxPackets()
    {
        return $this->txPackets;
    }

    /**
     * @return mixed
     */
    public function getTxErrors()
    {
        return $this->txErrors;
    }

    /**
     * @return mixed
     */
    public function getTxDrop()
    {
        return $this->txDrop;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->getRxErrors() + $this->getTxErrors();
    }

    /**
     * @return mixed
     */
    public function getDrop()
    {
        return $this->getRxDrop() + $this->getTxDrop();
    }

    /**
     * @param mixed $name
     *
     * @return NetworkDto
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $rxBytes
     *
     * @return NetworkDto
     */
    public function setRxBytes($rxBytes)
    {
        $this->rxBytes = $rxBytes;

        return $this;
    }

    /**
     * @param mixed $rxPackets
     *
     * @return NetworkDto
     */
    public function setRxPackets($rxPackets)
    {
        $this->rxPackets = $rxPackets;

        return $this;
    }

    /**
     * @param mixed $rxErrors
     *
     * @return NetworkDto
     */
    public function setRxErrors($rxErrors)
    {
        $this->rxErrors = $rxErrors;

        return $this;
    }

    /**
     * @param mixed $rxDrop
     *
     * @return NetworkDto
     */
    public function setRxDrop($rxDrop)
    {
        $this->rxDrop = $rxDrop;

        return $this;
    }

    /**
     * @param mixed $txBytes
     *
     * @return NetworkDto
     */
    public function setTxBytes($txBytes)
    {
        $this->txBytes = $txBytes;

        return $this;
    }

    /**
     * @param mixed $txPackets
     *
     * @return NetworkDto
     */
    public function setTxPackets($txPackets)
    {
        $this->txPackets = $txPackets;

        return $this;
    }

    /**
     * @param mixed $txErrors
     *
     * @return NetworkDto
     */
    public function setTxErrors($txErrors)
    {
        $this->txErrors = $txErrors;

        return $this;
    }

    /**
     * @param mixed $txDrop
     *
     * @return NetworkDto
     */
    public function setTxDrop($txDrop)
    {
        $this->txDrop = $txDrop;

        return $this;
    }
//endregion Getters/Setters


}