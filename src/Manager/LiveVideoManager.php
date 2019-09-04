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
use App\Entity\LiveVideo\Cam;
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
    /**
     * @return int
     */
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
     * @return LiveVideoManager
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

    /**
     * @param LiveVideoDto $liveVideoDto
     *
     * @return LiveVideoManager
     */
    public function getCamera($liveVideoDto)
    {
        $repository = $this->entityManager->getRepository(Cam::class);

        $builder = $repository->createQueryBuilder('cams');

        $builder
            ->where('cams.active = \'a\'')
            ->leftJoin('cams.group', 'group');

        if ($liveVideoDto && $liveVideoDto->getLiveStreams()) {
            $streams = $liveVideoDto->getLiveStreams()->getStreams();
            if ($streams) {
                $builder->andWhere('cams.stream IN (:streams)')
                    ->setParameter('streams', $streams);
            }
        }

        if ($liveVideoDto && $liveVideoDto->getLiveStreams()) {
            $builder->andWhere('cams.control = :control')
                ->setParameter('control', $liveVideoDto->getLiveStreams()->hasControl());
        }


        $this->setData($builder->getQuery()->getResult());

        return $this;
    }


    /**
     * @param LiveVideoDto|null $dto
     *
     * @return mixed
     */
    public function getData($dto = null)
    {
        if ($dto && $dto->isEmptyResult() && !$this->hasSingleData()) {
            return [];
        } else {
            return parent::getData();
        }
    }


//endregion Getters/Setters
}