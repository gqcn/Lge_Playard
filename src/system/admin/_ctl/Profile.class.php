<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Profile extends AceAdmin_BaseControllerAuth
{
    /**
     * 个人信息
     */
    public function index()
    {
        importLib('FileSYS');
        $this->setBreadCrumbs(array(
            array('default'),
            array('profile'),
        ));

        $this->_session['user']['quota_total_format'] = FileSYS::formatSize($this->_session['user']['quota_total']);
        $this->_session['user']['quota_used_format']  = FileSYS::formatSize($this->_session['user']['quota_used']);
        
        $this->assigns(array(
        	'mainTpl'     => 'profile/index'
        ));
        $this->display();
    }
    
    /**
     * 
     * 个人信息修改
     * 
     * @todo 客户端处理密码md5
     */
    public function edit()
    {
        $data = $this->getRequest(array(
        	'nickname'     => '', 
        	'gender'       => 1, 
        	'email'        => '', 
        	'mobile'       => '', 
        	'telephone'    => '', 
        	'qq'           => '', 
        	'address'      => '', 
        	'brief'        => '', 
        	'avatar'       => $this->cfg['avatar']['default'], 
        ));
        
        if (empty($data['avatar'])) {
            $data['avatar'] = $this->cfg['avatar']['default'];
        }
        $userModel = &M('User');
        if ($userModel->update($data, "`uid`={$this->_session['user']['uid']}")) {
            foreach ($data as $k => $v) {
                $this->_session['user'][$k] = strStripSlashes($v);
            }
            $this->addMessage('个人信息修改成功', 'success');
        } else {
            $this->addMessage('个人信息修改失败', 'error');
        }
        $this->redirect();
    }
    
    /**
     * 展示修改密码页面.
     */
    public function password()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('profile'),
            array('profile', 'password'),
        ));

        $this->assigns(array(
        	'mainTpl'     => 'profile/password'
        ));
        $this->display();
    }
    
    /**
     * 执行重新设置密码.
     */
    public function resetPassword()
    {
        $data = $this->getRequest(array(
        	'old_password'   => '', 
        	'new_password'   => '', 
        	'new_password2'  => ''
        ));

        if (empty($data['old_password']) || empty($data['new_password']) || empty($data['new_password2'])) {
            $this->addMessage('参数不完整', 'error');
        } else {
            $userModel = &M('User');
            $userInfo  = $userModel->getOne("*", "`uid`={$this->_session['user']['uid']}");
            $password  = md5($data['old_password'].$userInfo['register_time']);
            if (strcasecmp($password, $userInfo['password']) != 0) {
                $this->addMessage('您输入的当前密码不正确', 'error');
            } else {
                $newPassword = md5($data['new_password'].$userInfo['register_time']);
                if ($userModel->update(array('password' => $newPassword), "`uid`={$this->_session['user']['uid']}")) {
                    $this->addMessage('密码修改成功', 'success');
                } else {
                    $this->addMessage('密码修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
}
