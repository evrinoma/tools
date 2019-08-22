<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 10:08 AM
 */

namespace App\Dto;

/**
 * Interface FactoryDtoInterface
 *
 * @package App\Dto
 */
interface FactoryDtoInterface
{
//region SECTION: Public
    public function fillEntity($entity);
//endregion Public

//region SECTION: Dto
    /**
     * @param $request
     *
     * @return mixed
     */
    public static function toDto(&$request);
//endregion SECTION: Dto
}