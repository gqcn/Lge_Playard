<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}
/**
 * 溯源系统 - 产品分类.
 *
 */
class Model_Trace_Category extends BaseModelTable
{
    public $table = 'plugin_trace_category';

    /**
     * 获得实例.
     *
     * @return Model_Trace_Category
     */
    public static function instance()
    {
        return self::_instanceInternal(__CLASS__);
    }

    /**
     * 获得分类列表.
     *
     * @return array
     */
    public function getCatArray()
    {
        $condition = array();
        $catArray  = $this->getAll("*", $condition, null, "`order` ASC,`id` ASC", 0, 0, 'id');
        return $catArray;
    }

    /**
     * 获得特定栏目的下一级子节点
     *
     * @param  array   $catArray 分类数组.
     * @param  integer $pCatId   父级ID.
     * @return array
     */
    public function getSubList(&$catArray, $pCatId)
    {
        $list = array();
        foreach ($catArray as $v){
            if($v['pid'] != $pCatId){
                continue;
            }
            $list[] = $v;
        }
        return $list;
    }

    /**
     * 获取当前我可管理的应用列表.
     *
     * @return array
     */
    public function getCatTree()
    {
        $catArray  = $this->getCatArray();
        $tree      = new Lib_Tree($catArray, array(
            'id'        => 'id',
            'parent_id' => 'pid',
            'name'      => 'name'
        ));
        return $tree->get_tree(0, '$spacer $name');
    }
}