<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 9:05 AM
 */

namespace App\Dto;

use App\Annotation\Dto;
use App\Entity\Mail\Acl;
use App\Entity\Model\ActiveTrait;
use App\Entity\Model\MailTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AclDto
 *
 * @package App\Dto
 */
class AclDto extends AbstractFactoryDto
{
    use ActiveTrait;
    use MailTrait;

//region SECTION: Fields
    private $id;

    private $type;

    private $email;

    /**
     * @Dto(class="App\Dto\DomainDto")
     * @var DomainDto
     */
    private $domain;
//endregion Fields

//region SECTION: Protected
    /**
     * @return mixed
     */
    protected function getClassEntity()
    {
        return Acl::class;
    }
//endregion Protected

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
        $entity
            ->setEmail($this->getEmail())
            ->setType($this->getType())
            ->setActive($this->getActive())
            ->setDomain($this->getDomain()->generatorEntity()->current());

        return $entity;
    }

    /**
     * @return string|null
     */
    public function lookingForRequest()
    {
        return null;
    }
//endregion Public

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return AbstractFactoryDto
     */
    public function toDto($request)
    {
        $class = $request->get('class');

        if ($class === $this->getClassEntity()) {
            $id      = $request->get('id');
            $active  = $request->get('active');
            $deleted = $request->get('is_deleted');
            $email   = $request->get('email');
            $type    = $request->get('type');

            if ($id) {
                $this->setId($id);
            }

            if ($active && $deleted) {
                $this->setActiveToDelete();
            }

            if ($email) {
                $this->setEmail($email);
            }

            if ($type) {
                $this->setType($type);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return DomainDto
     */
    public function getDomain(): DomainDto
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
     * @param DomainDto $domain
     *
     * @return AclDto
     */
    public function setDomain(DomainDto $domain)
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