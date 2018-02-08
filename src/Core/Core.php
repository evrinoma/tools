<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/5/18
 * Time: 5:17 PM
 */

namespace App\Core;


use App\Manager\ModuleManager;

class Core
{
//region SECTION: Fields
    private $moduleManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ModuleManager $manager)
    {
        $this->moduleManager = $manager;
    }
//endregion Constructor

//region SECTION: Getters/Setters
    public function getMenuList()
    {
        return $this->moduleManager->getListModules();
    }
//endregion Getters/Setters
}