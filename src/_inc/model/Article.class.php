<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 文章管理模型。
 *
 */
class Model_Article extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'article';
        $this->primary = 'article_id';
    }
}
?>