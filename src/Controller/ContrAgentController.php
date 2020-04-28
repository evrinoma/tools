<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContrAgentController
 *
 * @package App\Controller
 */
final class ContrAgentController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/contr_agent", name="quantity_surveyor_contr_agent")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contrAgent()
    {
        $event = ['titleHeader' => 'ContrAgent', 'pageName' => 'ContrAgent'];

        return $this->render('QuantitySurveyor/contr_agent.html.twig', $event);
    }

//endregion Public


}