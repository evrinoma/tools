<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 2:19 PM
 */

namespace App\Dto;


use Symfony\Component\HttpFoundation\Request;

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

//region SECTION: Protected
    /**
     * @return mixed
     */
    abstract protected static function getClassEntity();

    /**
     * @param Request $request
     * @param string  $classEntity
     * @param string  $searchTarget
     */
    protected static function regeneratRequest(Request $request, $classEntity, $searchTarget)
    {
        $target = $request->get($searchTarget);
        $class  = $request->get('class');
        if ($class !== $classEntity && $target) {
            if (is_string($target)) {
                $target = json_decode($target, true);
            }
            if ($target && is_array($target) && count($target) > 0) {
                $request->isMethod('GET') ? $request->query->add($target) : $request->request->add($target);
            }
        }
    }
//endregion Protected

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

    /**
     * @return int
     */
    public function countEntity()
    {
        return count($this->entitys);
    }

    /**
     * @return bool
     */
    public function hasSingleEntity()
    {
        return $this->countEntity() === 1;
    }

    /**
     * @return int
     */
    public function countClone()
    {
        return count($this->clones);
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