<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/16/19
 * Time: 5:25 PM
 */

namespace App\Dto\ApartDto;

use Evrinoma\DtoBundle\Dto\AbstractApartDto;

/**
 * Class FileDto
 *
 * @package App\Dto\ApartDto
 */
class FileDto extends AbstractApartDto
{
//region SECTION: Fields
    private $name;
    private $path;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->path.$this->name;
    }

    /**
     * @param mixed $name
     *
     * @return FileDto
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $path
     *
     * @return FileDto
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
//endregion Getters/Setters


}