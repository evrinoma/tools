<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;

use App\Entity\Mail\Acl;
use App\Entity\Model\ActiveTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Acl
 *
 * @package App\Dto
 */
class AclDto implements FactoryDtoInterface
{
    use ActiveTrait;

//region SECTION: Fields
    private $id;

    private $type;

    private $email;

    private $domain;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isValidEmail()
    {
        return $this->email && (preg_match("/[a-zA-Z0-9_\-.+*]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $this->email) === 1);
    }

    /**
     * @param Acl $entity
     *
     * @return Acl
     */
    public function fillEntity($entity)
    {
        $entity->setEmail($this->getEmail())->setType($this->getType())->setActive($this->getActive());

        return $entity;
    }

    /**
     * @return mixed
     */
    public function isEmail()
    {
        return mb_strpos($this->email, '*@') === false;
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param $request
     *
     * @return array
     */
    public static function toDto(Request $request)
    {
        $dto     = new self();
        $id      = $request->get('id');
        $active  = $request->get('active');
        $deleted = $request->get('deleted');
        $email   = $request->get('email');
        $type    = $request->get('type');
        $domain  = $request->get('domain');

        if ($id) {
            $dto->setId($id);
        }

        if ($active) {
            if ($deleted) {
                $dto->setActiveToDelete();
            }
        }

        if ($email) {
            $dto->setEmail($email);
        }

        if ($type) {
            $dto->setType($type);
        }

        if ($domain) {
            if (!is_array($domain)) {
                $domain = json_decode($domain, true);
            }


            if (isset($domain['domain'])) {
                $dto->setDomain($domain['domain']);
            }
        }


        return $dto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailDomain()
    {
        return mb_strcut($this->email, mb_strpos($this->email, '@'), mb_strlen($this->email));
    }


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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return self::class;
    }

    /**
     * @param mixed $domain
     *
     * @return AclDto
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param mixed $email
     *
     * @return AclDto
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return AclDto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $type
     *
     * @return AclDto
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters
}