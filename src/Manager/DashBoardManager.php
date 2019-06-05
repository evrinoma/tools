<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/5/19
 * Time: 7:33 PM
 */

namespace App\Manager;

use App\Dashboard\DashBoard;

/**
 * Class DashBoard
 *
 * @package App\Manager
 */
class DashBoardManager
{

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getDashBoard()
    {
        $dashBoard = new DashBoard();

        $sysinfo  = $dashBoard->createInfo()->getSysInfo();
        $procinfo = $dashBoard->getProcInfo();

        return ['sysinfo' => $sysinfo, 'procinfo' => $procinfo];
    }
//endregion Getters/Setters
}