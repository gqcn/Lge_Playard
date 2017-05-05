<?php
namespace Lge;

if (!defined('LGE')) {
    exit('Include Permission Denied!');
}

/**
 * 接口管理模块。
 */
class Module_Api extends BaseModule
{

    /**
     * 获得实例.
     *
     * @return Module_Api
     */
    public static function instance()
    {
        return self::_instanceInternal(__CLASS__);
    }

}
