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
use App\Manager\MailManager;
use App\Manager\MenuManager;
use App\Manager\ServerManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
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
     * @SWG\Get(tags={"users"})
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
     * @Rest\Put("/internal/menu/create_default", name="create_default_menu")
     * @SWG\Put(tags={"menu"})
     * @SWG\Response(response=200,description="Returns the rewards of default generated menu")
     *
     * @param MenuManager $menuManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createDefaultMenu(MenuManager $menuManager)
    {
        $menuManager->createDefaultMenu();

        return $this->json(['message' => 'the Menu was generate successFully']);
    }

    /**
     * @Rest\Delete("/internal/menu/delete", name="delete_menu")
     * @SWG\Delete(tags={"menu"})
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param MenuManager $menuManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteMenu(MenuManager $menuManager)
    {
        $menuManager->deleteDefaultMenu();

        return $this->json(['message' => 'the Menu was delete successFully']);
    }

    /**
     * @Rest\Post("/internal/domain/create_default", name="create_default_domain")
     *
     * @SWG\Post(tags={"domain"})
     * @SWG\Parameter(
     *  name="ip",
     *     in="query",
     *     type="array",
     *     description="This is a parameter",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\ServerType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     default="ite-ng.ru",
     *     description="Mail name server"
     * )
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"name": "ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createDomain(MailManager $mailManager, Request $request)
    {

        $ip   = $request->get('ip');
        $name = $request->get('name');

        return $this->json(['domains' => $mailManager->createDomain()], $mailManager->getRestStatus());
    }

    /**
     * @Rest\Put("/internal/domain/merge", name="merge_default_domains")
     * @SWG\Put(tags={"domain"})
     * @SWG\Response(response=200,description="Returns the merge of domains")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function migrateDomains(MailManager $mailManager)
    {
        return $this->json(['domains' => $mailManager->megrateDomains()]);
    }

    /**
     * @Rest\Post("/internal/servers/create_default", name="create_default_server")
     *
     * @SWG\Post(tags={"servers"})
     * @SWG\Parameter(
     *     name="ip",
     *     in="query",
     *     type="string",
     *     pattern="\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}",
     *     default="172.20.1.4",
     *     description="ip server"
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     default="mail.ite-ng.ru",
     *     description="name server"
     * )
     *
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"name": "mail.ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     *
     * @param ServerManager $serverManger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createServer(ServerManager $serverManger, Request $request)
    {
        $ip   = $request->get('ip');
        $name = $request->get('name');

        return $this->json(['server' => $serverManger->createServer()]);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/internal/domain/domains", name="domains")
     * @SWG\Get(tags={"domain"})
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDomain(MailManager $mailManager)
    {
        return $this->json(['domains' => $mailManager->getDomains()]);
    }

    /**
     * @Rest\Get("/internal/servers/servers", name="servers")
     * @SWG\Get(tags={"servers"})
     * @SWG\Response(response=200,description="Returns the rewards of all servers")
     *
     * @param ServerManager $serverManger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getServer(ServerManager $serverManger)
    {
        return $this->json(['server' => $serverManger->getServers()]);
    }

    /**
     * @Rest\Get("/api/doc/system_status", options={"expose"=true}, name="system_status")
     * @SWG\Get(tags={"system"})
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
     * @Rest\Get("/api/doc/journal", options={"expose"=true}, name="journal")
     * @SWG\Get(tags={"delta8"})
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