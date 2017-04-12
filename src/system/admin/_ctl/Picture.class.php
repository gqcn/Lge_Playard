<?php
if(!defined('PhpMe')){
	exit('Include Permission Denied!');
}

class Controller_Picture extends BaseAppEx
{
    public $catType = 2;
    
    /**
     * 列表管理.
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('picture'),
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
        $pictureModel = &M('Picture');
        $catModel     = &M('Category');
        $limit        = $data['limit'] > 100 ? 100 : $data['limit'];
        $start        = $this->getStart($limit);
        $list         = $pictureModel->getList("*", $condition, $start, $limit, "`order` ASC,`picture_id` DESC");
        $count        = $pictureModel->getCount($condition);
        $catArray     = $catModel->getCatArray($this->catType);
        foreach ($list as $k => $v) {
            $v['cat_name'] = isset($catArray[$v['cat_id']]['cat_name']) ? $catArray[$v['cat_id']]['cat_name'] : '';
            $list[$k]      = $v;
        }
        $this->assigns(array(
            'list'     => $list,
        	'page'     => $this->getPage($count, $limit),
        	'catArray' => $catModel->getCatTreeListByCatArray($catArray),
        	'mainTpl'  => 'picture/index'
        ));
        $this->display();
    }
    
    /**
     * 图片分类管理
     */
    public function category()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('picture'),
            array('picture', 'category'),
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
     * 显示图片添加/修改
     */
    public function showEdit()
    {
        $pictureId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        $data      = array(
        	'picture_id'   => 0, 
        	'cat_id'       => 0, 
        	'author'       => $this->_session['user']['nickname'], 
        	'order'        => 999, 
        	'title'        => '', 
        	'thumb'        => '', 
        	'brief'        => '', 
        	'content' 	   => '', 
        	'tags' 		   => ''
        );
        if ($pictureId) {
            $pictureModel = &M('Picture');
            $contentModel = &M('PictureContent');
            $picture      = $pictureModel->getOne("*", "`picture_id`={$pictureId}");
            $content      = $contentModel->getValue("`content`", "`picture_id`={$pictureId}");
            if (!empty($picture)) {
                $data            = $picture;
                $data['content'] = $content;
            }
        }
        // 面包屑
        $breadCrumbs = array(
            array('default'),
            array('picture'),
        );
        if (empty($pictureId)) {
            $breadCrumbs[] = array('picture', 'showEdit');
        } else {
            $breadCrumbs[] = array('picture', 'showEdit', '图片修改');
            $this->setCurrentMenu('picture', 'index');
        }
        $this->setBreadCrumbs($breadCrumbs);
        // 树形分类
        $catModel = &M('Category');
        $catTree  = $catModel->getCatTreeList($this->catType);
        $this->assigns(array(
        	'catArray' => $catTree,
        	'data'     => $data,
        	'mainTpl'  => 'picture/showEdit'
        ));
        $this->display();
    }
    
    /**
     * 
     * 图片添加/修改
     */
    public function edit()
    {
        $data = $this->getRequest(array(
        	'picture_id'   => 0, 
        	'cat_id'       => 0, 
        	'author'       => '', 
        	'order'        => 999, 
        	'thumb'        => '', 
        	'title'        => '', 
        	'brief'        => '', 
        	'content' 	   => '', 
        	'tags' 		   => ''
        ));
        $pictureId = $data['picture_id'];
        $content   = $data['content'];
        if (empty($data['author'])) {
            $this->addMessage('图片作者不能为空', 'error');
        } else if (empty($data['title'])) {
            $this->addMessage('图片标题不能为空', 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['status']       = 1;
            $data['update_time']  = time();
            unset($data['picture_id'], $data['content']);
            $pictureModel = &M('Picture');
            $contentModel = &M('PictureContent');
            if (empty($pictureId)) {
                $data['create_time'] = time();
                $pictureId           = $pictureModel->insert($data);
                if ($pictureId > 0) {
                    $contentModel->insert(array(
                        'picture_id' => $pictureId,
                        'content'    => $content,
                    ));
                    $this->addMessage('图片添加成功', 'success');
                } else {
                    $this->addMessage('图片添加失败', 'error');
                }
            } else {
                $r1 = $pictureModel->update($data, "`picture_id`={$pictureId}");
                $r2 = $contentModel->update(array(
                	'content' => $content
                ), "`picture_id`={$pictureId}");
                if ($r1 || $r2) {
                    $this->addMessage('图片修改成功', 'success');
                } else {
                    $this->addMessage('图片修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 图片删除.
     */
    public function delete()
    {
        $pictureId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($pictureId)) {
            $this->addMessage('请选择需要删除的图片', 'error');
        } else {
            $pictureModel = &M('Picture');
            $contentModel = &M('PictureContent');
            $pictureModel->delete("`picture_id`={$pictureId}");
            $contentModel->delete("`picture_id`={$pictureId}");
            $this->addMessage('图片删除成功', 'success');
        }
        $this->redirect();
    }
}
