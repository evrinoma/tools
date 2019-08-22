<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:35 AM
 */

namespace App\Dto;

/**
 * Class FactoryDto
 *
 * @package App\Dto
 */
class FactoryDto
{
//region SECTION: Fields
    private $request;
//endregion Fields

//region SECTION: Dto
    /**
     * @param $class
     *
     * @return array
     */
    public function createDto($class)
    {
        $dtos = [];

        if (class_exists($class) && $this->request) {
            $dto = new $class;
            if ($dto instanceof FactoryDtoInterface) {
                /** @var FactoryDtoInterface $class */
                $dtos = $class::toDto($this->request);
            }
        }

        return $dtos;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param $request
     *
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
//endregion Getters/Setters
}