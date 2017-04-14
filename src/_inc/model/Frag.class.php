<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 碎片管理模型。
 *
 */
class Model_Frag extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'frag';
        $this->primary = 'frag_id';
    }
}
?>