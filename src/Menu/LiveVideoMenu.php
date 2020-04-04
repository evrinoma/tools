<?php


namespace App\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\LiveVideoBundle\Voiter\LiveVideoRoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;
use Evrinoma\UtilsBundle\Voiter\RoleInterface;

/**
 * Class LiveVideoMenu
 *
 * @package App\Menu
 */
final class LiveVideoMenu implements MenuInterface
{

//region SECTION: Public
    public function createMenu(EntityManagerInterface $em): void
    {
        $iparkVideo = new MenuItem();
        $iparkVideo
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, LiveVideoRoleInterface::ROLE_IPARK_VIDEO, LiveVideoRoleInterface::ROLE_VIDEO_ALL])
            ->setName('ipark45')
            ->setRoute('live_video')
            ->setRouteParameters(['groupAlias' => 'live_ipark45']);

        $em->persist($iparkVideo);

        $kzktVideo = new MenuItem();
        $kzktVideo
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, LiveVideoRoleInterface::ROLE_KZKT_VIDEO, LiveVideoRoleInterface::ROLE_VIDEO_ALL])
            ->setName('kzkt45')
            ->setRoute('live_video')
            ->setRouteParameters(['groupAlias' => 'live_kzkt45']);

        $em->persist($kzktVideo);

        $ishimVideo = new MenuItem();
        $ishimVideo
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, LiveVideoRoleInterface::ROLE_ISHIM_VIDEO, LiveVideoRoleInterface::ROLE_VIDEO_ALL])
            ->setName('Ишим')
            ->setRoute('live_video')
            ->setRouteParameters(['groupAlias' => 'live_ishim']);

        $em->persist($ishimVideo);

        $tobolskVideo = new MenuItem();
        $tobolskVideo
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, LiveVideoRoleInterface::ROLE_TOBOLSK_VIDEO, LiveVideoRoleInterface::ROLE_VIDEO_ALL])
            ->setName('Тобольск')
            ->setRoute('live_video')
            ->setRouteParameters(['groupAlias' => 'live_tobolsk']);

        $em->persist($tobolskVideo);

        $vankorVideo = new MenuItem();
        $vankorVideo
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, LiveVideoRoleInterface::ROLE_VANKOR_VIDEO, LiveVideoRoleInterface::ROLE_VIDEO_ALL])
            ->setName('Ванкор')
            ->setRoute('live_video')
            ->setRouteParameters(['groupAlias' => 'live_vankor']);

        $em->persist($vankorVideo);

        $video = new MenuItem();
        $video
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, LiveVideoRoleInterface::ROLE_VIDEO, LiveVideoRoleInterface::ROLE_VIDEO_ALL])
            ->setName('Live Cam')
            ->setUri('#')
            ->addChild($iparkVideo)
            ->addChild($kzktVideo)
            ->addChild($ishimVideo)
            ->addChild($tobolskVideo)
            ->addChild($vankorVideo);

        $em->persist($video);
    }

    public function order(): int
    {
        return 20;
    }
//endregion Public
}