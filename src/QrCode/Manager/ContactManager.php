<?php

namespace App\QrCode\Manager;

use App\Entity\User;
use App\QrCode\Std\ContactStd;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use  Endroid\QrCodeBundle\Response\QrCodeResponse;
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
     * @throws
     */
    public function getContact($user): ?QrCodeResponse
    {
        $vcard = $user->getVCard();
        if ($vcard) {
            $writer = new PngWriter();
            $qrCode = QrCode::create($vcard)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(400)
                ->setMargin(5)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
            $logo = Logo::create('../front/images/contact/logo.png')
                ->setResizeToWidth(100);
            $result = $writer->write($qrCode, $logo);

            return new QrCodeResponse($result);
        }

        return null;
    }
//endregion Getters/Setters

}