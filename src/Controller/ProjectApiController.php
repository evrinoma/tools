<?php

namespace App\Controller;


use App\QuantitySurveyor\Manager\ProjectManager;
use Evrinoma\DashBoardBundle\Manager\DashBoardManager;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ProjectApiController
 *
 * @package App\Controller
 */
final class ProjectApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var Request
     */
    private $request;
    /**
     * @var ProjectManager
     */
    private $projectManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param RequestStack        $requestStack
     */
    public function __construct(SerializerInterface $serializer, RequestStack $requestStack, ProjectManager $projectManager)
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(
                    new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()
                )
            )
            ->build();

        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->projectManager = $projectManager;

    }
//endregion Constructor

//region SECTION: Public

    /**
     * @Rest\Get("/evrinoma/api/quantity_surveyor/project", options={"expose"=true}, name="api_project")
     * @SWG\Get(tags={"quantity_surveyor"})
     * @SWG\Response(response=200,description="Returns projects")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function projectAction()
    {
        return $this->json($this->projectManager->setRestSuccessOk()->getAll(), $this->projectManager->getRestStatus());
    }

    /**
     * @Rest\Get("/evrinoma/api/quantity_surveyor/project/column_defs", options={"expose"=true}, name="api_column_defs_project")
     * @SWG\Get(tags={"quantity_surveyor"})
     * @SWG\Response(response=200,description="Returns column_defs project")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function projectColumnDefsAction()
    {
        return $this->json($this->projectManager->setRestSuccessOk()->getColumnDefs(), $this->projectManager->getRestStatus());
    }
//endregion Public
}