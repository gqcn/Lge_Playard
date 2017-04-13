<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Comment extends AceAdmin_BaseControllerAuth
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
