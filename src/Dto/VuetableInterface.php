<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/23/19
 * Time: 5:11 PM
 */

namespace App\Dto;

/**
 * Interface VuetableInterface
 *
 * @package App\Dto
 */
interface VuetableInterface
{
    /**
     * @return mixed
     */
    public function getPage();

    /**
     * @return mixed
     */
    public function getPerPage();

    /**
     * @return mixed
     */
    public function getFilter();
}