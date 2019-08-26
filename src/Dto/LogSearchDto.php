<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 3:48 PM
 */

namespace App\Dto;

use App\Annotation\ApartAnnotation\DtoAdapterItem;
use App\Annotation\DtoAdapter;
use App\Entity\Model\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LogSearchDto
 *
 * @package App\Dto
 */
class LogSearchDto extends AbstractFactoryDto
{
    use ActiveTrait;

//region SECTION: Fields
    private   $searchString;
    private   $searchFile = [];
//endregion Fields

//region SECTION: Public
    /**
     * @param Object $entity
     *
     * @return mixed
     */
    public function fillEntity($entity)
    {
        $entity->setActive();

        return $entity;
    }

    /**
     * @DtoAdapter(adaptors={
     *     @DtoAdapterItem(class="App\Dto\SettingsDto",method="setClassEntity")
     * })
     */
    public function getClass()
    {
        return parent::getClass();
    }

    /**
     * @return int
     */
    public function isValidSearchStr()
    {
        return $this->searchString !== '';
    }

    public function hasFile($fileName)
    {
        return (count($this->searchFile) === 0 || array_key_exists($fileName, $this->searchFile));
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
        $searchString = $request->get('searchString');
        $searchFile   = $request->get('searchFile');

        $dto = new self();

        if ($searchString) {
            $dto->setSearchString($searchString);
        }

        if ($searchFile) {
            $dto->setSearchFile($searchFile);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * @return mixed
     */
    public function getSearchFile()
    {
        return $this->searchFile;
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
     * @param mixed $searchString
     *
     * @return LogSearchDto
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;

        return $this;
    }

    /**
     * @param mixed $searchFile
     *
     * @return LogSearchDto
     */
    public function setSearchFile($searchFile)
    {
        $this->searchFile = array_flip(preg_split('/,/', $searchFile, null, PREG_SPLIT_NO_EMPTY));

        return $this;
    }
//endregion Getters/Setters
}