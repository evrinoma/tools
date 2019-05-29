<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/27/19
 * Time: 1:30 AM
 */

namespace App\Dto\SysInfo;

/**
 * Class CpuDto
 *
 * @package App\Dto\SysInfoDto
 */
class CpuDto
{
//region SECTION: Fields
    private $model    = '';
    private $cpuSpeed = '';
    private $cache    = '';
    private $bogomips = 0;
//endregion Fields

//region SECTION: Public
    /**
     * @param mixed $cache
     *
     * @return CpuDto
     */
    public function addCache($cache)
    {
        $this->cache += $cache;

        return $this;
    }

    /**
     * @param mixed $bogomips
     *
     * @return CpuDto
     */
    public function addBogomips($bogomips)
    {
        $this->bogomips += $bogomips;

        return $this;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getCpuSpeed()
    {
        return $this->cpuSpeed;
    }

    /**
     * @return mixed
     */
    public function getCache()
    {
        return $this->cache / 1024 .' KB';
    }

    /**
     * @return mixed
     */
    public function getBogomips()
    {
        return $this->bogomips;
    }

    /**
     * @param mixed $model
     *
     * @return CpuDto
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param mixed $cpuSpeed
     *
     * @return CpuDto
     */
    public function setCpuSpeed($cpuSpeed)
    {
        $this->cpuSpeed = $cpuSpeed;

        return $this;
    }

    /**
     * @param mixed $cache
     *
     * @return CpuDto
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param mixed $bogomips
     *
     * @return CpuDto
     */
    public function setBogomips($bogomips)
    {
        $this->bogomips = $bogomips;

        return $this;
    }
//endregion Getters/Setters

}