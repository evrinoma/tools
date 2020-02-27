<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/28/19
 * Time: 8:23 PM
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VideoController
 *
 * @package App\Controller
 */
class VideoController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/video/live_ipark45", options={"expose"=true}, name="live_ipark45")
     * @Template("video/display.html.twig")
     *
     * @return array
     */
    public function videoIpark45Action()
    {
        return ['titleHeader' => 'Video', 'pageName' => 'Video Ipark45'];
    }

    /**
     * @Route("/video/live_kzkt45", options={"expose"=true}, name="live_kzkt45")
     * @Template("video/display.html.twig")
     *
     * @return array
     */
    public function videoKzkt45Action()
    {
        return ['titleHeader' => 'Video', 'pageName' => 'Video Kzkt45'];
    }

    /**
     * @Route("/video/live_ishim", options={"expose"=true}, name="live_ishim")
     * @Template("video/display.html.twig")
     *
     * @return array
     */
    public function videoIshimAction()
    {
        return ['titleHeader' => 'Video', 'pageName' => 'Video Ishim'];
    }

    /**
     * @Route("/video/live_tobolsk", options={"expose"=true}, name="live_tobolsk")
     * @Template("video/display.html.twig")
     *
     * @return array
     */
    public function videoTobolskAction()
    {
        return ['titleHeader' => 'Video', 'pageName' => 'Video Tobolsk'];
    }

    /**
     * @Route("/video/live_vankor", options={"expose"=true}, name="live_vankor")
     * @Template("video/display.html.twig")
     *
     * @return array
     */
    public function videoVankorAction()
    {
        return ['titleHeader' => 'Video', 'pageName' => 'Video Vankor'];
    }
//endregion Public
}