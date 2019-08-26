<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 8:35 AM
 */

namespace App\Annotation;


use App\Dto\FactoryDto;
use Doctrine\Common\Annotations\Reader;
use ReflectionObject;
use ReflectionProperty;

/**
 * Class DtoAnnotationListener
 *
 * @package App\Annotation
 */
class DtoAnnotationListener
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
    private function handleAnnotation($dto): void
    {
        $reflectionObject    = new ReflectionObject($dto);
        $reflectionProperties = $reflectionObject->getProperties(ReflectionProperty::IS_PRIVATE);

        foreach ($reflectionProperties as $reflectionProperty) {
            $annotation = $this->annotationReader->getPropertyAnnotation($reflectionProperty, Dto::class);
            if ($annotation instanceof Dto) {
                $annotationDto = $this->factoryDto->createDto($annotation->class);
                $dto->{'set'.ucfirst($reflectionProperty->getName())}($annotationDto);
            }
        }
    }
//endregion Private

//region SECTION: Dto
    public function onKernelDto(DtoEvent $event): void
    {
        $dto = $event->getDto();

        $this->handleAnnotation($dto);
    }
//endregion SECTION: Dto
}