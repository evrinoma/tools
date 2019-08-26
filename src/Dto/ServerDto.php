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
class ServerDto extends AbstractDto
{
    use ActiveTrait;

//region SECTION: Fields
    private $ip;
    private $hostName;
//endregion Fields

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
     * @param $request
     *
     * @return FactoryDtoInterface
     */
    public static function toDto(Request $request)
    {
        $ip   = $request->get('ip');
        $name = $request->get('hostname');

        $dto = new self();

        if ($name) {
            $dto->setHostName($name);
        }

        if ($ip) {
            $dto->setIp($ip);
        }

        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function getRequest(Request $request)
    {
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
     * @return string
     */
    public function getClass()
    {
        return self::class;
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