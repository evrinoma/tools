<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 1/27/20
 * Time: 6:49 PM
 */

namespace App\DataFixtures;

use App\Dto\ApartDto\ContactDto;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class VCardFixtures
 *
 * @package App\DataFixtures
 */
class VCardFixtures extends AbstractFixtures
{

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = $manager->find(User::class, 1);
        /** @var User $user */
        if ($user) {
            $vCard = new ContactDto();
            $vCard
                ->setFirstName('')
                ->setLastName('')
                ->setPosition('')
                ->setComapanyName('')
                ->setTelWork('')
                ->setTelWorkDop('')
                ->setTelMobile('')
                ->setEmail('')
                ->setUrl('');
            $user->setContact($vCard);

            $manager->flush();
        }
    }
//endregion Public
}