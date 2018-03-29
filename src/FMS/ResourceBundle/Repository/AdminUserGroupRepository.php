<?php
/**
 * Created by PhpStorm.
 * User: wenquan
 * Date: 2018/3/29
 * Time: 下午2:36
 */

namespace App\FMS\ResourceBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AdminUserGroupRepository extends EntityRepository
{
    public function getAdminUserGroup($page, $pageSize)
    {
        if ($pageSize == null) {
            $query = $this->createQueryBuilder('a')
                ->select('a')
                ->getQuery();
        } else {
            $query = $this->createQueryBuilder('a')
                ->select('a')
                ->setFirstResult(($page - 1)* $pageSize)
                ->setMaxResults($pageSize)
                ->getQuery();
        }
        return $query->getResult();
    }

    public function countAdminUserGroup()
    {
        $query = $this->createQueryBuilder('a')
            ->select('count(a)')
            ->getQuery();
        return $query->getSingleScalarResult();
    }
}