<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/4/19
 * Time: 12:13 PM
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RestSelectChoice
 *
 * @package App\Form
 */
class RestChoiceType extends AbstractType
{
//region SECTION: Public
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            $options['rest_component_name'],
            ChoiceType::class,
            [
                'documentation' => [
                    'description' => $options['rest_description'],
                    'in'          => 'body',
                ],
                'choices'       => $options['rest_choices'],
            ]
        )->addViewTransformer(
            new CallbackTransformer(
                function ($value) {
                    // transform the array to a string
                    return $value === '' ? null : $value;
                },
                function ($value) {
                    // transform the string back to an array
                    return $value ?? '';
                }
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['rest_component_name', 'rest_choices', 'rest_description']);
        $resolver->setDefault('compound', true);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return ChoiceType::class;
    }
//endregion Getters/Setters
}