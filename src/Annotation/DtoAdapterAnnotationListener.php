<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 8:35 AM
 */

namespace App\Annotation;


use App\Annotation\ApartAnnotation\DtoAdapterItem;
use App\Dto\FactoryDto;
use Doctrine\Common\Annotations\Reader;
use ReflectionObject;

/**
 * Class DtoAdapterAnnotationListener
 *
 * @package App\Annotation
 */
class DtoAdapterAnnotationListener
{
//region SECTION: Fields
    private $annotationReader;

    /**
     * FactoryDto
     */
    private $factoryDto;

//endregion Fields

//region SECTION: Constructor
    public function __construct(Reader $annotationReader, FactoryDto $factoryDto)
    {
        $this->annotationReader = $annotationReader;
        $this->factoryDto       = $factoryDto;
    }
//endregion Constructor

//region SECTION: Public
//endregion Public

//region SECTION: Private
    private function handleAnnotation($dto, $class)
    {
        $dtoTo = null;

        $reflectionObject  = new ReflectionObject($dto);
        $reflectionMethods = $reflectionObject->getMethods();

        foreach ($reflectionMethods as $reflectionMethod) {
            $annotations = $this->annotationReader->getMethodAnnotation($reflectionMethod, DtoAdapter::class);
            if ($annotations instanceof DtoAdapter) {
                /** @var DtoAdapterItem $adaptor */
                foreach ($annotations->adaptors as $adaptor) {
                    if ($adaptor->class === $class) {
                        $dtoTo = $this->factoryDto->cloneDto($class);
                        $dtoTo->{$adaptor->method}($dto->{$reflectionMethod->getName()}());

                        return $dtoTo;
                    }
                }
            }
        }

        return $dtoTo;
    }
//endregion Private

//region SECTION: Dto
    public function onKernelDto(DtoAdapterEvent $event): void
    {
        $dtoTo = $this->handleAnnotation($event->getDtoFrom(), $event->getClass());
        $event->setDtoTo($dtoTo);
    }
//endregion SECTION: Dto
}