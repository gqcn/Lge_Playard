<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}
/**
 * 溯源系统 - 产品分类
 */
class Controller_Trace_Category extends AceAdmin_BaseControllerAuth
{
    public $bindTableName = 'plugin_trace_category';

    /**
     * 分类管理.
     */
    public function index()
    {
        $this->assigns(array(
            'catList' => Model_Trace_Category::instance()->getCatTree(),
            'mainTpl' => 'trace/category',
        ));
        $this->display();
    }

    /**
     * 添加/修改.
     */
    public function item()
    {
        if (Lib_Request::isRequestMethodPost()) {
            $this->_handleSave();
        } else {
            $this->addMessage('参数不完整', 'error');
            Lib_Redirecter::redirectExit();
        }
    }

    private function _handleSave()
    {
        $id     = Lib_Request::getPost('id');
        $data   = Lib_Request::getPostArray(array(
            'uid'         => $this->_session['user']['uid'],
            'order'       => 99,
            'update_time' => time(),
        ), true);
        if (empty($id)) {
            $data['create_time'] = time();
        }
        $result = Instance::table($this->bindTableName)->mysqlFiltSave($data);
        if (empty($result)) {
            $this->addMessage('分类保存失败', 'error');
        } else {
            $this->addMessage('分类保存成功', 'success');
        }
        Lib_Redirecter::redirectExit();
    }

    /**
     * 列表排序.
     *
     * @return void
     */
    public function sort()
    {
        $orders = Lib_Request::getPost('orders');
        foreach ($orders as $id => $v) {
            if (empty($id)) {
                continue;
            }
            $id = intval($id);
            $v  = intval($v);
            Instance::table($this->bindTableName)->update(
                array('order' => $v),
                array('id'    => $id)
            );
        }
        $this->addMessage('分类排序完成', 'success');
        Lib_Redirecter::redirectExit();
    }
}