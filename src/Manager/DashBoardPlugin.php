<?php


namespace App\Manager;


use App\Adaptor\ScanServiceAdaptor;
use App\Adaptor\ServiceAdaptor;
use Doctrine\Common\Collections\ArrayCollection;
use Evrinoma\DashBoardBundle\Plugin\PluginInterface;
use Iterator;

class DashBoardPlugin implements PluginInterface
{
//region SECTION: Fields
    /**
     * @var SettingsManager
     */
    private $settingsManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * DashBoardPlugin constructor.
     *
     * @param SettingsManager $settingsManager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }
//endregion Constructor

//region SECTION: Getters/Setters

    /**
     * @inheritDoc
     */
    public function getService(): Iterator
    {
        $services = new ArrayCollection();

        foreach ($this->settingsManager->getSqlServers() as $server)
        {
            $services->add(new ServiceAdaptor($server));
        }

        foreach ($this->settingsManager->getLocalSsh() as $server)
        {
            $services->add(new ScanServiceAdaptor($server));
        }

        return $services->getIterator();
    }
//endregion Getters/Setters
}