<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 7/10/19
 * Time: 10:56 AM
 */

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Class AbstractFixtures
 *
 * @package App\DataFixtures
 */
abstract class AbstractFixtures extends Fixture implements FixtureGroupInterface
{

//region SECTION: Getters/Setters
    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return [SettingsFixtures::class];
    }
//endregion Getters/Setters
}