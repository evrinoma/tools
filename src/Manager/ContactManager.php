<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 1/27/20
 * Time: 4:17 PM
 */

namespace App\Manager;

use App\Entity\User;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

/**
 * Class ContactManager
 *
 * @package App\Manager
 */
class ContactManager
{

//region SECTION: Getters/Setters
    /**
     * @param User|null $user
     *
     * @return QrCodeResponse
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     */
    public function getContact($user): ?QrCodeResponse
    {
        opcache_reset();
        apcu_clear_cache();
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