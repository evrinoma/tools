<?php


namespace App\Entity\Common;


use App\Entity\User;

trait UpdateByUser
{

//region SECTION: Fields
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
     * @return User
     */
    public function getUpdated(): User
    {
        return $this->updated;
    }
//endregion Getters/Setters
}