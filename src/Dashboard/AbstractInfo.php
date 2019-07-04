<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 12:21 PM
 */

namespace App\Dashboard;

/**
 * Class AbstractInfo
 *
 * @package App\Dashboard
 */
abstract class AbstractInfo
{
//region SECTION: Fields
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $result;

    /**
     * @var array
     */
    private $paths = ['/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin'];
//endregion Fields

//region SECTION: Protected
    /**
     * @param      $strFileName
     * @param int  $intLines
     * @param int  $intBytes
     * @param bool $booErrorRep
     *
     * @return bool
     */
    protected function rfts($strFileName, $intLines = 0, $intBytes = 4096, $booErrorRep = true): bool
    {
        $this->setClean();
        $intCurLine = 1;

        if (file_exists($strFileName)) {
            if ($fd = fopen($strFileName, 'r')) {
                while (!feof($fd)) {
                    $this->result .= fgets($fd, $intBytes);
                    if ($intLines <= $intCurLine && $intLines !== 0) {
                        break;
                    } else {
                        $intCurLine++;
                    }
                }
                fclose($fd);
            } else {
                if ($booErrorRep) {
                    $this->error = 'fopen('.$strFileName.') file can not read by phpsysinfo';
                }

                return false;
            }
        } else {
            if ($booErrorRep) {
                $this->error = 'fopen('.$strFileName.') the file does not exist on your machine';
            }

            return false;
        }

        return true;
    }

    /**
     * @param        $programname
     * @param string $args
     * @param bool   $bootErrorRep
     *
     * @return bool
     */
    protected function executeProgram($programname, $args = '', $bootErrorRep = true): bool
    {
        $this->setClean();

        $buffer  = '';
        $program = $this->findProgram($programname);

        if (!$program) {
            if ($bootErrorRep) {
                $this->error = 'findProgram('.$programname.') program not found on the machine';
            }

            return false;
        }

        // see if we've gotten a |, if we have we need to do patch checking on the cmd
        if ($args) {
            $args_list = preg_split('/\s/', $args);
            $max       = count($args_list);
            for ($i = 0; $i < $max; $i++) {
                if ($args_list[$i] === '|') {
                    $cmd     = $args_list[$i + 1];
                    $new_cmd = $this->findProgram($cmd);
                    $args    = preg_replace("/\| $cmd/", "| $new_cmd", $args);
                }
            }
        }
        // we've finally got a good cmd line.. execute it
        if ($fp = popen("($program $args > /dev/null) 3>&1 1>&2 2>&3", 'r')) {
            while (!feof($fp)) {
                $buffer .= fgets($fp, 4096);
            }
            pclose($fp);
            $buffer = trim($buffer);
            if (!empty($buffer)) {
                if ($bootErrorRep) {
                    $this->error = 'findProgram('.$program.') program not found on the machine';

                    return false;
                }
            }
        }
        if ($fp = popen("$program $args", 'r')) {
            $buffer = '';
            while (!feof($fp)) {
                $buffer .= fgets($fp, 4096);
            }
            pclose($fp);
        }
        $this->result = trim($buffer);

        return true;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @return array
     */
    public function toArrayString(): array
    {
        return explode("\n", $this->getResult());
    }
//endregion Public

//region SECTION: Private
    /**
     * @param $program
     *
     * @return string|null
     */
    private function findProgram($program): ?string
    {
        reset($this->paths);
        if (function_exists('is_executable')) {
            while ($this_path = current($this->paths)) {
                if (is_executable("$this_path/$program")) {
                    return "$this_path/$program";
                }
                next($this->paths);
            }
        }

        return null;
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function setClean()
    {
        $this->result = '';
        $this->error  = '';

        return $this;
    }
//endregion Getters/Setters
}