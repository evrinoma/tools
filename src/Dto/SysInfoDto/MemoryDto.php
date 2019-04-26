<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 5:27 PM
 */

namespace App\Dto\SysInfoDto;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class MemoryDto
 *
 * @package App\Dto\SysInfoDto
 */
class MemoryDto
{
private $memTotal = 0;
private $memFree = 0;
private $cached = 0;
private $swapTotal = 0;
private $swapFree = 0;
    private $buffers = 0;
    private $devSwap;

    /**
     * MemoryDto constructor.
     */
    public function __construct()
    {
        $this->devSwap = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getDevSwap(): ArrayCollection
    {
        return $this->devSwap;
    }

    /**
     * @param DiskDto $devSwap
     *
     * @return MemoryDto
     */
    public function addDevSwap(DiskDto $devSwap)
    {
        $this->devSwap->add($devSwap);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRamUsed()
    {
        return $this->getMemTotal() - $this->getMemFree();
    }

    /**
     * @return mixed
     */
    public function getRamApp()
    {
        return $this->getRamUsed() - $this->getCached() - $this->getBuffers();
    }

    /**
     * @return mixed
     */
    public function getRamAppPercent()
    {
        return $this->getMemTotal() ? round(($this->getRamApp() * 100) / $this->getMemTotal()) : 0;
    }


    /**
     * @return mixed
     */
    public function getRamBuffersPercent()
    {
        return $this->getMemTotal() ? round(($this->getBuffers() * 100) / $this->getMemTotal()) : 0;
    }

    /**
     * @return mixed
     */
    public function getRamCachedPercent()
    {
        return $this->getMemTotal() ? round(($this->getCached() * 100) / $this->getMemTotal()) : 0;
    }

    /**
     * @return mixed
     */
    public function getRamPercent()
    {
        return $this->getMemTotal() ? round(($this->getMemFree() * 100) / $this->getMemTotal()) : 0;
    }

    /**
     * @return mixed
     */
    public function getSwapUsed()
    {
        return $this->getSwapTotal() - $this->getSwapFree();
    }


    /**
     * @return mixed
     */
    public function getSwapPercent()
    {
        return $this->getSwapTotal() ? round(($this->getSwapFree() * 100) / $this->getSwapTotal()) : 0;
    }



    /**
     * @return mixed
     */
    public function getBuffers()
    {
        return $this->buffers;
    }

    /**
     * @param mixed $buffers
     *
     * @return MemoryDto
     */
    public function setBuffers($buffers)
    {
        $this->buffers = $buffers;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getMemTotal()
    {
        return $this->memTotal;
    }

    /**
     * @param mixed $memTotal
     *
     * @return MemoryDto
     */
    public function setMemTotal($memTotal)
    {
        $this->memTotal = $memTotal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemFree()
    {
        return $this->memFree;
    }

    /**
     * @param mixed $memFree
     *
     * @return MemoryDto
     */
    public function setMemFree($memFree)
    {
        $this->memFree = $memFree;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCached()
    {
        return $this->cached;
    }

    /**
     * @param mixed $cached
     *
     * @return MemoryDto
     */
    public function setCached($cached)
    {
        $this->cached = $cached;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSwapTotal()
    {
        return $this->swapTotal;
    }

    /**
     * @param mixed $swapTotal
     *
     * @return MemoryDto
     */
    public function setSwapTotal($swapTotal)
    {
        $this->swapTotal = $swapTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSwapFree()
    {
        return $this->swapFree;
    }

    /**
     * @param mixed $swapFree
     *
     * @return MemoryDto
     */
    public function setSwapFree($swapFree)
    {
        $this->swapFree = $swapFree;
        return $this;
    }



}