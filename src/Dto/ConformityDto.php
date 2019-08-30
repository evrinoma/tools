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
    protected function getClassEntity()
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
     * @return AbstractFactoryDto
     */
    public function toDto($request)
    {
        $class = $request->get('class');

        if ($class === $this->getClassEntity()) {
            $type = $request->get('type');
            $this->setType($type);
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string|null
     */
    public function lookingForRequest()
    {
        return 'conformity';
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