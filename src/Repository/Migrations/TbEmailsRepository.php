<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/14/19
 * Time: 7:20 PM
 */

namespace App\Repository\Migrations;


use Doctrine\ORM\EntityRepository;

/**
 * Class TbEmailsRepository
 *
 * @package App\Repository
 */
class TbEmailsRepository extends EntityRepository
{
//region SECTION: Public
    public function all()
    {
        $builder = $this->createQueryBuilder('e');
        $builder
            ->select('e.type, e.email, md.domain, md.id')
            ->leftJoin('App\Entity\Mail\Migrations\TbDomains', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'e.domain = u.id')
            ->leftJoin('App\Entity\Mail\Domain', 'md', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.domain = md.domain')
        ;

        return $builder->getQuery()->getResult();
    }
//endregion Public
}