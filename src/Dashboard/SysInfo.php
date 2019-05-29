<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 12:18 PM
 */

namespace App\Dashboard;


use App\Dto\SysInfo\CpuDto;
use App\Dto\SysInfo\DevDto;
use App\Dto\SysInfo\DiskDto;
use App\Dto\SysInfo\MemoryDto;
use App\Dto\SysInfo\NetworkDto;
use App\Dto\SysInfo\ScsiDto;
use App\Dto\SysInfoDto;

/**
 * Class SysInfo
 *
 * @package App\Dashboard
 */
class SysInfo extends AbstractInfo
{
//region SECTION: Fields
    private const NOT_AVAILABLE = 'N.A.';
    private const ERROR         = 'ERROR';

    /**
     * @var SysInfoDto
     */
    private $sysInfo;

//endregion Fields

//region SECTION: Constructor
    /**
     * SysInfo constructor.
     */
    public function __construct()
    {
        $this->sysInfo = new SysInfoDto();
    }
//endregion Constructor
    // get the distro name and icon when create the sysinfo object
//    function sysinfo() {
//
//        $this->parser = new Parser();
//        $this->parser->df_param = 'Pl';
//
//        $list = parse_ini_file(APP_ROOT . "/" . $this->inifile, true);
//        if (!$list) {
//            return;
//        }
//        foreach ($list as $section => $distribution) {
//            if (!isset($distribution["Files"])) {
//                continue;
//            } else {
//                foreach (explode(";", $distribution["Files"]) as $filename) {
//                    if (file_exists($filename)) {
//                        $buf = rfts( $filename );
//                        $this->icon = isset($distribution["Image"]) ? $distribution["Image"] : $this->icon;
//                        $this->distro = isset($distribution["Name"]) ? $distribution["Name"] . " " . trim($buf) : trim($buf);
//                        $this->distroname = $section;
//                        break 2;
//                    }
//                }
//            }
//        }
//    }

    // get our apache SERVER_NAME or vhost


//region SECTION: Protected
    protected function getIpAddress()
    {
        $varName = getenv('SERVER_ADDR');
        if ($varName !== '') {
            $this->sysInfo->setIpAddress($varName);
        }

        return $this;
    }

    protected function getVHostName()
    {
        $varName = getenv('SERVER_NAME');
        if ($varName !== '') {
            $this->sysInfo->setVHostName($varName);
        }

        return $this;
    }

    protected function getCHostName()
    {
        if ($this->rfts('/proc/sys/kernel/hostname', 1)) {
            $this->sysInfo->setCHostName(gethostbyaddr(gethostbyname(trim($this->getResult()))));
        }

        return $this;
    }


    protected function getKernel()
    {
        if ($this->rfts('/proc/version', 1)) {
            if (preg_match('/version (.*?) /', $this->getResult(), $ar_buf)) {
                $result = $ar_buf[1];
                if (preg_match('/SMP/', $this->getResult())) {
                    $result .= ' (SMP)';
                }
            }
            $this->sysInfo->setKernel($result);
        } else {
            $this->sysInfo->setKernel(self::NOT_AVAILABLE);
        }

        return $this;
    }

    // get the IP address of our canonical hostname

    protected function getUptime()
    {
        if ($this->rfts('/proc/uptime', 1)) {
            $ar_buf = preg_split('/\s/', $this->getResult());
            $this->sysInfo->setUpTime(trim($ar_buf[0]));
        }

        return $this;
    }

    protected function getUsers()
    {
        if ($this->executeProgram('who', '-q')) {
            $who = explode('=', $this->getResult());
            $this->sysInfo->setUsers($who[1]);
        }

        return $this;
    }

    protected function getLoadAvg()
    {
        if ($this->rfts('/proc/loadavg')) {
            $results = preg_split("/\s/", $this->getResult(), 4);
            $this->sysInfo->getLoadAvg()->setLoadAve1($results[0])->setLoadAve5($results[1])->setLoadAve15($results[2]);
            if ($this->rfts('/proc/stat', 1)) {
                sscanf($this->getResult(), '%*s %f %f %f %f', $ab, $ac, $ad, $ae);
                $this->sysInfo->getLoadAvg()->setUserCpuLast($ab)->setNiceCpuLast($ac)->setSystemCpuLast($ad)->setIdleCpuLast($ae);

                sleep(1);

                $this->rfts('/proc/stat', 1);
                sscanf($this->getResult(), '%*s %f %f %f %f', $ab, $ac, $ad, $ae);
                $this->sysInfo->getLoadAvg()->setUserCpuLast($ab)->setNiceCpuLast($ac)->setSystemCpuLast($ad)->setIdleCpuLast($ae);
            }
        }

        return $this;
    }

