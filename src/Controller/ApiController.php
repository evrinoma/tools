<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 12:58 PM
 */

namespace App\Controller;


use App\Core\MenuBuilder;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ApiController
 *
 * @package App\Controller
 */
class ApiController extends AbstractController
{
//region SECTION: Public
    /**
     * @Rest\Get("/users", name="users")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     type="string",
     *     description="The field used to order rewards"
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
     * @Rest\Put("/default_menu", name="/default_menu")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of default generated menu"
     * )
     */
    public function generateDefaultMenu(MenuBuilder $menuBuilder)
    {
        $menuBuilder->generateDefaultMenu();

        return $this->json(['message' => 'the Menu was generate successFully']);
    }
//endregion Public
}