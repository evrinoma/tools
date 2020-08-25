<?php

namespace App\Menu;

use App\Voiter\VCardRoleInterface;
use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;

/**
 * Class VCardMenu
 *
 * @package App\Menu
 */
final class VCardMenu implements MenuInterface
{

    public function createMenu(EntityManagerInterface $em): void
    {
        $contact = new MenuItem();
        $contact
            ->setRole([VCardRoleInterface::ROLE_VCARD])
            ->setName('Contact')
            ->setRoute('core_contact');

        $em->persist($contact);
    }

    public function order(): int
    {
        return 25;
    }
}