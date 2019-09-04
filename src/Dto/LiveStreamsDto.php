<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 9/3/19
 * Time: 5:06 PM
 */

namespace App\Dto;

use App\Entity\LiveVideo\Cam;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LiveStreamsDto
 *
 * @package App\Dto
 */
class LiveStreamsDto extends AbstractFactoryDto
{
//region SECTION: Fields
    private $liveStreams = [];

    private $streams = [];
    /**
     * @var boolean
     */
    private $control = true;
    /**
     * @var
     */
    private $action;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return Cam::class;
    }
//endregion Protected

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

    /**
     * @return string|null
     */
    public function lookingForRequest()
    {
        return 'live_streams';
    }

    /**
     * @param mixed $liveStreams
     *
     * @return LiveStreamsDto
     */
    public function addLiveStream($liveStreams)
    {
        $this->liveStreams[] = $liveStreams;
        $this->streams[]     = &$this->liveStreams[count($this->liveStreams) - 1]['stream'];

        return $this;
    }

    /**
     * @return bool
     */
    public function hasControl(): bool
    {
        return $this->control;
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
            $liveStreams = $request->get('live_streams');

            if (!is_array($liveStreams)) {
                $liveStreams = explode(',', $liveStreams);
                if (is_array($liveStreams)) {
                    foreach ($liveStreams as $cam) {
                        $this->addLiveStream(['stream' => $cam]);
                    }
                }
            }

            $action = $request->get('action');

            if (!is_array($action)) {
                $action = explode(',', $action);
                if (is_array($action)) {
                    $this->setAction(end($action));
                }
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getStreams(): array
    {
        return $this->streams;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getLiveStreams()
    {
        return $this->liveStreams;
    }

    /**
     * @param bool $control
     *
     * @return LiveStreamsDto
     */
    public function setControl(bool $control)
    {
        $this->control = $control;

        return $this;
    }

    /**
     * @param mixed $action
     *
     * @return LiveStreamsDto
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
//endregion Getters/Setters
}