<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 家庭管理模型。
 *
 */
class Model_Family extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'family';
        $this->primary = 'family_id';
    }
}
