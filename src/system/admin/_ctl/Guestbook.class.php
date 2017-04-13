<?php
namespace Lge;
if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Guestbook extends AceAdmin_BaseControllerAuth
{
    
    /**
     * 主页面展示
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
?>
