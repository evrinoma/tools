<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 11/27/19
 * Time: 3:42 PM
 */

namespace App\Entity\Model;

/**
 * Trait MailTrait
 *
 * @package App\Entity\Model
 */
trait MailTrait
{
    abstract public function getEmail(): string;

    /**
     * @return mixed
     */
    public function isEmail()
    {
        return mb_strpos($this->getEmail(), '*@') === false;
    }
}