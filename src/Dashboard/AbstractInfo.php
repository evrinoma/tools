<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 12:21 PM
 */

namespace App\Dashboard;

use App\Core\CoreShellTrait;

/**
 * Class AbstractInfo
 *
 * @package App\Dashboard
 */
abstract class AbstractInfo
{
    use CoreShellTrait;

//region SECTION: Public

    /**
     * @return array
     */
    public function toArrayString(): array
    {
        return explode("\n", $this->getResult());
    }
//endregion Public

}