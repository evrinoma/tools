<?php

namespace App\Controller;

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
     * @var DashBoardManager
     */
    private $dashBoardManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface         $serializer
     * @param RequestStack                $requestStack
     */
    public function __construct(SerializerInterface $serializer, RequestStack $requestStack)
    {
        parent::__construct($serializer);
        $this->request            = $requestStack->getCurrentRequest();
    }
//endregion Constructor

//region SECTION: Public

    /**
     * @Rest\Get("/api/project/project", options={"expose"=true}, name="api_project")
     * @SWG\Get(tags={"system"})
     * @SWG\Response(response=200,description="Returns projects")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function projectAction()
    {
        return $this->json(['project' => '']);
    }
//endregion Public
}