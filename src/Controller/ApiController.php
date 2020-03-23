<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 12:58 PM
 */

namespace App\Controller;


use App\Core\AbstractEntityManager;
use App\Dto\VuetableInterface;
use App\Manager\JournalManager;
use App\Manager\MenuManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 *
 * @package App\Controller
 */
class ApiController extends AbstractController
{


//region SECTION: Fields
    /**
     * @var Serializer
     */
    private $serializer;
    /**
     * @var SerializationContext
     */
    private $serializationContext;
//endregion Fields

//region SECTION: Protected
    protected function json($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        if ($this->serializer) {

            $json = $this->serializer->serialize($data, 'json', $this->serializationContext);

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($data, $status, $headers);
    }
//endregion Protected

//region SECTION: Public


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
        try {
            $data = $journalManager->validate($dataFlow, $date)->findParams()->findDiscretInfo()->getData();
        } catch (\Exception $exception) {
            $data = [];
        }

        return $this->json(['delta_data' => $data]);
    }

    /**
     * @Rest\Get("/api/doc/object", options={"expose"=true}, name="api_delta_object")
     * @SWG\Get(tags={"delta"})
     * @SWG\Response(response=200,description="Returns delta objects")
     *
     * @param Request        $request
     * @param JournalManager $journalManager
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function journalDelptaObjectAction(Request $request, JournalManager $journalManager)
    {
        return $this->json(
            $journalManager->getDeltaObjects(),
            $journalManager->getRestStatus()
        );
    }

    /**
     * @Rest\Get("/internal/menu/create_default", name="api_create_default_menu")
     * @SWG\Get(tags={"menu"})
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

//endregion Public

//region SECTION: Private
    /**
     * @param $name
     *
     * @return $this
     */
    private function setSerializeGroup($name)
    {
        if ($name) {
            $this->serializationContext = SerializationContext::create()->setGroups($name);
        }

        return $this;
    }

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
     * @param SerializerInterface $serializer
     *
     * @required
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
//endregion Getters/Setters
}