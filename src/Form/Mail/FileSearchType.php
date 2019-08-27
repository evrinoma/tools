<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/21/19
 * Time: 8:40 PM
 */

namespace App\Form\Mail;

use App\Dto\ApartDto\FileDto;
use App\Dto\FactoryDto;
use App\Dto\SettingsDto;
use App\Manager\SettingsManager;
use App\Rest\Form\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FileSearchType
 *
 * @package App\Form\Mail
 */
class FileSearchType extends AbstractType
{

    //region SECTION: Fields
    public const REST_CLASS_ENTITY = 'rest_class_entity';
    /**
     * SettingsManager
     */
    private $settingsManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     */
    public function __construct(FactoryDto $factoryDto, SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
        $this->factoryDto      = $factoryDto;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $fileList = [];
            $class    = $options->offsetGet(self::REST_CLASS_ENTITY);
            if ($class) {
                $dto         = $this->factoryDto->cloneDto($class);
                $settingsDto = $dto->getFactoryAdapter()->setFrom($dto)->setTo(SettingsDto::class)->adapter();

                foreach ($this->settingsManager->getSettings($settingsDto) as $file) {
                    $data = $file->getData();
                    if ($data instanceof FileDto) {
                        /** @var $data FileDto */
                        $fileList[] = $data->getName();
                    }
                }
            }

            return $fileList;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'fileSearch');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'fileSearchList');
        $resolver->setDefault(self::REST_CLASS_ENTITY, null);
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