<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 2:20 PM
 */

namespace App\Form\LiveVideo;

use App\Dto\FactoryDto;
use App\Dto\LiveVideoDto;
use App\Entity\LiveVideo\Group;
use App\Manager\LiveVideoManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GroupType
 *
 * @package App\Form\LiveVideo
 */
class GroupType extends AbstractType
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
            $groups = [];
            $liveVideoDto = $this->factoryDto->cloneDto(LiveVideoDto::class);
            foreach ($this->liveVideoManager->getGroup($liveVideoDto)->getData() as $data) {
                /** @var $data Group */
                $groups[] = $data->getAlias();
            }

            return $groups;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'fileSearch');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'fileSearchList');
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