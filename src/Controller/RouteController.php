<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/1/18
 * Time: 10:24 AM
 */

namespace App\Controller;


use App\Manager\ContactManager;
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
     * титуальная страница
     *
     * @Route("/", name="core_home")
     * @Template("base.html.twig")
     *
     * @return array
     */
    public function home()
    {
        return ['titleHeader' => 'Site Administration', 'pageName' => 'Setup Module Administration'];
    }

    /**
     * титуальная страница
     *
     * @Route("/contact", name="core_contact")
     * @Template("modules/contact.html.twig")
     *
     * @param ContactManager $contactManager
     *
     * @return \Endroid\QrCode\Response\QrCodeResponse
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     */
    public function contact(ContactManager $contactManager)
    {
        $qr = $contactManager->getContact($this->getUser());

        return $qr ?: [];
    }

    /**
     * титуальная страница
     *
     * @Route("/clear_cache", name="core_clear_cache")
     * @Template("base.html.twig")
     *
     * @return array
     */
    public function clearCache()
    {
        opcache_reset();
        apcu_clear_cache();

        return [];
    }

//endregion Public

}