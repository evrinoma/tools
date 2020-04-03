<?php

namespace App\QrCode\Fixtures;

use App\Entity\User;
use App\QrCode\Dto\ApartDto\ContactDto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class VCardFixtures
 *
 * @package App\QrCode\Fixtures
 */
class VCardFixtures extends Fixture
{

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $vCard = new ContactDto();
        $vCard
            ->setFirstName('')
            ->setLastName('')
            ->setPosition('')
            ->setComapanyName('АО Интертехэлектро')
            ->setTelWork('+74956444430')
            ->setTelWorkDop('')
            ->setTelMobile('+7')
            ->setEmail('@ite-ng.ru')
            ->setUrl('www.ite-ng.ru');

        if ($vCard && $vCard->getEmail()) {
            /** @var User $user */
            $user = $manager->getRepository(User::class)->findOneBy(['email' => $vCard->getEmail()]);
            if ($user) {
                $user->setContact($vCard);
                $manager->flush();
            }
        }

    }
//endregion Public
}