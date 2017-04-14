<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 连接管理模型。
 *
 */
class Model_Link extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'link';
        $this->primary = 'link_id';
    }
}
?>