<?php


namespace App\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;
use Evrinoma\UtilsBundle\Voter\RoleInterface;

/**
 * Class EximMenu
 *
 * @package App\Menu
 */
final class EximMenu implements MenuInterface
{

    public function createMenu(EntityManagerInterface $em): void
    {
        $mailSearch = new MenuItem();
        $mailSearch
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Log Search')
            ->setRoute('mail_search');

        $em->persist($mailSearch);

        $mailDomain = new MenuItem();
        $mailDomain
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Edit Domain')
            ->setRoute('mail_domain');

        $em->persist($mailDomain);

        $mailAcl = new MenuItem();
        $mailAcl
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Edit ACL')
            ->setRoute('mail_acl');

        $em->persist($mailAcl);

        $mail = new MenuItem();
        $mail
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Mail')
            ->setUri('#')
            ->addChild($mailSearch)
            ->addChild($mailDomain)
            ->addChild($mailAcl);

        $em->persist($mail);
    }

    public function order(): int
    {
        return 15;
    }
}