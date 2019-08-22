<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;

use App\Entity\Mail\Acl;
use App\Entity\Model\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Acl
 *
 * @package App\Dto
 */
class AclDto implements FactoryDtoInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
//endregion Fields

//region SECTION: Public
    /**
     * @param Acl $entity
     *
     * @return Acl
     */
    public function fillEntity($entity)
    {
        //$entity->setDomain($this->getName())->addServer($this->getServers())->setActive();

        return $entity;
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param $request
     *
     * @return array
     */
    public static function toDto(Request $request)
    {
        $id = $request->get('id');

        $result = [];

        if ($id) {
            $dto = new self();
            $dto->setId($id);
            $result[] = $dto;
        }

        return $result;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return AclDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


//endregion Getters/Setters
}