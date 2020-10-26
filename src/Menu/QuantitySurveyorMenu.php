<?php


namespace App\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\Delta8Bundle\Voter\Delta8RoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Menu\MenuInterface;
use Evrinoma\UtilsBundle\Voter\RoleInterface;

/**
 * Class ProjectMenu
 *
 * @package App\Menu
 */
final class QuantitySurveyorMenu implements MenuInterface
{

    public function create(EntityManagerInterface $em): void
    {
        $project = new MenuItem();
        $project
            ->setRole([RoleInterface::ROLE_DEV_USER])
            ->setName('Project')
            ->setRoute('project')
            ->setTag($this->tag());

        $em->persist($project);

        $contrAgent = new MenuItem();
        $contrAgent
            ->setRole([RoleInterface::ROLE_DEV_USER])
            ->setName('ContrAgent')
            ->setRoute('contr_agent')
            ->setTag($this->tag());

        $em->persist($contrAgent);


        $menuQuantitySurveyor = new MenuItem();
        $menuQuantitySurveyor
            ->setRole([RoleInterface::ROLE_DEV_USER])
            ->setName('QuantitySurveyor')
            ->setUri('#')
            ->addChild($project)
            ->addChild($contrAgent)
            ->setTag($this->tag());

        $em->persist($menuQuantitySurveyor);
    }

    public function order(): int
    {
        return 30;
    }

    public function tag(): string
    {
        return MenuInterface::DEFAULT_TAG;
    }
}