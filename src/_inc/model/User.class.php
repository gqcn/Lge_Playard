<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 用户管理模型。
 *
 */
class Model_User extends BaseModelTable
{
    /**
     * 用户状态.
     * @var array
     */
    public $statuses = array(
        0 => '禁用',
        1 => '正常',
        2 => '未验证邮箱',
    );
    
    public function setTableAndPri()
    {
        $this->table   = 'user';
        $this->primary = 'uid';
    }
    
    /**
     * 获得状态名称.
     * 
     * @param integer $status 状态码.
     * 
     * @return string
     */
    public function getStatusName($status)
    {
        if (isset($this->statuses[$status])) {
            return $this->statuses[$status];
        } else {
            return '未知';
        }
    }
    
    /**
     * 获取配额大小.
     * 
     * @param integer $uid 用户ID,为0时表示检查当前用户.
     * 
     * @return integer
     */
    public function getQuota($uid = 0)
    {
        if ($uid == 0) {
            if ($this->_session['user']['gid'] == 2) {
                return 999999999;
            } else {
                return $this->_session['user']['quota_total'] - $this->_session['user']['quota_used'];
            }
        } else {
            $one   = $this->getOne("`quota_total`, `quota_used`", "`uid`={$uid}");
            $quota = $one['quota_total'] - $one['quota_used'];
            return $quota;
        }
    }
    
    /**
     * 检查增加$size KB数据,用户是否超过配额.
     * 
     * @param integer $size 单位Byte.
     * @param integer $uid  用户ID,为0时表示检查当前用户.
     * 
     * @return boolean
     */
    public function checkQuota($size, $uid = 0)
    {
        $quota = $this->getQuota($uid);
        return ($quota > $size);
    }
    
    /**
     * 使用一定大小的配额.
     * 
     * @param integer $size 单位Byte.
     * @param integer $uid  用户ID,为0时表示检查当前用户.
     */
    public function useQuota($size, $uid = 0)
    {
        if ($size == 0) {
            return;
        }
        if ($uid == 0) {
            $uid = $this->_session['user']['uid'];
            if ($this->_session['user']['gid'] == 2) {
                return ;
            } else {
                $this->_session['user']['quota_used'] += $size; 
            }
        }
        $this->update(array("`quota_used`=`quota_used`+{$size}"), "`uid`={$uid}");
    }
    
    /**
     * 更新配额.
     * 
     * @param integer $quota 新的配额大小(Byte).
     * @param integer $uid   用户ID.
     */
    public function updateQuota($quota, $uid = 0)
    {
        if ($uid == 0) {
            $uid = $this->_session['user']['uid'];
            if ($this->_session['user']['gid'] == 2) {
                return ;
            } else {
                $this->_session['user']['quota_used'] = $this->_session['user']['quota_total'] - $quota; 
            }
        }
        $this->update(array("`quota_used`=`quota_total` - {$quota}"), "`uid`={$uid}");
    }
    
    /**
     * 用户登录.
     * 
     * @param string $passport 帐号.
     * @param string $password 密码.
     * 
     * @return boolean
     */
    public function doLogin($passport, $password)
    {
        $userInfo  = $this->getOne("*", "`passport`='{$passport}' AND `status`=1");
        if (!empty($userInfo)) {
            if (strcasecmp(md5($password.$userInfo['register_time']), $userInfo['password']) == 0) {
                $familyUserModel = &M('FamilyUser');
                // 写入session
                unset($userInfo['password']);
                $familyUserInfo = $familyUserModel->getOne("*", "`uid`={$userInfo['uid']}");
                $userInfo['family_id']   = $familyUserInfo['family_id'];
                $userInfo['family_role'] = $familyUserInfo['family_role'];
                $this->_session['user']  = $userInfo;
                // 更新用户登录信息
                $this->updateUserLoginInfo($userInfo['uid']);
                return true;
            }
        }
        return false;
    }
    
    /**
     * 更新用户登录信息.
     * 
     * @param integer $uid UID.
     * 
     * @return void
     */
    public function updateUserLoginInfo($uid)
    {
        importLib('Ip');
        $data = array(
            'last_login_time' => time(),
            'last_login_ip'   => Ip::getClientIp(),
        );
        $this->update($data, "`uid`={$uid}");
    }
}
?>