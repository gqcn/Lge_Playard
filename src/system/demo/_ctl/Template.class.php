<?php
namespace Lge;

if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Template extends Controller_Base
{
    /**
     * 默认入口函数.
     *
     * @return void
     */
    public function index()
    {
        $users = array(
            array('age' => 16, 'name' => 'Smith'),
            array('age' => 28, 'name' => 'John'),
        );
        $this->assigns(array(
            'list' => $users,
        ));
        $this->display('index');
    }
}