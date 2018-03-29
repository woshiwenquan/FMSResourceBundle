<?php
/**
 * Created by PhpStorm.
 * User: wenquan
 * Date: 2018/3/29
 * Time: 下午2:34
 */

namespace App\FMS\ResourceBundle\DoctrineExtends;


use App\FMS\ResourceBundle\Entity\AdminUserGroup;
use Doctrine\Bundle\DoctrineBundle\Registry;

class FMSDoctrine
{
    /**
     * @var $adminUserGroup \App\FMS\ResourceBundle\Repository\AdminUserGroupRepository
     */
    var $adminUserGroup;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;

        $this->adminUserGroup = $this->doctrine->getRepository(AdminUserGroup::class);

    }
}