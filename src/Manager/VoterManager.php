<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 9:41 AM
 */

namespace App\Manager;


use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class VoterManager
 *
 * @package App\Manager
 */
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
     * @param array $roles
     *
     * @return bool
     */
    public function checkPermission($roles): bool
    {
        return $this->security->isGranted($roles) || $this->isSuperAdmin() ? true : false;
    }
//endregion Public

//region SECTION: Private
    private function isSuperAdmin(): bool
    {
        return $this->security->isGranted(['ROLE_SUPER_ADMIN']) ? true : false;
    }
//endregion Private
}