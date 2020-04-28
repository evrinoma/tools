<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 *
 * @package App\Controller
 */
final class ProjectController extends AbstractController
{
//region SECTION: Public
    /**
     * @Route("/project", name="quantity_surveyor_project")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function project()
    {
        $event = ['titleHeader' => 'Project', 'pageName' => 'Project'];

        return $this->render('QuantitySurveyor/project.html.twig', $event);
    }

//endregion Public
}