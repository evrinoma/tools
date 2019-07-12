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
     * @Rest\Put("/internal/menu/create_default", name="api_create_default_menu")
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
     * @Rest\Delete("/internal/menu/delete", name="api_delete_menu")
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
     * @Rest\Post("/internal/domain/create_default", name="api_create_default_domain")
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
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function createDomain(MailManager $mailManager, Request $request)
    {

        $ip   = $request->get('ip');
        $name = $request->get('name');

        return $this->json(
            ['domains' => $mailManager->setRestSuccessOk()->createDomain($ip, $name)],
            $mailManager->getRestStatus()
        );
    }

    /**
     * @Rest\Put("/internal/domain/merge", name="api_merge_default_domains")
     * @SWG\Put(tags={"domain"})
     * @SWG\Response(response=200,description="Returns the merge of domains")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function migrateDomains(MailManager $mailManager)
    {
        return $this->json(['domains' => $mailManager->setRestSuccessOk()->megrateDomains()], $mailManager->getRestStatus());
    }

    /**
     * @Rest\Post("/internal/servers/create_default", name="api_create_default_server")
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
     *     name="hostname",
     *     in="query",
     *     type="string",
     *     default="mail.ite-ng.ru",
     *     description="hostname server"
     * )
     *
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"hostname": "mail.ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     *
     * @SWG\Response(response=409,description="Generated domain with spme value ip or hostname allready exist",
     *     @SWG\Schema(
     *        type="object",
     *        example={"hostname": "mail.ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     *
     * @param ServerManager $serverManger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function createServer(ServerManager $serverManger, Request $request)
    {
        $ip       = $request->get('ip');
        $hostname = $request->get('hostname');

        return $this->json(['servers' => $serverManger->setRestSuccessOk()->createServer($ip, $hostname)], $serverManger->getRestStatus());
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/internal/domain/domains", name="api_domains")
     * @SWG\Get(tags={"domain"})
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDomain(MailManager $mailManager)
    {
        return $this->json(['domains' => $mailManager->setRestSuccessOk()->getDomains()], $mailManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/servers/servers", name="api_servers")
     * @SWG\Get(tags={"servers"})
     * @SWG\Response(response=200,description="Returns the rewards of all servers")
     *
     * @param ServerManager $serverManger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getServer(ServerManager $serverManger)
    {
        return $this->json(['servers' => $serverManger->setRestSuccessOk()->getServers()], $serverManger->getRestStatus());
    }

    /**
     * @Rest\Get("/api/doc/system_status", options={"expose"=true}, name="api_system_status")
     * @SWG\Get(tags={"system"})
     * @SWG\Response(response=200,description="Returns system status")
     *
     * @param DashBoardManager $dashBoardManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getSystemStatus(DashBoardManager $dashBoardManager)
    {
        return $this->json(['system' => $dashBoardManager->getDashBoard()]);
    }

    /**
     * @Rest\Get("/api/doc/journal", options={"expose"=true}, name="api_delta_journal")
     * @SWG\Get(tags={"delta"})
     * @SWG\Parameter(
     *      name="dataFlow",
     *      in="query",
     *      type="array",
     *      description="Select data by date value",
     *      items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Delta\DataFlowType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="date",
     *     in="query",
     *     type="string",
     *     format="date",
     *     pattern="\d{1,2}-\d{1,2}-\d{4}",
     *     default="13-05-2019",
     *     description="Select data by date value"
     * )
     * @SWG\Response(response=200,description="Returns journal delta")
     *
     * @param JournalManager $journalManager
     * @param Request        $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getJournal(JournalManager $journalManager, Request $request)
    {

        $date = $request->get('date');
        $dataFlow = $request->get('dataFlow');

        $data = $journalManager->validate($dataFlow,$date)->findParams()->findDiscretInfo()->getData();


        return $this->json(['delta_data' => $data]);
    }
//endregion Getters/Setters
}