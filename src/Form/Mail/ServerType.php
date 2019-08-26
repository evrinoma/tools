<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/2/19
 * Time: 8:40 PM
 */

namespace App\Form\Mail;

use App\Dto\FactoryDto;
use App\Dto\ServerDto;
use App\Manager\ServerManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ServerType
 *
 * @package App\Form\Mail
 */
class ServerType extends AbstractType
{


    //region SECTION: Fields
    /**
     * ServerManager.
     */
    private $serverManager;
    /**
     * @var FactoryDto
     */
    private $factoryDto;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     *
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManager
     */
    public function __construct(FactoryDto $factoryDto, ServerManager $serverManager)
    {
        $this->serverManager = $serverManager;
        $this->factoryDto = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $servers = [];
            foreach ($this->serverManager->getServers($this->factoryDto->cloneDto(ServerDto::class))->getData() as $server) {
                $servers[] = $server->getIp();
            }

            return $servers;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'server');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'ServerIp');
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