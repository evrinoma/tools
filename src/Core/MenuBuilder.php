<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/4/19
 * Time: 3:38 PM
 */

namespace App\Core;


use Knp\Menu\FactoryInterface;

class MenuBuilder
{

    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('display', ['route' => 'core_display']);

        $menu->addChild('logout', ['route' => 'fos_user_security_logout']);

        // ... add more children

        return $menu;
    }
}