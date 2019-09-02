<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 10:26 AM
 */

namespace App\Entity\LiveVideo;

use App\Entity\Model\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;


/**
 * Class CamType
 *
 * @package App\Entity\LiveVideo
 * @ORM\Entity
 * @ORM\Table(name="live_type")
 */
class Type
{
    use ActiveTrait;

//region SECTION: Fields
    const HIKVISION = 'hikvision';
    const AXIS      = 'axis';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"full"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     * @Groups({"full"})
     */
    private $type = '';
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Type
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters


}