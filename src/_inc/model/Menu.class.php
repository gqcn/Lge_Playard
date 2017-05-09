<?php
namespace Lge;
if (!defined('LGE')) {
    exit('Include Permission Denied!');
}
/**
 * 菜单管理模型。
 *
 */
class Model_Menu extends BaseModelTable
{
    public $table = '_menu';
    public $types = array(
        0 => '内部连接',
        1 => '外部连接',
        2 => '连接到模块',
    );
    
    public $targets = array(
        '_blank' => '新窗口',
        '_self'  => '原窗口',
    );
    
    /**
     * 获得菜单列表.
     * 
     * @param integer $type 菜单类型.
     * 
     * @return array
     */
    public function getMenuArray()
    {
        $menuArray = $this->getList("*", 1, 0, 0, "`order` ASC,`menu_id` ASC", true);
        return $menuArray;
    }
    
    /**
     * 获得树形列表.
     * 
     * @param integer $type 菜单类型.
     * 
     * @return array
     */
    public function getMenuTreeList()
    {
        $menuArray = $this->getMenuArray();
        return $this->getCatTreeListByMenuArray($menuArray);
    }
    
    /**
     * 获得树形列表.
     * 
	 * @param  array   $menuArray 菜单数组.
     * 
     * @return array
     */
    public function getCatTreeListByMenuArray($menuArray)
    {
        importLib('Tree');
        $tree     = new Tree($menuArray, array(
            'id'        => 'menu_id', 
            'parent_id' => 'pmenu_id', 
            'name'      => 'menu_name'
        ));
        return $tree->getTree(0, '$spacer $menu_name');
    }
    
	/**
	 * 获得特定栏目的下一级子节点
	 *
	 * @param  array   $menuArray 菜单数组.
	 * @param  integer $pMenuId   父级ID.
	 * @return array
	 */
	public function getSubList(&$menuArray, $pMenuId)
	{
	    $list = array();
	    foreach ($menuArray as $v){
	        if($v['pmenu_id'] != $pMenuId){
	            continue;
	        }
	        $list[] = $v;
	    }
	    return $list;
	}
	
	/**
	 * 获取指定顶级栏目所有子栏目的ID，合成字符串返回
	 *
	 * @param  $menuArray $menuArray 菜单数组.
	 * @param  integer   $pMenuId   栏目ID 
	 * @param  string    $children (不需要传参)
	 * @return string
	 */
	public function getChildren(&$menuArray, $pMenuId, $children = '')
	{
		$list = $this->getSubList($pMenuId);
		foreach ($list as $row){
			$children .= $row['menu_id'].',';
			$children  = $this->getChildren($row['menu_id'], $children);
		}
		return rtrim($children, ',');
	}
}
