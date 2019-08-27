<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/27/19
 * Time: 4:48 PM
 */

namespace App\Form\Mail;


use App\Dto\DomainDto;
use App\Dto\FactoryDto;
use App\Entity\Mail\Domain;
use App\Manager\DomainManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DomainType
 *
 * @package App\Form\Mail
 */
class DomainType extends AbstractType
{
//region SECTION: Fields

    private $domainManager;
    private $factoryDto;
//endregion Fields

//region SECTION: Constructor
    /**
     * DomainType constructor.
     *
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     */
    public function __construct(FactoryDto $factoryDto, DomainManager $domainManager)
    {
        $this->domainManager = $domainManager;
        $this->factoryDto    = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $domains   = [];
            $domainDto = $this->factoryDto->cloneDto(DomainDto::class);
            /** @var Domain $domain */
            foreach ($this->domainManager->getDomains($domainDto)->getData() as $domain) {
                $domains[] = $domain->getDomainName();
            }

            return $domains;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'domainName');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'domainName');
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