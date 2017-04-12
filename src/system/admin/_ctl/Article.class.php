<?php
if(!defined('PhpMe')){
	exit('Include Permission Denied!');
}

class Controller_Article extends BaseAppEx
{
    public $catType = 1;
    
    /**
     * 列表管理.
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('article'),
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
        $articleModel = &M('Article');
        $catModel     = &M('Category');
        $limit        = $data['limit'] > 100 ? 100 : $data['limit'];
        $start        = $this->getStart($limit);
        $list         = $articleModel->getList("*", $condition, $start, $limit, "`order` ASC,`article_id` DESC");
        $count        = $articleModel->getCount($condition);
        $catArray     = $catModel->getCatArray($this->catType);
        foreach ($list as $k => $v) {
            $v['cat_name'] = isset($catArray[$v['cat_id']]['cat_name']) ? $catArray[$v['cat_id']]['cat_name'] : '';
            $list[$k]      = $v;
        }
        $this->assigns(array(
            'list'     => $list,
        	'page'     => $this->getPage($count, $limit),
        	'catArray' => $catModel->getCatTreeListByCatArray($catArray),
        	'mainTpl'  => 'article/index'
        ));
        $this->display();
    }
    
    /**
     * 文章分类管理
     */
    public function category()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('article'),
            array('article', 'category'),
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
     * 显示文章添加/修改
     */
    public function showEdit()
    {
        $articleId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        $data      = array(
        	'article_id'   => 0, 
        	'cat_id'       => 0, 
        	'author'       => $this->_session['user']['nickname'], 
        	'order'        => 999, 
        	'release_date' => date('Y-m-d'), 
        	'release_time' => date('H:i:s'), 
        	'title'        => '', 
        	'thumb'        => '', 
        	'referer'      => '', 
        	'referto'      => '', 
        	'brief'        => '', 
        	'content' 	   => '', 
        	'tags' 		   => ''
        );
        if ($articleId) {
            $articleModel = &M('Article');
            $contentModel = &M('ArticleContent');
            $article      = $articleModel->getOne("*", "`article_id`={$articleId}");
            $content      = $contentModel->getValue("`content`", "`article_id`={$articleId}");
            if (!empty($article)) {
                $data = $article;
                $data['release_date'] = date('Y-m-d', $article['release_time']);
                $data['release_time'] = date('H-i-s', $article['release_time']);
                $data['content']      = $content;
            }
        }
        // 面包屑
        $breadCrumbs = array(
            array('default'),
            array('article'),
        );
        if (empty($articleId)) {
            $breadCrumbs[] = array('article', 'showEdit');
        } else {
            $breadCrumbs[] = array('article', 'showEdit', '文章修改');
            $this->setCurrentMenu('article', 'index');
        }
        $this->setBreadCrumbs($breadCrumbs);
        // 树形分类
        $catModel = &M('Category');
        $catTree  = $catModel->getCatTreeList($this->catType);
        $this->assigns(array(
        	'catArray' => $catTree,
        	'data'     => $data,
        	'mainTpl'  => 'article/showEdit'
        ));
        $this->display();
    }
    
    /**
     * 
     * 文章添加/修改
     */
    public function edit()
    {
        $data = $this->getRequest(array(
        	'article_id'   => 0, 
        	'cat_id'       => 0, 
        	'author'       => '', 
        	'order'        => 999, 
        	'thumb'        => '', 
        	'release_date' => date('Y-m-d'), 
        	'release_time' => date('H-i-s'), 
        	'title'        => '', 
        	'referer'      => '', 
        	'referto'      => '', 
        	'brief'        => '', 
        	'content' 	   => '', 
        	'tags' 		   => ''
        ));
        $articleId = $data['article_id'];
        $content   = $data['content'];
        if (empty($data['author'])) {
            $this->addMessage('文章作者不能为空', 'error');
        } else if (empty($data['title'])) {
            $this->addMessage('文章标题不能为空', 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['status']       = 1;
            $data['release_time'] = strtotime("{$data['release_date']} {$data['release_time']}");
            $data['update_time']  = time();
            unset($data['article_id'], $data['release_date'], $data['content']);
            $articleModel = &M('Article');
            $contentModel = &M('ArticleContent');
            if (empty($articleId)) {
                $data['create_time'] = time();
                $articleId           = $articleModel->insert($data);
                if ($articleId > 0) {
                    $contentModel->insert(array(
                        'article_id' => $articleId,
                        'content'    => $content,
                    ));
                    $this->addMessage('文章添加成功', 'success');
                } else {
                    $this->addMessage('文章添加失败', 'error');
                }
            } else {
                $r1 = $articleModel->update($data, "`article_id`={$articleId}");
                $r2 = $contentModel->update(array(
                'content' => $content
                ), "`article_id`={$articleId}");
                if ($r1 || $r2) {
                    $this->addMessage('文章修改成功', 'success');
                } else {
                    $this->addMessage('文章修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 文章删除.
     */
    public function delete()
    {
        $articleId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($articleId)) {
            $this->addMessage('请选择需要删除的文章', 'error');
        } else {
            $articleModel = &M('Article');
            $contentModel = &M('ArticleContent');
            $articleModel->delete("`article_id`={$articleId}");
            $contentModel->delete("`article_id`={$articleId}");
            $this->addMessage('文章删除成功', 'success');
        }
        $this->redirect();
    }
}
