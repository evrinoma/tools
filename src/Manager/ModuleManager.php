<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/1/18
 * Time: 10:52 AM
 */

namespace App\Manager;


use App\Dto\ModuleDto;

class ModuleManager
{

//region SECTION: Constructor
    public function __construct()
    {
    }
//endregion Constructor

//region SECTION: Getters/Setters
    public function getListModules()
    {
        $modules[] = new ModuleDto("Admin", "Users", "0.06.05.2014", "Nikolay Nikolaev", "Enabled", "GPLv2+", "Core add new or delete Admin users.");
        $modules[] = new ModuleDto("Admin", "test page", "0.05.10.2012", "Nikolay Nikolaev", "Enabled", "GPLv2+", "Show test page.");
        $modules[] = new ModuleDto("Archive Cam", "Captured Tumen", "5.12.12.2017", "Nikolay Nikolaev", "Enabled", "GPLv2+", "Show capture images from cam.");
        $modules[] = new ModuleDto("Camera Settings", "Gusev", "0.15.01.2018", "Nikolay Nikolaev", "Enabled", "GPLv2+", "Gusev IP Camera Settings.");


        return $modules;
    }
//endregion Getters/Setters
}