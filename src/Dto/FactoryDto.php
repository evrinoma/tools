<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:35 AM
 */

namespace App\Dto;

use App\Annotation\DtoEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class FactoryDto
 *
 * @package App\Dto
 */
class FactoryDto
{
//region SECTION: Fields
    private $request;
    private $eventDispatcher;
    private $pull = [];
//endregion Fields

//region SECTION: Constructor

    /**
     * FactoryDto constructor.
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
//endregion Constructor

//region SECTION: Private
    /**
     * @param $dto FactoryDtoInterface
     */
    private function push($dto)
    {
        $this->pull[$dto->getClass()] = $dto;

    }
//endregion Private

//region SECTION: Dto
    /**
     * @param $class
     *
     * @return FactoryDtoInterface
     */
    public function createDto($class)
    {
        $dto = null;

        if (class_exists($class) && $this->request) {
            $dto = new $class;
            if ($dto instanceof FactoryDtoInterface) {
                if (!$this->hasDto($dto)) {
                    /** @var FactoryDtoInterface $class */
                    $dto = $class::toDto($this->request);
                    $this->push($dto);
                    $event = new DtoEvent();
                    $event->setDto($dto);
                    $this->eventDispatcher->dispatch(DtoEvent::NAME, $event);
                } else {
                    $dto = $this->getDtoByClass($class);
                }
            }
        }

        return $dto;
    }

    /**
     * @param FactoryDtoInterface $dto
     *
     * @return bool
     */
    public function hasDto($dto)
    {
        return array_key_exists($dto->getClass(), $this->pull);
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param string $class
     *
     * @return FactoryDtoInterface
     */
    public function getDtoByClass($class)
    {
        return $this->pull[$class];
    }

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