    protected function getCpuInfo()
    {
        if ($this->rfts('/proc/cpuinfo')) {
            $cpu = new CpuDto();
            foreach ($this->toArrayString() as $item) {
                $splite = preg_split('/\s+:\s+/', $item);
                if (count($splite) > 1) {
                    [$key, $value] = $splite;
                    switch ($key) {
                        case 'model name':
                        case 'cpu':
                        case 'Processor':
                            $cpu->setModel($value);
                            break;
                        case 'BogoMIPS':
                            $cpu->setCpuSpeed($value);
                            break;
                        case 'cpu MHz':
                        case 'clock':
                            $cpu->setCpuSpeed(sprintf('%.2f', $value));
                            break;
                        case 'cycle frequency [Hz]':
                            $cpu->setCpuSpeed(sprintf('%.2f', $value / 1000000));
                            break;
                        case 'cache size':
                        case 'L2 cache':
                        case 'I size':
                            $cpu->setCache($value);
                            break;
                        case 'D size':
                            $cpu->addCache($value);
                            break;
                        case 'revision':
                        case 'cpu model':
                            $cpu->setModel($cpu->getModel().' ( rev: '.$value.')');
                            break;
                        case 'bogomips':
                        case 'BogoMips': // For sparc arch
                            $cpu->addBogomips($value);
                            break;
                        case 'system type': // Alpha arch - 2.2.x
                            $cpu->setModel($cpu->getModel().', '.$value.' ');
                            break;
                        case 'platform string': // Alpha arch - 2.2.x
                            $cpu->setModel($cpu->getModel().' ('.$value.')');
                            break;
                        case 'Cpu0ClkTck': // Linux sparc64
                            $cpu->setCpuSpeed(sprintf('%.2f', hexdec($value) / 1000000));
                            break;
                        case 'Cpu0Bogo': // Linux sparc64 & sparc32
                            $cpu->setBogomips($value);
                            break;
                    }
                }
            }
            $this->sysInfo->addCpu($cpu);
        }

        return $this;
    }

    protected function getPci()
    {
        if ($this->executeProgram('lspci', '', false)) {
            foreach ($this->toArrayString() as $buf) {
                $device = explode(' ', $buf, 4);
                if (array_key_exists(3, $device)) {
                    $pci = new DevDto();
                    $pci->setProduct($device[2].$device[1])->setSerialNumber($device[0])->setDescription($device[3]);
                    $this->sysInfo->addPci($pci);
                }
            }
        }

        return $this;
    }

    protected function getScsi()
    {
        $dev_type = '';
        $get_type = 0;

        if ($this->executeProgram('lsscsi', '-c', false) || $this->rfts('/proc/scsi/scsi')) {
            foreach ($this->toArrayString() as $buf) {
                if (false !== strpos($buf, 'Vendor')) {
                    preg_match('/Vendor: (.*) Model: (.*) Rev: (.*)/i', $buf, $dev);
                    [$key, $value] = preg_split('/:\s/', $buf, 2);
                    $get_type = true;
                    continue;
                }

                if ($get_type) {
                    preg_match('/Type:\s+(\S+)/i', $buf, $dev_type);
                    $scsi = new ScsiDto();
                    $scsi
                        ->setModel($dev[1].' '.$dev[2].' ('.$dev_type[1].')')
                        ->setMedia('Hard Disk');
                    $this->sysInfo->addScsi($scsi);
                    $get_type = false;
                }
            }
        }

        return $this;
    }

    protected function getUsb()
    {
        if ($this->executeProgram('lsusb', '', false)) {
            foreach ($this->toArrayString() as $buf) {
                $device = explode(' ', $buf, 7);
                if (array_key_exists(6, $device)) {
                    $usb = new DevDto();
                    $usb->setProduct($device[6])->setSerialNumber($device[5]);
                    $this->sysInfo->addUsb($usb);
                }
            }
        } else {
            if ($this->rfts('/proc/bus/usb/devices')) {
                $values = $this->toArrayString();
                $keys   = preg_grep('/^\s*$/', explode("\n", $values));
                $i      = 0;
                $stop   = true;
                do {
                    $j = $i + 1;
                    if (array_key_exists($i, $keys)) {
                        $i = $keys[$i];
                    }
                    if (array_key_exists($j, $keys)) {
                        $j = $keys[$j];
                    } else {
                        $j    = count($values);
                        $stop = false;
                    }
                    $usb = new DevDto();
                    for (; $i < $j; $i++) {
                        [$key, $value] = explode('=', $values[$i], 2);
                        switch ($key) {
                            case 'Manufacturer':
                                $usb->setDescription($value);
                                break;
                            case 'Product':
                                $usb->setProduct($value);
                                break;
                            case 'SerialNumber':
                                $usb->setSerialNumber($value);
                                break;
                        }
                    }
                    $this->sysInfo->addUsb($usb);
                } while ($stop);
            }
        }

        return $this;
    }

    protected function getNetwork()
    {
        if ($this->rfts('/proc/net/dev')) {
            foreach (preg_grep('/:/', $this->toArrayString()) as $buf) {
                [$dev_name, $stats_list] = explode(':', $buf, 2);
                $stats   = preg_split('/\s+/', trim($stats_list));
                $network = new NetworkDto();
                $network->setName($dev_name)
                    ->setRxBytes($stats[0])
                    ->setRxPackets($stats[1])
                    ->setRxErrors($stats[2])
                    ->setRxDrop($stats[3])
                    ->setTxBytes($stats[8])
                    ->setTxPackets($stats[9])
                    ->setTxErrors($stats[10])
                    ->setTxDrop($stats[11]);
                $this->sysInfo->addNetwork($network);
            }
        }

        return $this;
    }

