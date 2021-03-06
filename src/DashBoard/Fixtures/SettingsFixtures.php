<?php

namespace App\DashBoard\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\SettingsBundle\Std\DescriptionStd;
use Evrinoma\SettingsBundle\Std\ServerStd;
use Evrinoma\SettingsBundle\Dto\ServiceDto;
use Evrinoma\SettingsBundle\Entity\Settings;

/**
 * Class SettingsFixtures
 *
 * @package App\DashBoard\Fixtures
 */
class SettingsFixtures extends Fixture
{

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $description = new DescriptionStd();
        $description
            ->setName('MySql');

        $service = new ServerStd();
        $service
            ->setPort('3306')
            ->setHost('172.18.2.1')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $description = new DescriptionStd();
        $description
            ->setName('SSH')
            ->setInstance('ssh');

        $service = new ServerStd();
        $service
            ->setPort('22')
            ->setHost('localhost')
            ->setType('port')
            ->setDescription($description);

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $manager->flush();
    }
//endregion Public
}