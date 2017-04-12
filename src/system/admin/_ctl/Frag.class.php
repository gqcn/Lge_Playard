<?php
if(!defined('PhpMe')){
	exit('Include Permission Denied!');
}

class Controller_Frag extends BaseAppEx
{
    public $catType = 5;
    
    /**
     * 列表管理.
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('frag'),
        ));
        
        $data = $this->getRequest(array(
        	'limit'  => 10, 
        	'cat_id' => 0, 
        	'key'    => '', 
        ));
        $condition = 1;
        if (!empty($data['cat_id'])) {
            $catId      = intval($data['cat_id']);
            $condition .= " AND `cat_id`={$catId}"; 
        }
        if (!empty($data['key'])) {
            $condition .= " AND `name` LIKE '%{$data['key']}%'"; 
        }
        $fragModel    = &M('Frag');
        $catModel     = &M('Category');
        $limit        = $data['limit'] > 100 ? 100 : $data['limit'];
        $start        = $this->getStart($limit);
        $list         = $fragModel->getList("*", $condition, $start, $limit, "`order` ASC,`frag_id` DESC");
        $count        = $fragModel->getCount($condition);
        $catArray     = $catModel->getCatArray($this->catType);
        foreach ($list as $k => $v) {
            $v['cat_name'] = isset($catArray[$v['cat_id']]['cat_name']) ? $catArray[$v['cat_id']]['cat_name'] : '';
            $list[$k]      = $v;
        }
        $this->assigns(array(
            'list'     => $list,
        	'page'     => $this->getPage($count, $limit),
        	'catArray' => $catModel->getCatTreeListByCatArray($catArray),
        	'mainTpl'  => 'frag/index'
        ));
        $this->display();
    }
    
    /**
     * 碎片分类管理
     */
    public function category()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('frag'),
            array('frag', 'category'),
        ));
        $catModel = &M('Category');
        $this->assigns(array(
        	'type'     => $this->catType,
        	'catArray' => $catModel->getCatTreeList($this->catType),
        	'mainTpl'  => 'category/category',
        ));
        $this->display();
    }
    
    /**
     * 异步判断key是否重复.
     */
    public function asyncCheckKey()
    {
        $data = $this->getRequest(array(
        	'key'     => '',
        	'frag_id' => 0,
        ));
        $message = "true";
        if (!empty($data['key'])) {
            $fragModel = &M('Frag');
            $count     = $fragModel->getCount("`frag_id`!={$data['frag_id']} AND `key`='{$data['key']}'");
            if ($count > 0) {
                $message = "碎片Key已经存在";
            }
        } else {
            $message = "请输入碎片Key";
        }
        echo json_encode($message);
    }
    
    /**
     * 显示碎片添加/修改
     */
    public function showEdit()
    {
        $fragId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        $data   = array(
        	'frag_id'      => 0, 
        	'cat_id'       => 0, 
        	'order'        => 999, 
        	'key'          => '', 
        	'name'         => '', 
        	'content' 	   => '', 
        );
        if ($fragId) {
            $fragModel = &M('Frag');
            $frag      = $fragModel->getOne("*", "`frag_id`={$fragId}");
            if (!empty($frag)) {
                $data = $frag;
            }
        }
        // 面包屑
        $breadCrumbs = array(
            array('default'),
            array('frag'),
        );
        if (empty($fragId)) {
            $breadCrumbs[] = array('frag', 'showEdit');
        } else {
            $breadCrumbs[] = array('frag', 'showEdit', '碎片修改');
            $this->setCurrentMenu('frag', 'index');
        }
        $this->setBreadCrumbs($breadCrumbs);
        // 树形分类
        $catModel = &M('Category');
        $catTree  = $catModel->getCatTreeList($this->catType);
        $this->assigns(array(
        	'catArray' => $catTree,
        	'data'     => $data,
        	'mainTpl'  => 'frag/showEdit'
        ));
        $this->display();
    }
    
    /**
     * 
     * 碎片添加/修改
     */
    public function edit()
    {
        $data = $this->getRequest(array(
        	'frag_id'      => 0, 
        	'cat_id'       => 0, 
        	'order'        => 999, 
        	'key'          => '', 
        	'name'         => '', 
        	'content' 	   => '', 
        ));
        $fragId = $data['frag_id'];
        if (empty($data['name']) || empty($data['key'])) {
            $this->addMessage('参数不完整', 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['status']       = 1;
            $data['update_time']  = time();
            $fragModel            = &M('Frag');
            unset($data['frag_id']);
            if (empty($fragId)) {
                $data['create_time'] = time();
                $fragId           = $fragModel->insert($data);
                if ($fragId > 0) {
                    $this->addMessage('碎片添加成功', 'success');
                } else {
                    $this->addMessage('碎片添加失败', 'error');
                }
            } else {
                $r = $fragModel->update($data, "`frag_id`={$fragId}");
                if ($r) {
                    $this->addMessage('碎片修改成功', 'success');
                } else {
                    $this->addMessage('碎片修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 碎片删除.
     */
    public function delete()
    {
        $fragId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($fragId)) {
            $this->addMessage('请选择需要删除的碎片', 'error');
        } else {
            $fragModel = &M('Frag');
            $fragModel->delete("`frag_id`={$fragId}");
            $this->addMessage('碎片删除成功', 'success');
        }
        $this->redirect();
    }
}
