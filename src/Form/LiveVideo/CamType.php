<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 9/3/19
 * Time: 4:51 PM
 */

namespace App\Form\LiveVideo;

use App\Dto\FactoryDto;
use App\Dto\LiveVideoDto;
use App\Entity\LiveVideo\Cam;
use App\Entity\LiveVideo\Group;
use App\Manager\LiveVideoManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CamType
 *
 * @package App\Form\LiveVideo
 */
class CamType extends AbstractType
{
//region SECTION: Fields
    /**
     * LiveVideoManager
     */
    private $liveVideoManager;

    /**
     * @var FactoryDto
     */
    private $factoryDto;
//endregion Fields
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     */
    public function __construct(FactoryDto $factoryDto, LiveVideoManager $liveVideoManager)
    {
        $this->liveVideoManager = $liveVideoManager;
        $this->factoryDto       = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $streams      = [];
            $liveVideoDto = $this->factoryDto->cloneDto(LiveVideoDto::class);
            /** @var Group $data */
            foreach ($this->liveVideoManager->getGroup($liveVideoDto)->getData() as $data) {
                /** @var Cam $cam */
                foreach ($data->getLiveStreams() as $cam) {
                    if ($cam->isControl()) {
                        $streams[] = $cam->getStream();
                    }
                }
            }

            return $streams;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'camera');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'cameraList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}