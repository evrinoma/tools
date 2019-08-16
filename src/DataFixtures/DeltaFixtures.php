<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/10/19
 * Time: 9:57 AM
 */

namespace App\DataFixtures;


use App\Entity\DescriptionService;
use App\Entity\Settings;
use Doctrine\Common\Persistence\ObjectManager;

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
        $descriptionChildMssql = new DescriptionService();
        $descriptionChildMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('TAZOVSKIY_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '17112017'));

        $descriptionMssql = new DescriptionService();
        $descriptionMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('TAZOVSKIY')
            ->addChild($descriptionChildMssql);


        $settingsMssql = new Settings();
        $settingsMssql
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType(DescriptionService::class)
            ->setServiceType($descriptionMssql)
            ->setRemote();

        $manager->persist($descriptionMssql);
        $manager->persist($descriptionChildMssql);
        $manager->persist($settingsMssql);


        $descriptionChildMssql = new DescriptionService();
        $descriptionChildMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('BELOYARSK_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '25032019'));

        $descriptionMssql = new DescriptionService();
        $descriptionMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('BELOYARSK')
            ->addChild($descriptionChildMssql);

        $settingsMssql = new Settings();
        $settingsMssql
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType(DescriptionService::class)
            ->setServiceType($descriptionMssql)
            ->setRemote();

        $manager->persist($descriptionMssql);
        $manager->persist($descriptionChildMssql);
        $manager->persist($settingsMssql);


        $descriptionChildMssql = new DescriptionService();
        $descriptionChildMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('KAMENNIY_GPA_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '18032017'));

        $descriptionMssql = new DescriptionService();
        $descriptionMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('KAMENNIY_GPA')
            ->addChild($descriptionChildMssql);

        $settingsMssql = new Settings();
        $settingsMssql
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType(DescriptionService::class)
            ->setServiceType($descriptionMssql)
            ->setRemote();

        $manager->persist($descriptionMssql);
        $manager->persist($descriptionChildMssql);
        $manager->persist($settingsMssql);

        $descriptionChildMssql = new DescriptionService();
        $descriptionChildMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('TG6_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '15042019'));

        $descriptionMssql = new DescriptionService();
        $descriptionMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('TG6')
            ->addChild($descriptionChildMssql);

        $settingsMssql = new Settings();
        $settingsMssql
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType(DescriptionService::class)
            ->setServiceType($descriptionMssql)
            ->setRemote();

        $manager->persist($descriptionMssql);
        $manager->persist($descriptionChildMssql);
        $manager->persist($settingsMssql);

        $descriptionChildMssql = new DescriptionService();
        $descriptionChildMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('TG8_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '22032018'));

        $descriptionMssql = new DescriptionService();
        $descriptionMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('TG8')
            ->addChild($descriptionChildMssql);

        $settingsMssql = new Settings();
        $settingsMssql
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType(DescriptionService::class)
            ->setServiceType($descriptionMssql)
            ->setRemote();

        $manager->persist($descriptionMssql);
        $manager->persist($descriptionChildMssql);
        $manager->persist($settingsMssql);

        $descriptionChildMssql = new DescriptionService();
        $descriptionChildMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('YARSALE_DATA');

        $descriptionMssql = new DescriptionService();
        $descriptionMssql
            ->setName('MsSql')
            ->setType('sql')
            ->setInstance('DCSRV01')
            ->setDescription('YARSALE')
            ->addChild($descriptionChildMssql);

        $settingsMssql = new Settings();
        $settingsMssql
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType(DescriptionService::class)
            ->setServiceType($descriptionMssql)
            ->setRemote();

        $manager->persist($descriptionMssql);
        $manager->persist($descriptionChildMssql);
        $manager->persist($settingsMssql);

        $manager->flush();
    }
//endregion Public
}