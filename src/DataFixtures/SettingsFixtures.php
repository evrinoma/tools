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
class SettingsFixtures extends AbstractFixtures
{

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $descriptionMysql = new DescriptionService();
        $descriptionMysql
            ->setName('MySql')
            ->setType('sql');

        $settingsMysql = new Settings();
        $settingsMysql
            ->setPort('3306')
            ->setHost('localhost')
            ->setServiceType($descriptionMysql);

        $manager->persist($descriptionMysql);
        $manager->persist($settingsMysql);

        $descriptionSsh = new DescriptionService();
        $descriptionSsh
            ->setName('SSH')
            ->setType('ssh');

        $settingsSsh = new Settings();
        $settingsSsh
            ->setPort('22')
            ->setHost('localhost')
            ->setServiceType($descriptionSsh);

        $manager->persist($descriptionSsh);
        $manager->persist($settingsSsh);

        $manager->flush();
    }
//endregion Public
}