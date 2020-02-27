<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 12/5/19
 * Time: 3:34 PM
 */

namespace App\Interfaces;

/**
 * Interface RoleInterface
 *
 * @package App\Interfaces
 */
interface RoleInterface
{
//region SECTION: Fields
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_USER_DELTA8 = 'ROLE_USER_DELTA8';
    public const ROLE_API = 'ROLE_API';
    public const ROLE_NO_LDAP_USER = 'ROLE_NO_LDAP_USER';

    public const ROLE_VIDEO = 'ROLE_VIDEO';
    public const ROLE_VIDEO_ALL = 'ROLE_VIDEO_ALL';
    public const ROLE_KZKT_VIDEO = 'ROLE_KZKT_VIDEO';
    public const ROLE_ISHIM_VIDEO = 'ROLE_ISHIM_VIDEO';
    public const ROLE_IPARK_VIDEO = 'ROLE_IPARK_VIDEO';
    public const ROLE_TOBOLSK_VIDEO = 'ROLE_TOBOLSK_VIDEO';
    public const ROLE_VANKOR_VIDEO = 'ROLE_VANKOR_VIDEO';

    public const ROLE_CONTROL_VIDEO_ALL = 'ROLE_CONTROL_VIDEO_ALL';
    public const ROLE_KZKT_CONTROL_VIDEO = 'ROLE_KZKT_CONTROL_VIDEO';
    public const ROLE_ISHIM_CONTROL_VIDEO = 'ROLE_ISHIM_CONTROL_VIDEO';
    public const ROLE_IPARK_CONTROL_VIDEO = 'ROLE_IPARK_CONTROL_VIDEO';

    public const ROLE_TOBOLSK_CONTROL_VIDEO = 'ROLE_TOBOLSK_CONTROL_VIDEO';

    public const ROLE_CONTROL_VIDEO_MIXED = [
        self::ROLE_CONTROL_VIDEO_ALL,
        self::ROLE_KZKT_CONTROL_VIDEO,
        self::ROLE_ISHIM_CONTROL_VIDEO,
        self::ROLE_IPARK_CONTROL_VIDEO,
        self::ROLE_TOBOLSK_CONTROL_VIDEO,
    ];
//endregion Fields
}