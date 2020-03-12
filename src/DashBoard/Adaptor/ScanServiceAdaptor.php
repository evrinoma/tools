<?php


namespace App\DashBoard\Adaptor;


use Evrinoma\DashBoardBundle\Provider\ScanServiceInterface;

/**
 * Class ScanServiceAdaptor
 *
 * @package App\DashBoard\Adaptor
 */
class ScanServiceAdaptor extends DefaultServiceAdaptor implements ScanServiceInterface
{
//region SECTION: Getters/Setters
    public function getProtocol(): string
    {
        return $this->entity->getServiceType()->getType();
    }
//endregion Getters/Setters
}