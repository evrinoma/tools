<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/22/19
 * Time: 6:22 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Dto\AclDto;
use App\Entity\Mail\Acl;
use App\Entity\Mail\Domain;
use App\Entity\Mail\Migrations\TbDomains;
use App\Entity\Mail\Migrations\TbEmails;
use App\Entity\Model\AclModel;
use App\Repository\AclRepository;
use App\Rest\Core\RestTrait;

/**
 * Class AclManager
 *
 * @package App\Manager
 * @property AclRepository $repository
 */
class AclManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Acl::class;
//endregion Fields


//region SECTION: Public
    /**
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function megrateAcls()
    {
        $this->getRepositoryAll(Acl::class)->removeEntitys();

        $rTbEmails = $this->entityManager->getRepository(TbEmails::class);
        /** @var TbDomains $value */
        foreach ($rTbEmails->all() as $value) {
            $acl = new Acl();
            $acl->setType($value['type'])
                ->setEmail($value['email'])
                ->setDomain($this->entityManager->getReference(Domain::class, $value['id']));
            $this->entityManager->persist($acl);
        }
        $this->entityManager->flush();

        return [];
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param AclDto[] $aclDto
     *
     * @return $this
     */
    public function getAcls($aclDto)
    {
        $dto = reset($aclDto);

        $this->repository
            ->createCriteria()
            ->setId($dto ? $dto->getId() : null);


        $this->setData($this->repository->findAcl());

        return $this;
    }

    /**
     * @return $this
     */
    public function getAclModel()
    {
        $this->setData(['class' => AclModel::class, 'model' => [AclModel::WHITE, AclModel::BLACK]]);

        return $this;
    }


    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}