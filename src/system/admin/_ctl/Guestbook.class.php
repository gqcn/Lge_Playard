<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

/**
 * 留言管理
 */
class Controller_Guestbook extends AceAdmin_BaseControllerAuth
{
    
    /**
     * 页面展示
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('guestbook'),
        ));
    	$this->assigns(array(
        	'mainTpl' => 'guestbook/index'
        ));
        $this->display('index');
    }
}