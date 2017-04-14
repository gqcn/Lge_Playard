<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 用户组管理模型。
 *
 */
class Model_UserGroup extends BaseModel
{
    /**
     * 用户组.
     * @var array
     */
    public $groups = array(
        // 1 => '普通用户',
        2 => '超级管理员',
        // 3 => '模板用户',
    );
    
    /**
     * 获得用户组列表.
     * 
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
