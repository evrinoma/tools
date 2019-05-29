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
     *
     * @param ProcInfo $procInfo
     * @param SysInfo  $sysInfo
     * @param Settings $settings
     */
    // public function __construct(ProcInfo $procInfo, SysInfo $sysInfo,Settings $settings)
    public function __construct()
    {
        $this->procInfo = new ProcInfo();
        $this->sysInfo  = new SysInfo();
        $this->settings = new Settings();
    }
//endregion Constructor

//region SECTION: Private
//endregion Private

//region SECTION: Getters/Setters
    public function getProcInfo()
    {
        if ($this->settings->isMysql()) {
            $this->procInfo->checkMysql($this->settings->getDbHost(), $this->settings->getDbPort());
        }
        $this->procInfo->checkSSH($this->settings->getDbHost());

        return $this->procInfo;
    }

    public function getSysInfo()
    {
        $this->sysInfo->getSysInfo();

        return $this->sysInfo;
    }
//endregion Getters/Setters
}