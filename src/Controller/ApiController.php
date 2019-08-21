<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 12:58 PM
 */

namespace App\Controller;


use App\Core\AbstractEntityManager;
use App\Manager\DashBoardManager;
use App\Manager\JournalManager;
use App\Manager\MailManager;
use App\Manager\MenuManager;
use App\Manager\SearchManager;
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
     * @Rest\Post("/internal/domain/save", name="api_save_domain")
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
    public function saveDomain(MailManager $mailManager, Request $request)
    {
        $ip   = $request->get('ip');
        $name = $request->get('name');

        return $this->json(
            ['domains' => $mailManager->setRestSuccessOk()->saveDomain($ip, $name)],
            $mailManager->getRestStatus()
        );
    }

    /**
     * @Rest\Put("/internal/domain/merge", name="api_merge_default_domain")
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
     * @Rest\Delete("/internal/domain/delete", name="api_delete_domain")
     * @SWG\Delete(tags={"domain"})
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string",
     *     default="-1",
     *     description="id record"
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param MailManager $mailManager
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteDomain(MailManager $mailManager, Request $request)
    {
        $id   = $request->get('id');
        $ip   = $request->get('ip');
        $name = $request->get('name');

        $mailManager->setRestSuccessOk()->getDomain($id)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $mailManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/internal/server/delete", name="api_delete_server")
     * @SWG\Delete(tags={"server"})
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
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param ServerManager $serverManger
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function deleteServer(ServerManager $serverManger, Request $request)
    {
        $ip = $request->get('ip');

        $serverManger->setRestSuccessOk()->getServer($ip)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $serverManger->getRestStatus());
    }


    /**
     * @Rest\Post("/internal/server/save", name="api_save_server")
     * @SWG\Post(tags={"server"})
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
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"name": "ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @param ServerManager $serverManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function saveServer(ServerManager $serverManager, Request $request)
    {
        $ip   = $request->get('ip');
        $name = $request->get('name');

        return $this->json(
            ['servers' => $serverManager->setRestSuccessOk()->saveServer($ip, $name)],
            $serverManager->getRestStatus()
        );
    }

    /**
     * @Rest\GET("/internal/log/search", name="api_log_search")
     * @SWG\Get(tags={"log"})
     * @SWG\Parameter(
     *     name="searchString",
     *     in="query",
     *     type="string",
     *     default="@ite-ng.ru",
     *     description="search for"
     * )
     * @SWG\Parameter(
     *     name="searchFile",
     *     in="query",
     *     type="array",
     *     description="search there",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\FileSearchType::class, options={"rest_class_type":"App\Manager\SearchManager"})
     *     )
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param SearchManager $searchManager
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearch(SearchManager $searchManager, Request $request)
    {
        $searchString = $request->get('searchString');
        $searchFile   = $request->get('searchFile');


        return $this->json(['message' => $searchManager->setSearchString($searchString)->setSearchFile($searchFile)->getSearch()->getSearchResult()], $searchManager->getRestStatus());
    }
//endregion Public

//region SECTION: Private
    /**
     * @param AbstractEntityManager $manager
     * @param                       $perPage
     * @param                       $page
     * @param                       $data
     *
     * @return array
     */
    private function toVuetable($manager, $perPage, $page, $data)
    {
        $total = $manager->getCount();

        return [
            'total'         => $total,
            'per_page'      => $perPage,
            'current_page'  => $page,
            'last_page'     => ($perPage !== 0) ? intdiv($total, $perPage) + (($total % $perPage) !== 0 ? 1 : 0) : 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from'          => $page * $perPage - $perPage + 1,
            'to'            => $page * $perPage,
            'data'          => $data,
        ];
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/internal/domain/domain", name="api_domain")
     * @SWG\Get(tags={"domain"})
     *
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDomain(MailManager $mailManager, Request $request)
    {
        return $this->json($mailManager->setRestSuccessOk()->getDomains(), $mailManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/domain/query", name="api_query_domain")
     * @SWG\Get(tags={"domain"})
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     default="1",
     *     description="page number"
     * )
     * @SWG\Parameter(
     *     name="per_page",
     *     in="query",
     *     type="integer",
     *     default="0",
     *     description="per page records"
     * )
     * @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     type="string",
     *     default="",
     *     description="filter by domain or mx"
     * )
     *
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @param MailManager $mailManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDomainByQuery(MailManager $mailManager, Request $request)
    {
        $mailManager
            ->setPage($request->get('page'))
            ->setPerPage($request->get('per_page'))
            ->setFilter($request->get('filter'))
            ->getDomains();

        $response = $this->toVuetable($mailManager, $mailManager->getPerPage(), $mailManager->getPage(), $mailManager->getData());

        $mailManager->setRestSuccessOk();

        return $this->json($response, $mailManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/server/server", name="api_server")
     * @SWG\Get(tags={"server"})
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

        $date     = $request->get('date');
        $dataFlow = $request->get('dataFlow');

        $data = $journalManager->validate($dataFlow, $date)->findParams()->findDiscretInfo()->getData();


        return $this->json(['delta_data' => $data]);
    }
//endregion Getters/Setters
}