<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 6:35 PM
 */

namespace App\Dto;


use App\Entity\Mail\Conformity;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConformityDto
 *
 * @package App\Dto
 */
class ConformityDto extends AbstractFactoryDto
{
//region SECTION: Fields
    /**
     * @var string
     */
    private $type;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected static function getClassEntity()
    {
        return Conformity::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @param $entity
     *
     * @return mixed
     */
    public function fillEntity($entity)
    {
        return $entity;
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto($request)
    {
        $dto   = new self();
        $class = $request->get('class');

        if ($class === self::getClassEntity()) {
            $type = $request->get('type');
            $dto->setType($type);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request)
    {
        self::regeneratRequest($request, self::getClassEntity(), 'conformity');

        return $request;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return ConformityDto
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters
}