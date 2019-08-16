<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/16/19
 * Time: 5:29 PM
 */

namespace App\DataFixtures;

use App\Dto\FileDto;
use App\Entity\Settings;
use App\Manager\SearchManager;
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
        'main.6'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.7'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.4'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.1'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.6'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.7'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.2'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.2'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.log'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.7'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.4'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.4'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.log'       => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.3'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.6'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.5'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.log'        => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'panic.5'          => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.5'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.3'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.2'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.3'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'reject.1'         => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'main.1'           => '/opt/WWW/container.ite-ng.ru/logs/exim/var/log/',
        'spamd.7'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.log' => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.5'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.4'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.6'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.4'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.7'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.log'        => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.2'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.6'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.1'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.5'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.3'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.2'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'greylist_dbg.1'   => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
        'spamd.3'          => '/opt/WWW/container.ite-ng.ru/logs/exim/tmp/',
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
                ->setType(SearchManager::class);

            $manager->persist($settingFile);
        }


        $manager->flush();
    }
}