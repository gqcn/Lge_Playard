<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 图片管理模型。
 *
 */
class Model_Picture extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'picture';
        $this->primary = 'picture_id';
    }
}
?>