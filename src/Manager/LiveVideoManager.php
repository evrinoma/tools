<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 1:01 PM
 */

namespace App\Manager;

use App\Core\AbstractEntityManager;
use App\Dto\LiveVideoDto;
use App\Entity\LiveVideo\Group;
use App\Rest\Core\RestTrait;

/**
 * Class LiveVideoManager
 *
 * @package App\Manager
 */
class LiveVideoManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    protected $repositoryClass = Group::class;
//endregion Fields

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param LiveVideoDto $liveVideoDto
     *
     * @return $this
     */
    public function getLiveVideo($liveVideoDto)
    {
        $this->getGroup($liveVideoDto);

        return $this;
    }

    /**
     * @param LiveVideoDto $liveVideoDto
     *
     * @return mixed
     */
    public function getGroup($liveVideoDto)
    {
        $builder = $this->repository->createQueryBuilder('groups');

        $builder->where('groups.active = \'a\'');

        if ($liveVideoDto && $liveVideoDto->getAlias()) {
            $builder->andWhere('groups.alias = :alias')
                ->setParameter('alias', $liveVideoDto->getAlias());
        }

        $this->setData($builder->getQuery()->getResult());

        return $this;
    }
//endregion Getters/Setters
}