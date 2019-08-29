<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;


use App\Entity\Mail\Server;
use App\Entity\Model\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerDto
 *
 * @package App\Dto
 */
class ServerDto extends AbstractFactoryDto
{
    use ActiveTrait;

//region SECTION: Fields
    private $ip;
    private $hostName;
    private $id;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected static function getClassEntity()
    {
        return Server::class;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @param Server $entity
     *
     * @return mixed
     */
    public function fillEntity($entity)
    {
        $entity->setIp($this->getIp())->setHostname($this->getHostName())->setActive();

        return $entity;
    }

    /**
     * @return bool
     */
    public function isValidHostName()
    {
        return (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $this->hostName) === 1);
    }

    /**
     * @return bool
     */
    public function isValidIp()
    {
        return (preg_match("/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $this->ip) === 1);
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto($request)
    {
        $dto   = new self();
        $class = $request->get('class');

        if ($class === self::getClassEntity()) {

            $ip   = $request->get('ip');
            $name = $request->get('hostname');
            $id   = $request->get('id');

            if ($name) {
                $dto->setHostName($name);
            }

            if ($ip) {
                $dto->setIp($ip);
            }

            if ($id) {
                $dto->setId($id);
            }

        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request)
    {
        self::regeneratRequest($request, self::getClassEntity(), 'server');

        return $request;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * @param mixed $id
     *
     * @return ServerDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $ip
     *
     * @return ServerDto
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @param mixed $hostName
     *
     * @return ServerDto
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;

        return $this;
    }
//endregion Getters/Setters
}