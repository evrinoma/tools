<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 5:15 PM
 */

namespace App\Dashboard\Dto\SysInfo;

/**
 * Class NetworkDto
 *
 * @package App\Dashboard\Dto\SysInfo
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

//region SECTION: Private
    /**
     * @return mixed
     */
    private function getRxPackets()
    {
        return $this->rxPackets;
    }

    /**
     * @return mixed
     */
    private function getRxErrors()
    {
        return $this->rxErrors;
    }

    /**
     * @return mixed
     */
    private function getRxDrop()
    {
        return $this->rxDrop;
    }

    /**
     * @return mixed
     */
    private function getTxPackets()
    {
        return $this->txPackets;
    }

    /**
     * @return mixed
     */
    private function getTxErrors()
    {
        return $this->txErrors;
    }

    /**
     * @return mixed
     */
    private function getTxDrop()
    {
        return $this->txDrop;
    }

    /**
     * @return mixed
     */
    private function getErrors()
    {
        return $this->getRxErrors() + $this->getTxErrors();
    }

    /**
     * @return mixed
     */
    private function getDrop()
    {
        return $this->getRxDrop() + $this->getTxDrop();
    }
//endregion Private

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
    public function getTxBytes()
    {
        return $this->txBytes;
    }

    /**
     * @param mixed $name
     *
     * @return NetworkDto
     */
    public function setName($name):self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $rxBytes
     *
     * @return NetworkDto
     */
    public function setRxBytes($rxBytes):self
    {
        $this->rxBytes = $rxBytes;

        return $this;
    }

    /**
     * @param mixed $rxPackets
     *
     * @return NetworkDto
     */
    public function setRxPackets($rxPackets):self
    {
        $this->rxPackets = $rxPackets;

        return $this;
    }

    /**
     * @param mixed $rxErrors
     *
     * @return NetworkDto
     */
    public function setRxErrors($rxErrors):self
    {
        $this->rxErrors = $rxErrors;

        return $this;
    }

    /**
     * @param mixed $rxDrop
     *
     * @return NetworkDto
     */
    public function setRxDrop($rxDrop):self
    {
        $this->rxDrop = $rxDrop;

        return $this;
    }

    /**
     * @param mixed $txBytes
     *
     * @return NetworkDto
     */
    public function setTxBytes($txBytes):self
    {
        $this->txBytes = $txBytes;

        return $this;
    }

    /**
     * @param mixed $txPackets
     *
     * @return NetworkDto
     */
    public function setTxPackets($txPackets):self
    {
        $this->txPackets = $txPackets;

        return $this;
    }

    /**
     * @param mixed $txErrors
     *
     * @return NetworkDto
     */
    public function setTxErrors($txErrors):self
    {
        $this->txErrors = $txErrors;

        return $this;
    }

    /**
     * @param mixed $txDrop
     *
     * @return NetworkDto
     */
    public function setTxDrop($txDrop):self
    {
        $this->txDrop = $txDrop;

        return $this;
    }
//endregion Getters/Setters


}