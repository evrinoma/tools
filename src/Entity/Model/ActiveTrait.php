<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 6/11/19
 * Time: 11:11 PM
 */

namespace App\Entity\Model;

use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=255, nullable=false)
     */
    private $active = ActiveModel::ACTIVE;
//endregion Fields

//region SECTION: Public
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
//endregion Public

//region SECTION: Getters/Setters
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
        switch ($active) {
            case ActiveModel::ACTIVE:
                $this->setActiveToActive();
                break;
            case ActiveModel::BLOCKED:
                $this->setActiveToBlocked();
                break;
            case ActiveModel::DELETED:
                $this->setActiveToDelete();
                break;
        }

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
     * @return ActiveTrait
     */
    public function setActiveToActive()
    {
        $this->active = ActiveModel::ACTIVE;

        return $this;
    }

    /**
     * @return ActiveTrait
     */
    public function setActiveToBlocked()
    {
        $this->active = ActiveModel::BLOCKED;

        return $this;
    }
//endregion Getters/Setters
}