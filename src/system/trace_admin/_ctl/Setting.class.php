<?php
namespace Lge;

if(!defined('LGE')){
	exit('Include Permission Denied!');
}

/**
 * 系统设置
 */
class Controller_Setting extends AceAdmin_Setting
{

    /**
     * 系统设置
     */
    public function system()
    {
        $setting = array(
            'trace.site_url' => Module_Setting::instance()->get('trace.site_url'),
        );
        $this->assigns(array(
            'setting' => $setting,
            'mainTpl' => 'setting/system',
        ));
        $this->display();
    }

}
