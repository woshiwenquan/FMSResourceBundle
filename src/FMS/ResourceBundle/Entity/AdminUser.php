<?php

namespace App\FMS\ResourceBundle\Entity;

use App\Govlan\AdminApiBundle\Constant\Key;
use App\Govlan\AdminApiBundle\Constant\NumberKey;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * AdminUser
 *
 * @ORM\Table(name="admin_user")
 * @ORM\Entity(repositoryClass="App\Govlan\AdminApiBundle\Repository\AdminUserRepository")
 */
class AdminUser implements UserInterface 
{
    public function __construct($jsonAdminUser)
    {
        if (in_array('userName', $jsonAdminUser)) {
            $userName = $jsonAdminUser['userName'];
            $this->setUserName($userName);
        } else {
            return new Exception('userName not null');
        }
        $password = $jsonAdminUser['password'];
        $nickName = $jsonAdminUser['nickName'];
        $roleId = $jsonAdminUser['roleId'];

        $this->setPassword(crypt($password, Key::HASH_KEY));
        $this->setNickName($nickName);
        $this->setRoleId($roleId);
        if ($roleId != NumberKey::ADMIN_USER) {
            $fatherId = $jsonAdminUser['roleId'];
            $this->setFatherId($fatherId);
        }
        if ($roleId == NumberKey::OPERATOR_USER) {
            $serviceFeeProportion = $jsonAdminUser['serviceFeeProportion'];
            $this->setServiceFeeProportion($serviceFeeProportion);
        }

        $operatorId = 'op'.$this->randomNumStr(7);;
        $this->setOperatorId($operatorId);
        $this->setTotalCharingFee(0);
        $this->setTotalOperator(0);
        $this->setTotalStation(0);
        $this->setIsDelete(0);
        $this->setCreateTime(new \DateTime('now'));

    }

    /**
     * @var integer
     *
     * @ORM\Column(name="admin_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=15, nullable=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nick_name", type="string", length=20, nullable=true)
     */
    private $nickName;

    /**
     * @var string
     *
     * @ORM\Column(name="role_id", type="string", length=1, nullable=true)
     */
    private $roleId;

    /**
     * @var string
     *
     * @ORM\Column(name="city_id", type="string", length=3, nullable=true)
     */
    private $cityId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=20, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time", type="datetime", nullable=true)
     */
    private $createTime;

    /**
     * @var string
     *
     * @ORM\Column(name="father_id", type="string", length=20, nullable=true)
     */
    private $fatherId;

    /**
     * @var string
     *
     * @ORM\Column(name="total_charing_fee", type="string", length=20, nullable=true)
     */
    private $totalCharingFee;

    /**
     * @var string
     *
     * @ORM\Column(name="total_station", type="string", length=20, nullable=true)
     */
    private $totalStation;

    /**
     * @var string
     *
     * @ORM\Column(name="total_operator", type="string", length=20, nullable=true)
     */
    private $totalOperator;

    /**
     * @var string
     *
     * @ORM\Column(name="is_delete", type="string", length=1, nullable=true)
     */
    private $isDelete;

    /**
     * @var string
     *
     * @ORM\Column(name="operator_id", type="string", length=9, nullable=false)
     */
    private $operatorId;

    /**
     * @var string
     *
     * @ORM\Column(name="service_fee_proportion", type="string", length=10, nullable=true)
     */
    private $serviceFeeProportion;

    /**
     * @var int
     *
     * @ORM\Column(name="groupId", type="integer", nullable=false)
     */
    private $groupId;

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
    public function getServiceFeeProportion()
    {
        return $this->serviceFeeProportion;
    }

    /**
     * @param string $serviceFeeProportion
     */
    public function setServiceFeeProportion($serviceFeeProportion)
    {
        $this->serviceFeeProportion = $serviceFeeProportion;
    }

    /**
     * @return string
     */
    public function getOperatorId()
    {
        return $this->operatorId;
    }

    /**
     * @param string $operatorId
     */
    public function setOperatorId($operatorId)
    {
        $this->operatorId = $operatorId;
    }

    /**
     * Get adminId
     *
     * @return integer
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return AdminUser
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

   

    /**
     * Set password
     *
     * @param string $password
     *
     * @return AdminUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     *
     * @return AdminUser
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get nickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set roleId
     *
     * @param string $roleId
     *
     * @return AdminUser
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set cityId
     *
     * @param string $cityId
     *
     * @return AdminUser
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return string
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AdminUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return AdminUser
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set fatherId
     *
     * @param string $fatherId
     *
     * @return AdminUser
     */
    public function setFatherId($fatherId)
    {
        $this->fatherId = $fatherId;

        return $this;
    }

    /**
     * Get fatherId
     *
     * @return string
     */
    public function getFatherId()
    {
        return $this->fatherId;
    }

    /**
     * Set totalCharingFee
     *
     * @param string $totalCharingFee
     *
     * @return AdminUser
     */
    public function setTotalCharingFee($totalCharingFee)
    {
        $this->totalCharingFee = $totalCharingFee;

        return $this;
    }

    /**
     * Get totalCharingFee
     *
     * @return string
     */
    public function getTotalCharingFee()
    {
        return $this->totalCharingFee;
    }

    /**
     * Set totalStation
     *
     * @param string $totalStation
     *
     * @return AdminUser
     */
    public function setTotalStation($totalStation)
    {
        $this->totalStation = $totalStation;

        return $this;
    }

    /**
     * Get totalStation
     *
     * @return string
     */
    public function getTotalStation()
    {
        return $this->totalStation;
    }



    /**
     * Set totalOperator
     *
     * @param string $totalOperator
     *
     * @return AdminUser
     */
    public function setTotalOperator($totalOperator)
    {
        $this->totalOperator = $totalOperator;

        return $this;
    }

    /**
     * Get totalOperator
     *
     * @return string
     */
    public function getTotalOperator()
    {
        return $this->totalOperator;
    }

    public function setDefaultValue()
    {
        if ($this->getCreateTime() == null) {
            $this->setCreateTime(new \DateTime('now'));
        }
        if(true == empty($this->getNickName()))
        {
            $this->setNickName($this->getUserName());
        }
        $this->setTotalCharingFee(0);
        $this->setTotalOperator(0);
        $this->setTotalStation(0);
        $this->setIsDelete(0);
    }


    /**
     * Set isDelete
     *
     * @param string $isDelete
     *
     * @return AdminUser
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return string
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getFormatTime()
    {
        return date_format($this->getCreateTime(),'Y-m-d H:i:s');
    }

    public function randomNumStr($length)
    {
        $arr = array_merge(range(0, 9),range(0, 9));

        $str = '';
        $arr_len = count($arr);
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, $arr_len-1);
            $str.=$arr[$rand];
        }
        return $str;
    }
}

