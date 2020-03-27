<?php


namespace App\DashBoard\Adaptor;

use Evrinoma\DashBoardBundle\Provider\DefaultServiceInterface;
use Evrinoma\SettingsBundle\Entity\Settings;


/**
 * Class DefaultServiceAdaptor
 *
 * @package App\Adaptor
 */
class DefaultServiceAdaptor implements DefaultServiceInterface
{
//region SECTION: Fields
    /**
     * @var Settings
     */
    protected $entity;
//endregion Fields

//region SECTION: Constructor
    public function __construct(Settings $entity)
    {
        $this->entity = $entity->getData();
    }
//endregion Constructor

//region SECTION: Getters/Setters
    public function getName()
    {
        return $this->entity->getDescription()->getName();
    }

    public function getPort()
    {
        return $this->entity->getPort();
    }

    public function getHost()
    {
        return $this->entity->getHost();
    }
//endregion Getters/Setters
}