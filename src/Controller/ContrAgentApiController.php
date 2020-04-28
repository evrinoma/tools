<?php

namespace App\Controller;


use App\QuantitySurveyor\Manager\ContrAgentManager;
use Evrinoma\DashBoardBundle\Manager\DashBoardManager;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ContrAgentApiController
 *
 * @package App\Controller
 */
final class ContrAgentApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ContrAgentManager
     */
    private $contrAgentManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param RequestStack        $requestStack
     * @param ContrAgentManager   $contrAgentManager
     */
    public function __construct(SerializerInterface $serializer, RequestStack $requestStack, ContrAgentManager $contrAgentManager)
    {
        parent::__construct($serializer);
        $this->request           = $requestStack->getCurrentRequest();
        $this->contrAgentManager = $contrAgentManager;
    }
//endregion Constructor

//region SECTION: Public

    /**
     * @Rest\Get("/evrinoma/api/quantity_surveyor/contraget", options={"expose"=true}, name="api_contr_agent")
     * @SWG\Get(tags={"quantity_surveyor"})
     * @SWG\Response(response=200,description="Returns projects")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function contrAgentAction()
    {
        return $this->json($this->contrAgentManager->setRestSuccessOk()->getAll(), $this->contrAgentManager->getRestStatus());
    }
//endregion Public
}