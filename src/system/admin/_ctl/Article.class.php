<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Article extends AceAdmin_BaseControllerAuth
{
    public $catType = 1;
    
    /**
     * 列表管理.
     */
    public function index()
    {
        $data = Lib_Request::getArray(array(
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
        $articleModel = Instance::table('_cms_article');
        $catModel     = Model_Category::instance();
        $limit        = $data['limit'] > 100 ? 100 : $data['limit'];
        $start        = $this->getStart($limit);
        $list         = $articleModel->getAll("*", $condition, $start, $limit, "`order` ASC,`id` DESC");
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
        $catModel = Model_Category::instance();
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
    public function item()
    {
        $this->setCurrentMenu('article', 'index');
        $data = array(
        	'id'           => 0,
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
        if ($data['id']) {
            $article = Instance::table('_cms_article')->getOne("*", "`id`={$data['id']}");
            if (!empty($article)) {
                $data = $article;
                $data['release_date'] = date('Y-m-d', $article['release_time']);
                $data['release_time'] = date('H-i-s', $article['release_time']);
            }
        }

        $this->assigns(array(
        	'catArray' => Model_Category::instance()->getCatTreeList($this->catType),
        	'data'     => $data,
        	'mainTpl'  => 'article/item'
        ));
        $this->display();
    }
    
    /**
     * 
     * 文章添加/修改
     */
    public function edit()
    {
        $data = Lib_Request::getPostArray(array(
        	'id'           => 0,
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
        $rules = array(
            'author' => array('required', '文章作者不能为空'),
            'title'  => array('required', '文章标题不能为空'),
        );
        $checkError = Lib_Validator::check($data, $rules, 2, true);
        if (!empty($checkError)) {
            $this->addMessage($checkError, 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['status']       = 1;
            $data['release_time'] = strtotime("{$data['release_date']} {$data['release_time']}");
            $data['update_time']  = time();
            if (empty($data['id'])) {
                $data['create_time'] = time();
            }
            $result = Instance::table('_cms_article')->save($data);
            if (empty($result)) {
                $this->addMessage('文章保存失败', 'error');
            } else {
                $this->addMessage('文章保存成功', 'success');
            }
        }
        Lib_Redirecter::redirectExit();
    }
}
