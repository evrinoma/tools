<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 9:14 AM
 */

namespace App\Dto;


use Symfony\Component\HttpFoundation\Request;

/**
 * Class SpamDto
 *
 * @package App\Dto
 */
class SpamDto extends AbstractFactoryDto
{

//region SECTION: Fields
    /**
     * @var string
     */
    private $filterType;

    /**
     * @var string
     */
    private $conformity;
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
        $filterType = $request->get('filterType');
        $conformity = $request->get('conformityType');

        $dto = new self();

        if ($filterType) {
            $dto->setFilterType($filterType);
        }

        if ($conformity) {
            $dto->setConformity($conformity);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getConformity()
    {
        return $this->conformity;
    }

    /**
     * @return mixed
     */
    public function getFilterType()
    {
        return $this->filterType;
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
     * @param string $conformity
     *
     * @return SpamDto
     */
    public function setConformity($conformity)
    {
        $this->conformity = $conformity;

        return $this;
    }

    /**
     * @param mixed $filterType
     *
     * @return SpamDto
     */
    public function setFilterType($filterType)
    {
        $this->filterType = $filterType;

        return $this;
    }
//endregion Getters/Setters
}