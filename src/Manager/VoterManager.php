<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 3/7/19
 * Time: 9:41 AM
 */

namespace App\Manager;


use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
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
    /**
     * @var AuthorizationChecker
     */
    private $securit;
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
        return $this->security->isGranted($roles)? true: false;
    }
//endregion Public
}