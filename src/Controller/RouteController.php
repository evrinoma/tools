<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/1/18
 * Time: 10:24 AM
 */

namespace App\Controller;


use App\Dashboard\DashBoard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RouteController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/status", options={"expose"=true}, name="core_status")
     * @Template("modules/display.html.twig")
     *
     * @return array
     */
    public function status()
    {

        $dashBoard = new DashBoard();

        $sysinfo  = $dashBoard->createInfo()->getSysInfo();
        $procinfo = $dashBoard->getProcInfo()->getProcInfo();

        return [
            'titleHeader' => 'Administration',
            'pageName'    => 'System Status',
            'sysinfo'     => $sysinfo,
            'procinfo'    => $procinfo,
        ];
    }


    /**
     * титуальная страница
     *
     * @Route("/", name="core_home")
     * @Template("base.html.twig")
     *
     * @return array
     */
    public function home()
    {
        return [];
    }

    /**
     * @Route("/", name="encore_display")
     * @Template("encore/show.html.twig")
     *
     * @return array
     */
    public function encore()
    {
        return [
            'titleHeader' => 'Site Administration',
            'pageName'    => 'Setup Module Administration',
        ];
    }
//endregion Public

}