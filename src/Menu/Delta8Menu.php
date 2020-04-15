<?php


namespace App\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\Delta8Bundle\Voiter\Delta8RoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;
use Evrinoma\UtilsBundle\Voiter\RoleInterface;

/**
 * Class Delta8Menu
 *
 * @package App\Menu
 */
final class Delta8Menu implements MenuInterface
{

    public function createMenu(EntityManagerInterface $em): void
    {
        $journal = new MenuItem();
        $journal
            ->setRole([Delta8RoleInterface::ROLE_USER_DELTA8])
            ->setName('Journal')
            ->setRoute('delta_journal');

        $em->persist($journal);

        $journalAgSimple = new MenuItem();
        $journalAgSimple
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Ag Simple')
            ->setRoute('delta_ag_simple');

        $em->persist($journalAgSimple);

        $journalAgTree = new MenuItem();
        $journalAgTree
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Ag Tree')
            ->setRoute('delta_ag_tree');

        $em->persist($journalAgTree);

        $journalHandsonTree = new MenuItem();
        $journalHandsonTree
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Handson Tree')
            ->setRoute('delta_handson_tree');

        $em->persist($journalHandsonTree);

        $menuDelta = new MenuItem();
        $menuDelta
            ->setRole([Delta8RoleInterface::ROLE_USER_DELTA8])
            ->setName('Delta8')
            ->setUri('#')
            ->addChild($journal)
            ->addChild($journalAgSimple)
            ->addChild($journalAgTree)
            ->addChild($journalHandsonTree)
        ;

        $em->persist($menuDelta);
    }

    public function order(): int
    {
        return 5;
    }
}