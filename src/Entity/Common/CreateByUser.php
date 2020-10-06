<?php


namespace App\Entity\Common;


use App\Entity\User;

trait CreateByUser
{
//region SECTION: Fields
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
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return User
     */
    public function getCreated(): User
    {
        return $this->created;
    }
//endregion Getters/Setters
}