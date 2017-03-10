<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

/**
 * 微信公众号 - 素材管理
 */
class Controller_WechatMaterial extends AceAdmin_BaseControllerAuth
{
    /**
     * 素材列表
     */
    public function index()
    {
        $this->assigns(array(
            'mainTpl' => 'wechat/material/index',
        ));
        $this->display();
    }
}