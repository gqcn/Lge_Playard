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
        $key       = Lib_Request::get('key');
        $catid     = Lib_Request::get('catid');
        $catid     = intval($catid);
        $tables    = array(
            'plugin_trace_product p',
            'left join plugin_trace_category c on(c.id=p.cat_id)',
        );
        $fields    = 'p.*, c.name as cat_name';
        $orderby   = '`order` asc, id desc';
        $condition = empty($catid) ? array() : array('p.cat_id' => $catid);
        if (!empty($key)) {
            $batchNo               = substr($key, 0, 10);
            $condition['batch_no'] = $batchNo;
        }
        $list      = Instance::table($tables)->getAll($fields, $condition, null, $orderby);
        $siteUrl   = Module_Setting::instance()->get('trace.site_url');
        $siteUrl   = rtrim($siteUrl, '/');
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $url = urlencode("{$siteUrl}/?no={$v['batch_no']}".base_convert(rand(1, $v['number']), 10, 36));
                $list[$k]['qrcode'] = "{$siteUrl}/qrcode?v={$url}";
            }
        }
        $this->assigns(array(
            'list'     => $list,
            'catList'  => Model_Trace_Category::instance()->getCatTree(),
            'mainTpl'  => 'trace/product/index',
        ));
        $this->display();
    }

    /**
     * 导出链接.
     */
    public function export()
    {
        $batchNo = Lib_Request::get('batch_no');
        if (empty($batchNo)) {
            $this->addMessage('请选择需要导出链接的产品', 'error');
            Lib_Redirecter::redirectExit();
        }
        $data    = Instance::table($this->bindTableName)->getOne("*", array('batch_no' => $batchNo));
        if (empty($data)) {
            $this->addMessage('请选择需要导出链接的产品', 'error');
            Lib_Redirecter::redirectExit();
        }
        $siteUrl = Module_Setting::instance()->get('trace.site_url');
        $siteUrl = rtrim($siteUrl, '/');
        $content = '';
        for ($i = 1; $i <= $data['number']; $i++) {
            $content .= "{$siteUrl}/?no={$data['batch_no']}".base_convert($i, 10, 36).PHP_EOL;
        }
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header('Content-Disposition: attachment;filename="产品链接.csv"');
        header('Cache-Control: max-age=0');
        echo $content;
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

    /**
     * 溯源管理.
     */
    public function flow()
    {
        if (Lib_Request::isRequestMethodPost()) {
            $this->_handleFlowSave();
        } else {
            $batchNo = Lib_Request::get('batch_no');
            if (empty($batchNo)) {
                $this->addMessage('请选择需要进行溯源管理的产品', 'error');
                Lib_Redirecter::redirectExit();
            }
            $this->setCurrentMenu('trace.product', 'index');
            $this->setBreadCrumbs(array(
                array(
                    'icon' => 'fa fa-cubes',
                    'name' => '产品管理',
                    'url'  => '/trace.product',
                ),
                array(
                    'icon' => '',
                    'name' => '溯源管理',
                    'url'  => '',
                ),
            ));
            if (!empty($batchNo)) {
                $data = Instance::table($this->bindTableName)->getOne("*", array('batch_no' => $batchNo));
                if (!empty($data)) {
                    $contentFlow          = empty($data['content_flow']) ? $data['content_flow'] : json_decode($data['content_flow'], true);
                    $data['content_flow'] = array();
                    $data['product_flow'] = Instance::table('plugin_trace_flow')->getAll(
                        "*", array('cat_id' => $data['cat_id']), null, "`order`,id asc", 0, 0, 'id'
                    );
                    if (!empty($data['product_flow'])) {
                        foreach ($data['product_flow'] as $flowId => $item) {
                            if (isset($contentFlow[$flowId])) {
                                $data['content_flow'][$flowId] = $contentFlow[$flowId];
                            }
                            $data['content_flow'][$flowId]['name'] = $item['name'];
                        }
                    } else {
                        $this->addMessage('当前产品分类下无溯源流程，如需溯源管理请为该分类下添加流程后继续', 'error');
                        Lib_Redirecter::redirectExit();
                    }
                } else {
                    $this->addMessage('您查询的产品不存在', 'error');
                    Lib_Redirecter::redirectExit();
                }
            }
            $this->assigns(array(
                'data'     => $data,
                'mainTpl'  => 'trace/product/flow',
            ));
            $this->display();
        }
    }

    private function _handleFlowSave()
    {
        $batchNo     = Lib_Request::getPost('batch_no');
        $contentFlow = Lib_Request::getPost('content_flow');
        $data        = array(
            'batch_no'     => $batchNo,
            'content_flow' => json_encode($contentFlow),
            'update_time'  => time(),
        );
        $result = Instance::table($this->bindTableName)->mysqlFiltSave($data);
        if ($result === false) {
            $this->addMessage('产品溯源信息保存失败', 'error');
        } else {
            $this->addMessage('产品溯源信息保存成功', 'success');
        }
        Lib_Redirecter::redirectExit();
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