<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 文章内容管理模型。
 *
 */
class Model_ArticleContent extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'article_content';
        $this->primary = 'article_id';
    }
}
?>