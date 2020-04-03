<?php


namespace App\Menu;

use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\DashBoardBundle\Voter\DashBoardRoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;

/**
 * Class DashBoardMenu
 *
 * @package App\Menu
 */
final class DashBoardMenu implements MenuInterface
{

    public function createMenu(EntityManagerInterface $em): void
    {
        $display = new MenuItem();
        $display
            ->setRole([DashBoardRoleInterface::ROLE_STATUS])
            ->setName('Status')
            ->setRoute('dashboard_status');

        $em->persist($display);
    }

    public function order(): int
    {
        return 0;
    }
}