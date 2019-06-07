<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/1/18
 * Time: 10:24 AM
 */

namespace App\Controller;


use App\Manager\DashBoardManager;
use App\Manager\JournalManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RouteController
 *
 * @package App\Controller
 */
class RouteController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/status", options={"expose"=true}, name="core_status")
     * @Template("modules/display.html.twig")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return array
     */
    public function status(DashBoardManager $dashBoardManager)
    {
        return ['titleHeader' => 'Administration', 'pageName' => 'System Status'] + $dashBoardManager->getDashBoard();
    }

    /**
     * @Route("/journal", options={"expose"=true}, name="core_journal")
     * @Template("base.html.twig")
     *
     * @return array
     */
    public function journal(JournalManager $journalManager)
    {
        $params = $journalManager->getParams();
        return ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Journal Delta8'];
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
        return ['titleHeader' => 'Site Administration', 'pageName' => 'Setup Module Administration'];
    }
//endregion Public

}