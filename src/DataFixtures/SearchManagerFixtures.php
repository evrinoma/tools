<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/16/19
 * Time: 5:29 PM
 */

namespace App\DataFixtures;

use App\Dto\ApartDto\FileDto;
use App\Dto\LogSearchDto;
use App\Entity\Settings;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class SearchManagerFixtures
 *
 * @package App\DataFixtures
 */
class SearchManagerFixtures extends AbstractFixtures
{

//region SECTION: Fields
    private $files = [
        'main.log'     => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.1'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.2'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.3'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.4'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.5'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.6'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log.7'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log'   => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.1' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.2' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.3' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.4' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.5' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.6' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log.7' => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.log'    => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.1'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.2'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.3'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.4'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.5'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.6'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log.7'  => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'panic.log'    => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.1'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.2'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.3'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.4'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.5'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.6'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log.7'  => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
//        'greylist_dbg.7'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.6'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.5'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.4'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.3'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.2'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.1'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
//        'greylist_dbg.log' => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
    ];
//endregion Fields
//region SECTION: Public

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        foreach ($this->files as $name => $filePath) {
            $file = new FileDto();

            $settingFile = new Settings();
            $settingFile
                ->setData($file->setName($name)->setPath($filePath))
                ->setType(LogSearchDto::class);

            $manager->persist($settingFile);
        }


        $manager->flush();
    }
}