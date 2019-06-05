<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:15 AM
 */

namespace App\Dashboard;


use App\Entity\Settings;

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
     * @var Settings
     */
    private $settings;
    /**
     * @var SysInfo
     */
    private $sysInfo;
//endregion Fields

//region SECTION: Constructor
    /**
     * DashBoard constructor.
     */
    // public function __construct(ProcInfo $procInfo, SysInfo $sysInfo,Settings $settings)
    public function __construct()
    {
        $this->procInfo = new ProcInfo();
        $this->sysInfo  = new SysInfo();
        $this->settings = new Settings();
    }
//endregion Constructor

//region SECTION: Public
    public function createInfo()
    {
        $this->sysInfo->createSysInfo();
        $this->procInfo->setSettings($this->settings)->createProcInfo();

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