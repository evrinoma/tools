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

//region SECTION: Fields

    use ActiveTrait;
    private $id;
    private $classSettingsEntity;
    private $files;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected static function getClassEntity()
    {
        return Settings::class;
    }
//endregion Protected

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
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto($request)
    {
        $settings            = $request->get('settings');
        $classSettingsEntity = $request->get('classEntity');
        $dto                 = new self();

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

        if ($classSettingsEntity) {
            $dto->setClassSettingsEntity($classSettingsEntity);
        }

        return $dto;

    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getClassSettingsEntity()
    {
        return $this->classSettingsEntity;
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
     * @param mixed $classSettingsEntity
     *
     * @return SettingsDto
     */
    public function setClassSettingsEntity($classSettingsEntity)
    {
        $this->classSettingsEntity = $classSettingsEntity;

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