<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 4:13 PM
 */

namespace App\Dto\SysInfoDto;


class DevDto
{
//region SECTION: Fields
    private $description;
    private $product;
    private $serialNumber;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param mixed $description
     *
     * @return DevDto
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param mixed $product
     *
     * @return DevDto
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @param mixed $serialNumber
     *
     * @return DevDto
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }
//endregion Getters/Setters


}