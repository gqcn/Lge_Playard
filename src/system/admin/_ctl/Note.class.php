<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Note extends AceAdmin_BaseControllerAuth
{
    public $catType = 6;
    
    /**
     * 列表管理.
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('note'),
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
        $noteModel = &M('Note');
        $catModel     = &M('Category');
        $limit        = $data['limit'] > 100 ? 100 : $data['limit'];
        $start        = $this->getStart($limit);
        $list         = $noteModel->getList("*", $condition, $start, $limit, "`order` ASC,`note_id` DESC");
        $count        = $noteModel->getCount($condition);
        $catArray     = $catModel->getCatArray($this->catType);
        foreach ($list as $k => $v) {
            $v['cat_name'] = isset($catArray[$v['cat_id']]['cat_name']) ? $catArray[$v['cat_id']]['cat_name'] : '';
            $list[$k]      = $v;
        }
        $this->assigns(array(
            'list'     => $list,
        	'page'     => $this->getPage($count, $limit),
        	'catArray' => $catModel->getCatTreeListByCatArray($catArray),
        	'mainTpl'  => 'note/index'
        ));
        $this->display();
    }
    
    /**
     * 笔记分类管理
     */
    public function category()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('note'),
            array('note', 'category'),
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
     * 显示笔记
     */
    public function showView()
    {
        $noteId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($noteId)) {
            $this->addMessage('请选择需要查看的笔记', 'error');
        } else {
            if ($noteId) {
                $noteModel    = &M('Note');
                $contentModel = &M('NoteContent');
                $note         = $noteModel->getOne("*", "`note_id`={$noteId}");
                $content      = $contentModel->getValue("`content`", "`note_id`={$noteId}");
                if (!empty($note)) {
                    $data = $note;
                    $data['content'] = $content;
                }
            }
            // 面包屑
            $breadCrumbs = array(
                array('default'),
                array('note'),
            );
            if (empty($noteId)) {
                $breadCrumbs[] = array('note', 'showEdit');
            } else {
                $breadCrumbs[] = array('note', 'showEdit', '查看笔记');
                $this->setCurrentMenu('note', 'index');
            }
            $this->setBreadCrumbs($breadCrumbs);
            // 树形分类
            $catModel = &M('Category');
            $catTree  = $catModel->getCatTreeList($this->catType);
            $this->assigns(array(
            	'catArray' => $catTree,
            	'data'     => $data,
            	'mainTpl'  => 'note/showView'
            ));
        }

        $this->display();
    }
    
    /**
     * 显示笔记添加/修改
     */
    public function showEdit()
    {
        $noteId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        $data      = array(
        	'note_id'      => 0, 
        	'cat_id'       => 0, 
        	'order'        => 999, 
        	'title'        => '', 
        	'content' 	   => '', 
        );
        if ($noteId) {
            $noteModel    = &M('Note');
            $contentModel = &M('NoteContent');
            $note         = $noteModel->getOne("*", "`note_id`={$noteId}");
            $content      = $contentModel->getValue("`content`", "`note_id`={$noteId}");
            if (!empty($note)) {
                $data = $note;
                $data['content']      = $content;
            }
        }
        // 面包屑
        $breadCrumbs = array(
            array('default'),
            array('note'),
        );
        if (empty($noteId)) {
            $breadCrumbs[] = array('note', 'showEdit');
        } else {
            $breadCrumbs[] = array('note', 'showEdit', '笔记修改');
            $this->setCurrentMenu('note', 'index');
        }
        $this->setBreadCrumbs($breadCrumbs);
        // 树形分类
        $catModel = &M('Category');
        $catTree  = $catModel->getCatTreeList($this->catType);
        $this->assigns(array(
        	'catArray' => $catTree,
        	'data'     => $data,
        	'mainTpl'  => 'note/showEdit'
        ));
        $this->display();
    }
    
    /**
     * 
     * 笔记添加/修改
     */
    public function edit()
    {
        $data = $this->getRequest(array(
        	'note_id'      => 0, 
        	'cat_id'       => 0, 
        	'order'        => 999, 
        	'title'        => '', 
        	'content' 	   => '', 
        ));
        $noteId = $data['note_id'];
        $content   = $data['content'];
        if (empty($data['title'])) {
            $this->addMessage('笔记标题不能为空', 'error');
        } else {
            $data['uid']          = $this->_session['user']['uid'];
            $data['status']       = 1;
            $data['update_time']  = time();
            unset($data['note_id'], $data['content']);
            $noteModel    = &M('Note');
            $contentModel = &M('NoteContent');
            if (empty($noteId)) {
                $data['create_time'] = time();
                $noteId           = $noteModel->insert($data);
                if ($noteId > 0) {
                    $contentModel->insert(array(
                        'note_id' => $noteId,
                        'content'    => $content,
                    ));
                    $this->addMessage('笔记添加成功', 'success');
                } else {
                    $this->addMessage('笔记添加失败', 'error');
                }
            } else {
                $r1 = $noteModel->update($data, "`note_id`={$noteId}");
                $r2 = $contentModel->update(array(
                	'content' => $content
                ), "`note_id`={$noteId}");
                if ($r1 || $r2) {
                    $this->addMessage('笔记修改成功', 'success');
                } else {
                    $this->addMessage('笔记修改失败', 'error');
                }
            }
        }
        $this->redirect();
    }
    
    /**
     * 笔记删除.
     */
    public function delete()
    {
        $noteId = isset($this->_get['id']) ? intval($this->_get['id']) : 0;
        if (empty($noteId)) {
            $this->addMessage('请选择需要删除的笔记', 'error');
        } else {
            $noteModel    = &M('Note');
            $contentModel = &M('NoteContent');
            $noteModel->delete("`note_id`={$noteId}");
            $contentModel->delete("`note_id`={$noteId}");
            $this->addMessage('笔记删除成功', 'success');
        }
        $this->redirect();
    }
}
