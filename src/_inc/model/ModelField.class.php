<?php
namespace Lge;
if (!defined('LGE')) {
    exit('Include Permission Denied!');
}
/**
 * 数据模型字段管理模型。
 *
 */
class Model_ModelField extends BaseModelTable
{
    public $table   = '_model_field';

    /**
     * 获得经过解析的字段.
     * 
     * @param integer $modelId 模型ID.
     * @param boolean $raw     是否不处理信息，从数据库原样返回.
     * 
     * @return array
     */
    public function getFields($modelId, $raw = false)
    {
        $arrayTypes = array('select', 'radio', 'checkbox');
        $fields     = $this->getList("*", "`model_id`={$modelId}", 0, 0, "`order` ASC,`field_id` ASC", "field_key");
        foreach ($fields as $k => $v) {
            if ($raw == false && in_array($v['field_type'], $arrayTypes)) {
                $fields[$k]['field_add_info'] = explode('|', $v['field_add_info'] );
            }
        }
        return $fields;
    }
}
