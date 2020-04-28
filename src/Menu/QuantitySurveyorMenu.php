<?php


namespace App\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\Delta8Bundle\Voiter\Delta8RoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;
use Evrinoma\UtilsBundle\Voiter\RoleInterface;

/**
 * Class ProjectMenu
 *
 * @package App\Menu
 */
final class QuantitySurveyorMenu implements MenuInterface
{

    public function createMenu(EntityManagerInterface $em): void
    {
        $project = new MenuItem();
        $project
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('Project')
            ->setRoute('quantity_surveyor_project');

        $em->persist($project);

        $contrAgent = new MenuItem();
        $contrAgent
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('ContrAgent')
            ->setRoute('quantity_surveyor_contr_agent');

        $em->persist($contrAgent);


        $menuQuantitySurveyor = new MenuItem();
        $menuQuantitySurveyor
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN])
            ->setName('QuantitySurveyor')
            ->setUri('#')
            ->addChild($project)
            ->addChild($contrAgent)
        ;

        $em->persist($menuQuantitySurveyor);
    }

    public function order(): int
    {
        return 30;
    }
}