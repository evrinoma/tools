<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/5/19
 * Time: 8:06 PM
 */

namespace App\Controller;


use App\Manager\JournalManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeltaController
 *
 * @package App\Controller
 */
class DeltaController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/delta/journal", options={"expose"=true}, name="delta_journal")
     * @Template("mail/display.html.twig")
     *
     * @return array
     */
    public function deltaJournal(JournalManager $journalManager)
    {
        return ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Journal Delta8', 'journal' => $journalManager->validate('TAZOVSKIY', '07-06-2019')->findParams()->findDataParams()->getData()];
    }
//endregion Public
}