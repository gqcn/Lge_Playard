<?php
if(!defined('PhpMe')){
	exit('Include Permission Denied!');
}

class Controller_Menu extends BaseAppEx
{
    public $catType = 3;
    
    /**
     * 菜单管理
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('menu'),
        ));
        $menuModel = &M('Menu');
        $catModel  = &M('Category');
        $catArray  = $catModel->getCatTreeList($this->catType);
        $menuArray = $menuModel->getMenuTreeList();
        $modules   = $catModel->getLinkableModules();
        $moduleCatMap = array();
        $menuCatMap   = array();
        foreach ($modules as $type => $module) {
            if (!empty($module['list'])) {
                foreach ($module['list'] as $k => $v) {
                    $moduleCatMap[$v['cat_id']] = $v;
                }
            }
        }
        foreach ($catArray as $k => $cat) {
            $menuCatMap[$cat['cat_id']] = $cat;
        }

        // 重新组织展示菜单数据
        foreach ($menuArray as $k => $menu) {
            $menu['type_name'] = $menuModel->types[$menu['type']];
            if (!empty($menu['tcat_id']) && !empty($moduleCatMap[$menu['tcat_id']])) {
                $menu['url_name'] = "连接到模块：{$moduleCatMap[$menu['tcat_id']]['old_name']}";
            }
            if (!empty($menu['cat_id']) && !empty($menuCatMap[$menu['cat_id']])) {
                $menu['cat_name'] = $menuCatMap[$menu['cat_id']]['old_name'];
            } else {
                $menu['cat_name'] = '(无分组)';
            }
            $menu['target_name'] = $menuModel->targets[$menu['target']];
            $menuArray[$k] = $menu;
        }

        $this->assigns(array(
        	'menuArray' => $menuArray,
        	'catArray'  => $catArray,
        	'modules'   => $modules,
        	'mainTpl'   => 'menu/index',
        ));
        $this->display();
    }
    
    /**
     * 菜单分类管理
     */
    public function category()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('menu'),
            array('menu', 'category'),
        ));
        $catModel = &M('Category');
        $this->assigns(array(
        	'type'     => 3,
        	'catArray' => $catModel->getCatTreeList($this->catType),
        	'mainTpl'  => 'category/category',
        ));
        $this->display();
    }
    
    /**
     * 菜单 排序.
     * 
     * @return void
     */
    public function sort()
    {
        $data = $this->getRequest(array(
            'orders' => array()
        ));
        $orders    = $data['orders'];
        $menuModel  = &M('Menu');
        $menuArray = $menuModel->getMenuArray();
        foreach ($orders as $menuId => $order) {
            $menuId = intval($menuId);
            $order  = intval($order);
            if (isset($menuArray[$menuId]) && $menuArray[$menuId]['order'] != $order) {
                $menuModel->update(array('order' => $order), "`menu_id`={$menuId}");
            }
        }
        $this->addMessage('菜单重新排序完成', 'success');
        $this->redirect();
    }
    
    /**
     * 菜单 添加/修改.
     * 
     * @return void
     */
    public function edit()
    {
        $data = $this->getRequest(array(
            'menu_id'     => 0, 
            'type'        => 0, 
            'cat_id'      => 0, 
            'pmenu_id'    => 0, 
            'order'       => 99, 
            'menu_key'    => '', 
            'menu_name'   => '', 
            'url_0'       => '',
            'url_1'       => '',
            'tcat_id'     => 0,
            'target'      => '_blank',
        ));
        if (empty($data['menu_name'])) {
            $this->addMessage("请输入菜单名称", 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['create_time']  = time();
            $data['order']        = intval($data['order']);
            switch ($data['type']) {
                case 0:
                    $data['url']     = $data['url_0'];
                    $data['tcat_id'] = 0;
                    break;
                    
                case 1:
                    $data['url']     = $data['url_1'];
                    $data['tcat_id'] = 0;
                    break;
                    
                case 2:
                    $data['url'] = '';
                    break;
            }
            unset($data['url_0'], $data['url_1']);
            $menuModel = &M('Menu');
            if (empty($data['menu_id'])) {
                if ($menuModel->insert($data)) {
                    $this->addMessage('菜单添加成功', 'success');
                } else {
                    $this->addMessage('菜单添加失败', 'error');
                }
            } else {
                $menuId = intval($data['menu_id']);
                if ($menuModel->update($data, "`menu_id`={$menuId}")) {
                    $this->addMessage('菜单信息修改成功', 'success');
                } else {
                    $this->addMessage('菜单信息修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 删除菜单.
     */
    public function delete()
    {
        if (empty($this->_get['menu_id'])) {
            $this->addMessage('请选择需要删除的菜单', 'error');
        } else {
            $menuId    = intval($this->_get['menu_id']);
            $menuModel = &M('Menu');
            $menuegory = $menuModel->getOne("*", "`pmenu_id`={$menuId}");
            if (empty($menuegory)) {
                if ($menuModel->delete("`menu_id`={$menuId}")) {
                    $this->addMessage('菜单删除成功', 'success');
                } else {
                    $this->addMessage('菜单删除失败', 'error');
                }
            } else {
                $this->addMessage('菜单下存在子级, 不能被删除', 'error');
            }
            $this->redirect();
        }
    }

}
?>
