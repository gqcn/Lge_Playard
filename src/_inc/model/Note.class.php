<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 笔记管理模型。
 *
 */
class Model_Note extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'note';
        $this->primary = 'note_id';
    }
}
?>