    protected function getMemory()
    {
        if ($this->rfts('/proc/meminfo')) {
            $memory = new MemoryDto();
            foreach ($this->toArrayString() as $buf) {
                if (preg_match('/^MemTotal:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                    $memory->setMemTotal($ar_buf[1]);
                    continue;
                }
                if (preg_match('/^MemFree:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                    $memory->setMemFree($ar_buf[1]);
                    continue;
                }
                if (preg_match('/^Cached:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                    $memory->setCached($ar_buf[1]);
                    continue;
                }
                if (preg_match('/^Buffers:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                    $memory->setBuffers($ar_buf[1]);
                    continue;
                }
                if (preg_match('/^SwapTotal:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                    $memory->setSwapTotal($ar_buf[1]);
                    continue;
                }
                if (preg_match('/^SwapFree:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                    $memory->setSwapFree($ar_buf[1]);
                    continue;
                }
            }

            if ($this->rfts('/proc/swaps')) {
                foreach ($this->toArrayString() as $item) {
                    if ($item !== '' & (strpos($item, 'Filename') === false)) {
                        $arBuf   = preg_split('/\s+/', $item, 6);
                        $devSwap = new DiskDto();
                        $devSwap->setName($arBuf[0])
                            ->setTotal($arBuf[2])
                            ->setUsed($arBuf[3]);
                        $this->sysInfo->getMemory()->addDevSwap($devSwap);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param bool $showBind
     *
     * @return $this
     */
    protected function getFilesystems($showBind = true)
    {
        $j = 0;

        if ($this->executeProgram('df', '-kPl')) {
            $df = preg_grep('/(\\%\\s)/', preg_split("/\n/", $this->getResult(), -1, PREG_SPLIT_NO_EMPTY));
        } else {
            $df = [];
        }

        if ($this->executeProgram('df', '-iPl')) {
            $dfInode = preg_grep('/(\\%\\s)/', preg_split("/\n/", $this->getResult(), -1, PREG_SPLIT_NO_EMPTY));
        } else {
            $dfInode = [];
        }

        if ($this->executeProgram('mount')) {
            $mount = preg_split("/\n/", $this->getResult(), -1, PREG_SPLIT_NO_EMPTY);
        } else {
            $mount = [];
        }

        foreach ($df as $line) {
            $dfBuf = preg_split('/(\%\s)/', $line, 2);

            preg_match('/(.*)(\s+)(([0-9]+)(\s+)([0-9]+)(\s+)([0-9]+)(\s+)([0-9]+)$)/', $dfBuf[0], $dfSplite);

            $df_buf = [$dfSplite[1], $dfSplite[4], $dfSplite[6], $dfSplite[8], $dfSplite[10], $dfBuf[1]];

            preg_match_all('/([0-9]+)%/', $dfInode[$j + 1], $inode_buf, PREG_SET_ORDER);

            $df_buf[0] = trim(str_replace("\$", "\\$", $df_buf[0]));
            $df_buf[5] = trim($df_buf[5]);

            $current = 0;

            foreach ($mount as $mount_line) {
                $current++;
                if (preg_match('#'.$df_buf[0].' on '.$df_buf[5]." type (.*) \((.*)\)#", $mount_line, $mount_buf)) {
                    $mount_buf[1] .= ','.$mount_buf[2];
                } elseif (!preg_match('#'.$df_buf[0].'(.*) on '.$df_buf[5]." \((.*)\)#", $mount_line, $mount_buf)) {
                    continue;
                }

                if ($showBind || false === stripos($mount_buf[2], 'bind')) {
                    $disk = new DiskDto();
                    $disk
                        ->setName(str_replace("\\$", '$', $df_buf[0]))
                        ->setTotal($df_buf[1])
                        ->setUsed($df_buf[2])
                        ->setFree($df_buf[3])
                        ->setMount($df_buf[5])
                        ->setFstype(substr($mount_buf[1], 0, strpos($mount_buf[1], ',')))
                        ->setOptions(substr($mount_buf[1], strpos($mount_buf[1], ',') + 1, strlen($mount_buf[1])));

                    if (isset($inode_buf[count($inode_buf) - 1][1])) {
                        $disk->setInodes($inode_buf[count($inode_buf) - 1][1]);
                    }
                    $this->sysInfo->addDisk($disk);
                    $j++;
                    unset($mount[$current - 1]);
                    sort($mount);
                    break;
                }
            }

        }

        return $this;
    }
//endregion Protected

//region SECTION: Getters/Setters
    public function getSysInfo()
    {
        return $this
            ->getMemory()
            ->getLoadAvg()
            ->getCHostName()
            ->getCpuInfo()
            ->getIpAddress()
            ->getKernel()
            ->getFilesystems()
            ->getNetwork()
            ->getPci()
            ->getUptime()
            ->getUsb()
            ->getUsers()
            ->getScsi()
            ->getVHostName()
            ->sysInfo;
    }
//endregion Getters/Setters
}