<?php
if(!defined('PhpMe')){
    exit('Include Permission Denied!');
}
/**
 * 网站类别管理模型。
 *
 */
class Model_SiteType extends BaseModelTable
{
    public function setTableAndPri()
    {
        $this->table   = 'site_type';
        $this->primary = 'type_id';
    }
    
    /**
     * 获得分类列表.
     * 
     * @param integer $type 分类类型.
     * 
     * @return array
     */
    public function getTypeArray($type)
    {
        $typeArray = $this->getList("*", "1", 0, 0, "`order` ASC,`type_id` ASC", true);
        return $typeArray;
    }
    
    /**
     * 获得树形列表.
     * 
     * @param integer $type 分类类型.
     * 
     * @return array
     */
    public function getTypeTreeList($type)
    {
        $typeArray = $this->getTypeArray($type);
        return $this->getTypeTreeListByTypeArray($typeArray);
    }
    
    /**
     * 获得树形列表.
     * 
	 * @param  array   $typeArray 分类数组.
     * 
     * @return array
     */
    public function getTypeTreeListByTypeArray($typeArray)
    {
        importLib('Tree');
        $tree     = new Tree($typeArray, array(
            'id'        => 'type_id', 
            'parent_id' => 'ptype_id', 
            'name'      => 'type_name'
        ));
        return $tree->get_tree(0, '$spacer $type_name');
    }
    
	/**
	 * 获得特定栏目的下一级子节点
	 *
	 * @param  array   $typeArray 分类数组.
	 * @param  integer $pTypeId   父级ID.
	 * @return array
	 */
	public function getSubList(&$typeArray, $pTypeId)
	{
	    $list = array();
	    foreach ($typeArray as $v){
	        if($v['ptype_id'] != $pTypeId){
	            continue;
	        }
	        $list[] = $v;
	    }
	    return $list;
	}
	
	/**
	 * 获取指定顶级栏目所有子栏目的ID，合成字符串返回
	 *
	 * @param  $typeArray $typeArray 分类数组.
	 * @param  integer   $pTypeId   栏目ID 
	 * @param  string    $children (不需要传参)
	 * @return string
	 */
	public function getChildren(&$typeArray, $pTypeId, $children = '')
	{
		$list = $this->getSubList($pTypeId);
		foreach ($list as $row){
			$children .= $row['type_id'].',';
			$children  = $this->getChildren($row['type_id'], $children);
		}
		return rtrim($children, ',');
	}
}
?>