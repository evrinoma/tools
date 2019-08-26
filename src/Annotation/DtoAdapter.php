<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 5:49 PM
 */

namespace App\Annotation;

/**
 * Class DtoAdapter
 *
 * @Annotation
 * @Attributes({
 *    @Attribute("adaptors", type = "array<App\Annotation\ApartAnnotation\DtoAdapterItem>"),
 * })
 * @package App\Annotation
 */
class DtoAdapter
{
//region SECTION: Fields

    public $adaptors;
//endregion Fields
}