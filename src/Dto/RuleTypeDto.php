<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 3:50 PM
 */

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RuleTypeDto
 *
 * @package App\Dto\ApartDto
 */
class RuleTypeDto extends AbstractFactoryDto
{
    /**
     * @var string
     */
    private $filterType;

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
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto(&$request)
    {
        $filterType = $request->get('type');

        $dto = new self();

        if ($filterType) {
            if (is_array($filterType)) {
                if ($filterType['type']) {
                    $dto->setFilterType($filterType['type']);
                }
            } else {
                $dto->setFilterType($filterType);
            }
        }

        return $dto;
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
     * @return mixed
     */
    public function getFilterType()
    {
        return $this->filterType;
    }

    /**
     * @param mixed $filterType
     *
     * @return RuleTypeDto
     */
    public function setFilterType($filterType)
    {
        $this->filterType = $filterType;

        return $this;
    }
}