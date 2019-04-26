<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 10:30 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settings
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="settings")
 */
class Settings extends AbstractSettings
{
//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="db_engine", type="string", nullable=true)
     */
    protected $dbEngine;

    /**
     * @var string
     * @ORM\Column(name="db_host", type="string", nullable=true)
     */
    protected $dbHost;

    /**
     * @var string
     * @ORM\Column(name="db_port", type="string", nullable=true)
     */
    protected $dbPort;

    /**
     * @var string
     * @ORM\Column(name="ssh_host", type="string", nullable=true)
     */
    protected $sshHost;

    /**
     * @var string
     * @ORM\Column(name="ssh_port", type="string", nullable=true)
     */
    protected $sshPort;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getDbEngine(): ?string
    {
        return $this->dbEngine;
    }

    /**
     * @return null|string
     */
    public function getDbHost(): ?string
    {
        return $this->dbHost ?? 'localhost';
    }

    /**
     * @return null|string
     */
    public function getDbPort(): ?string
    {
        return $this->dbPort ?? '3306';
    }

    /**
     * @return null|string
     */
    public function getSshHost(): ?string
    {
        return $this->sshHost  ?? '22';
    }

    /**
     * @return null|string
     */
    public function getSshPort(): ?string
    {
        return $this->sshPort;
    }

    /**
     * @param string $dbEngine
     *
     * @return Settings
     */
    public function setDbEngine(string $dbEngine): Settings
    {
        $this->dbEngine = $dbEngine;

        return $this;
    }

    /**
     * @param string $dbHost
     *
     * @return Settings
     */
    public function setDbHost(string $dbHost): Settings
    {
        $this->dbHost = $dbHost;

        return $this;
    }

    /**
     * @param string $dbPort
     *
     * @return Settings
     */
    public function setDbPort(string $dbPort): Settings
    {
        $this->dbPort = $dbPort;

        return $this;
    }

    /**
     * @param string $sshHost
     *
     * @return Settings
     */
    public function setSshHost(string $sshHost): Settings
    {
        $this->sshHost = $sshHost;

        return $this;
    }

    /**
     * @param string $sshPort
     *
     * @return Settings
     */
    public function setSshPort(string $sshPort): Settings
    {
        $this->sshPort = $sshPort;

        return $this;
    }
//endregion Getters/Setters
}