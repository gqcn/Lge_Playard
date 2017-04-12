<?php
if(!defined('PhpMe')){
	exit('Include Permission Denied!');
}

class Controller_Comment extends BaseAppEx
{
    
    /**
     * 主页面展示
     */
    public function index()
    {
        $this->setBreadCrumbs(array(
            array('default'),
            array('comment'),
        ));
    	$this->assigns(array(
        	'mainTpl' => 'comment/index'
        ));
        $this->display('index');
    }
}
?>
