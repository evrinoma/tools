<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 2:12 PM
 */

namespace App\Dto;

use App\Entity\LiveVideo\Group;
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

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return Group::class;
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
     * @return AbstractFactoryDto
     */
    public function toDto($request)
    {
        $alias = $request->get('alias');

        if ($alias) {
            $this->setAlias($alias);
        }

        return $this;
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
     * @return string|null
     */
    public function lookingForRequest()
    {
        return null;
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