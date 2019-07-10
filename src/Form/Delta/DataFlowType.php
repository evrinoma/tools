<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/2/19
 * Time: 8:40 PM
 */

namespace App\Form\Delta;

use App\Entity\DescriptionService;
use App\Manager\SettingsManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DataFlowType
 *
 * @package App\Form\Delta
 */
class DataFlowType extends AbstractType
{


    //region SECTION: Fields
    /**
     * ServerManager.
     */
    private $settingsManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $servers = [];
            /** @var DescriptionService $server */
            foreach ($this->settingsManager->getDeltaServices() as $server) {
                $servers[] = $server->getDescription();
            }

            return $servers;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'dataflow');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'Delta Data Server');
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