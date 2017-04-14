<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 家庭成员管理模型。
 *
 */
class Model_FamilyUser extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'family_user';
        $this->primary = 'id';
    }
    
    /**
     * 获得家庭成员列表.
     * 
     * @param integer $familyId 家庭ID.
     * 
     * @return array
     */
    public function getFamilyUsers($familyId)
    {
        $list   = $this->getList("*", "`family_id`={$familyId}", 0, 99999, "`order` ASC,`id` ASC", "uid");
        $uidStr = implode(',', array_keys($list));
        if (!empty($uidStr)) {
            $userModel = &M('User');
            $users     = $userModel->getList("*", "`uid` IN({$uidStr})", 0, 99999, null, "uid");
            foreach ($list as $uid => $item) {
                $list[$uid] = array_merge($item, $users[$uid]);
            }
        }
        return $list;
    }
}
