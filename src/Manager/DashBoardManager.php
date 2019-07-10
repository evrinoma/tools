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
//region SECTION: Fields
    private $dashBoard;
//endregion Fields

//region SECTION: Constructor
    /**
     * DashBoardManager constructor.
     *
     * @param $dashBoard
     */
    public function __construct(DashBoard $dashBoard)
    {
        $this->dashBoard = $dashBoard;
    }
//endregion Constructor

//region SECTION: Getters/Setters

    /**
     * @return array
     */
    public function getDashBoard()
    {
        $sysinfo  = $this->dashBoard->createInfo()->getSysInfo();
        $procinfo = $this->dashBoard->getProcInfo();

        return ['sysinfo' => $sysinfo, 'procinfo' => $procinfo];
    }
//endregion Getters/Setters
}