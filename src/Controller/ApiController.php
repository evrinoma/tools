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
use App\Dto\SettingsDto;
use App\Dto\SpamDto;
use App\Dto\VuetableInterface;
use App\Manager\AclManager;
use App\Manager\DashBoardManager;
use App\Manager\DomainManager;
use App\Manager\JournalManager;
use App\Manager\MenuManager;
use App\Manager\SearchManager;
use App\Manager\ServerManager;
use App\Manager\SpamManager;
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
     * @Rest\Get("/internal/acl/acl", name="api_acl")
     * @SWG\Get(tags={"acl"})
     * @SWG\Parameter(
     *     name="aclId",
     *     in="query",
     *     type="string",
     *     description="id record"
     * )
     * @SWG\Response(response=200,description="Returns the acl list")
     *
     * @param Request    $request
     * @param FactoryDto $factoryDto
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function aclAction(Request $request, FactoryDto $factoryDto, AclManager $aclManager)
    {
        $aclDto = $factoryDto->setRequest($request)->createDto(AclDto::class);

        return $this->json($aclManager->setRestSuccessOk()->getAcls($aclDto)->getData(), $aclManager->getRestStatus());
    }

    /**
     * @Rest\Put("/internal/acl/import", name="api_import_default_acl")
     * @SWG\Put(tags={"acl"})
     * @SWG\Response(response=200,description="Returns the import of acls")
     *
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function aclImport(AclManager $aclManager)
    {
        return $this->json(['acls' => $aclManager->setRestSuccessOk()->megrateAcls()], $aclManager->getRestStatus());
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
    public function aclModelAction(AclManager $aclManager)
    {
        return $this->json($aclManager->setRestSuccessOk()->getAclModel()->getData(), $aclManager->getRestStatus());
    }

    /**
     * @Rest\Post("/internal/acl/save", name="api_acl_save")
     * @SWG\Post(tags={"acl"})
     * @SWG\Parameter(
     *     name="aclId",
     *     in="query",
     *     type="string",
     *     description="id record"
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="email or domain record"
     * )
     * @SWG\Parameter(
     *     name="type",
     *     in="query",
     *     type="array",
     *     description="black or white",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\TypeAclType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="domainName",
     *     in="query",
     *     type="array",
     *     description="select domain",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\DomainType::class)
     *     )
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param Request    $request
     * @param FactoryDto $factoryDto
     * @param AclManager $aclManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function aclSaveAction(Request $request, FactoryDto $factoryDto, AclManager $aclManager)
    {
        $aclDto = $factoryDto->setRequest($request)->createDto(AclDto::class);

        return $this->json($aclManager->setRestSuccessOk()->saveAcl($aclDto), $aclManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/domain/domain", name="api_domain")
     * @SWG\Get(tags={"domain"})
     *
     * @SWG\Response(response=200,description="Returns the rewards of all generated domains")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainAction(Request $request, FactoryDto $factoryDto, DomainManager $domainManager)
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
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainByQueryAction(Request $request, FactoryDto $factoryDto, DomainManager $domainManager)
    {
        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);
        $domainManager->getDomains($domainDto);
        $response = $this->toVuetable($domainManager, $domainDto, $domainManager->getData());

        $domainManager->setRestSuccessOk();

        return $this->json($response, $domainManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/internal/domain/delete", name="api_delete_domain")
     * @SWG\Delete(tags={"domain"})
     * @SWG\Parameter(
     *     name="domainId",
     *     in="query",
     *     type="string",
     *     default="-1",
     *     description="id record"
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainDeleteAction(Request $request, FactoryDto $factoryDto, DomainManager $domainManager)
    {
        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);

        $domainManager->setRestSuccessOk()->getDomains($domainDto)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $domainManager->getRestStatus());
    }

    /**
     * @Rest\Put("/internal/domain/import", name="api_import_default_domain")
     * @SWG\Put(tags={"domain"})
     * @SWG\Response(response=200,description="Returns the import of domains")
     *
     * @param DomainManager $domainManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function domainImportAction(DomainManager $domainManager)
    {
        return $this->json(['domains' => $domainManager->setRestSuccessOk()->megrateDomains()], $domainManager->getRestStatus());
    }

    /**
     * @Rest\Post("/internal/domain/save", name="api_save_domain")
     * @SWG\Post(tags={"domain"})
     * @SWG\Parameter(
     *  name="hostNameServer",
     *     in="query",
     *     type="array",
     *     description="This is a parameter",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\ServerType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="domainName",
     *     in="query",
     *     type="string",
     *     default="ite-ng.ru",
     *     description="Mail name server"
     * )
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"domainName": "ite29.ite-ng.ru", "ip": "172.20.1.4"}
     *     )
     * )
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param DomainManager $domainManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function domainSaveAction(Request $request, FactoryDto $factoryDto, DomainManager $domainManager)
    {
        $domainDto = $factoryDto->setRequest($request)->createDto(DomainDto::class);

        return $this->json(
            ['domains' => $domainManager->setRestSuccessOk()->saveDomain($domainDto)],
            $domainManager->getRestStatus()
        );
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
     * @param Request        $request
     * @param JournalManager $journalManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function journalAction(Request $request, JournalManager $journalManager)
    {

        $date     = $request->get('date');
        $dataFlow = $request->get('dataFlow');

        $data = $journalManager->validate($dataFlow, $date)->findParams()->findDiscretInfo()->getData();


        return $this->json(['delta_data' => $data]);
    }

    /**
     * @Rest\Get("/internal/log/search", name="api_log_search")
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
     *         @Model(type=App\Form\Mail\FileSearchType::class, options={"rest_class_entity":"App\Dto\LogSearchDto"})
     *     )
     * )
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param SearchManager $searchManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchAction(Request $request, FactoryDto $factoryDto, SearchManager $searchManager)
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
     * @Rest\Get("/internal/log/settings", name="api_log_settings")
     * @SWG\Get(tags={"log"})
     *
     * @SWG\Response(response=200,description="Returns nothing")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param SearchManager $searchManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchSettingsAction(Request $request, FactoryDto $factoryDto, SearchManager $searchManager)
    {
        $logSearchDto = $factoryDto->setRequest($request)->createDto(LogSearchDto::class);

        return $this->json(['settings' => $searchManager->setRestSuccessOk()->setDto($logSearchDto)->getSettings(), 'classEntity' => LogSearchDto::class], $searchManager->getRestStatus());
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
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param SearchManager $searchManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logSearchSettingsSaveAction(Request $request, FactoryDto $factoryDto, SearchManager $searchManager)
    {
        $settingsDto = $factoryDto->setRequest($request)->createDto(SettingsDto::class);

        return $this->json(['settings' => $searchManager->setRestSuccessOk()->setDto($settingsDto)->saveSettings()], $searchManager->getRestStatus());
    }

    /**
     * @Rest\Put("/internal/menu/create_default", name="api_create_default_menu")
     * @SWG\Put(tags={"menu"})
     * @SWG\Response(response=200,description="Returns the rewards of default generated menu")
     *
     * @param MenuManager $menuManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuCreateDefaultAction(MenuManager $menuManager)
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
    public function menuDeleteAction(MenuManager $menuManager)
    {
        $menuManager->deleteDefaultMenu();

        return $this->json(['message' => 'the Menu was delete successFully']);
    }

    /**
     * @Rest\Get("/internal/server/server", name="api_server")
     * @SWG\Get(tags={"server"})
     * @SWG\Response(response=200,description="Returns the rewards of all servers")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function serverAction(Request $request, FactoryDto $factoryDto, ServerManager $serverManger)
    {
        $serverDto = $factoryDto->setRequest($request)->createDto(ServerDto::class);

        return $this->json(['servers' => $serverManger->setRestSuccessOk()->getServers($serverDto)->getData()], $serverManger->getRestStatus());
    }

    /**
     * @Rest\Delete("/internal/server/delete", name="api_delete_server")
     * @SWG\Delete(tags={"server"})
     * @SWG\Parameter(
     *  name="hostNameServer",
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
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function serverDeleteAction(Request $request, FactoryDto $factoryDto, ServerManager $serverManger)
    {
        $serverDto = $factoryDto->setRequest($request)->createDto(ServerDto::class);

        $serverManger->setRestSuccessOk()->getServers($serverDto)->lockEntitys();

        return $this->json(['message' => 'the Domain was delete successFully'], $serverManger->getRestStatus());
    }

    /**
     * @Rest\Post("/internal/server/save", name="api_save_server")
     * @SWG\Post(tags={"server"})
     * @SWG\Parameter(
     *     name="idServer",
     *     in="query",
     *     type="string",
     *     default=null,
     *     description="id server"
     * )
     * @SWG\Parameter(
     *     name="ipServer",
     *     in="query",
     *     type="string",
     *     pattern="\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}",
     *     default="172.20.1.4",
     *     description="ip server"
     * )
     * @SWG\Parameter(
     *     name="hostNameServer",
     *     in="query",
     *     type="string",
     *     default="mail.ite-ng.ru",
     *     description="hostname server"
     * )
     * @SWG\Response(response=200,description="Returns the rewards of default generated domain",
     *     @SWG\Schema(
     *        type="object",
     *        example={"hostNameServer": "ite-ng.ru", "ipServer": "172.20.1.4"}
     *     )
     * )
     * @SWG\Response(response=400,description="set ip and name domain")
     *
     * @param Request       $request
     * @param FactoryDto    $factoryDto
     * @param ServerManager $serverManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function serverSaveAction(Request $request, FactoryDto $factoryDto, ServerManager $serverManager)
    {
        $serverDto = $factoryDto->setRequest($request)->createDto(ServerDto::class);

        return $this->json(
            ['servers' => $serverManager->setRestSuccessOk()->saveServer($serverDto)],
            $serverManager->getRestStatus()
        );
    }

    /**
     * @Rest\Get("/internal/spam/rules", name="api_spam_rules")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules")
     * @SWG\Parameter(
     *     name="filterType",
     *     in="query",
     *     type="array",
     *     description="select spam filter type",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\FilterType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="conformityType",
     *     in="query",
     *     type="array",
     *     description="select spam conformity type",
     *     items=@SWG\Items(
     *         type="string",
     *         @Model(type=App\Form\Mail\ConformityType::class)
     *     )
     * )
     * @param Request     $request
     * @param FactoryDto  $factoryDto
     * @param SpamManager $spamManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesAction(Request $request, FactoryDto $factoryDto, SpamManager $spamManager)
    {
        $spamDto = $factoryDto->setRequest($request)->createDto(SpamDto::class);

        return $this->json($spamManager->setRestSuccessOk()->getSpamRules($spamDto)->getData(), $spamManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/spam/conformity", name="api_spam_rules_conformity")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules conformity")
     *
     * @param Request     $request
     * @param FactoryDto  $factoryDto
     * @param SpamManager $spamManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesConformityAction(Request $request, FactoryDto $factoryDto, SpamManager $spamManager)
    {
        $spamDto = $factoryDto->setRequest($request)->createDto(SpamDto::class);

        return $this->json($spamManager->setRestSuccessOk()->getSpamRuleConformity($spamDto)->getData(), $spamManager->getRestStatus());
    }

    /**
     * @Rest\Put("/internal/spam/import", name="api_import_default_spam")
     * @SWG\Put(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the import of spam rules")
     *
     * @param SpamManager $spamManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesImportAction(SpamManager $spamManager)
    {
        return $this->json(['spam' => $spamManager->setRestSuccessOk()->megrateSpamRules()], $spamManager->getRestStatus());
    }

    /**
     * @Rest\Get("/internal/spam/rules_type", name="api_spam_rules_type")
     * @SWG\Get(tags={"spam"})
     * @SWG\Response(response=200,description="Returns the spam rules types")
     *
     * @param Request     $request
     * @param FactoryDto  $factoryDto
     * @param SpamManager $spamManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function spamRulesTypeAction(Request $request, FactoryDto $factoryDto, SpamManager $spamManager)
    {
        $spamDto = $factoryDto->setRequest($request)->createDto(SpamDto::class);

        return $this->json($spamManager->setRestSuccessOk()->getSpamRuleType($spamDto)->getData(), $spamManager->getRestStatus());
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
    public function systemStatusAction(DashBoardManager $dashBoardManager)
    {
        return $this->json(['system' => $dashBoardManager->getDashBoard()]);
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
}