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

        $menu->addChild('display', ['route' => 'core_display']);

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $exim = $menu->addChild('Exim', ['uri' => 'exim']);
            $exim->addChild('Log Search', ['uri' => 'exim#search']);
            $exim->addChild('Edit ACL', ['uri' => 'exim#acl']);

            $menu->addChild('ApiDoc', ['route' => 'app.swagger_ui']);
        }

        $menu->addChild('Logout', ['route' => 'fos_user_security_logout', 'attributes' => ['class' => 'logout']]);

        return $menu;
    }
//endregion Public
}