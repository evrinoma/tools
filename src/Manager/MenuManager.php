<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/4/19
 * Time: 3:38 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\MenuItem;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * Class MenuManager
 *
 * @package App\Manager
 */
class MenuManager extends AbstractEntityManager
{
//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = MenuItem::class;
    /**
     * @var VoterManager
     */
    private $voterManager;
    /**
     * @var FactoryInterface
     */
    private $factory;
//endregion Fields

//region SECTION: Constructor
    /**
     * MenuManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param FactoryInterface       $factory
     * @param VoterManager           $voterManager
     */
    public function __construct(EntityManagerInterface $entityManager, FactoryInterface $factory, VoterManager $voterManager)
    {
        parent::__construct($entityManager);
        $this->factory      = $factory;
        $this->voterManager = $voterManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param array $options
     *
     * @return ItemInterface
     */
    public function createMainMenu(array $options)
    {
        $root = $this->factory->createItem('root');

        $items = $this->getMenuItems($root);

        $this->createMenu($root, $items);

        return $root;
    }

    public function deleteDefaultMenu(): void
    {
        $allMenuItems = $this->repository->findAll();
        foreach ($allMenuItems as $menu) {
            $this->entityManager->remove($menu);
        }
        $this->entityManager->flush();
    }

    /**
     *
     */
    public function createDefaultMenu(): void
    {
        $display = new MenuItem();
        $display
            ->setRole(['ROLE_USER'])
            ->setName('Status')
            ->setRoute('core_status');

        $this->entityManager->persist($display);

        $logout = new MenuItem();
        $logout
            ->setRole(['ROLE_USER'])
            ->setName('Logout')
            ->setRoute('fos_user_security_logout')
            ->setAttributes(['class' => 'logout']);
        $this->entityManager->persist($logout);

        $apiDocInternal = new MenuItem();
        $apiDocInternal
            ->setRole(['ROLE_SUPER_ADMIN'])
            ->setName('Internal')
            ->setRoute('app.swagger_ui.internal');
        $this->entityManager->persist($apiDocInternal);

        $apiDoc = new MenuItem();
        $apiDoc
            ->setRole(['ROLE_SUPER_ADMIN', 'ROLE_API'])
            ->setName('ApiDoc')
            ->setUri('#')
            ->addChild($apiDocInternal);

        $this->entityManager->persist($apiDoc);

        $mailSearch = new MenuItem();
        $mailSearch
            ->setRole(['ROLE_SUPER_ADMIN'])
            ->setName('Log Search')
            ->setRoute('mail_search');

        $this->entityManager->persist($mailSearch);

        $mailDomain = new MenuItem();
        $mailDomain
            ->setRole(['ROLE_SUPER_ADMIN'])
            ->setName('Edit Domain')
            ->setRoute('mail_domain');

        $this->entityManager->persist($mailDomain);

        $mailAcl = new MenuItem();
        $mailAcl
            ->setRole(['ROLE_SUPER_ADMIN'])
            ->setName('Edit ACL')
            ->setRoute('mail_acl');

        $this->entityManager->persist($mailAcl);

        $mail = new MenuItem();
        $mail
            ->setRole(['ROLE_SUPER_ADMIN'])
            ->setName('Mail')
            ->setUri('#')
            ->addChild($mailSearch)
            ->addChild($mailDomain)
            ->addChild($mailAcl);

        $this->entityManager->persist($mail);

        $this->entityManager->flush();
    }
//endregion Public

//region SECTION: Private
    /**
     * @param ItemInterface $menuLevel
     * @param MenuItem      $menuItem
     *
     * @return mixed
     */
    private function createItem($menuLevel, $menuItem)
    {
        return $menuLevel->addChild($menuItem->getName(), $menuItem->getOptions());
    }

    /**
     * @param MenuItem[] $items
     */
    private function createMenu($menu, array $items)
    {
        foreach ($items as $menuItem) {
            if ($this->voterManager->checkPermission($menuItem->getRole())) {
                if ($menuItem->hasChildren()) {
                    $menuLevel = $this->createItem($menu, $menuItem);
                    $this->createMenu($menuLevel, $menuItem->getChildren()->getValues());
                } else {
                    $this->createItem($menu, $menuItem);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    private function getMenuItems()
    {
        return $this->repository->findBy(['parent' => null]);
    }
//endregion Private
}