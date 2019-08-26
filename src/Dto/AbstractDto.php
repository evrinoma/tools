<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 2:19 PM
 */

namespace App\Dto;

/**
 * Class AbstractDto
 *
 * @package App\Dto
 */
abstract class AbstractDto
{
//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getClass()
    {
        return static::class;
    }
//endregion Getters/Setters
}