<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 9:54 AM
 */

namespace App\Annotation;

use App\Dto\FactoryDtoInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DtoAdapterEvent
 *
 * @package App\Annotation
 */
class DtoAdapterEvent extends Event
{
//region SECTION: Fields
    public const NAME = 'custom.event.dto.adapter';
    /**
     * @var FactoryDtoInterface
     */
    private $dtoFrom;

    /**
     * @var FactoryDtoInterface
     */
    private $dtoTo;

    private $class;
//endregion Fields

//region SECTION: Dto
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return FactoryDtoInterface
     */
    public function getDtoFrom()
    {
        return $this->dtoFrom;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return FactoryDtoInterface
     */
    public function getDtoTo()
    {
        return $this->dtoTo;
    }

    /**
     * @param string $class
     *
     * @return DtoAdapterEvent
     */
    public function setClass(&$class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param FactoryDtoInterface $dtoFrom
     *
     * @return DtoAdapterEvent
     */
    public function setDtoFrom(&$dtoFrom)
    {
        $this->dtoFrom = $dtoFrom;

        return $this;
    }

    /**
     * @param FactoryDtoInterface $dtoTo
     *
     * @return DtoAdapterEvent
     */
    public function setDtoTo(&$dtoTo)
    {
        $this->dtoTo = $dtoTo;

        return $this;
    }
//endregion Getters/Setters
}