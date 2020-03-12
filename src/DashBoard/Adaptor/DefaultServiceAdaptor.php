<?php


namespace App\DashBoard\Adaptor;


use App\Entity\Settings;
use Evrinoma\DashBoardBundle\Provider\DefaultServiceInterface;


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
        $this->entity = $entity;
    }
//endregion Constructor

//region SECTION: Getters/Setters
    public function getName()
    {
        return $this->entity->getServiceType()->getName();
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