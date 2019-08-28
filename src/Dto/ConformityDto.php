<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 6:35 PM
 */

namespace App\Dto;


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
    public static function toDto(&$request)
    {
        $conformity = $request->get('conformity');

        $dto = new self();

        if ($conformity) {
            if (is_array($conformity)) {
                if ($conformity['type']) {
                    $dto->setType($conformity['type']);
                }
            } else {
                $dto->setType($conformity);
            }
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