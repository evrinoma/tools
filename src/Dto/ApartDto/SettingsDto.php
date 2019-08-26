<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto\ApartDto;


use App\Dto\AbstractDto;
use App\Dto\DtoApartInterface;
use App\Entity\Model\ActiveTrait;

/**
 * Class SettingsDto
 *
 * @package App\Dto
 */
class SettingsDto extends AbstractDto implements DtoApartInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
    private $classEntity;
//endregion Fields

//region SECTION: Getters/Setters

    /**
     * @return mixed
     */
    public function getClassEntity()
    {
        return $this->classEntity;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $classEntity
     *
     * @return SettingsDto
     */
    public function setClassEntity($classEntity)
    {
        $this->classEntity = $classEntity;

        return $this;
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