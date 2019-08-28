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
    private $type;

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
                    $dto->setType($filterType['type']);
                }
            } else {
                $dto->setType($filterType);
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return RuleTypeDto
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}