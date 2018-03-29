<?php
/**
 * Created by PhpStorm.
 * User: wenquan
 * Date: 2018/3/29
 * Time: 下午2:24
 */

namespace App\FMS\ResourceBundle\Controller;

use App\FMS\ResourceBundle\Entity\AdminUser;
use App\FMS\ResourceBundle\Entity\AdminUserGroup;
use App\Govlan\AdminApiBundle\Constant\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/v1/admin")
 * Class AdminUserController
 * @package App\FMS\ResourceBundle\Controller
 */
class AdminUserController extends BaseController
{
    /**
     * 获取用户组列表
     * @Route("/adminUserGroup", methods={"GET"})
     * @SWG\Parameter( name="page",in="query",type="integer",required=true,description="页码")
     * @SWG\Parameter( name="pageSize",in="query",type="integer",required=true,description="分页大小")
     * @SWG\Response(
     *     response=200,
     *     description="获取管理员",
     * )
     * @SWG\Tag(name="adminUserGroup")
     * @param Request $request
     * @return Response
     */
    public function getAdminUserGroups(Request $request)
    {
        $page = $request->get('page');
        $pageSize = $request->get('pageSize');
        $adminUserGroups = $this->getFMSDoctrine()->adminUserGroup->getAdminUserGroup($page, $pageSize);
        $adminUserGroupCount = $this->getFMSDoctrine()->adminUserGroup->countAdminUserGroup();
        $newAdminUserGroups = null;

        foreach ($adminUserGroups as $adminUserGroup) {
            $entity = $this->filterAdminUserGroup($adminUserGroup);
            $newAdminUserGroups[] = $entity;
        }
        if (false == empty($pageSize)) {
            $data['pageInfo'] = $this->getPageInfo($page, $adminUserGroupCount, 'adminUsers', '', $pageSize);
        }
        $data['entities'] = $newAdminUserGroups;
        return $this->getResponseHandler()->writeOk($data,Message::SUCCESS);
    }

    /**
     * 添加用户组
     * @Route("/adminUserGroup", methods={"POST"})
     * @SWG\Parameter( name="groupName",in="query",type="string",required=true,description="用户组名称")
     * @SWG\Response(
     *     response=200,
     *     description="添加用户组",
     * )
     * @SWG\Tag(name="adminUserGroup")
     * @param Request $request
     * @return Response
     */
    public function addAdminUserGroup(Request $request)
    {
        $groupName = $request->get('groupName');
        if ($groupName == null) {
            return $this->getResponseHandler()->writeFail(null,Message::FAIL);
        }
        $existAdminUserGroup = $this->getFMSDoctrine()->adminUserGroup->findOneBy(array('groupName'=>$groupName));
        if (false == empty($existAdminUserGroup)) {
            return $this->getResponseHandler()->writeFail(null,Message::FAIL);
        }
        $adminUserGroup = new AdminUserGroup();
        $adminUserGroup->setGroupName($groupName);
        $adminUserGroup->setCanDelete(true);
        $adminUserGroup->setPermission(1);
        $this->saveEntity($adminUserGroup);

        $data = $this->filterAdminUserGroup($adminUserGroup);
        return $this->getResponseHandler()->writeOk($data,Message::SUCCESS);
    }

    /**
     * 删除用户分组
     * @Route("/adminUserGroup/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="删除用户分组",
     * )
     * @SWG\Tag(name="adminUserGroup")
     * @param AdminUserGroup $adminUserGroup
     * @return Response
     */
    public function deleteAdminUserGroup(AdminUserGroup $adminUserGroup)
    {
        if (false == $adminUserGroup->isCanDelete()) {
            return $this->getResponseHandler()->writeFail(null,Message::FAIL);
        }
        //todo 分配该用户组权限为普通用户管理权限
        $this->removeEntity($adminUserGroup);
        return $this->getResponseHandler()->writeOk(null, Message::SUCCESS);
    }

    public function filterAdminUserGroup(AdminUserGroup $adminUserGroup)
    {
        $entity['groupId'] = $adminUserGroup->getGroupId();
        $entity['groupName'] = $adminUserGroup->getGroupName();
        return $entity;
    }
}