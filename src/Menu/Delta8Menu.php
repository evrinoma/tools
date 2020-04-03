<?php


namespace App\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\Delta8Bundle\Voter\Delta8RoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;

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

        $journalRtt = new MenuItem();
        $journalRtt
            ->setRole([Delta8RoleInterface::ROLE_USER_DELTA8])
            ->setName('Rtt')
            ->setRoute('delta_rtt');

        $em->persist($journalRtt);

        $menuDelta = new MenuItem();
        $menuDelta
            ->setRole([Delta8RoleInterface::ROLE_USER_DELTA8])
            ->setName('Delta8')
            ->setUri('#')
            ->addChild($journal)
            ->addChild($journalRtt);

        $em->persist($menuDelta);
    }

    public function order(): int
    {
        return 5;
    }
}