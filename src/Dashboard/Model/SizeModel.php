<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/4/19
 * Time: 4:16 PM
 */

namespace App\Dashboard\Model;

/**
 * Class SizeModel
 *
 * @package App\Dashboard\Model
 */
abstract class SizeModel
{
//region SECTION: Fields
    public const SYZE_IN_BYTE     = 1;
    public const SYZE_IN_KILOBYTE = 1000;
    public const SYZE_IN_MEGABYTE = 1000000;
    public const SYZE_IN_GIGABYTE = 1000000000;
//endregion Fields
}