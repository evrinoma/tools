<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:16 AM
 */

namespace App\Dashboard;

/**
 * Class ProcInfo
 *
 * @package App\Dashboard
 */
class ProcInfo
{
//region SECTION: Fields
    private $timeout = 5;
//endregion Fields

//region SECTION: Public
    /**
     * @param $host
     *
     * @return bool
     */
    public function checkSSH($host): bool
    {
        $cont       = file('/proc/net/tcp');
        $search     = 'SSH';
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
        $array_port = array_diff(array_unique(explode(':', $array_port)), array(''));
        $max = count($array_port);
        for ($i = 0; $i < $max; $i++) {
            if ($sock = @fsockopen($host, $array_port[$i], $errno, $errstr, $this->timeout)) {
                stream_set_timeout($sock, 0, 100000);
                $tmp = strtoupper(fread($sock, 127));
                if (strpos($tmp, $search) !== false) {
                    return $array_port[$i];
                }
                fclose($sock);
            }
        }

        return false;
    }

    /**
     * @param $host
     * @param $port
     *
     * @return bool
     */
    public function checkMysql($host, $port): bool
    {
        return $this->checkPort($host, $port);
    }
//endregion Public

//region SECTION: Private
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
}