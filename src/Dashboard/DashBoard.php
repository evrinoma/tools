<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:15 AM
 */

namespace App\Dashboard;


use App\Manager\SettingsManager;

/**
 * Class DashBoard
 *
 * @package App\Dashboard
 */
class DashBoard
{

//region SECTION: Fields
    /**
     * @var ProcInfo
     */
    private $procInfo;

    /**
     * @var SysInfo
     */
    private $sysInfo;
//endregion Fields

//region SECTION: Constructor
    /**
     * DashBoard constructor.
     *
     * @param SettingsManager $settingsManager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->procInfo        = new ProcInfo($settingsManager);
        $this->sysInfo         = new SysInfo();
    }
//endregion Constructor

//region SECTION: Public
    public function createInfo()
    {
        $this->sysInfo->createSysInfo();
        $this->procInfo->createProcInfo();

        return $this;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getSysInfo()
    {
        return $this->sysInfo->getSysInfo();
    }


    public function getProcInfo()
    {
        return $this->procInfo->getProcInfo();
    }
//endregion Getters/Setters
}