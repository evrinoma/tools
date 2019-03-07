<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/1/18
 * Time: 10:24 AM
 */

namespace App\Controller;


use App\Core\Core;
use App\Manager\ModuleManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RouteController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/display/{moduleName}", name="core_display")
     * @Template("modules/show.html.twig")
     * @param               $moduleName
     * @param Core          $core
     * @param ModuleManager $module
     *
     * @return array
     */
    public function display($moduleName = '', Core $core, ModuleManager $module)
    {
        return [
            'titleHeader' => 'Site Administration',
            'pageName'    => 'Setup Module Administration',
            'menu'        => $core->getMenuList(),
            'listModules' => $module->getListModules(),
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