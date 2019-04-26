<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 4/26/19
 * Time: 11:45 AM
 */

namespace App\Entity;

/**
 * Class AbstractSettings
 *
 * @package App\Dashboard
 */
abstract class AbstractSettings
{
    /**
     * @return null|string
     */
    abstract public function getDbEngine(): ?string;

    public function isMysql()
    {
        return $this->getDbEngine() === 'mysql';
    }
}