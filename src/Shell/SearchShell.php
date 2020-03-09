<?php


namespace App\Shell;


use Evrinoma\ShellBundle\Core\Shell;

class SearchShell extends Shell
{
    protected $programs = ['sed' => '', 'grep' => '', 'cat' => ''];

    /**
     * @param        $programName
     * @param string $args
     * @param bool   $bootErrorRep
     *
     * @return bool
     */
    public function executeProgram($programName, $args = '', $bootErrorRep = true): bool
    {
        exec($programName, $this->result);

        return count($this->result) ? true : false;
    }
}