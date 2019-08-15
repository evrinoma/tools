<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/11/19
 * Time: 11:11 PM
 */

namespace App\Entity\Model;


trait ActiveTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=255, nullable=false)
     */
    private $active = ActiveModel::ACTIVE;

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * @param string $active
     *
     * @return ActiveTrait
     */
    public function setActive(string $active = ActiveModel::ACTIVE)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return ActiveTrait
     */
    public function setActiveToDelete()
    {
        $this->active = ActiveModel::DELETED;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active === ActiveModel::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->active === ActiveModel::BLOCKED;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->active === ActiveModel::DELETED;
    }
}