<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 2:12 PM
 */

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class LiveVideoDto
 *
 * @package App\Dto
 */
class LiveVideoDto extends AbstractFactoryDto
{

//region SECTION: Fields
    private $alias;
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
        $alias = $request->get('alias');

        $dto = new self();

        if ($alias) {
            $dto->setAlias($alias);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

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
     * @param mixed $alias
     *
     * @return LiveVideoDto
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }
//endregion Getters/Setters
}