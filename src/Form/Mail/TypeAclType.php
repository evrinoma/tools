<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/27/19
 * Time: 4:37 PM
 */

namespace App\Form\Mail;


use App\Manager\AclManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TypeAclType
 *
 * @package App\Form\Mail
 */
class TypeAclType extends AbstractType
{
//region SECTION: Fields

    private $aclManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * TypeAclType constructor.
     *
     * @param AclManager $aclManager
     */
    public function __construct(AclManager $aclManager)
    {
        $this->aclManager = $aclManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $type = [];
            foreach ($this->aclManager->getAclModel()->getData() as $name) {
                $type[] = $name;
            }

            return $type;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'type');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'type');
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