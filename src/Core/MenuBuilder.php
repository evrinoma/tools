<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/4/19
 * Time: 3:38 PM
 */

namespace App\Core;


use App\Entity\MenuItem;
use App\Manager\VoterManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;

/**
 * Class MenuBuilder
 *
 * @package App\Core
 */
class MenuBuilder
{

//region SECTION: Fields
    /**
     * @var VoterManager
     */
    private $voterManager;
    /**
     * @var FactoryInterface
     */
    private $factory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, VoterManager $voterManager, EntityManagerInterface $entityManager)
    {
        $this->factory       = $factory;
        $this->voterManager  = $voterManager;
        $this->entityManager = $entityManager;
    }
//endregion Constructor
//
//    private function getMenuItems()
//    {
//        return [];
//    }

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

    public function generateDefaultMenu(): void
    {
        $display = new MenuItem();
        $display
            ->setRole('ROLE_USER')
            ->setName('Display')
            ->setRoute('core_display');

        $this->entityManager->persist($display);

        $logout = new MenuItem();
        $logout
            ->setRole('ROLE_USER')
            ->setName('Logout')
            ->setRoute('fos_user_security_logout')
            ->setAttributes(['class' => 'logout']);
        $this->entityManager->persist($logout);

        $eximSearch = new MenuItem();
        $eximSearch
            ->setRole('ROLE_SUPER_ADMIN')
            ->setName('Log Search')
            ->setUri('exim#search');

        $this->entityManager->persist($eximSearch);

        $eximAcl = new MenuItem();
        $eximAcl
            ->setRole('ROLE_SUPER_ADMIN')
            ->setName('Edit ACL')
            ->setUri('exim#acl');

        $this->entityManager->persist($eximAcl);

        $exim = new MenuItem();
        $exim
            ->setRole('ROLE_SUPER_ADMIN')
            ->setName('Exim')
            ->setUri('exim')
            ->addChild($eximSearch)
            ->addChild($eximAcl);

        $this->entityManager->persist($exim);
        $this->entityManager->flush();
    }
//endregion Public
}