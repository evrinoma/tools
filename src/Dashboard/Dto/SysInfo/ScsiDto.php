<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 3:46 PM
 */

namespace App\Dashboard\Dto\SysInfo;


use App\Dashboard\Dto\SysInfoDto;

/**
 * Class ScsiDto
 *
 * @package App\Dashboard\Dto\SysInfo
 */
class ScsiDto
{
//region SECTION: Fields
    private $model = SysInfoDto::UNKNOWN;
    private $media = SysInfoDto::UNKNOWN;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getMedia(): string
    {
        return $this->media;
    }

    /**
     * @param string $model
     *
     * @return ScsiDto
     */
    public function setModel(string $model):self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param string $media
     *
     * @return ScsiDto
     */
    public function setMedia(string $media):self
    {
        $this->media = $media;

        return $this;
    }
//endregion Getters/Setters

}