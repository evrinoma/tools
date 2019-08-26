<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 12:58 PM
 */

namespace App\Controller;


use App\Core\AbstractEntityManager;
use App\Dto\AclDto;
use App\Dto\DomainDto;
use App\Dto\FactoryDto;
use App\Dto\LogSearchDto;
use App\Dto\ServerDto;
use App\Dto\VuetableInterface;
use App\Manager\AclManager;
use App\Manager\DashBoardManager;
use App\Manager\DomainManager;
use App\Manager\JournalManager;
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
     *     name="hostname",
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
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function saveDomain(FactoryDto $factoryDto, DomainManager $domainManager, Request $request)
    {
        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);

        return $this->json(
            ['domains' => $domainManager->setRestSuccessOk()->saveDomain($domainDto)],
            $domainManager->getRestStatus()
        );
    }

    /**
     * @Rest\Put("/internal/domain/migrate", name="api_migrate_default_domain")
     * @SWG\Put(tags={"domain"})
     * @SWG\Response(response=200,description="Returns the merge of domains")
     *
     * @param DomainManager $domainManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function migrateDomains(DomainManager $domainManager)
    {
        return $this->json(['domains' => $domainManager->setRestSuccessOk()->megrateDomains()], $domainManager->getRestStatus());
    }

    /**
     * @Rest\Put("/internal/acl/migrate", name="api_migrate_default_acl")
     * @SWG\Put(tags={"acl"})
     * @SWG\Response(response=200,description="Returns the merge of acls")
     *
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function migrateAcls(AclManager $aclManager)
    {
        return $this->json(['acls' => $aclManager->setRestSuccessOk()->megrateAcls()], $aclManager->getRestStatus());
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
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteDomain(FactoryDto $factoryDto, DomainManager $domainManager, Request $request)
    {
        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);

        $domainManager->setRestSuccessOk()->getDomain($domainDto)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $domainManager->getRestStatus());
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
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManger
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function deleteServer(FactoryDto $factoryDto, ServerManager $serverManger, Request $request)
    {
        $serverDto = $factoryDto->setRequest($request)->createDto(ServerDto::class);

        $serverManger->setRestSuccessOk()->getServers($serverDto)->lockEntitys();

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
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManager
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveServer(FactoryDto $factoryDto, ServerManager $serverManager, Request $request)
    {
        $serverDto = $factoryDto->setRequest($request)->createDto(ServerDto::class);

        return $this->json(
            ['servers' => $serverManager->setRestSuccessOk()->saveServer($serverDto)],
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
    public function logSearch(FactoryDto $factoryDto, SearchManager $searchManager, Request $request)
    {
        $logSearch = $factoryDto->setRequest($request)->createDto(LogSearchDto::class);

        return $this->json(
            [
                'search' => $searchManager->setRestSuccessOk()
                    ->setDto($logSearch)
                    ->getSearch()
                    ->getSearchResult(),
            ],
            $searchManager->getRestStatus()
        );
    }

    /**
     * @Rest\GET("/internal/log/settings", name="api_log_settings")
     * @SWG\Get(tags={"log"})
     *
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param SearchManager $searchManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchSettings(FactoryDto $factoryDto, SearchManager $searchManager, Request $request)
    {
        $logSearchDto = $factoryDto->setRequest($request)->createDto(LogSearchDto::class);

        return $this->json(['settings' => $searchManager->setRestSuccessOk()->setDto($logSearchDto)->getSettings()], $searchManager->getRestStatus());
    }

    /**
     * @Rest\Post("/internal/log/settings/save", name="api_save_settings")
     * @SWG\Post(tags={"log"})
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * required=true,
     *      @SWG\Schema(
     *          @SWG\Property(
     *          property="settings",
     *          type="array",
     *          @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="string", ),
     *              @SWG\Property(property="active", type="string",),
     *              ),
     *          ),
     *      ),
     *  ),
     *
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param FactoryDto    $factoryDto
     * @param SearchManager $searchManager
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveSearchSettings(FactoryDto $factoryDto, SearchManager $searchManager, Request $request)
    {
        //  $settingsDto = $factoryDto->setRequest($request)->createDto(SettingsDto::class);

        return $this->json(['settings' => $searchManager->setRestSuccessOk()->saveSettings([])], $searchManager->getRestStatus());
    }
//endregion Public

//region SECTION: Private
    /**
     * @param AbstractEntityManager $manager
     * @param VuetableInterface     $dto
     * @param                       $data
     *
     * @return array
     */
    private function toVuetable($manager, $dto, $data)
    {
        $total = $manager->getCount($dto);

        $vuetableData = $dto ? [
            'total'         => $total,
            'per_page'      => $dto->getPerPage(),
            'current_page'  => $dto->getPage(),
            'last_page'     => ($dto->getPerPage() !== 0) ? intdiv($total, $dto->getPerPage()) + (($total % $dto->getPerPage()) !== 0 ? 1 : 0) : 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from'          => $dto->getPage() * $dto->getPerPage() - $dto->getPerPage() + 1,
            'to'            => $dto->getPage() * $dto->getPerPage(),
            'data'          => $data,
        ] : [
            'total'         => 0,
            'per_page'      => 0,
            'current_page'  => 0,
            'last_page'     => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from'          => 0,
            'to'            => 0,
            'data'          => 0,
        ];

        return $vuetableData;
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/internal/acl/acl", name="api_acl")
     * @SWG\Get(tags={"acl"})
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string",
     *     description="id record"
     * )
     * @SWG\Response(response=200,description="Returns the acl list")
     *
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAcl(FactoryDto $factoryDto, AclManager $aclManager, Request $request)
    {
        $aclDto = $factoryDto->setRequest($request)->createDto(AclDto::class);

        return $this->json($aclManager->setRestSuccessOk()->getAcls($aclDto)->getData(), $aclManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/acl/model", name="api_acl_model")
     * @SWG\Get(tags={"acl"})
     *
     * @SWG\Response(response=200,description="Returns the acl model")
     *
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAclModel(AclManager $aclManager)
    {
        return $this->json($aclManager->setRestSuccessOk()->getAclModel()->getData(), $aclManager->getRestStatus());
    }

    /**
     * @Rest\Post("/internal/acl/save", name="api_acl_save")
     * @SWG\Post(tags={"acl"})
     *
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param FactoryDto $factoryDto
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function getAclSave(FactoryDto $factoryDto, AclManager $aclManager, Request $request)
    {
        $aclDto = $factoryDto->setRequest($request)->createDto(AclDto::class);

        return $this->json(['acl' => $aclManager->setRestSuccessOk()->saveAcl($aclDto)], $aclManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/domain/domain", name="api_domain")
     * @SWG\Get(tags={"domain"})
     *
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDomain(FactoryDto $factoryDto, DomainManager $domainManager, Request $request)
    {
        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);

        return $this->json($domainManager->setRestSuccessOk()->getDomains($domainDto)->getData(), $domainManager->getRestStatus());
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
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDomainByQuery(FactoryDto $factoryDto, DomainManager $domainManager, Request $request)
    {
//        $domainManager
//            ->setPage($request->get('page'))
//            ->setPerPage($request->get('per_page'))
//            ->setFilter($request->get('filter'))
//            ->getDomains();

        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);
        $domainManager->getDomains($domainDto);
        $response = $this->toVuetable($domainManager, $domainDto, $domainManager->getData());

        $domainManager->setRestSuccessOk();

        return $this->json($response, $domainManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/server/server", name="api_server")
     * @SWG\Get(tags={"server"})
     * @SWG\Response(response=200,description="Returns the rewards of all servers")
     *
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManger
     * @param Request       $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function getServer(FactoryDto $factoryDto, ServerManager $serverManger, Request $request)
    {
        $serverDto = $factoryDto->setRequest($request)->createDto(ServerDto::class);

        return $this->json(['servers' => $serverManger->setRestSuccessOk()->getServers($serverDto)->getData()], $serverManger->getRestStatus());
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