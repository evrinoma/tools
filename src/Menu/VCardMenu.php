<?php

namespace App\Menu;

use App\Voter\VCardRoleInterface;
use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Menu\MenuInterface;

/**
 * Class VCardMenu
 *
 * @package App\Menu
 */
final class VCardMenu implements MenuInterface
{

    public function create(EntityManagerInterface $em): void
    {
        $contact = new MenuItem();
        $contact
            ->setRole([VCardRoleInterface::ROLE_VCARD])
            ->setName('Contact')
            ->setRoute('core_contact')
            ->setTag($this->tag());

        $em->persist($contact);
    }

    public function order(): int
    {
        return 25;
    }

    public function tag(): string
    {
        return MenuInterface::DEFAULT_TAG;
    }
}