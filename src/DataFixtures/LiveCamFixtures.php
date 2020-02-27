<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/29/19
 * Time: 11:19 AM
 */

namespace App\DataFixtures;


use App\Entity\LiveVideo\Cam;
use App\Entity\LiveVideo\Group;
use App\Entity\LiveVideo\Type;
use App\Interfaces\RoleInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LiveCamFixtures
 *
 * @package App\DataFixtures
 */
class LiveCamFixtures extends AbstractFixtures
{

//region SECTION: Fields
    private $hikvisionType;

    private $axisType;
//endregion Fields

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this
            ->createTypes($manager)
            ->createLiveIpark45($manager)
            ->createLiveGusev($manager)
            ->createLiveIshim($manager)
            ->createLiveKzkt45($manager)
            ->createLivePregolskay($manager)
            ->createLivePrimorsky($manager)
            ->createLiveSovetsk($manager)
            ->createLiveTobolsk($manager)
            ->createLiveTumen($manager)
            ->createLiveVankor($manager)
            ;

        $manager->flush();
    }
//endregion Public

//region SECTION: Private
    private function createTypes(ObjectManager $manager)
    {
        $this->hikvisionType = new Type();
        $this->hikvisionType->setType('hikvision');

        $this->axisType = new Type();
        $this->axisType->setType('axis');

        $manager->persist($this->hikvisionType);
        $manager->persist($this->axisType);

        return $this;
    }
    private function createLiveVankor(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_vankor')
            ->setName('Ванкор')
            ->setMaxColumn(2)
            ->setActiveToBlocked();

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.22.243')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Камера #1')
            ->setStream('cam_172.16.22.243_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('172.16.22.244')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Камера #2')
            ->setStream('cam_172.16.22.244_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('172.16.22.245')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Камера #3 ')
            ->setStream('cam_172.16.22.245_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        return $this;
    }


    private function createLiveIpark45(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_ipark45')
            ->setName('Курганский Индустриальный парк')
            ->setMaxColumn(5)
            ->addRole(RoleInterface::ROLE_IPARK_CONTROL_VIDEO)
            ->addRole(RoleInterface::ROLE_CONTROL_VIDEO_ALL);

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.39.14')
            ->setUserName('admin')
            ->setPassword('Qve12345')
            ->setTitle('Восточная сторона производственного цеха')
            ->setStream('cam_172.16.39.14_LQ.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('83.146.116.47:31524')
            ->setUserName('admin')
            ->setPassword('Qve12345')
            ->setTitle('Восточная точка, здание Вейсалова')
            ->setStream('cam_172.16.39.24_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('83.146.116.47:31534')
            ->setUserName('admin')
            ->setPassword('qwe12345')
            ->setTitle('Западная сторона производственного цеха, первая от улицы Бажова')
            ->setStream('cam_172.16.39.25_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        $camFour = new Cam();
        $camFour
            ->setName('Four')
            ->setIp('83.146.116.47:31544')
            ->setUserName('admin')
            ->setPassword('QWE12345')
            ->setTitle('Западная сторона производственного цеха, вторая от улицы Бажова')
            ->setStream('cam_172.16.39.26_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFour);

        $camFive = new Cam();
        $camFive
            ->setName('Five')
            ->setIp('83.146.116.47:31554')
            ->setUserName('admin')
            ->setPassword('qwe12345')
            ->setTitle('Западная сторона производственного цеха, вторая от улицы К.Мяготина')
            ->setStream('cam_172.16.39.27_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFive);

        $camSix = new Cam();
        $camSix
            ->setName('Six')
            ->setIp('83.146.116.47:31564')
            ->setUserName('admin')
            ->setPassword('qwe12345')
            ->setTitle('Западная сторона производственного цеха, первая от улицы К.Мяготина')
            ->setStream('cam_172.16.39.28_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camSix);

        $camSeven = new Cam();
        $camSeven
            ->setName('Seven')
            ->setIp('83.146.116.47:31574')
            ->setUserName('admin')
            ->setPassword('Hikvision1234')
            ->setTitle('КПП 1')
            ->setStream('cam_172.16.39.29_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camSeven);

        $camEighth = new Cam();
        $camEighth
            ->setName('Eighth')
            ->setIp('83.146.116.47:31584')
            ->setUserName('admin')
            ->setPassword('Hikvision1234')
            ->setTitle('КПП 2')
            ->setStream('cam_172.16.39.30_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camEighth);

        $camNine = new Cam();
        $camNine
            ->setName('Nine')
            ->setIp('83.146.116.47:31594')
            ->setUserName('admin')
            ->setPassword('Hikvision1234')
            ->setTitle('КПП 3')
            ->setStream('cam_172.16.39.31_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camNine);

        $camTen = new Cam();
        $camTen
            ->setName('Ten')
            ->setIp('83.146.116.47:31604')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('N1 по исполнительной схеме')
            ->setStream('cam_172.16.39.32_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camNine);

        $camEleven = new Cam();
        $camEleven
            ->setName('Eleven')
            ->setIp('83.146.116.47:31614')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('N2 по исполнительной схеме')
            ->setStream('cam_172.16.39.33_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camEleven);

        $camTwelve = new Cam();
        $camTwelve
            ->setName('Twelve')
            ->setIp('83.146.116.47:31624')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('N3 по исполнительной схеме')
            ->setStream('cam_172.16.39.34_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwelve);

        $camThirteen = new Cam();
        $camThirteen
            ->setName('Thirteen')
            ->setIp('83.146.116.47:31624')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('N3 по исполнительной схеме')
            ->setStream('cam_172.16.39.35_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThirteen);

        $camFourteen = new Cam();
        $camFourteen
            ->setName('Fourteen')
            ->setIp('83.146.116.47:31654')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('NX по исполнительной схеме')
            ->setStream('cam_172.16.39.37_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFourteen);

        $camFourteen = new Cam();
        $camFourteen
            ->setName('Sixteen')
            ->setIp('83.146.116.47:31694')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('Indpark kur 14')
            ->setStream('cam_172.16.39.43_LQ.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFourteen);

        $camFourteen = new Cam();
        $camFourteen
            ->setName('Seventeen')
            ->setIp('83.146.116.47:31704')
            ->setUserName('admin')
            ->setPassword('Qwer12345')
            ->setTitle('Indpark kur 15')
            ->setStream('cam_172.16.39.44_LQ.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFourteen);

        return $this;
    }

    private function createLiveGusev(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_gusev')
            ->setName('Гусев')
            ->setMaxColumn(3)
            ->setActiveToBlocked();

        $manager->persist($group);


        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.42.31')
            ->setUserName('ite')
            ->setPassword('rfvuec2016')
            ->setTitle('Камера #1 (КПП №1, ГК)')
            ->setStream('cam_172.16.42.31_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('172.16.42.39')
            ->setUserName('ite')
            ->setPassword('rfvuec2016')
            ->setTitle('Камера #2 (БЩУ)')
            ->setStream('cam_172.16.42.39_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('172.16.42.33')
            ->setUserName('ite')
            ->setPassword('rfvuec2016')
            ->setTitle('Камера #3 (ГК: общий вид)')
            ->setStream('cam_172.16.42.33_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        $camFour = new Cam();
        $camFour
            ->setName('Four')
            ->setIp('172.16.42.34')
            ->setUserName('ite')
            ->setPassword('rfvuec2016')
            ->setTitle('Камера #4 (ГК Машзал)')
            ->setStream('cam_172.16.42.34_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFour);

        $camFive = new Cam();
        $camFive
            ->setName('Five')
            ->setIp('172.16.42.32')
            ->setUserName('ite')
            ->setPassword('rfvuec2016')
            ->setTitle('Камера #5 (ЭТП ГК)')
            ->setStream('cam_172.16.42.32_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFive);

        return $this;
    }

    private function createLiveIshim(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_ishim')
            ->setName('Ишим')
            ->setMaxColumn(3)
            ->addRole(RoleInterface::ROLE_ISHIM_CONTROL_VIDEO)
            ->addRole(RoleInterface::ROLE_CONTROL_VIDEO_ALL);

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.47.243')
            ->setUserName('admin')
            ->setPassword('N.vtym2017')
            ->setTitle('Камера №1')
            ->setStream('cam_172.16.47.243_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camOne);

        return $this;
    }

    private function createLiveKzkt45(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_kzkt45')
            ->setName('Курганский завод комплексных технологий')
            ->setMaxColumn(3)
            ->addRole(RoleInterface::ROLE_KZKT_CONTROL_VIDEO)
            ->addRole(RoleInterface::ROLE_CONTROL_VIDEO_ALL);

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.39.10')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Kurgan KZKT CAM1')
            ->setStream('cam_172.16.39.10_HD.stream')
            ->setControl(true)
            ->setType($this->axisType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('172.16.39.11')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Kurgan KZKT CAM2')
            ->setStream('cam_172.16.39.11_HD.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('172.16.39.12')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Kurgan KZKT CAM3')
            ->setStream('cam_172.16.39.12_HD.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        $camFour = new Cam();
        $camFour
            ->setName('Four')
            ->setIp('172.16.39.36')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Kurgan KZKT CAM4')
            ->setStream('cam_172.16.39.36_LQ.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFour);

        $camFive = new Cam();
        $camFive
            ->setName('Five')
            ->setIp('172.16.39.38')
            ->setUserName('ite')
            ->setPassword('video2014')
            ->setTitle('Kurgan KZKT CAM5')
            ->setStream('cam_172.16.39.38_LQ.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFive);

        $camFourteen = new Cam();
        $camFourteen
            ->setName('Six')
            ->setIp('172.16.39.39')
            ->setUserName('admin')
            ->setPassword('rehufy2014')
            ->setTitle('3 пролет восточная сторона')
            ->setStream('cam_172.16.39.39_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFourteen);

        $camFourteen = new Cam();
        $camFourteen
            ->setName('Seven')
            ->setIp('172.16.39.40')
            ->setUserName('admin')
            ->setPassword('rehufy2014')
            ->setTitle('2 пролет восточная сторона')
            ->setStream('cam_172.16.39.40_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFourteen);

        return $this;
    }

    private function createLivePregolskay(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_pregolskay')
            ->setName('Прегольская')
            ->setMaxColumn(2)
            ->setActiveToBlocked();

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('188.168.34.45')
            ->setUserName('energo')
            ->setPassword('energo123')
            ->setTitle('Камера #1 (портал на тер-рии ОРУ)')
            ->setStream('cam_188.168.34.45_12554_LQ.stream')
            ->setType($this->axisType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('188.168.34.46')
            ->setUserName('energo')
            ->setPassword('energo123')
            ->setTitle('Камера #2 (портал на тер-рии ОРУ)')
            ->setStream('cam_188.168.34.45_12555_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('188.168.34.46')
            ->setUserName('energo')
            ->setPassword('energo123')
            ->setTitle('Камера #3 (осветительная вышка на тер-рии ОРУ)')
            ->setStream('cam_188.168.34.45_12556_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        $camFour = new Cam();
        $camFour
            ->setName('Four')
            ->setIp('188.168.34.46')
            ->setUserName('energo')
            ->setPassword('energo123')
            ->setTitle('Камера #4 (осветительная вышка у АБК, смотрит на градирни)')
            ->setStream('cam_188.168.34.45_12557_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFour);

        return $this;
    }

    private function createLivePrimorsky(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_primorsky')
            ->setName('Приморский')
            ->setMaxColumn(2)
            ->setActiveToBlocked();

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('78.36.203.246:554')
            ->setUserName('reception1')
            ->setPassword('Qq123456')
            ->setTitle('Камера #1 (Пятно застройки ГК)')
            ->setStream('cam_78.36.203.246_555_LQ.stream')
            ->setType($this->axisType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('78.36.203.246:555')
            ->setUserName('reception1')
            ->setPassword('Qq123456')
            ->setTitle('Камера #4 (Общий вид #2)')
            ->setStream('cam_78.36.203.246_554_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('83.220.254.3:11554')
            ->setUserName('reception1')
            ->setPassword('Qq123456')
            ->setTitle('Камера #3 (Общий вид #1)')
            ->setStream('cam_83.220.254.3_11554_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);


        $camFour = new Cam();
        $camFour
            ->setName('Four')
            ->setIp('78.36.203.246:556')
            ->setUserName('reception1')
            ->setPassword('Qq123456')
            ->setTitle('Камера #2 (КПП)')
            ->setStream('cam_78.36.203.246_556_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFour);

        return $this;
    }

    private function createLiveSovetsk(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_sovetsk')
            ->setName('Советск')
            ->setMaxColumn(3)
            ->setActiveToBlocked();

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.41.26')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера №1 (ЭТП ГК)')
            ->setStream('cam_172.16.41.26_LQ.stream')
            ->setType($this->axisType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('172.16.41.27')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера #2 (АБК-ОВК)')
            ->setStream('cam_172.16.41.27_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);


        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('172.16.41.28')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера #3 (ГК)')
            ->setStream('cam_172.16.41.28_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        $camFour = new Cam();
        $camFour
            ->setName('Four')
            ->setIp('172.16.41.29')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера #4 (Резервуары ДТ)')
            ->setStream('cam_172.16.41.29_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFour);

        $camFive = new Cam();
        $camFive
            ->setName('Five')
            ->setIp('172.16.41.30')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера #5 (ГК Машзал)')
            ->setStream('cam_172.16.41.30_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camFive);

        $camSix = new Cam();
        $camSix
            ->setName('Six')
            ->setIp('172.16.41.31')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера #6 (ГК Общий вид)')
            ->setStream('cam_172.16.41.31_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camSix);

        $camSeven = new Cam();
        $camSeven
            ->setName('Seven')
            ->setIp('172.16.41.222')
            ->setUserName('ite')
            ->setPassword('rfvcjd2016')
            ->setTitle('Камера #7 (БЩУ)')
            ->setStream('cam_172.16.41.222_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camSeven);

        return $this;
    }

    private function createLiveTobolsk(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_tobolsk')
            ->setName('Тобольск')
            ->setMaxColumn(3)
            ->addRole(RoleInterface::ROLE_ISHIM_CONTROL_VIDEO)
            ->addRole(RoleInterface::ROLE_CONTROL_VIDEO_ALL);

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.48.244')
            ->setUserName('admin')
            ->setPassword('N.vtym2017')
            ->setTitle('Камера №1')
            ->setStream('cam_172.16.48.244_LQ.stream')
            ->setControl(true)
            ->setType($this->axisType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('172.16.48.245')
            ->setUserName('admin')
            ->setPassword('N.vtym2017')
            ->setTitle('Камера №2')
            ->setStream('cam_172.16.48.245_LQ.stream')
            ->setControl(true)
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        return $this;
    }

    private function createLiveTumen(ObjectManager $manager)
    {
        $group = new Group();
        $group
            ->setAlias('live_tumen')
            ->setName('Тюмень')
            ->setMaxColumn(2)
            ->setActiveToBlocked();

        $manager->persist($group);

        $camOne = new Cam();
        $camOne
            ->setName('One')
            ->setIp('172.16.47.245')
            ->setUserName('admin')
            ->setPassword('N.vtym2017')
            ->setTitle('Камера №1')
            ->setStream('cam_172.16.47.245_LQ.stream')
            ->setType($this->axisType)
            ->setGroup($group);
        $manager->persist($camOne);

        $camTwo = new Cam();
        $camTwo
            ->setName('Two')
            ->setIp('172.16.47.244')
            ->setUserName('admin')
            ->setPassword('N.vtym2017')
            ->setTitle('Камера №2')
            ->setStream('cam_172.16.47.244_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camTwo);

        $camThree = new Cam();
        $camThree
            ->setName('Three')
            ->setIp('172.16.47.243')
            ->setUserName('admin')
            ->setPassword('N.vtym2017')
            ->setTitle('Камера №3')
            ->setStream('cam_172.16.47.243_LQ.stream')
            ->setType($this->hikvisionType)
            ->setGroup($group);
        $manager->persist($camThree);

        return $this;
    }
//endregion Private
}