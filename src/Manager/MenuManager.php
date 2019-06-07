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

    /**
     *
     */
    public function generateDefaultMenu(): void
    {
        $display = new MenuItem();
        $display
            ->setRole('ROLE_USER')
            ->setName('Status')
            ->setRoute('core_status');

        $this->entityManager->persist($display);

        $journal = new MenuItem();
        $journal
            ->setRole('ROLE_USER')
            ->setName('Journal')
            ->setRoute('core_journal');

        $this->entityManager->persist($journal);

        $logout = new MenuItem();
        $logout
            ->setRole('ROLE_USER')
            ->setName('Logout')
            ->setRoute('fos_user_security_logout')
            ->setAttributes(['class' => 'logout']);
        $this->entityManager->persist($logout);

        $apiDoc = new MenuItem();
        $apiDoc
            ->setRole('ROLE_SUPER_ADMIN')
            ->setName('ApiDoc')
            ->setRoute('app.swagger_ui');

        $this->entityManager->persist($apiDoc);

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
                    $this->createMenu($menuLevel, $menuItem->getChildren());
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