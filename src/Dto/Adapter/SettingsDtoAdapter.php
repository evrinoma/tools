<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 4:46 PM
 */

namespace App\Dto\Adapter;


use App\Dto\ApartDto\SettingsDto;
use App\Dto\FactoryDto;

/**
 * Class SettingsAdapter
 *
 * @package App\Dto\Adapter
 */
class SettingsDtoAdapter
{

    /**
     * @var SettingsDto $settingsDto
     */
    private $settingsDto;

    /**
     * SettingsDtoAdapter constructor.
     *
     * @param $settingsDto
     */
    public function __construct($settingsDto)
    {
        $this->settingsDto = $settingsDto;
    }

    public function setClassEntity($classEntity)
    {
        $this->settingsDto->setClassEntity($classEntity);

        return $this;
    }

    public function getDto()
    {
        return $this->settingsDto;
    }
}