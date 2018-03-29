<?php

namespace App\FMS\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * adminUserGroup
 *
 * @ORM\Table(name="admin_user_group")
 * @ORM\Entity(repositoryClass="App\FMS\ResourceBundle\Repository\AdminUserGroupRepository")
 */
class AdminUserGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private  $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=50, nullable=true)
     */
    private $groupName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="can_delete", type="boolean")
     */
    private $canDelete;

    /**
     * @return bool
     */
    public function isCanDelete(): bool
    {
        return $this->canDelete;
    }

    /**
     * @param bool $canDelete
     */
    public function setCanDelete(bool $canDelete)
    {
        $this->canDelete = $canDelete;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName)
    {
        $this->groupName = $groupName;
    }


    /**
     * @return string
     */
    public function getPermission(): string
    {
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission(string $permission)
    {
        $this->permission = $permission;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="permission", type="string", length=500)
     */
    private $permission;
}

