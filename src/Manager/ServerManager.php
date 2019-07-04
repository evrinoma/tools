<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/3/19
 * Time: 6:59 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Entity\Mail\Server;

/**
 * Class ServerManger
 *
 * @package App\Manager
 */
class ServerManager extends AbstractEntityManager
{

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Server::class;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function createServer()
    {
        return [];
    }

    /**
     * @return Server[]
     */
    public function getServers()
    {
        $criteria = ['active' => 'a'];

        return $this->repository->findBy($criteria);
    }
//endregion Getters/Setters

}