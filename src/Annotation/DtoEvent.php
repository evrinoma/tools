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
 * Class DtoEvent
 *
 * @package App\Annotation
 */
class DtoEvent extends Event
{
    public const NAME = 'custom.event.dto';
//region SECTION: Fields
    /**
     * @var FactoryDtoInterface
     */
    private $dto;

    private $request;
//endregion Fields

//region SECTION: Dto
    /**
     * @return mixed
     */
    public function getDto()
    {
        return $this->dto;
    }

    /**
     * @param mixed $dto
     *
     * @return DtoEvent
     */
    public function setDto($dto)
    {
        $this->dto = $dto;

        return $this;
    }
//endregion SECTION: Dto
}