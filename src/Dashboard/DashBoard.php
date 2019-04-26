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
    private $procInfo;
    private $settings;
//endregion Fields

//region SECTION: Constructor
    /**
     * DashBoard constructor.
     *
     * @param ProcInfo $procInfo
     * @param SysInfo  $sysInfo
     * @param Settings $settings
     */
    public function __construct(ProcInfo $procInfo, SysInfo $sysInfo,Settings $settings)
    {
        $this->procInfo = $procInfo;
        $this->sysInfo = $sysInfo;
        $this->settings = $settings;
    }
//endregion Constructor

//region SECTION: Private
    private function getProcInfo()
    {
        if ($this->settings->isMysql()) {
            $this->procInfo->checkMysql($this->settings->getDbHost(),$this->settings->getDbPort());
        }
        $this->procInfo->checkSSH($this->settings->getDbHost());
    }

    private function getSysInfo()
    {
        $this->sysInfo->getSysInfo();
    }


//endregion Private
}