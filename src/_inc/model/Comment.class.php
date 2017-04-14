<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 评论管理模型。
 *
 */
class Model_Comment extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'comment';
        $this->primary = 'comment_id';
    }
}
?>