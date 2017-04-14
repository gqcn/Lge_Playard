<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 数据模型内容管理模型。
 *
 */
class Model_ModelContent extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'model_content';
        $this->primary = 'id';
    }
    
    /**
     * 获得数据模型的一条内容.
     * 
     * @param integer $contentId 内容ID.
     * 
     * @return array
     */
    public function getContent($contentId)
    {
        $data = array();
        $one  = $this->getOne("*", "`id`={$contentId}");
        if (!empty($one)) {
            $fieldModel      = &M('ModelField');
            $fieldValueModel = &M('ModelFieldValue');
            $fieldMap        = $fieldModel->getFields($one['model_id']);
            $fieldValue      = $fieldValueModel->getOne("*", "`content_id`={$contentId}");
            $data            = $one;
            foreach ($fieldValue as $k => $v) {
                $data[$v['field_key']] = array(
                	'field' => $fieldMap[$v['field_id']],
                    'value' => $v['value']
                );
            }
        }
        return $data;
    }
}
?>