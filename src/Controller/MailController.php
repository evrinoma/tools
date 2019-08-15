<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/4/19
 * Time: 8:06 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MailController
 *
 * @package App\Controller
 */
class MailController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/mail/search", options={"expose"=true}, name="mail_search")
     * @Template("mail/display.html.twig")
     *
     * @return array
     */
    public function mailSearch()
    {
        return ['titleHeader' => 'Mail', 'pageName' => 'System Status'];
    }

    /**
     * @Route("/mail/domain", options={"expose"=true}, name="mail_domain")
     * @Template("mail/display.domain.html.twig")
     *
     * @return array
     */
    public function mailDomain()
    {
        return ['titleHeader' => 'Mail', 'pageName' => 'System Status'];
    }

    /**
     * @Route("/mail/acl", options={"expose"=true}, name="mail_acl")
     * @Template("mail/display.html.twig")
     *
     * @return array
     */
    public function mailAcl()
    {
        return ['titleHeader' => 'Mail', 'pageName' => 'System Status'];
    }
//endregion Public
}