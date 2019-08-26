<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 10:08 AM
 */

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface FactoryDtoInterface
 *
 * @package App\Dto
 */
interface FactoryDtoInterface
{
//region SECTION: Public
    /**
     * @param $entity
     *
     * @return mixed
     */
    public function fillEntity($entity);
//endregion Public

//region SECTION: Dto
    /**
     * @param $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto(Request $request);
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request);
//endregion Getters/Setters
    /**
     * @return string
     */
    public function getClass();
}