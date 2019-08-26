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
abstract class AbstractFactoryDto extends AbstractDto implements FactoryDtoInterface
{
//region SECTION: Fields
    /**
     * @var AbstractFactoryDto[]
     */
    private $clones = [];
    /**
     * @var
     */
    private $entitys;
    /**
     * @var FactoryAdaptor $factoryAdapter
     */
    private $factoryAdapter;
//endregion Fields

//region SECTION: Public
    /**
     * @return \Generator|object
     */
    public function generatorClone()
    {
        foreach ($this->clones as $clone) {
            yield $clone;
        }
    }

    /**
     * @return AbstractFactoryDto
     */
    public function clone()
    {
        $clone          = clone $this;
        $clone->clones  = null;
        $this->clones[] = &$clone;

        return $clone;
    }

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
     * @return object[]
     */
    public function getEntitys()
    {
        return $this->entitys;
    }

    /**
     * @return FactoryAdaptor
     */
    public function getFactoryAdapter()
    {
        return $this->factoryAdapter;
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

    /**
     * @param FactoryAdaptor $factoryAdapter
     */
    public function setFactoryAdapter(&$factoryAdapter)
    {
        $this->factoryAdapter = &$factoryAdapter;
    }
    //endregion Getters/Setters
}