<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

/**
 * 友情链接
 */
class Controller_Link extends AceAdmin_BaseControllerAuth
{
    public $catType = 4;
    
    /**
     * 列表管理.
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('link'),
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
            $condition .= " AND `title` LIKE '%{$data['key']}%'"; 
        }
        $linkModel    = &M('Link');
        $catModel     = &M('Category');
        $limit        = $data['limit'] > 100 ? 100 : $data['limit'];
        $start        = $this->getStart($limit);
        $list         = $linkModel->getList("*", $condition, $start, $limit, "`order` ASC,`link_id` DESC");
        $count        = $linkModel->getCount($condition);
        $catArray     = $catModel->getCatArray($this->catType);
        foreach ($list as $k => $v) {
            $v['cat_name'] = isset($catArray[$v['cat_id']]['cat_name']) ? $catArray[$v['cat_id']]['cat_name'] : '';
            $list[$k]      = $v;
        }
        $this->assigns(array(
            'list'     => $list,
        	'page'     => $this->getPage($count, $limit),
        	'catArray' => $catModel->getCatTreeListByCatArray($catArray),
        	'mainTpl'  => 'link/index'
        ));
        $this->display();
    }
    
    /**
     * 连接分类管理
     */
    public function category()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('link'),
            array('link', 'category'),
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
     * 显示连接添加/修改
     */
    public function showEdit()
    {
        $linkId    = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        $data      = array(
        	'link_id'      => 0, 
        	'cat_id'       => 0, 
        	'order'        => 999, 
        	'title'        => '', 
        	'thumb'        => '', 
        	'url'          => '', 
        	'brief'        => '', 
        );
        if ($linkId) {
            $linkModel = &M('Link');
            $link      = $linkModel->getOne("*", "`link_id`={$linkId}");
            if (!empty($link)) {
                $data = $link;
            }
        }
        // 面包屑
        $breadCrumbs = array(
            array('default'),
            array('link'),
        );
        if (empty($linkId)) {
            $breadCrumbs[] = array('link', 'showEdit');
        } else {
            $breadCrumbs[] = array('link', 'showEdit', '连接修改');
            $this->setCurrentMenu('link', 'index');
        }
        $this->setBreadCrumbs($breadCrumbs);
        // 树形分类
        $catModel = &M('Category');
        $catTree  = $catModel->getCatTreeList($this->catType);
        $this->assigns(array(
        	'catArray' => $catTree,
        	'data'     => $data,
        	'mainTpl'  => 'link/showEdit'
        ));
        $this->display();
    }
    
    /**
     * 
     * 连接添加/修改
     */
    public function edit()
    {
        $data = $this->getRequest(array(
        	'link_id'      => 0, 
        	'cat_id'       => 0, 
        	'order'        => 999, 
        	'thumb'        => '', 
        	'title'        => '', 
        	'url'          => '', 
        	'brief'        => '', 
        ));
        $linkId  = $data['link_id'];
        if (empty($data['title']) || empty($data['url'])) {
            $this->addMessage('参数不完整', 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['status']       = 1;
            $linkModel            = &M('Link');
            unset($data['link_id']);
            if (empty($linkId)) {
                $data['create_time'] = time();
                $linkId           = $linkModel->insert($data);
                if ($linkId > 0) {
                    $this->addMessage('连接添加成功', 'success');
                } else {
                    $this->addMessage('连接添加失败', 'error');
                }
            } else {
                $r = $linkModel->update($data, "`link_id`={$linkId}");
                if ($r) {
                    $this->addMessage('连接修改成功', 'success');
                } else {
                    $this->addMessage('连接修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 连接删除.
     */
    public function delete()
    {
        $linkId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($linkId)) {
            $this->addMessage('请选择需要删除的连接', 'error');
        } else {
            $linkModel = &M('Link');
            $linkModel->delete("`link_id`={$linkId}");
            $this->addMessage('连接删除成功', 'success');
        }
        $this->redirect();
    }
}
