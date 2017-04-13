<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}
/**
 * 
 * @todo 分类key重复异步判断.
 * @author john
 *
 */
class Controller_Category extends AceAdmin_BaseControllerAuth
{
    // 分类 或者 分组
    public $name = '分类';
    
    public function __init()
    {
        
    }
    
    /**
     * 分类 排序.
     * 
     * @return void
     */
    public function sort()
    {
        $data     = $this->getRequest(array(
            'type'   => 1, 
            'orders' => array()
        ));
        $type     = intval($data['type']);
        $orders   = $data['orders'];
        $catModel = &M('Category');
        $catArray = $catModel->getCatArray($type);
        foreach ($orders as $catId => $order) {
            $catId = intval($catId);
            $order = intval($order);
            if (isset($catArray[$catId]) && $catArray[$catId]['order'] != $order) {
                $catModel->update(array('order' => $order), "`cat_id`={$catId}");
            }
        }
        $this->addMessage("{$this->name}重新排序完成", 'success');
        $this->redirect();
    }
    
    /**
     * 分类 添加/修改.
     * 
     * @return void
     */
    public function edit()
    {
        $data = $this->getRequest(array(
            'cat_id'   => 0, 
            'pcat_id'  => 0, 
            'order'    => 99, 
            'type'     => 0, 
            'brief'    => '', 
            'cat_key'  => '',
            'cat_name' => ''
        ));
        if (empty($data['cat_name']) || empty($data['type'])) {
            $this->addMessage("参数不完整", 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['update_time']  = time();
            $data['order']        = intval($data['order']);
            $catModel             = &M('Category');
            if (empty($data['cat_id'])) {
                $data['create_time'] = $data['update_time'];
                if ($catModel->insert($data)) {
                    $this->addMessage("{$this->name}添加成功", 'success');
                } else {
                    $this->addMessage("{$this->name}添加失败", 'error');
                }
            } else {
                $catId = intval($data['cat_id']);
                if ($catModel->update($data, "`cat_id`={$catId}")) {
                    $this->addMessage("{$this->name}信息修改成功", 'success');
                } else {
                    $this->addMessage("{$this->name}信息修改失败", 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 删除分类.
     */
    public function delete()
    {
        if (empty($this->_get['cat_id'])) {
            $this->addMessage("需要删除的{$this->name}ID不能为空", 'error');
        } else {
            $catId    = intval($this->_get['cat_id']);
            $catModel = &M('Category');
            $category = $catModel->getOne("*", "`pcat_id`={$catId}");
            if (empty($category)) {
                if ($catModel->delete("`cat_id`={$catId}")) {
                    $this->addMessage("{$this->name}删除成功", 'success');
                } else {
                    $this->addMessage("{$this->name}删除失败", 'error');
                }
            } else {
                $this->addMessage("{$this->name}下存在子级, 不能被删除", 'error');
            }
            $this->redirect();
        }
    }
}
?>
