<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 3:03 PM
 */

namespace App\Dto\SysInfo;

/**
 * Class LoadAvgDto
 *
 * @package App\Dto\SysInfoDto
 */
class LoadAvgDto
{
//region SECTION: Fields
    private $loadAve1  = 0;
    private $loadAve5  = 0;
    private $loadAve15 = 0;

    private $userCpuNext   = 0;
    private $niceCpuNext   = 0;
    private $systemCpuNext = 0;
    private $idleCpuNext   = 0;

    private $userCpuLast   = 0;
    private $niceCpuLast   = 0;
    private $systemCpuLast = 0;
    private $idleCpuLast   = 0;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getUserCpuLast(): int
    {
        return $this->userCpuLast;
    }

    /**
     * @return int
     */
    public function getNiceCpuLast(): int
    {
        return $this->niceCpuLast;
    }

    /**
     * @return int
     */
    public function getSystemCpuLast(): int
    {
        return $this->systemCpuLast;
    }

    /**
     * @return int
     */
    public function getIdleCpuLast(): int
    {
        return $this->idleCpuLast;
    }

    /**
     * @return int
     */
    public function getUserCpuNext(): int
    {
        return $this->userCpuNext;
    }

    /**
     * @return int
     */
    public function getNiceCpuNext(): int
    {
        return $this->niceCpuNext;
    }

    /**
     * @return int
     */
    public function getSystemCpuNext(): int
    {
        return $this->systemCpuNext;
    }

    /**
     * @return int
     */
    public function getIdleCpuNext(): int
    {
        return $this->idleCpuNext;
    }

    /**
     * @return mixed
     */
    public function getPercentCpu()
    {
        $loadLast  = $this->getUserCpuLast() + $this->getNiceCpuLast() + $this->getSystemCpuLast();
        $totalLast = $loadLast + $this->getIdleCpuLast();

        $loadNext  = $this->getUserCpuNext() + $this->getNiceCpuNext() + $this->getSystemCpuNext();
        $totalNext = $loadLast + $this->getIdleCpuNext();

        return ($totalNext !== $totalLast) ? ((100 * ($loadNext - $loadLast)) / ($totalNext - $totalLast)) : 0;
    }

    /**
     * @return mixed
     */
    public function getLoadAve1()
    {
        return $this->loadAve1;
    }

    /**
     * @return mixed
     */
    public function getLoadAve5()
    {
        return $this->loadAve5;
    }

    /**
     * @return mixed
     */
    public function getLoadAve15()
    {
        return $this->loadAve15;
    }

    /**
     * @param int $userCpuLast
     *
     * @return LoadAvg
     */
    public function setUserCpuLast(int $userCpuLast)
    {
        $this->userCpuLast = $userCpuLast;

        return $this;
    }

    /**
     * @param int $niceCpuLast
     *
     * @return LoadAvg
     */
    public function setNiceCpuLast(int $niceCpuLast)
    {
        $this->niceCpuLast = $niceCpuLast;

        return $this;
    }

    /**
     * @param int $systemCpuLast
     *
     * @return LoadAvg
     */
    public function setSystemCpuLast(int $systemCpuLast)
    {
        $this->systemCpuLast = $systemCpuLast;

        return $this;
    }

    /**
     * @param int $idleCpuLast
     *
     * @return LoadAvg
     */
    public function setIdleCpuLast(int $idleCpuLast)
    {
        $this->idleCpuLast = $idleCpuLast;

        return $this;
    }

    /**
     * @param int $userCpuNext
     *
     * @return LoadAvg
     */
    public function setUserCpuNext(int $userCpuNext)
    {
        $this->userCpuNext = $userCpuNext;

        return $this;
    }

    /**
     * @param int $niceCpuNext
     *
     * @return LoadAvg
     */
    public function setNiceCpuNext(int $niceCpuNext)
    {
        $this->niceCpuNext = $niceCpuNext;

        return $this;
    }

    /**
     * @param int $systemCpuNext
     *
     * @return LoadAvg
     */
    public function setSystemCpuNext(int $systemCpuNext)
    {
        $this->systemCpuNext = $systemCpuNext;

        return $this;
    }

    /**
     * @param int $idleCpuNext
     *
     * @return LoadAvg
     */
    public function setIdleCpuNext(int $idleCpuNext)
    {
        $this->idleCpuNext = $idleCpuNext;

        return $this;
    }

    /**
     * @param mixed $loadAve1
     *
     * @return LoadAvg
     */
    public function setLoadAve1($loadAve1)
    {
        $this->loadAve1 = $loadAve1;

        return $this;
    }

    /**
     * @param mixed $loadAve5
     *
     * @return LoadAvg
     */
    public function setLoadAve5($loadAve5)
    {
        $this->loadAve5 = $loadAve5;

        return $this;
    }

    /**
     * @param mixed $loadAve15
     *
     * @return LoadAvg
     */
    public function setLoadAve15($loadAve15)
    {
        $this->loadAve15 = $loadAve15;

        return $this;
    }
//endregion Getters/Setters


}