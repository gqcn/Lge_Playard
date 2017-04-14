<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 数据模型管理模型。
 *
 */
class Model_Model extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'model';
        $this->primary = 'model_id';
    }
}
?>