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

    /**
     * @return \Generator|object
     */
    public function generatorEntity();
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto(&$request);
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @return object[]
     */
    public function getEntitys();

    /**
     * @param object[] $entitys
     *
     * @return FactoryDtoInterface
     */
    public function setEntitys($entitys);
//endregion Getters/Setters
}