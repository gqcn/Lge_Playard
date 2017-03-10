<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}
/**
 * 溯源系统 - 产品管理
 */
class Controller_Trace_Product extends AceAdmin_BaseControllerAuth
{
    public $bindTableName    = 'plugin_trace_product';
    public $bindTablePrimary = 'batch_no';

    /**
     * 分类管理.
     */
    public function index()
    {
        $catid     = Lib_Request::get('catid');
        $catid     = intval($catid);
        $tables    = array(
            'plugin_trace_product p',
            'left join plugin_trace_category c on(c.id=p.cat_id)',
        );
        $fields    = 'p.*, c.name as cat_name';
        $condition = empty($catid) ? array() : array('p.cat_id' => $catid);
        $orderby   = '`order` asc, id desc';
        $list      = Instance::table($tables)->getAll($fields, $condition, null, $orderby);

        $this->assigns(array(
            'list'     => $list,
            'catList'  => Model_Trace_Category::instance()->getCatTree(),
            'mainTpl'  => 'trace/product/index',
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
            $batchNo = Lib_Request::get('batch_no');
            $this->setCurrentMenu('trace.product', 'index');
            $this->setBreadCrumbs(array(
                array(
                    'icon' => 'fa fa-cubes',
                    'name' => '产品管理',
                    'url'  => '/trace.product',
                ),
                array(
                    'icon' => '',
                    'name' => empty($batchNo) ? '添加产品' : '修改产品',
                    'url'  => '',
                ),
            ));
            $data   = array(
                'batch_no' => Model_Trace_Product::instance()->makeUniqueBatchNo(),
                'order'    => 999,
            );
            if (!empty($batchNo)) {
                $result = Instance::table($this->bindTableName)->getOne("*", array('batch_no' => $batchNo));
                if (!empty($result)) {
                    $data = array_merge($data, $result);
                }
            }
            $this->assigns(array(
                'data'     => $data,
                'catList'  => Model_Trace_Category::instance()->getCatTree(),
                'mainTpl'  => 'trace/product/item',
            ));
            $this->display();
        }
    }

    private function _handleSave()
    {
        $batchNo = Lib_Request::getPost('batch_no');
        $data    = Lib_Request::getPostArray(array(
            'uid'         => $this->_session['user']['uid'],
            'order'       => 999,
            'update_time' => time(),
        ), true);
        if (empty($batchNo)) {
            $data['create_time'] = time();
        }
        $result = Instance::table($this->bindTableName)->mysqlFiltSave($data);
        if ($result === false) {
            $this->addMessage('产品保存失败', 'error');
        } else {
            $this->addMessage('产品保存成功', 'success');
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