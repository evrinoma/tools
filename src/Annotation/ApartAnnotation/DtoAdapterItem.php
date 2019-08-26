<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/26/19
 * Time: 6:18 PM
 */

namespace App\Annotation\ApartAnnotation;

/**
 * Class DtoAdapterItem
 *
 * @Annotation
 * @Attributes(
 *    @Attribute("class",  type = "string"),
 *    @Attribute("method",  type = "string")
 * )
 * @package App\Annotation\ApartAnnotation
 */
class DtoAdapterItem
{
//region SECTION: Fields
    public $class;
    public $method;
//endregion Fields
}