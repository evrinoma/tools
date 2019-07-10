<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:16 AM
 */

namespace App\Dashboard;

use App\Dashboard\Dto\ProcInfo\ServiceDto;
use App\Dashboard\Dto\ProcInfoDto;
use App\Entity\Settings;
use App\Manager\SettingsManager;

/**
 * Class ProcInfo
 *
 * @package App\Dashboard
 */
class ProcInfo
{
//region SECTION: Fields
    private $timeout = 5;
    private $ports   = [];
    /**
     * @var Settings
     */
    private $settingsManager;

    /**
     * @var ProcInfoDto
     */
    private $procInfo;
//endregion Fields

//region SECTION: Constructor
    public function __construct(SettingsManager $settingsManager)
    {
        $this->procInfo = new ProcInfoDto();
        $this->settingsManager = $settingsManager;
    }
//endregion Constructor

//region SECTION: Public
    public function createProcInfo()
    {
        $this
            ->getLocalPorts()
            ->checkLocalSql()
            ->checkLocalSSH()
            ->checkLocalWeb();

        return $this;
    }
//endregion Public

//region SECTION: Private
    /**
     * @return $this
     */
    private function checkLocalSql()
    {

        $service = new ServiceDto();
        $service
            ->setName('MySQL')
            ->setHost($this->settingsManager->getDbHost())
            ->setPort($this->settingsManager->getDbPort());

        if ($this->settingsManager->isMysql()) {
            $status = $this->checkPort($this->settingsManager->getDbHost(), $this->settingsManager->getDbPort());
            $status ? $service->setStatusOK() : $service->setStatusError();

        } else {
            $service->setStatusNA();
        }
        $this->procInfo->addService($service);

        return $this;
    }


    private function checkLocalSSH()
    {
        $service = new ServiceDto();
        $service
            ->setName('SSH Server')
            ->setHost($this->settingsManager->getDbHost());

        $service->setPort($this->checkPrefix($this->settingsManager->getDbHost(), 'SSH'));
        if ($service->getPort()) {
            $service->setStatusOK();
        } else {
            $service->setStatusError();
        }

        $this->procInfo->addService($service);

        return $this;
    }

    private function checkLocalWeb()
    {
        $service = new ServiceDto();
        $service
            ->setName('Web Server')
            ->setHost($this->settingsManager->getDbHost())
            ->setStatusOK();

        $this->procInfo->addService($service);

        return $this;
    }

    private function getLocalPorts()
    {
        $cont       = file('/proc/net/tcp');
        $array_port = '';
        $max        = count($cont);
        for ($i = 0; $i < $max; $i++) {
            $str = explode(' ', $cont[$i]);
            if (preg_match('/[a-fA-F0-9:]$/', $str[4])) {
                $data = explode(':', $str[4]);
                if (isset($data[1])) {
                    $array_port .= hexdec($data[1]).':';
                }
            }
        }
        $this->ports = array_diff(array_unique(explode(':', $array_port)), array(''));

        return $this;
    }

    /**
     * @param $host
     *
     * @return mixed|null
     */
    private function checkPrefix($host, $prefix)
    {
        $max = count($this->ports);
        for ($i = 0; $i < $max; $i++) {
            if ($sock = @fsockopen($host, $this->ports[$i], $errno, $errstr, $this->timeout)) {
                stream_set_timeout($sock, 0, 100000);
                $tmp = strtoupper(fread($sock, 127));
                if (strpos($tmp, $prefix) !== false) {
                    return $this->ports[$i];
                }
                fclose($sock);
            }
        }

        return null;
    }

    /**
     * @param $host
     * @param $port
     *
     * @return bool
     */
    private function checkPort($host, $port)
    {
        if ($sock = @fsockopen($host, $port, $errno, $errstr, $this->timeout)) {
            fclose($sock);

            return true;
        }

        return false;
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getProcInfo()
    {
        return $this->procInfo;
    }
//endregion Getters/Setters
}