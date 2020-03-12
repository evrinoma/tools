<?php


namespace App\DashBoard\Provider;

use App\DashBoard\Adaptor\ScanServiceAdaptor;
use App\DashBoard\Adaptor\DefaultServiceAdaptor;
use App\Manager\SettingsManager;
use Doctrine\Common\Collections\ArrayCollection;
use Evrinoma\DashBoardBundle\Provider\ProviderInterface;
use Iterator;

/**
 * Class DashBoardProvider
 *
 * @package App\DashBoard\Manager\Provider
 */
class DashBoardProvider implements ProviderInterface
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
            $services->add(new DefaultServiceAdaptor($server));
        }

        foreach ($this->settingsManager->getLocalSsh() as $server)
        {
            $services->add(new ScanServiceAdaptor($server));
        }

        return $services->getIterator();
    }
//endregion Getters/Setters
}