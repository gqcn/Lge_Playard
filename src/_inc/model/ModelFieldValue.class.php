<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 数据模型字段值管理模型。
 *
 */
class Model_ModelFieldValue extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'model_field_value';
        $this->primary = 'value_id';
    }
}
?>