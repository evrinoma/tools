<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/10/19
 * Time: 9:57 AM
 */

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Evrinoma\SettingsBundle\Dto\ApartDto\DescriptionDto;
use Evrinoma\SettingsBundle\Dto\ApartDto\ServerDto;
use Evrinoma\SettingsBundle\Dto\ServiceDto;
use Evrinoma\SettingsBundle\Entity\Settings;

/**
 * Class SettingsFixtures
 *
 * @package App\DataFixtures
 */
class DeltaFixtures extends AbstractFixtures
{

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $descriptionChild = new DescriptionDto();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TAZOVSKIY_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '17112017'));

        $description= new DescriptionDto();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TAZOVSKIY')
            ->addChild($descriptionChild);

        $service = new ServerDto();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $descriptionChild = new DescriptionDto();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('BELOYARSK_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '25032019'));

        $description= new DescriptionDto();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('BELOYARSK')
            ->addChild($descriptionChild);

        $service = new ServerDto();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $descriptionChild = new DescriptionDto();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('KAMENNIY_GPA_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '18032017'));

        $description= new DescriptionDto();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('KAMENNIY_GPA')
            ->addChild($descriptionChild);

        $service = new ServerDto();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $descriptionChild = new DescriptionDto();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG6_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '15042019'));

        $description= new DescriptionDto();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG6')
            ->addChild($descriptionChild);

        $service = new ServerDto();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $descriptionChild = new DescriptionDto();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG8_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '22032018'));

        $description= new DescriptionDto();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG8')
            ->addChild($descriptionChild);

        $service = new ServerDto();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $descriptionChild = new DescriptionDto();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('YARSALE_DATA');

        $description= new DescriptionDto();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('YARSALE')
            ->addChild($descriptionChild);

        $service = new ServerDto();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $manager->persist($settings);

        $manager->flush();
    }
//endregion Public
}