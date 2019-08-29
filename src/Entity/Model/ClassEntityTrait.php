<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 4:21 PM
 */

namespace App\Entity\Model;

use Doctrine\Common\Util\ClassUtils;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Trait ClassEntityTrait
 *
 * @package App\Entity\Model
 */
trait ClassEntityTrait
{
//region SECTION: Getters/Setters
    /**
     * @VirtualProperty()
     * @return string
     */
    public function getClass()
    {
        return ClassUtils::getRealClass(static::class);
    }
//endregion Getters/Setters
}