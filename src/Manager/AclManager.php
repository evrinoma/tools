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
use Doctrine\ORM\EntityManagerInterface;

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

    private $domainManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * AclManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param DomainManager          $domainManager
     */
    public function __construct(EntityManagerInterface $entityManager, DomainManager $domainManager)
    {
        parent::__construct($entityManager);

        $this->domainManager = $domainManager;
    }
//endregion Constructor


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

    /**
     * @param AclDto[] $aclDto
     *
     * @return Acl
     * @throws \Exception
     */
    public function saveAcl($aclDto)
    {
        $dto = reset($aclDto);
        if ($dto) {
            $entity = $this->repository->setDto($dto)->findAcl();
            if (!$dto->getId() && count($entity)) {
                $this->setRestClientErrorBadRequest();
                $dto = $entity;
            } else {
                if ($dto->isValidEmail()) {
                    $domain = $this->domainManager->getDomain();
                    $dto = $this->save(count($entity) ? reset($entity) : new Acl(), $dto);
                } else {
                    $this->setRestClientErrorBadRequest();
                    $dto = 'Не правильный формат адреса';
                }
            }
        } else {
            $this->setRestClientErrorBadRequest();
            $dto = 'нет входных данных';
        }

        return $dto;
    }
//endregion Public

//region SECTION: Private
//    /**
//     * @param Acl    $entity
//     * @param AclDto $aclDto
//     *
//     * @return Acl
//     */
//    private function save(Acl $entity, $aclDto)
//    {
//        $aclDto->fillEntity($entity);
//        $this->entityManager->persist($entity);
//        $this->entityManager->flush();
//
//        return $entity;
//    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @param AclDto[] $aclDto
     *
     * @return $this
     */
    public function getAcls($aclDto)
    {
        $dto = reset($aclDto);

        $this->setData($this->repository->setDto($dto)->findAcl());

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