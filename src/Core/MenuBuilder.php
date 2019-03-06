<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/4/19
 * Time: 3:38 PM
 */

namespace App\Core;


use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class MenuBuilder
 *
 * @package App\Core
 */
class MenuBuilder
{

//region SECTION: Fields
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;
    /**
     * @var FactoryInterface
     */
    private $factory;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $security)
    {
        $this->factory  = $factory;
        $this->security = $security;
    }
//endregion Constructor

//region SECTION: Public
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('display', ['route' => 'core_display', 'attributes' => ['class' => 'display']]);

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $exim = $menu->addChild('exim', ['route' => 'core_home', 'attributes' => ['class' => 'exim']]);
            $exim->addChild('Search', ['route' => 'core_display']);
            $exim->addChild('ACL', ['route' => 'core_display']);

            $menu->addChild('api_doc', ['route' => 'app.swagger_ui']);
        }

        $menu->addChild('logout', ['route' => 'fos_user_security_logout', 'attributes' => ['class' => 'logout']]);

        return $menu;
    }
//endregion Public
}