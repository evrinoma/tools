<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;


use App\Entity\Model\ActiveTrait;
use App\Entity\Settings;

/**
 * Class SettingsDto
 *
 * @package App\Dto
 */
class SettingsDto implements FactoryDtoInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
//endregion Fields

//region SECTION: Public
    /**
     * @param Settings $entity
     *
     * @return mixed
     */
    public function fillEntity($entity)
    {
        $entity->setActive($this->getActive());

        return $entity;
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param $request
     *
     * @return mixed
     */
    public static function toDto(&$request)
    {
        $result = [];
        foreach ($request as $item) {
            if (isset($item['id'], $item['active'])) {
                $dto = new self();
                $dto->setId($item['id'])->setActive($item['active']);
                $result[$dto->getId()] = $dto;
            }
        }

        return $result;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
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
     * @return SettingsDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
//endregion Getters/Setters
}