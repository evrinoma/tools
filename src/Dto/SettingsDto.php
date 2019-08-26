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
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SettingsDto
 *
 * @package App\Dto
 */
class SettingsDto extends AbstractFactoryDto
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;
    private $classEntity;

    private $files;
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
     * @return FactoryDtoInterface
     */
    public static function toDto(Request $request)
    {
        $settings    = $request->get('settings');
        $classEntity = $request->get('classEntity');
        $dto         = new self();

        if ($settings) {
            if (is_array($settings)) {
                /** @var SettingsDto $item */
                /** @var SettingsDto $clone */
                foreach ($settings as $item) {
                    if (isset($item['id'], $item['active'])) {
                        $clone = $dto->clone();
                        $clone->setId($item['id']);
                        $clone->setActive($item['active']);
                    }
                }
            }
        }

        if ($classEntity) {
           $dto->setClassEntity($classEntity);
        }

        return $dto;

    }
//endregion SECTION: Dto

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
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request)
    {
        return $request;
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