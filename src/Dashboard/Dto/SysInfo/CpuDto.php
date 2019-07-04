<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/27/19
 * Time: 1:30 AM
 */

namespace App\Dashboard\Dto\SysInfo;

/**
 * Class CpuDto
 *
 * @package App\Dashboard\Dto\SysInfo
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
        return $this->cache . 'B';
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
    public function setModel($model):self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param mixed $cpuSpeed
     *
     * @return CpuDto
     */
    public function setCpuSpeed($cpuSpeed):self
    {
        $this->cpuSpeed = $cpuSpeed;

        return $this;
    }

    /**
     * @param mixed $cache
     *
     * @return CpuDto
     */
    public function setCache($cache):self
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param mixed $bogomips
     *
     * @return CpuDto
     */
    public function setBogomips($bogomips):self
    {
        $this->bogomips = $bogomips;

        return $this;
    }
//endregion Getters/Setters

}