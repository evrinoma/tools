<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:16 AM
 */

namespace App\Dashboard;

use App\Dto\ProcInfo\ServiceDto;
use App\Dto\ProcInfoDto;
use App\Entity\Settings;

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
    private $settings;

    /**
     * @var ProcInfoDto
     */
    private $procInfo;
//endregion Fields

//region SECTION: Constructor
    public function __construct()
    {
        $this->procInfo = new ProcInfoDto();
    }
//endregion Constructor

//region SECTION: Public
    public function createProcInfo()
    {
        $this
            ->getPorts($this->settings->getDbHost())
            ->checkMysql()
            ->checkSSH()
            ->checkWeb();

        return $this;
    }
//endregion Public

//region SECTION: Private
    /**
     * @return $this
     */
    private function checkMysql()
    {
        $service = new ServiceDto();
        $service
            ->setName('MySQL')
            ->setHost($this->settings->getDbHost())
            ->setPort($this->settings->getDbPort());

        if ($this->settings->isMysql()) {
            $status = $this->checkPort($this->settings->getDbHost(), $this->settings->getDbPort());
            $status ? $service->setStatusOK() : $service->setStatusError();

        } else {
            $service->setStatusNA();
        }
        $this->procInfo->addService($service);

        return $this;
    }


    private function checkSSH()
    {
        $service = new ServiceDto();
        $service
            ->setName('SSH Server')
            ->setHost($this->settings->getDbHost());

        $service->setPort($this->checkPrefix($this->settings->getDbHost(), 'SSH'));
        if ($service->getPort()) {
            $service->setStatusOK();
        } else {
            $service->setStatusError();
        }

        $this->procInfo->addService($service);

        return $this;
    }

    private function checkWeb()
    {
        $service = new ServiceDto();
        $service
            ->setName('Web Server')
            ->setHost($this->settings->getDbHost())
            ->setStatusOK();

        $this->procInfo->addService($service);

        return $this;
    }

    private function getPorts($host)
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

    public function setSettings(&$settings)
    {
        $this->settings = $settings;

        return $this;
    }
//endregion Getters/Setters
}