<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 2:46 PM
 */

namespace App\Dto;

use App\Dto\SysInfoDto\CpuDto;
use App\Dto\SysInfoDto\DevDto;
use App\Dto\SysInfoDto\DiskDto;
use App\Dto\SysInfoDto\LoadAvgDto;
use App\Dto\SysInfoDto\MemoryDto;
use App\Dto\SysInfoDto\NetworkDto;
use App\Dto\SysInfoDto\ScsiDto;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SysInfoDto
 *
 * @package App\Dto
 */
class SysInfoDto
{
//region SECTION: Fields
    public const UNKNOWN = 'unknown';
    private $vHostName = self::UNKNOWN;
    private $cHostName = self::UNKNOWN;
    private $ipAddress = self::UNKNOWN;
    private $distrName = self::UNKNOWN;
    private $distr     = self::UNKNOWN;
    private $kernel    = self::UNKNOWN;
    private $upTime    = self::UNKNOWN;
    private $users     = self::UNKNOWN;
    private $loadAvg;
    private $scsi;
    private $usb;
    private $pci;
    private $network;
    private $disk;
    private $memory;
    private $cpu;
//endregion Fields

//region SECTION: Constructor
    /**
     * SysInfoDto constructor.
     */
    public function __construct()
    {
        $this->loadAvg = new LoadAvgDto();
        $this->scsi    = new ArrayCollection();
        $this->usb     = new ArrayCollection();
        $this->pci     = new ArrayCollection();
        $this->network = new ArrayCollection();
        $this->memory  = new MemoryDto();
        $this->disk    = new ArrayCollection();
        $this->cpu     = new ArrayCollection();
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param CpuDto $cpu
     *
     * @return $this
     */
    public function addCpu(CpuDto $cpu)
    {
        $this->cpu->add($cpu);

        return $this;
    }

    /**
     * @param DiskDto $disk
     *
     * @return $this
     */
    public function addDisk(DiskDto $disk)
    {
        $this->disk->add($disk);

        return $this;
    }

    /**
     * @param NetworkDto $network
     *
     * @return $this
     */
    public function addNetwork(NetworkDto $network)
    {
        $this->network->add($network);

        return $this;
    }

    /**
     * @param DevDto $pci
     *
     * @return $this
     */
    public function addPci(DevDto $pci)
    {
        $this->pci->add($pci);

        return $this;
    }

    /**
     * @param DevDto $usb
     *
     * @return $this
     */
    public function addUsb(DevDto $usb)
    {
        $this->usb->add($usb);

        return $this;
    }

    /**
     * @param ScsiDto $scsi
     *
     * @return SysInfoDto
     */
    public function addScsi(ScsiDto $scsi)
    {
        $this->scsi->add($scsi);

        return $this;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return ArrayCollection
     */
    public function getCpu(): ArrayCollection
    {
        return $this->cpu;
    }

    /**
     * @return ArrayCollection
     */
    public function getDisk(): ArrayCollection
    {
        return $this->disk;
    }

    /**
     * @return MemoryDto
     */
    public function getMemory(): MemoryDto
    {
        return $this->memory;
    }

    /**
     * @return ArrayCollection
     */
    public function getNetwork(): ArrayCollection
    {
        return $this->network;
    }

    /**
     * @return ArrayCollection
     */
    public function getPci(): ArrayCollection
    {
        return $this->pci;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsb(): ArrayCollection
    {
        return $this->usb;
    }

    /**
     * @return ArrayCollection
     */
    public function getScsi(): ArrayCollection
    {
        return $this->scsi;
    }

    /**
     * @return LoadAvgDto
     */
    public function getLoadAvg(): LoadAvgDto
    {
        return $this->loadAvg;
    }

    /**
     * @return string
     */
    public function getUsers(): string
    {
        return $this->users;
    }

    /**
     * @return string
     */
    public function getUpTime(): string
    {
        return $this->upTime;
    }

    /**
     * @return string
     */
    public function getKernel(): string
    {
        return $this->kernel;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @return string
     */
    public function getCHostName(): string
    {
        return $this->cHostName;
    }

    /**
     * @return mixed
     */
    public function getVHostName()
    {
        return $this->vHostName;
    }

    /**
     * @return string
     */
    public function getDistrName(): string
    {
        return $this->distrName;
    }

    /**
     * @return string
     */
    public function getDistr(): string
    {
        return $this->distr;
    }

    /**
     * @param string $users
     *
     * @return SysInfoDto
     */
    public function setUsers(string $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param string $upTime
     *
     * @return SysInfoDto
     */
    public function setUpTime(string $upTime)
    {
        $this->upTime = $upTime;

        return $this;
    }

    /**
     * @param string $kernel
     *
     * @return SysInfoDto
     */
    public function setKernel(string $kernel)
    {
        $this->kernel = $kernel;

        return $this;
    }

    /**
     * @param string $ipAddress
     *
     * @return SysInfoDto
     */
    public function setIpAddress(string $ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * @param string $cHostName
     *
     * @return SysInfoDto
     */
    public function setCHostName(string $cHostName)
    {
        $this->cHostName = $cHostName;

        return $this;
    }

    /**
     * @param mixed $vHostName
     *
     * @return SysInfoDto
     */
    public function setVHostName($vHostName)
    {
        $this->vHostName = $vHostName;

        return $this;
    }

    /**
     * @param string $distrName
     *
     * @return SysInfoDto
     */
    public function setDistrName(string $distrName)
    {
        $this->distrName = $distrName;

        return $this;
    }

    /**
     * @param string $distr
     *
     * @return SysInfoDto
     */
    public function setDistr(string $distr)
    {
        $this->distr = $distr;

        return $this;
    }
//endregion Getters/Setters


}