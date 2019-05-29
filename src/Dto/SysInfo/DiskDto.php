<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 5:56 PM
 */

namespace App\Dto\SysInfo;

/**
 * Class DiskDto
 *
 * @package App\Dto\SysInfoDto
 */
class DiskDto
{
//region SECTION: Fields
    private $name    = '';
    private $total   = 0;
    private $used    = 0;
    private $free    = 0;
    private $mount   = '';
    private $fstype  = '';
    private $options = '';
    private $inodes  = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return int
     */
    public function calcFree()
    {

        return $this->getTotal() - $this->getUsed();
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getInodes()
    {
        return $this->inodes;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getFstype()
    {
        return $this->fstype;
    }

    /**
     * @return string
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * @return int
     */
    public function getFree()
    {
        return $this->free;
    }

    /**
     * @return int
     */
    public function getPercent()
    {

        return $this->getTotal() ? round(($this->getUsed() * 100) / $this->getTotal()) : 0;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param mixed $inodes
     *
     * @return DiskDto
     */
    public function setInodes($inodes)
    {
        $this->inodes = $inodes;

        return $this;
    }

    /**
     * @param mixed $options
     *
     * @return DiskDto
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $fstype
     *
     * @return DiskDto
     */
    public function setFstype($fstype)
    {
        $this->fstype = $fstype;

        return $this;
    }

    /**
     * @param string $mount
     *
     * @return DiskDto
     */
    public function setMount($mount)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * @param int $free
     *
     * @return DiskDto
     */
    public function setFree($free)
    {
        $this->free = $free;

        return $this;
    }

    /**
     * @param $used
     *
     * @return $this
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $devSwapTotal
     *
     * @return DiskDto
     */
    public function setTotal($devSwapTotal)
    {
        $this->total = $devSwapTotal;

        return $this;
    }
//endregion Getters/Setters

}