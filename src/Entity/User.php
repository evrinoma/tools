<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/8/18
 * Time: 2:02 PM
 */

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}