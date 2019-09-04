<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 2:12 PM
 */

namespace App\Dto;

use App\Annotation\Dto;
use App\Entity\LiveVideo\Group;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LiveVideoDto
 *
 * @package App\Dto
 */
class LiveVideoDto extends AbstractFactoryDto
{

//region SECTION: Fields
    private $isEmptyResult  = true;
    private $alias;
    private $serializeGroup = 'restrict';

    /**
     * @Dto(class="App\Dto\LiveStreamsDto")
     * @var LiveStreamsDto
     */
    private $liveStreams;

    /**
     * @Dto(class="App\Dto\LiveControlDto")
     * @var LiveControlDto
     */
    private $liveControl;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return Group::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @return bool
     */
    public function isEmptyResult()
    {
        return $this->isEmptyResult;
    }

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
     * @return string|null
     */
    public function lookingForRequest()
    {
        return null;
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return AbstractFactoryDto
     */
    public function toDto($request)
    {
        $class = $request->get('class');

        if ($class === $this->getClassEntity()) {
            $alias         = $request->get('alias');
            $isEmptyResult = $request->get('isEmptyResult');

            $serializeGroup = $request->get('serializeGroup');

            if ($alias) {
                $this->setAlias($alias);
            }

            if ($isEmptyResult) {
                $this->setIsEmptyResult($isEmptyResult);
            }

            if ($serializeGroup) {
                $this->setSerializeGroup($serializeGroup);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return LiveControlDto
     */
    public function getLiveControl()
    {
        return $this->liveControl;
    }

    /**
     * @return LiveStreamsDto
     */
    public function getLiveStreams()
    {
        return $this->liveStreams;
    }

    /**
     * @return mixed
     */
    public function getSerializeGroup()
    {
        return $this->serializeGroup;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param LiveStreamsDto $liveControl
     *
     * @return LiveVideoDto
     */
    public function setLiveControl($liveControl)
    {
        $this->liveControl = $liveControl;

        return $this;
    }

    /**
     * @param LiveStreamsDto[] $liveStreams
     *
     * @return LiveVideoDto
     */
    public function setLiveStreams($liveStreams)
    {
        $this->liveStreams = $liveStreams;

        return $this;
    }

    /**
     * @param mixed $serializeGroup
     *
     * @return LiveVideoDto
     */
    public function setSerializeGroup($serializeGroup)
    {
        $this->serializeGroup = $serializeGroup;

        return $this;
    }

    /**
     * @param bool $isEmptyResult
     *
     * @return LiveVideoDto
     */
    public function setIsEmptyResult($isEmptyResult)
    {
        $this->isEmptyResult = $isEmptyResult === 'true';

        return $this;
    }

    /**
     * @param mixed $alias
     *
     * @return LiveVideoDto
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }
//endregion Getters/Setters
}