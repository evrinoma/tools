<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/4/19
 * Time: 1:32 PM
 */

namespace App\Rest\Core;

use App\Rest\Model\RestModel;

/**
 * Trait RestTrait
 *
 * @package App\Core
 */
trait RestTrait
{
//region SECTION: Fields
    private $status = RestModel::SUCCESS_OK;
//endregion Fields

//region SECTION: Getters/Setters
    abstract public function getRestStatus(): int;
//endregion Getters/Setters
}