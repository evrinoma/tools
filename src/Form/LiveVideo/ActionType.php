<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 9/4/19
 * Time: 11:34 AM
 */

namespace App\Form\LiveVideo;

use App\Manager\LiveControlManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ActionType
 *
 * @package App\Form\LiveVideo
 */
class ActionType extends AbstractType
{
//region SECTION: Fields
    /**
     * @var LiveControlManager
     */
    private $liveControlManager;


//endregion Fields
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     */
    public function __construct(LiveControlManager $liveControlManager)
    {
        $this->liveControlManager = $liveControlManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            return $this->liveControlManager->getModelActions();
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'action');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'actionList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}