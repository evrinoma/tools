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
    public function migrateAcls()
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
     * @param AclDto $aclDto
     *
     * @return Acl
     * @throws \Exception
     */
    public function saveAcl($aclDto)
    {
        $entity = null;

        if ($aclDto->isValidEmail()) {
            $entity = $this->repository->setDto($aclDto)->findAcl();
            $aclDto->setEntitys($entity);
            if (!$aclDto->getId() && count($entity)) {
                $this->setRestClientErrorBadRequest();
                $entity = 'уже существует';
            } else {
                $aclDto->getDomain()->setEntitys($this->domainManager->getDomains($aclDto->getDomain())->getData());
                if ($aclDto->getDomain()->hasSingleEntity()) {
                    $entity = $this->save(count($entity) ? reset($entity) : new Acl(), $aclDto);
                } else {
                    $this->setRestClientErrorBadRequest();
                    $entity = 'нет домена или их несколько';
                }
            }
        } else {
            $this->setRestClientErrorBadRequest();
            $entity = 'нет входных данных';
        }

        return $entity;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param AclDto $aclDto
     *
     * @return $this
     */
    public function getAcls($aclDto)
    {
        $this->setData($this->repository->setDto($aclDto)->findAcl());

        return $this;
    }

    /**
     * @return $this
     */
    public function getAclModel()
    {
        $this->setClassModel(AclModel::class)->setData([AclModel::WHITE, AclModel::BLACK]);

        return $this;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}