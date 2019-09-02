<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 10:39 AM
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
 * @ORM\Table(name="live_group")
 */
class Group
{
    use ActiveTrait;

//region SECTION: Fields
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"restrict", "full"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=50, nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $alias = '';
    /**
     * @var int
     * @ORM\Column(name="max_column", type="integer", nullable=false)
     * @Groups({"restrict", "full"})
     */
    private $maxColumn;

    /**
     * @var Cam
     * @ORM\OneToMany(targetEntity="App\Entity\LiveVideo\Cam", mappedBy="group")
     * @Groups({"restrict", "full"})
     */
    private $liveStreams;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getMaxColumn(): int
    {
        return $this->maxColumn;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Cam
     */
    public function getLiveStreams()
    {
        return $this->liveStreams;
    }

    /**
     * @param int $maxColumn
     *
     * @return Group
     */
    public function setMaxColumn(int $maxColumn)
    {
        $this->maxColumn = $maxColumn;

        return $this;
    }

    /**
     * @param string $alias
     *
     * @return Group
     */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @param Cam[] $liveStreams
     *
     * @return Group
     */
    public function setLiveStreams($liveStreams)
    {
        $this->liveStreams = $liveStreams;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Group
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
//endregion Getters/Setters
}