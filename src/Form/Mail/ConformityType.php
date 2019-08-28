<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 11:22 AM
 */

namespace App\Form\Mail;


use App\Dto\FactoryDto;
use App\Dto\SpamDto;
use App\Manager\SpamManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConformityType
 *
 * @package App\Form\Mail
 */
class ConformityType extends AbstractType
{
//region SECTION: Fields
    /**
     * @var FactoryDto
     */
    private $factoryDto;

    /**
     * @var SpamManager
     */
    private $spamManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     *
     * @param FactoryDto  $factoryDto
     * @param SpamManager $spamManager
     */
    public function __construct(FactoryDto $factoryDto, SpamManager $spamManager)
    {
        $this->spamManager = $spamManager;
        $this->factoryDto  = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $conformists = [];
            $spamDto     = $this->factoryDto->cloneDto(SpamDto::class);
            /** @var \App\Entity\Mail\Filter $rule */
            foreach ($this->spamManager->getSpamRuleConformity($spamDto)->getData() as $rule) {
                $conformists[] = $rule->getType();
            }

            return $conformists;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'conformity');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'conformityType');
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