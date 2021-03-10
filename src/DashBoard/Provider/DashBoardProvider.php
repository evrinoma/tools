<?php


namespace App\DashBoard\Provider;

use App\DashBoard\Adaptor\DefaultServiceAdaptor;
use App\DashBoard\Adaptor\ScanServiceAdaptor;
use Doctrine\Common\Collections\ArrayCollection;
use Evrinoma\DashBoardBundle\Provider\ProviderInterface;
use Evrinoma\SettingsBundle\Dto\ServiceDto;
use Evrinoma\SettingsBundle\Manager\SettingsManager;
use Evrinoma\SettingsBundle\Std\ServerStd;
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
        $hash     = [];

        foreach ($this->settingsManager->toSettings(new ServiceDto()) as $service) {
            /** @var ServerStd $settings */
            $settings = $service->getData();
            switch ($settings->getType()) {
                case 'orm':
                    if (!in_array($settings->getHost().'_'.$settings->getPort(), $hash, true)) {
                        $hash[] = $settings->getHost().'_'.$settings->getPort();
                        $services->add(new DefaultServiceAdaptor($service));
                    }
                    break;
                case 'port':
                    if (!in_array($settings->getHost().'_'.$settings->getPort(), $hash, true)) {
                        $hash[] = $settings->getHost().'_'.$settings->getPort();
                        $services->add(new ScanServiceAdaptor($service));
                    }
                    break;
            }
        }

        return $services->getIterator();
    }
//endregion Getters/Setters
}