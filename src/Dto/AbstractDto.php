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
abstract class AbstractDto implements FactoryDtoInterface
{
//region SECTION: Fields
    private $entitys;
//endregion Fields

//region SECTION: Public
    /**
     * @return \Generator|object
     */
    public function generatorEntity()
    {
        foreach ($this->entitys as $entity) {
            yield $entity;
        }
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    abstract public function getClass();

    /**
     * @return object[]
     */
    public function getEntitys()
    {
        return $this->entitys;
    }

    /**
     * @param object[] $entitys
     *
     * @return FactoryDtoInterface
     */
    public function setEntitys($entitys)
    {
        $this->entitys = $entitys;

        return $this;
    }
    //endregion Getters/Setters
}