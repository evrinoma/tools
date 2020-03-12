<?php


namespace App\Adaptor;


use Evrinoma\DashBoardBundle\Plugin\ScanServiceInterface;

class ScanServiceAdaptor extends ServiceAdaptor implements ScanServiceInterface
{
//region SECTION: Getters/Setters
    public function getProtocol(): string
    {
        return $this->entity->getServiceType()->getType();
    }
//endregion Getters/Setters
}