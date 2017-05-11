<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

/**
 * 自定义模型管理
 */
class Controller_Model extends AceAdmin_BaseControllerAuth
{
    /**
     * 列表管理.
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('model'),
        ));
        $modelModel = &M('Model');
        $list       = $modelModel->getList("*", 1, 0, 0, "`order` ASC,`model_id` DESC");
        $this->assigns(array(
            'list'     => $list,
        	'mainTpl'  => 'model/index'
        ));
        $this->display();
    }
    
    
    /**
     * 显示添加/修改
     */
    public function showEdit()
    {
        $modelId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        $data    = array(
        	'model_id'     => 0, 
        	'model_key'    => '', 
        	'model_name'   => '', 
        	'order'        => 99, 
        	'brief'        => '',
        	'fields'       => array(),
        );
        if ($modelId) {
            $modelModel = &M('Model');
            $fieldModel = &M('ModelField');
            $model      = $modelModel->getOne("*", "`model_id`={$modelId}");
            if (!empty($model)) {
                $data           = $model;
                $data['fields'] = $fieldModel->getFields($modelId, true);
            }
        }
        // 面包屑
        $breadCrumbs = array(
            array('default'),
            array('model'),
        );
        if (empty($modelId)) {
            $breadCrumbs[] = array('model', 'showEdit');
        } else {
            $breadCrumbs[] = array('model', 'showEdit', '模型修改');
            $this->setCurrentMenu('model', 'index');
        }
        $this->setBreadCrumbs($breadCrumbs);
        $this->assigns(array(
        	'data'     => $data,
        	'mainTpl'  => 'model/showEdit'
        ));
        $this->display();
    }
    
    /**
     * 显示内容添加/修改
     */
    public function showContentEdit()
    {
        $modelId   = isset($this->_get['model_id']) ? intval($this->_get['model_id']) : 0;
        $contentId = isset($this->_get['content_id']) ? intval($this->_get['content_id']) : 0;
        if (empty($modelId) && empty($contentId)) {
            $this->addMessage('参数不完整', 'error');
            $this->redirect();
        } else {
            $modelModel   = &M('Model');
            $fieldModel   = &M('ModelField');
            $contentModel = &M('ModelContent');
            $data         = array(
            	'model_id'     => 0, 
            	'model_key'    => '', 
            	'model_name'   => '', 
            	'order'        => 99, 
            	'brief'        => '',
            	'fields'       => array(),
            );
            if ($contentId) {
                $content = $contentModel->getContent($contentId);
                if (!empty($content)) {
                    $data           = $modelModel->getOne("*", "`model_id`={$modelId}");;
                    $data['fields'] = $content;
                }
            } else {
                $fields = $fieldModel->getFields($modelId);
                foreach ($fields as $key => $field) {
                    $data['fields'][$key] = array(
                        'field' => $field,
                        'value' => $field['default_value'],
                    );
                }
            }
            // 面包屑
            $breadCrumbs = array(
                array('default'),
                array('model'),
                array('model', 'content'),
            );
            if (empty($contentId)) {
                $breadCrumbs[] = array('model', 'showContentEdit', '模型内容新增');
            } else {
                $breadCrumbs[] = array('model', 'showContentEdit', '模型内容修改');
            }

            $this->setCurrentMenu('model', 'content');
            $this->setBreadCrumbs($breadCrumbs);
            $this->assigns(array(
            	'data'     => $data,
            	'models'   => $modelModel->getList("*", 1, 0, 0, "`order` ASC,`model_id` ASC", "model_id"),
            	'mainTpl'  => 'model/showContentEdit'
            ));
            $this->display();
        }
    }
    
    /**
     * 
     * 添加/修改
     */
    public function edit()
    {
        $modelModel = &M('Model');
        $fieldModel = &M('ModelField');
        $data       = $this->getRequest(array(
        	'model_id'       => 0, 
        	'model_key'      => '', 
        	'model_name'     => '', 
        	'order'          => 99, 
        	'brief'          => '',
        	'field_order'    => array(),
        	'field_key'      => array(),
        	'field_name'     => array(),
        	'default_value'  => array(),
        	'field_type'     => array(),
        	'field_add_type' => array(),
        	'field_add_info' => array(),
        
        ));
        foreach ($data['field_key'] as $index => $key) {
            if (empty($key) || empty($data['field_name'][$index])) {
                $this->addMessage('模型字段参数不完整', 'error');
                $this->redirect();
            }
        }
        if (empty($data['model_key']) || empty($data['model_name'])) {
            $this->addMessage('参数不完整', 'error');
        } else {
            // 修改模型信息
            $modelId   = $data['model_id'];
            $modelData = array(
            	'model_key'      => $data['model_key'], 
            	'model_name'     => $data['model_name'], 
            	'order'          => $data['order'], 
            	'brief'          => $data['brief'], 
            	'uid'            => $this->_session['user']['uid'], 
            	'update_time'    => time(), 
            );
            if (empty($modelId)) {
                $modelData['create_time'] = time();
                $modelId = $modelModel->insert($modelData);
                if ($modelId > 0) {
                    $this->addMessage('模型添加成功', 'success');
                } else {
                    $this->addMessage('模型添加失败', 'error');
                }
            } else {
                $r = $modelModel->update($modelData, "`model_id`={$modelId}");
                if ($r) {
                    $this->addMessage('模型修改成功', 'success');
                } else {
                    $this->addMessage('模型修改失败', 'error');
                }
            }
            // 模型字段处理
            $updateFields  = array();
            $insertFields  = array();
            $deleteFields  = array();
            $fields        = $fieldModel->getList("*", "`model_id`={$modelId}", 0, 0, null, 'field_key');
            foreach ($data['field_key'] as $index => $key) {
                $insertFields[$key] = array(
                    'model_id'       => $modelId,
                    'order'          => $data['field_order'][$index],
                    'field_key'      => $data['field_key'][$index],
                    'field_name'     => $data['field_name'][$index],
                    'default_value'  => $data['default_value'][$index],
                    'field_type'     => $data['field_type'][$index],
                    'field_add_type' => $data['field_add_type'][$index],
                    'field_add_info' => $data['field_add_info'][$index],
                );
            }
            
            foreach ($fields as $field) {
                if (isset($insertFields[$field['field_key']])) {
                    $updateFields[$field['field_key']] = $insertFields[$field['field_key']];
                    unset($insertFields[$field['field_key']]);
                } else {
                    $deleteFields[$field['field_key']] = $field;
                }
            }
            if (!empty($insertFields)) {
                $fieldModel->batchInsert($insertFields);
            }
            if (!empty($deleteFields)) {
                foreach ($deleteFields as $key => $field) {
                    $key = addslashes($key);
                    $fieldModel->delete("`model_id`={$modelId} AND `field_key`='{$key}'");
                }
            }
            if (!empty($updateFields)) {
                foreach ($updateFields as $key => $field) {
                    unset($field['field_id']);
                    $key = addslashes($key);
                    $fieldModel->update($field, "`model_id`={$modelId} AND `field_key`='{$key}'");
                }
            }  
        }

        $this->redirect("?app=model&act=index");
    }
    
    /**
     * 删除.
     */
    public function delete()
    {
        $modelId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($modelId)) {
            $this->addMessage('请选择需要删除的模型', 'error');
        } else {
            $modelModel = &M('Model');
            $modelModel->delete("`model_id`={$modelId}");
            $this->addMessage('模型删除成功', 'success');
        }
        $this->redirect();
    }
}
