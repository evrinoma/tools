<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 5:56 PM
 */

namespace App\Dashboard\Dto\SysInfo;


use App\Dashboard\Core\SizeTrait;

/**
 * Class DiskDto
 *
 * @package App\Dto\SysInfo
 */
class DiskDto
{
    use SizeTrait;

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
    private function calcFree()
    {

        return $this->getTotal() - $this->getUsed();
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    private function getInodes()
    {
        return $this->inodes;
    }

    /**
     * @return mixed
     */
    private function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    private function getFstype()
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
    private function getFree()
    {
        return $this->free;
    }

    private function calc()
    {

        return $this->getTotal() ? $this->getUsed() / $this->getTotal() : 0;
    }

    /**
     * @return int
     */
    public function getPercent()
    {
        return round($this->calc() * 100, 2);
    }

    /**
     * @return string
     */
    private function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total / $this->getSize();
    }

    /**
     * @return int
     */
    public function getUsed()
    {
        return $this->used / $this->getSize();
    }

    /**
     * @param mixed $inodes
     *
     * @return DiskDto
     */
    public function setInodes($inodes):self
    {
        $this->inodes = $inodes;

        return $this;
    }

    /**
     * @param mixed $options
     *
     * @return DiskDto
     */
    public function setOptions($options):self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $fstype
     *
     * @return DiskDto
     */
    public function setFstype($fstype):self
    {
        $this->fstype = $fstype;

        return $this;
    }

    /**
     * @param string $mount
     *
     * @return DiskDto
     */
    public function setMount($mount):self
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * @param int $free
     *
     * @return DiskDto
     */
    public function setFree($free):self
    {
        $this->free = $free;

        return $this;
    }

    /**
     * @param $used
     *
     * @return $this
     */
    public function setUsed($used):self
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name):self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $devSwapTotal
     *
     * @return DiskDto
     */
    public function setTotal($devSwapTotal):self
    {
        $this->total = $devSwapTotal;

        return $this;
    }
//endregion Getters/Setters

}