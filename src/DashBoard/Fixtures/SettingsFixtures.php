<?php

namespace App\DashBoard\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Evrinoma\SettingsBundle\Dto\ApartDto\DescriptionDto;
use Evrinoma\SettingsBundle\Dto\ApartDto\ServerDto;
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
        $description = new DescriptionDto();
        $description
            ->setName('MySql');

        $service = new ServerDto();
        $service
            ->setPort('3306')
            ->setHost('172.18.2.1')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $description = new DescriptionDto();
        $description
            ->setName('SSH')
            ->setInstance('ssh');

        $service = new ServerDto();
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