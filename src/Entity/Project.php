<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ProjectBundle\Entity\BaseProject;
use JMS\Serializer\Annotation\Type;

/**
 * Class Project
 *
 * @package App\Entity
 * @ORM\Table(indexes={@ORM\Index(name="IDX_2FB3D0EE979B1AD6", columns={"contragent_id"}), @ORM\Index(name="IDX_2FB3D0EE896DBBDE", columns={"updated_id"}), @ORM\Index(name="IDX_2FB3D0EEB03A8386", columns={"created_id"})})
 */
class Project extends BaseProject
{
//region SECTION: Fields
    /**
     * @var Contragent
     * @Type("App\Entity\Contragent")
     *
     * @ORM\ManyToOne(targetEntity="Contragent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contragent_id", referencedColumnName="id")
     * })
     */
    private $contragent;

    /**
     * @var User
     * @Type("App\Entity\User")
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_id", referencedColumnName="id")
     * })
     */
    private $created;

    /**
     * @var User
     * @Type("App\Entity\User")
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_id", referencedColumnName="id")
     * })
     */
    private $updated;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return Contragent
     */
    public function getContragent(): Contragent
    {
        return $this->contragent;
    }

    /**
     * @return User
     */
    public function getCreated(): User
    {
        return $this->created;
    }

    /**
     * @return User
     */
    public function getUpdated(): User
    {
        return $this->updated;
    }
//endregion Getters/Setters
}