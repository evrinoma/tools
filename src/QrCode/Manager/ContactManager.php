<?php

namespace App\QrCode\Manager;

use App\Entity\User;
use App\QrCode\Std\ContactStd;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;

/**
 * Class ContactManager
 *
 * @package App\Manager
 */
class ContactManager extends AbstractEntityManager
{
//region SECTION: Public
    public function migration()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            if ($user->getContact()) {
                $contact             = new ContactStd();
                $aUser               = (array)$user->getContact();
                $incompleteClassName = $aUser['__PHP_Incomplete_Class_Name'];
                $ar                  = [];
                foreach ($aUser as $key => $value) {
                    if ($incompleteClassName !== $value) {
                        $keyNew      = substr($key, strlen($incompleteClassName)+2);
                        $ar[$keyNew] = $value;
                    }
                }
                $ar = (object)$ar;
                $contact->setFirstName($ar->firstName);
                $contact->setLastName($ar->lastName);
                $contact->setPosition($ar->position);
                $contact->setComapanyName($ar->comapanyName);
                $contact->setTelWork($ar->telWork);
                $contact->setTelWorkDop($ar->telWorkDop);
                $contact->setTelMobile($ar->telMobile);
                $contact->setEmail($ar->email);
                $contact->setUrl($ar->url);
                $user->setContact($contact);
            }
        }
       $this->entityManager->flush();
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param User|null $user
     *
     * @return QrCodeResponse
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     */
    public function getContact($user): ?QrCodeResponse
    {
        $vcard = $user->getVCard();
        if ($vcard) {
            $qrCode = new QrCode();
            $qrCode->setText($user->getVCard());
            $qrCode->setForegroundColor(array('r' => 0, 'g' => 67, 'b' => 134, 'a' => 0));
            $qrCode->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
            $qrCode->setLogoPath("../assets/images/contact/logo.png");
            $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel('low'));
            $qrCode->setLogoSize(98);
            $qrCode->setSize(400);

            return new QrCodeResponse($qrCode);
        }

        return null;
    }
//endregion Getters/Setters

}