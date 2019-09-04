<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 9/4/19
 * Time: 11:18 AM
 */

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class LiveControlDto
 *
 * @package App\Dto
 */
class LiveControlDto extends AbstractFactoryDto
{

//region SECTION: Fields
    /**
     * @var boolean
     */
    private $control = true;

    /**
     * @var
     */
    private $action;

    /**
     * @return bool
     */
    public function hasControl(): bool
    {
        return $this->control;
    }

    /**
     * @param bool $control
     *
     * @return LiveControlDto
     */
    public function setControl(bool $control)
    {
        $this->control = $control;

        return $this;
    }
//endregion Fields



//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return LiveControlDto::class;
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

    /**
     * @return string|null
     */
    public function lookingForRequest()
    {
        return null;
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
            $action = $request->get('action');

            if (!is_array($action)) {
                $action = explode(',', $action);
                if (is_array($action)) {
                    $this->setAction(end($action));
                }
            }

        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     *
     * @return LiveControlDto
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
//endregion Getters/Setters
}