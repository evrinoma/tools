<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 9:41 AM
 */

namespace App\Manager;


use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class VoterManager
{
//region SECTION: Fields
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;
//endregion Fields

//region SECTION: Constructor
    /**
     * VoterManager constructor.
     *
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

//region SECTION: Public
    /**
     * @param string $role
     *
     * @return bool
     */
    public function checkPermission($role): bool
    {
        return $this->security->isGranted($role) ? true : false;
    }
//endregion Public
}