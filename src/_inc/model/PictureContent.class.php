<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 图片内容管理模型。
 *
 */
class Model_PictureContent extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'picture_content';
        $this->primary = 'picture_id';
    }
}
?>