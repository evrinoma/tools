<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/5/19
 * Time: 8:06 PM
 */

namespace App\Controller;


use App\Manager\JournalManager;
use JMS\Serializer\SerializerInterface;
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
     * @Template("delta/display.html.twig")
     *
     * @return array
     */
    public function deltaJournal(JournalManager $journalManager, SerializerInterface $serializer)
    {
        return [
            'titleHeader' => 'Delta8 Administration',
            'pageName'    => 'Journal Delta8',
        ];
    }

    /**
     * @Route("/delta/journal/clear", options={"expose"=true}, name="delta_journal_clear")
     * @Template("delta/display.clear.html.twig")
     *
     * @return array
     */
    public function deltaJournalClear(JournalManager $journalManager)
    {
        return [
            'titleHeader' => 'Delta8 Administration',
            'pageName'    => 'Journal Delta8',
        ];
    }

    /**
     * @Route("/delta/rtt", options={"expose"=true}, name="delta_rtt")
     * @Template("delta/journal.html.twig")
     *
     * @return array
     */
    public function deltaJournalRtt(JournalManager $journalManager)
    {
        return [
            'titleHeader' => 'Delta8 Administration',
            'pageName'    => 'Journal Delta8',
        ];
    }
//endregion Public
}