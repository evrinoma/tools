<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 12:58 PM
 */

namespace App\Controller;


use App\Manager\DashBoardManager;
use App\Manager\JournalManager;
use App\Manager\MenuManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 *
 * @package App\Controller
 */
class ApiController extends AbstractController
{
//region SECTION: Public
    /**
     * @Rest\Get("/internal/users", name="users")
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     type="string",
     *     description="The field used to order rewards"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     */
    public function index()
    {
        return $this->json(
            [
                'message' => 'Welcome to your new controller!',
                'path'    => 'src/Controller/DisplayController.php',
            ]
        );
    }

    /**
     * @Rest\Put("/api/default_menu", name="default_menu")
     * @SWG\Response(response=200,description="Returns the rewards of default generated menu")
     *
     * @param MenuManager $menuManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function generateDefaultMenu(MenuManager $menuManager)
    {
        $menuManager->generateDefaultMenu();

        return $this->json(['message' => 'the Menu was generate successFully']);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/system_status", options={"expose"=true}, name="system_status")
     *
     * @SWG\Response(response=200,description="Returns system status")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getSystemStatus(DashBoardManager $dashBoardManager)
    {
        return $this->json($dashBoardManager->getDashBoard());
    }

    /**
     * @Rest\Get("/api/journal", options={"expose"=true}, name="journal")
     * @SWG\Parameter(
     *     name="date",
     *     in="query",
     *     type="string",
     *     format="date",
     *     pattern="\d{1,2}-\d{1,2}-\d{4}",
     *     default="07-06-2019",
     *     description="Select data by date value"
     * )
     * @SWG\Response(response=200,description="Returns journal delta 8")
     *
     * @param JournalManager $journalManager
     * @param Request        $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getJournal(JournalManager $journalManager, Request $request)
    {

        $date = $request->get('date');
        $data = $journalManager->findParams()->findDataParams($date)->getData();


        return $this->json(['journal' => $data]);
    }
//endregion Getters/Setters
}