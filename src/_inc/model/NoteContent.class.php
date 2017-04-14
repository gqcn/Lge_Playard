<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 笔记内容管理模型。
 *
 */
class Model_NoteContent extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'note_content';
        $this->primary = 'note_id';
    }
}
?>